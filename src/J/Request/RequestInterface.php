<?php

namespace J\Request;

use J\Request\Message\MessageInterface;

/**
 * Interface RequestInterface
 *
 * @package J\Request
 */
interface RequestInterface {

	/**
	 * @param bool $multicall
	 *
	 * @return null
	 */
	public function setMultiCall($multicall);

	/**
	 * @return bool
	 */
	public function getMultiCall();

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
} 
