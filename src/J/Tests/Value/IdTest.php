<?php

namespace J\Tests\Value;

use J\Tests\Assets\ValueTestCase;
use J\Value;
use J\Value\ValueInterface;

class IdTest extends ValueTestCase {

	/**
	 * @return Value\Id
	 */
	protected function getValuePrototype() {
		return new Value\Id(1);
	}

	/**
	 * @return string
	 */
	protected function getExceptionClass() {
		return 'J\Value\Exception\InvalidId';
	}

	/**
	 * @return array
	 */
	public function validValueDataProvider() {
		return array(
			array('id'),
		        array(123),
		        array(null),
		        array(4.2),
		);
	}

	/**
	 * @return array
	 */
	public function invalidValueDataProvider() {
		return array(
			array(array(123)),
		        array(true),
		        array(false),
		        array(fopen('php://stdin', 'r')),
		);
	}
}
