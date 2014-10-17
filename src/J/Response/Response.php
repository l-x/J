<?php

namespace J\Response;

use J\Response\Message\MessageInterface;

/**
 * Class Response
 *
 * @package J\Response
 */
class Response implements ResponseInterface {

	/**
	 * @var MessageInterface[]
	 */
	private $messages = array();

	/**
	 * @var bool
	 */
	private $multi_call = false;

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

	/**
	 * @param bool $multi_call
	 *
	 * @return null
	 */
	public function setMultiCall($multi_call) {
		$this->multi_call = $multi_call;
	}

	/**
	 * @return bool
	 */
	public function getMultiCall() {
		return $this->multi_call;
	}
}
