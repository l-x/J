<?php

namespace J\Tests\Value;

use J\Tests\Assets\ValueTestCase;
use J\Value;

class ParamsTest extends ValueTestCase {

	/**
	 * @return Value\Id
	 */
	protected function getValuePrototype() {
		return new Value\Params(null);
	}

	/**
	 * @return string
	 */
	protected function getExceptionClass() {
		return 'J\Value\Exception\InvalidParams';
	}

	/**
	 * @return array
	 */
	public function validValueDataProvider() {
		return array(
			array(null),
			array(array(1, 2, 3)),
		        array(array('param' => 'value', 'another_param' => 'another value'))
		);
	}

	/**
	 * @return array
	 */
	public function invalidValueDataProvider() {
		return array(
		        array(true),
		        array(false),
		        array((object) array(1, 2, 3)),
		        array(fopen('php://stdin', 'r')),
		        array(''),
		);
	}
}
