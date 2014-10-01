<?php

namespace J\Request;

use J\Value\Jsonrpc;
use J\Value\Id;
use J\Value\Method;
use J\Value\Params;

/**
 * Class RequestFactory
 *
 * @package J\Request
 */
class RequestFactory implements RequestFactoryInterface {

	/**
	 * @return Message
	 */
	public function createMessage() {
		return new Message();
	}

	/**
	 * @return Request
	 */
	public function createRequest() {
		return new Request();
	}
} 
