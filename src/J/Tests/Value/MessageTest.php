<?php

namespace J\Tests\Value;

use J\Tests\Assets\ValueTestCase;
use J\Value\Message;
use J\Value\ValueInterface;

/**
 * Class MessageTest
 *
 * @package J\Tests\Value
 */
class MessageTest extends ValueTestCase {

	/**
	 * @return ValueInterface
	 */
	protected function getValuePrototype() {
		return new Message('some message');
	}

	/**
	 * @return string
	 */
	protected function getExceptionClass() {
		return 'J\Value\Exception\InvalidMessage';
	}

	/**
	 * @return array
	 */
	public function validValueDataProvider() {
		return array(
			array('some string'),
		        array(''),
		);
	}

	/**
	 * @return array
	 */
	public function invalidValueDataProvider() {
		return array(
			array(4.2),
			array(fopen('php://stdin', 'r')),
			array(true),
			array(false),
		);
	}
}
