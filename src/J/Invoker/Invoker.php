<?php

namespace J\Invoker;

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
	 * @param MessageInterface $message
	 * @param $controller
	 *
	 * @return mixed
	 */
	public function __invoke(MessageInterface $message, $controller) {
		if (!$this->isCallable($controller)) {
			throw new \RuntimeException('Controller must be closure or invokable object');
		}

		$params = (array) $message->getParams()->getValue();

		return call_user_func_array($controller, $params);
	}
} 
