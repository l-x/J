<?php

namespace J;

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
class Server extends Container {

	public function __construct(array $options = array()) {
		parent::__construct();
		$this->setup();
		$this->setOptions($options);
	}

	private function setOptions(array $options) {
		foreach ($options as $key => $value) {
			$this[$key] = $value;
		}
	}

	/**
	 * return null
	 */
	private function setup() {
		$this['controllers'] = new Container();

		$this['exceptions'] = new Container();
		$this->registerExceptions(new Service\ProtocolExceptionServiceProvider());

		$this->register(new Service\JsonServiceProvider());
		$this->register(new Service\RequestServiceProvider());
		$this->register(new Service\ResponseServiceProvider());
		$this->register(new Service\InvokerServiceProvider());
		$this->register(new Service\ValueObjectServiceProvider());
	}

	public function registerControllers(ServiceProviderInterface $controllers) {
		$this['controllers']->register($controllers);

		return $this;
	}

	public function registerExceptions(ServiceProviderInterface $exceptions) {
		$this['exceptions']->register($exceptions);

		return $this;
	}

	private function jsonEncode($data) {
		return $this['json_encoder']($data);
	}

	private function jsonDecode($json_string) {
		$data = $this['json_decoder']($json_string);
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
		$value_factory = $this['value_factory'];
		$message = $this['response_message'];

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
		$error = $this['error'];
		$this['error_hydrator']->hydrate($error, $exception);

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
			$controller = $this['controllers'][$controller_name];
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
		$result = $this['invoke']($request_message, $this->getController($request_message));
		$result_object = $this['value_factory']->createResult($result);
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

		$request = $this['request'];

		/** @var callable $hydrate_request */
		$hydrate_request = $this['request_hydrator'];

		$hydrate_request($request, $data);

		return $request;
	}

	private function serializeResponse(ResponseInterface $response) {
		return $this->jsonEncode(
			$this['extract_response']($response)
		);
	}


	public function handleRequest(RequestInterface $request, ResponseInterface $response) {

		if ($request->getMultiCall()) {
			$response->setMultiCall(true);
		}

		foreach ($request->getMessages() as $request_message) {
			$this->handleRequestMessage($request_message, $response);
		}
	}

	/**
	 * @param Request\RequestInterface|string $request
	 * @param Response\ResponseInterface $response
	 *
	 * @return string
	 */
	public function handle($request, Response\ResponseInterface $response = null) {
		if (null === $response) {
			$response = $this['response'];
		}

		$this->handleRequest($this->unserializeRequest($request), $response);

		return $this->serializeResponse($response);
	}
} 
