<?php

namespace J\Tests\Value;

use J\Tests\Assets\ValueTestCase;
use J\Value;

class ResultTest extends ValueTestCase {

	/**
	 * @return Value\Id
	 */
	protected function getValuePrototype() {
		return new Value\Result(null);
	}

	/**
	 * @return string
	 */
	protected function getExceptionClass() {
		return '';
	}

	/**
	 * @return array
	 */
	public function validValueDataProvider() {
		return array(
			array(null),
			array(array(1, 2, 3)),
		        array((object) array(1, 2, 3)),
		        array(true),
		        array(false),
		        array('string'),
		        array(''),
		        array(12.34),
		        array(1234),
		);
	}

	/**
	 * @return array
	 */
	public function invalidValueDataProvider() {
		return array();
	}

	/**
	 *
	 */
	public function failsOnInvalidValue() {
		// disables test in template class
	}
}
