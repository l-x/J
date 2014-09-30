<?php

namespace J\Tests\Value;

use J\Tests\Assets\ValueTestCase;
use J\Value;

class MethodTest extends ValueTestCase {

	/**
	 * @return Value\Id
	 */
	protected function getValuePrototype() {
		return new Value\Method('name');
	}

	/**
	 * @return string
	 */
	protected function getExceptionClass() {
		return 'J\Value\Exception\InvalidMethod';
	}

	/**
	 * @return array
	 */
	public function validValueDataProvider() {
		return array(
			array('method'),
		        array('method.name'),
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
		        array(''),
		);
	}
}
