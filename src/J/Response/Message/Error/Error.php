<?php

namespace J\Response\Message\Error;

use J\Value\Code;
use J\Value\Data;
use J\Value\Message;

/**
 * Class Error
 *
 * @package J\Response\Message
 */
class Error {

	/**
	 * @var Code
	 */
	private $code;

	/**
	 * @var Message
	 */
	private $message;

	/**
	 * @var Data
	 */
	private $data;

	/**
	 * @param Code $code
	 */
	public function setCode(Code $code) {
		$this->code = $code;
	}

	/**
	 * @return Code
	 */
	public function getCode() {
		return $this->code;
	}

	/**
	 * @param Message $message
	 */
	public function setMessage(Message $message) {
		$this->message = $message;
	}

	/**
	 * @return Message
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @param Data $data
	 */
	public function setData(Data $data) {
		$this->data = $data;
	}

	/**
	 * @return Data
	 */
	public function getData() {
		return $this->data;
	}
} 
