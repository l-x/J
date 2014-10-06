<?php

namespace J\Tests\Value;

use J\Tests\Assets\ValueTestCase;
use J\Value\Code;
use J\Value\ValueInterface;

/**
 * Class CodeTest
 *
 * @package J\Tests\Value
 */
class CodeTest extends ValueTestCase {

	/**
	 * @return ValueInterface
	 */
	protected function getValuePrototype() {
		return new Code(0);
	}

	/**
	 * @return string
	 */
	protected function getExceptionClass() {
		return 'J\Value\Exception\InvalidCode';
	}

	/**
	 * @return array
	 */
	public function validValueDataProvider() {
		return array(
			array(-32000),
		        array(4711),
		);
	}

	/**
	 * @return array
	 */
	public function invalidValueDataProvider() {
		return array(
			array('string'),
		        array('4,2'),
		        array(fopen('php://stdin', 'r')),
		        array(true),
		        array(false),
		);
	}
}
