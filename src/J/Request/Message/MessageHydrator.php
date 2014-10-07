<?php

namespace J\Request\Message;

use J\Value\ValueFactoryInterface;

/**
 * Class MessageHydrator
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

		$creator = 'create'.ucfirst($property);
		$setter = 'set'.ucfirst($property);

		try {
			$value_object = $this->value_factory->$creator($value);
			$message->$setter($value_object);
		} catch (\Exception $exception) {
			$message->setException($exception);
		}



	}

	/**
	 * @param MessageInterface $message
	 * @param \stdClass $data
	 */
	public function hydrate(MessageInterface $message, \stdClass $data) {
		foreach (array('id', 'jsonrpc', 'method', 'params') as $property) {
			$this->hydrateProperty($message, $property, $data);
		}
	}
} 
