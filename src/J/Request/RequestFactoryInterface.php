<?php

namespace J\Request;

use J\Value\Params;
use J\Value\Method;
use J\Value\Jsonrpc;
use J\Value\Id;

/**
 * Class RequestFactory
 *
 * @package J\Request
 */
interface RequestFactoryInterface {

	/**
	 * @return Message
	 */
	public function createMessage();

	/**
	 * @return Request
	 */
	public function createRequest();
}
