<?php

namespace J\Request\Message;

use J\Exception\InvalidRequest;
use J\Value\Exception\InvalidObjectValue;
use J\Value\ValueFactoryInterface;

/**
 * Class MessageExtractor
 *
 * @package J\Request
 */
class MessageHydrator {

	/**
	 * @var ValueFactoryInterface
	 */
	private $value_factory;

	/**
	 * @param ValueFactoryInterface $value_factory
	 */
	public function __construct(ValueFactoryInterface $value_factory) {
		$this->value_factory = $value_factory;
	}

	/**
	 * @param MessageInterface $message
	 * @param string $property
	 * @param \stcClass $data
	 *
	 * @return null
	 */
	private function hydrateProperty(MessageInterface $message, $property, $data) {
		$value = isset($data->$property) ? $data->$property : null;

		$create = 'create'.ucfirst($property);
		$set = 'set'.ucfirst($property);

		try {
			$value_object = $this->value_factory->$create($value);
			$message->$set($value_object);
		} catch (InvalidObjectValue $exception) {
			$message->setException(new InvalidRequest());
		}



	}

	public function __invoke(MessageInterface $message, $data) {
		foreach (array('id', 'jsonrpc', 'method', 'params') as $property) {
			$this->hydrateProperty($message, $property, $data);
		}

		if (isset($data->exception)) {
			$message->setException($data->exception);
		}
	}
}
