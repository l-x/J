<?php

namespace J;

use J\Exception\InvalidRequest;
use \Pimple\Container;
use \Pimple\ServiceProviderInterface;
use J\Exception\MethodNotFound;
use J\Exception\ParseError;
use J\Request\Message\MessageInterface;
use J\Request\RequestInterface;
use J\Response\ResponseInterface;
use J\Service;

/**
 * Class Server
 *
 * @package J
 */
class Server {

	/**
	 * @var Container
	 */
	private $controllers;

	/**
	 * @var Container
	 */
	private $services;

	/**
	 * @param array $options
	 */
	public function __construct(array $options = array()) {
		$this->setup($options);
	}

	/**
	 * return null
	 */
	private function setup(array $options) {
		$this->services = new Container($options);
		$this->services['exceptions'] = new Container();
		$this->controllers = new Container();

		$this->registerExceptions(new Service\ProtocolExceptionServiceProvider());
		$this->registerServices(new Service\EssentialServiceProvider());

	}

	public function registerServices(ServiceProviderInterface $services) {
		$this->services->register($services);
	}

	public function registerControllers(ServiceProviderInterface $controllers) {
		$this->controllers->register($controllers);

		return $this;
	}

	public function registerExceptions(ServiceProviderInterface $exceptions) {
		$this->services['exceptions']->register($exceptions);

		return $this;
	}

	/**
	 * @param mixed $data
	 *
	 * @return string
	 */
	private function jsonEncode($data) {
		return $this->services['json.encoder']($data);
	}

	/**
	 * @param $json_string
	 *
	 * @return mixed
	 * @throws ParseError
	 */
	private function jsonDecode($json_string) {
		try {
			$data = $this->services['json.decoder']($json_string);
		} catch (\Exception $exception) {
			throw new ParseError();
		}

		if (null === $data) {
			throw new ParseError();
		}

		return $data;
	}

	/**
	 * @param Value\Id $id
	 *
	 * @return Response\Message\MessageInterface
	 */
	private function createResponseMessage(Value\Id $id = null) {
		$value_factory = $this->services['value.factory'];
		$message = $this->services['response.message'];

		if (null === $id) {
			$id = $value_factory->createId($id);
		}

		$message->setId($id);
		$message->setJsonrpc($value_factory->createJsonrpc('2.0'));

		return $message;
	}

	/**
	 * @param \Exception $exception
	 *
	 * @return Response\Message\Error\Error
	 */
	private function createError(\Exception $exception) {
		$error = $this->services['error'];
		$this->services['error.hydrator']($error, $exception);

		return $error;
	}


	/**
	 * @param Request\Message\MessageInterface $request_message
	 *
	 * @return callable
	 * @throws MethodNotFound
	 */
	private function getController(Request\Message\MessageInterface $request_message) {
		$controller_name = $request_message->getMethod()->getValue();
		try {
			$controller = $this->controllers[$controller_name];
		} catch (\Exception $exception) {
			throw new MethodNotFound();
		}

		return $controller;
	}

	/**
	 * @param Request\Message\MessageInterface $request_message
	 * @param Response\Message\MessageInterface $response_message
	 * @param Invoker\InvokerInterface $invoker
	 *
	 * @return null
	 * @throws \Exception
	 */
	private function invoke(Request\Message\MessageInterface $request_message, Response\Message\MessageInterface $response_message) {
		if ($exception = $request_message->getException()) {
			throw $exception;
		}
		$result = $this->services['invoker']($request_message, $this->getController($request_message));
		$result_object = $this->services['value.factory']->createResult($result);
		$response_message->setResult($result_object);
	}

	/**
	 * @param Request\Message\MessageInterface $message
	 *
	 * @return mixed
	 * @throws \Exception
	 */
	private function processMessage(Request\Message\MessageInterface $message) {
		$response_message = $this->createResponseMessage($message->getId());

		try {
			$this->invoke($message, $response_message);
		} catch (\Exception $exception) {
			$response_message->setError($this->createError($exception));
		}

		return $response_message;
	}

	private function handleRequestMessage(MessageInterface $request_message, ResponseInterface $response) {
		$response_message = $this->processMessage($request_message);
		if (!$request_message->isNotification() || $request_message->getException()) {
			$response->addMessage($response_message);
		}
	}

	/**
	 * @param string $json_request
	 *
	 * @return Request\RequestInterface
	 */
	private function unserializeRequest($json_request) {
		try {
			$data = $this->jsonDecode($json_request);
		} catch (\Exception $exception) {
			$data = new \stdClass();
			$data->exception = $exception;
		}

		$request = $this->services['request'];

		/** @var callable $hydrate_request */
		$hydrate_request = $this->services['request.hydrator'];

		$hydrate_request($request, $data);

		return $request;
	}

	/**
	 * @param ResponseInterface $response
	 *
	 * @return string
	 */
	private function serializeResponse(ResponseInterface $response) {
		return $this->jsonEncode(
			$this->services['response.extractor']($response)
		);
	}

	/**
	 * @param RequestInterface $request
	 * @param ResponseInterface $response
	 *
	 * @return null
	 */
	public function handleRequest(RequestInterface $request, ResponseInterface $response) {

		if ($request->getMultiCall()) {
			$response->setMultiCall(true);
		}

		$request_messages = $request->getMessages();

		if (0 == count($request_messages)) {
			$error = $this->createError(new InvalidRequest());
			$response_message = $this->createResponseMessage();
			$response_message->setError($error);
			$response->addMessage($response_message);
		}

		foreach ($request->getMessages() as $request_message) {
			$this->handleRequestMessage($request_message, $response);
		}
	}

	/**
	 * @param RequestInterface|string $request
	 * @param ResponseInterface $response
	 *
	 * @return string
	 */
	public function handle($request, ResponseInterface $response = null) {
		if (null === $response) {
			$response = $this->services['response'];
		}

		$this->handleRequest($this->unserializeRequest($request), $response);

		return $this->serializeResponse($response);
	}
} 
