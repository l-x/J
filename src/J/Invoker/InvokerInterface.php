<?php

namespace J\Invoker;

use J\Request\Message\MessageInterface;

/**
 * Interface InvokerInterface
 *
 * @package J\Invoker
 */
interface InvokerInterface {

	/**
	 * @param MessageInterface $message
	 * @param callable $controller
	 *
	 * @return mixed
	 */
	public function __invoke(MessageInterface $message, $controller);
}
