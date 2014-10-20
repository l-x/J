<?php

namespace J\Response\Message;

use J\Response\Message\Error\ErrorExtractorInterface;

/**
 * Class MessageExtractor
 *
 * @package J\Response\Message
 */
class MessageExtractor implements MessageExtractorInterface {

	/**
	 * @var ErrorExtractorInterface
	 */
	private $error_extractor;

	/**
	 * @param ErrorExtractorInterface $error_hydrator
	 */
	public function __construct(ErrorExtractorInterface $error_extractor) {
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
