<?php

namespace J\Response\Message;

use J\Response\Message\Error\ErrorExtractor;
use J\Response\Message\Error\ErrorHydrator;

/**
 * Class MessageExtractor
 *
 * @package J\Response\Message
 */
class MessageExtractor {

	/**
	 * @var ErrorHydrator
	 */
	private $error_extractor;

	/**
	 * @param ErrorHydrator $error_hydrator
	 */
	public function __construct(ErrorExtractor $error_extractor) {
		$this->error_extractor = $error_extractor;
	}

	/**
	 * @param MessageInterface $message
	 *
	 * @return \stdClass
	 */
	public function __invoke(MessageInterface $message) {
		$data = array(
			'jsonrpc'       => $message->getJsonrpc()->getValue(),
			'id'            => $message->getId()->getValue(),
		);

		if ($error = $message->getError()) {
			$data['error'] = $this->error_extractor->__invoke($error);
		} else {
			$data['result'] = $message->getResult()->getValue();
		}

		return (object) $data;
	}
} 
