<?php

namespace J\Tests\Request\Message;

use J\Request\Message\Message;

/**
 * Class MessageTest
 *
 * @package J\Tests\Request\Message
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
	 * @testdox setter and getter for method work as expected
	 */
	public function method() {
		$this->propertyTest('Method', 'J\Value\Method');
	}

	/**
	 * @test
	 * @testdox setter and getter for params work as expected
	 */
	public function params() {
		$this->propertyTest('Params', 'J\Value\Params');
	}

	/**
	 * @test
	 * @testdox setter and getter for exception work as expected
	 */
	public function exception() {
		$exception = new \Exception();
		$this->message->setException($exception);

		$this->assertSame($exception, $this->message->getException());
	}

	/**
	 * @test
	 * @testdox isNotification returns true on missing id value object
	 */
	public function isNotificationReturnsTrueOnMissingId() {
		$this->assertNull($this->message->getId());
		$this->assertTrue($this->message->isNotification());
	}

	/**
	 * @test
	 * @testdox isNotification returns true on value object's value eq null
	 */
	public function isNotificationReturnsTrueOnNullValue() {
		$id = $this->getMockBuilder('J\Value\Id')
			->disableOriginalConstructor()
			->setMethods(array('getValue'))
			->getMock();
		$id->expects($this->any())
			->method('getValue')
			->will($this->returnValue(null));
		$this->message->setId($id);

		$this->assertTrue($this->message->isNotification());
	}

	/**
	 * @test
	 * @testdox isNotification returns false on valid id
	 */
	public function isNotificationReturnsFalseOnValidId() {
		$id = $this->getMockBuilder('J\Value\Id')
			->disableOriginalConstructor()
			->setMethods(array('getValue'))
			->getMock();
		$id->expects($this->any())
			->method('getValue')
			->will($this->returnValue('some_id'));
		$this->message->setId($id);

		$this->assertFalse($this->message->isNotification());
	}
}
