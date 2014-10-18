<?php

namespace J\Response;

use J\Response\Message\MessageExtractor;

/**
 * Class ResponseExtractor
 *
 * @package J\Response
 */
class ResponseExtractor {

	/**
	 * @var MessageExtractor
	 */
	private $message_extractor;

	/**
	 * @param MessageExtractor $message_hydrator
	 */
	public function __construct(MessageExtractor $message_extractor) {
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
