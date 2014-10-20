<?php

namespace J\Request\Message;

/**
 * Class MessageExtractor
 *
 * @package J\Request
 */
interface MessageHydratorInterface {

	/**
	 * @param MessageInterface $message
	 * @param \stdClass $data
	 *
	 * @return null
	 */
	public function __invoke(MessageInterface $message, $data);
}
