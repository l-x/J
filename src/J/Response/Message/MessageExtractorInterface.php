<?php

namespace J\Response\Message;

/**
 * Class MessageExtractorInterface
 *
 * @package J\Response\Message
 */
interface MessageExtractorInterface {

	/**
	 * @param MessageInterface $message
	 *
	 * @return \stdClass
	 */
	public function __invoke(MessageInterface $message);
}
