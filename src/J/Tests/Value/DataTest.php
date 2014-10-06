<?php

namespace J\Tests\Value;

use J\Tests\Assets\ValueTestCase;
use J\Value\Data;
use J\Value\ValueInterface;

/**
 * Class DataTest
 *
 * @package J\Tests\Value
 */
class DataTest extends ValueTestCase {

	/**
	 * @return ValueInterface
	 */
	protected function getValuePrototype() {
		return new Data('data');
	}

	/**
	 * @return string
	 */
	protected function getExceptionClass() {
		return 'J\Value\Exception\InvalidData';
	}

	/**
	 * @return array
	 */
	public function validValueDataProvider() {
		return array(
			array(1234),
		        array(12.34),
		        array(true),
		        array(false),
		        array('string'),
		        array(array('some', 'array')),
		        array((object) array('some' => 'property')),
		);
	}

	/**
	 * @return array
	 */
	public function invalidValueDataProvider() {
		return array(
			array(fopen('php://input', 'r')),
		);
	}
}
