<?php

namespace J\Request;

use J\Exception\InvalidRequest;
use J\Request\Message\MessageHydrator;
use J\Request\Message\MessageInterface;

/**
 * Class RequestHydrator
 *
 * @package J\Request
 */
class RequestHydrator {

	/**
	 * @var callable
	 */
	private $message_hydrator;

	/**
	 * @var MessageInterface
	 */
	private $message_prototype;

	/**
	 * @param MessageHydrator $message_hydrator
	 */
	public function __construct(MessageHydrator $message_hydrator, MessageInterface $message_prototype) {
		$this->message_hydrator = $message_hydrator;
		$this->message_prototype = $message_prototype;
	}

	/**
	 * @param \stdClass $data
	 *
	 * @return MessageInterface
	 */
	private function hydrateMessage($data) {
		$hydrate_message = $this->message_hydrator;
		$message = clone $this->message_prototype;

		$hydrate_message($message, $data);

		return $message;
	}

	/**
	 * @param RequestInterface $request
	 * @param \stdClass|\stdClass[] $data
	 *
	 * @throws InvalidRequest
	 */
	public function __invoke(RequestInterface $request, $data) {
		if (is_array($data)) {
			$request->setMultiCall(true);
		} else if (is_object($data)) {
			$data = array($data);
		} else {
			throw new InvalidRequest();
		}

		foreach ($data as $message_raw) {
			$message = $this->hydrateMessage($message_raw);
			$request->addMessage($message);
		}
	}
}
