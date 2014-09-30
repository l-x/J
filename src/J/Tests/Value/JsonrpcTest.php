<?php

namespace J\Tests\Value;

use J\Tests\Assets\ValueTestCase;
use J\Value;

/**
 * Class JsonrpcTest
 *
 * @package J\Tests\Value
 */
class JsonrpcTest extends ValueTestCase {

	/**
	 * @return Value\Id
	 */
	protected function getValuePrototype() {
		return new Value\Jsonrpc('2.0');
	}

	/**
	 * @return string
	 */
	protected function getExceptionClass() {
		return 'J\Value\Exception\InvalidJsonrpc';
	}

	/**
	 * @return array
	 */
	public function validValueDataProvider() {
		return array(
			array('2.0'),
		);
	}

	/**
	 * @return array
	 */
	public function invalidValueDataProvider() {
		return array(
		        array(2.0),
		        array(null),
		        array(2.000000001),
		        array('2.000000001'),
		);
	}
}
