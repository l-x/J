<?php

namespace J\Response;

use J\Response\Message\MessageInterface;

/**
 * Interface ResponseInterface
 *
 * @package J\Response
 */
interface ResponseInterface {

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
	 * @param bool $multi_call
	 *
	 * @return null
	 */
	public function setMultiCall($multi_call);

	/**
	 * @return bool
	 */
	public function getMultiCall();
} 
