<?php

namespace J\Tests\Assets;

use J\Value\ValueInterface;

/**
 * Class ValueTestCase
 *
 * @package J\Tests\Assets
 */
abstract class ValueTestCase extends \PHPUnit_Framework_TestCase {

	/**
	 * @return ValueInterface
	 */
	abstract protected function getValuePrototype();

	/**
	 * @return string
	 */
	abstract protected function getExceptionClass();

	/**
	 * @return array
	 */
	abstract public function validValueDataProvider();

	/**
	 * @return array
	 */
	abstract public function invalidValueDataProvider();

	/**
	 * @test
	 * @testdox Inherits J\Value\ValueInterface
	 */
	public function inheritsValueInterface() {
		$this->assertInstanceOf(ValueInterface::class, $this->getValuePrototype());
	}

	/**
	 * @test
	 * @testdox Constructor accepts valid values
	 * @dataProvider validValueDataProvider
	 */
	public function acceptsValidValues($value) {
		$class = get_class($this->getValuePrototype());
		$object = new $class($value);

		$this->assertSame($value, $object->getValue());
	}

	/**
	 * @test
	 * @testdox Constructor fails for invalid values
	 * @dataProvider invalidValueDataProvider
	 */
	public function failsOnInvalidValue($value) {
		$this->setExpectedException($this->getExceptionClass());
		$class = get_class($this->getValuePrototype());
		new $class($value);
	}
} 
