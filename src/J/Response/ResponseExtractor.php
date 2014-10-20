<?php

namespace J\Response;

use J\Response\Message\MessageExtractorInterface;

/**
 * Class ResponseExtractor
 *
 * @package J\Response
 */
class ResponseExtractor {

	/**
	 * @var MessageExtractorInterface
	 */
	private $message_extractor;

	/**
	 * @param MessageExtractorInterface $message_hydrator
	 */
	public function __construct(MessageExtractorInterface $message_extractor) {
		$this->message_extractor = $message_extractor;
	}

	/**
	 * @param ResponseInterface $response
	 *
	 * @return \stdClass[]|\stdClass
	 */
	public function __invoke(ResponseInterface $response) {
		$data = array_map(
			$this->message_extractor,
			$response->getMessages()
		);

		if (false === $response->getMultiCall() && 1 <= count($data)) {
			$data = $data[0];
		}

		return $data;
	}


} 
