<?php

namespace J\Request;

use J\Request\Message;

/**
 * Class Request
 *
 * @package J\Request
 */
class Request implements RequestInterface {

	/**
	 * @var MessageInterface[]
	 */
	private $messages = array();

	/**
	 * @var bool
	 */
	private $is_multi_call = false;

	/**
	 * @param MessageInterface $message
	 *
	 * @return null
	 */
	public function addMessage(MessageInterface $message) {
		$this->messages[] = $message;
		if (count($this->getMessages()) > 1) {
			$this->setMultiCall(true);
		}
	}

	/**
	 * @return MessageInterface[]
	 */
	public function getMessages() {
		return $this->messages;
	}

	/**
	 * @param bool $value
	 *
	 * @return null
	 */
	public function setMultiCall($value = true) {
		$this->is_multi_call = $value;
	}

	/**
	 * @return bool
	 */
	public function isMultiCall() {
		return $this->is_multi_call;
	}
} 
