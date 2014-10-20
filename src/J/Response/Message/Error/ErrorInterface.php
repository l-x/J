<?php

namespace J\Response\Message\Error;

use J\Value\Data;
use J\Value\Code;
use J\Value\Message;

/**
 * Class Error
 *
 * @package J\Response\Message
 */
interface ErrorInterface {

	/**
	 * @param Code $code
	 */
	public function setCode(Code $code);

	/**
	 * @return Code
	 */
	public function getCode();

	/**
	 * @param Message $message
	 */
	public function setMessage(Message $message);

	/**
	 * @return Message
	 */
	public function getMessage();

	/**
	 * @param Data $data
	 */
	public function setData(Data $data);

	/**
	 * @return Data
	 */
	public function getData();
}
