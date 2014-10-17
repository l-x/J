<?php

namespace J\Request;

use J\Request\Message\MessageInterface;
use Traversable;

/**
 * Class Request
 *
 * @package J\Request
 */
class Request implements RequestInterface {

	/**
	 * @var bool
	 */
	private $multi_call = false;

	/**
	 * @var MessageInterface[]
	 */
	private $messages = array();

	/**
	 * @param bool $multicall
	 *
	 * @return null
	 */
	public function setMultiCall($multicall) {
		$this->multi_call = $multicall;
	}

	/**
	 * @return bool
	 */
	public function getMultiCall() {
		return $this->multi_call;
	}

	/**
	 * @param MessageInterface $message
	 *
	 * @return null
	 */
	public function addMessage(MessageInterface $message) {
		$this->messages[] = $message;
	}

	/**
	 * @return MessageInterface[]
	 */
	public function getMessages() {
		return $this->messages;
	}
}
