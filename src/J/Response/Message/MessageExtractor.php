<?php

namespace J\Response\Message;

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
	private $error_hydrator;

	/**
	 * @param ErrorHydrator $error_hydrator
	 */
	public function __construct(ErrorHydrator $error_hydrator) {
		$this->error_hydrator = $error_hydrator;
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
			$data['error'] = $this->error_hydrator->extract($error);
		} else {
			$data['result'] = $message->getResult()->getValue();
		}

		return (object) $data;
	}
} 
