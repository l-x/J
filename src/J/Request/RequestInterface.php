<?php

namespace J\Request;

/**
 * Class Request
 *
 * @package J\Request
 */
interface RequestInterface {

	/**
	 * @param MessageInterface $message
	 *
	 * @return null
	 */
	public function addMessage(MessageInterface $message);

	/**
	 * @return MessageInterface[]
	 */
	public function getMessages();

	/**
	 * @param bool $value
	 *
	 * @return null
	 */
	public function setMultiCall($value = true);

	/**
	 * @return bool
	 */
	public function isMultiCall();
}
