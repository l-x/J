<?php

namespace J\Tests\Response\Message\Error;

use J\Response\Message\Error\Error;

class ErrorTest extends \PHPUnit_Framework_TestCase {
	/**
	 * @var Error
	 */
	private $error;

	/**
	 *
	 */
	public function setUp() {
		$this->error = new Error();
	}

	/**
	 * @param string $property
	 * @param string $class
	 */
	public function propertyTest($property, $class) {
		$set = 'set'.$property;
		$get = 'get'.$property;

		$value = $this->getMockBuilder($class)
			->disableOriginalConstructor()
			->getMock();

		$this->error->$set($value);
		$this->assertSame($value, $this->error->$get());
	}

	/**
	 * @test
	 * @testdox setter and getter for code work as expected
	 */
	public function code() {
		$this->propertyTest('Code', 'J\Value\Code');
	}

	/**
	 * @test
	 * @testdox setter and getter for message work as expected
	 */
	public function message() {
		$this->propertyTest('Message', 'J\Value\Message');
	}

	/**
	 * @test
	 * @testdox setter and getter for data work as expected
	 */
	public function data() {
		$this->propertyTest('Data', 'J\Value\Data');
	}
}
