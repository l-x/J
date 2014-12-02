<?php

namespace J\Invoker;

use J\Request\Message\MessageInterface;
use Lx\Fna\Wrapper;

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
	protected function invokeController($controller, $params) {
		$callback_wrapper = new Wrapper($controller);

		return $callback_wrapper($params);
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

		return $this->invokeController($controller, $params);
	}
} 
