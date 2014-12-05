<?php

namespace J\Invoker;

use Fna\Exception\InvalidParameterException;
use J\Exception\InvalidRequest;
use J\Request\Message\MessageInterface;

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
		return call_user_func_array($controller, $params);
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

		if (null === $params) {
			$params = array();
		}

		return $this->invokeController($controller, $params);
	}
} 
