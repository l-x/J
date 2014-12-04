<?php

namespace J\Invoker;

use Fna\Exception\InvalidParameterException;
use J\Exception\InvalidRequest;
use J\Request\Message\MessageInterface;
use Fna\Wrapper;

/**
 * Class Invoker
 *
 * @package J\Invoker
 */
class Invoker implements InvokerInterface {

	/**
	 * @param callable $callback
	 *
	 * @return bool
	 */
	private function isCallable($callback) {
		return is_object($callback) && method_exists($callback, '__invoke');
	}

	/**
	 * @param object $controller
	 * @param array $params
	 *
	 * @return mixed
	 */
	protected function invokeController($controller, $params = array()) {
		$callback_wrapper = new Wrapper($controller);

		try {
			return $callback_wrapper($params);
		} catch (InvalidParameterException $exception) {
			throw new InvalidRequest();
		}
	}

	/**
	 * @param MessageInterface $message
	 * @param $controller
	 *
	 * @return mixed
	 */
	public function __invoke(MessageInterface $message, $controller) {
		if (!$this->isCallable($controller)) {
			throw new \RuntimeException('Controller must be closure or invokable object');
		}

		$params = $message->getParams()->getValue();
		if (is_object($params)) {
			$params = (array) $params;
		}

		if (null === $params) {
			$params = array();
		}

		return $this->invokeController($controller, $params);
	}
} 
