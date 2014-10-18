<?php

namespace J\Tests\Response\Message;

use J\Response\Message\Message;

/**
 * Class MessageTest
 *
 * @package J\Tests\Response\Message
 */
class MessageTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Message
	 */
	private $message;

	/**
	 *
	 */
	public function setUp() {
		$this->message = new Message();
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

		$this->message->$set($value);
		$this->assertSame($value, $this->message->$get());
	}

	/**
	 * @test
	 * @testdox setter and getter for id work as expected
	 */
	public function id() {
		$this->propertyTest('Id', 'J\Value\Id');
	}

	/**
	 * @test
	 * @testdox setter and getter for jsonrpc work as expected
	 */
	public function jsonrpc() {
		$this->propertyTest('Jsonrpc', 'J\Value\Jsonrpc');
	}

	/**
	 * @test
	 * @testdox setter and getter for result work as expected
	 */
	public function result() {
		$this->propertyTest('Result', 'J\Value\Result');
	}

	/**
	 * @test
	 * @testdox setter and getter for error work as expected
	 */
	public function error() {
		$error = $this->getMock('J\Response\Message\Error\Error');
		$this->message->setError($error);

		$this->assertSame($error, $this->message->getError());
	}
}
