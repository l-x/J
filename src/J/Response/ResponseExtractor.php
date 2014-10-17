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
		$data = array();
		$exctract_message = $this->message_extractor;

		foreach ($response->getMessages() as $message) {
			$data[] = $exctract_message($message);
		}

		if (!$response->getMultiCall() && 1 <= count($data)) {
			$data = $data[0];
		}

		return $data;
	}


} 
