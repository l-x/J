<?php

namespace J\Tests\Request;

use J\Request\Message;

/**
 * Class MessageTest
 *
 * @package J\Tests\Request
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
	 * @param string $property_name
	 * @param string $property_value_class
	 */
	private function messagePropGetterSetterTest($property_name, $property_value_class) {
		$getter = 'get'.$property_name;
		$setter = 'set'.$property_name;

		$this->assertNull($this->message->$getter());
		$mock = $this->getMockBuilder($property_value_class)->disableOriginalConstructor()->getMock();
		$this->message->$setter($mock);

		$this->assertSame($mock, $this->message->$getter());
	}

	/**
	 * @test
	 * @testdox Getter and setter for Id works as expected
	 */
	public function getSetId() {
		$this->messagePropGetterSetterTest('Id', 'J\Value\Id');
	}

	/**
	 * @test
	 * @testdox Getter and setter for Jsonrpc works as expected
	 */
	public function getSetJsonrpc() {
		$this->messagePropGetterSetterTest('Jsonrpc', 'J\Value\Jsonrpc');
	}

	/**
	 * @test
	 * @testdox Getter and setter for Method works as expected
	 */
	public function getSetMethod() {
		$this->messagePropGetterSetterTest('Method', 'J\Value\Method');
	}

	/**
	 * @test
	 * @testdox Getter and setter for Params works as expected
	 */
	public function getSetParams() {
		$this->messagePropGetterSetterTest('Params', 'J\Value\Params');
	}

	/**
	 * @test
	 * @testdox Getter and setter for Exception works as expected
	 */
	public function getSetExceptiond() {
		$this->messagePropGetterSetterTest('Exception', '\Exception');
	}

	/**
	 * @test
	 * @testdox isNotification returns true on empty id property
	 */
	public function isNotificationReturnsTrueOnEmptyIdProperty() {
		$this->assertNull($this->message->getId());
		$this->assertTrue($this->message->isNotification());
	}

	/**
	 * @test
	 * @testdox isNotification returns true on id value eq null
	 */
	public function isNotificationReturnsTrueOnIdValueNull() {
		$id_mock = $this->getMockBuilder('J\Value\Id')
			->setMethods(array('getValue'))
			->disableOriginalConstructor()
			->getMock();
		$id_mock->expects($this->any())
			->method('getValue')
			->will($this->returnValue(null));
		$this->message->setId($id_mock);

		$this->assertTrue($this->message->isNotification());
	}

	/**
	 * @test
	 * @testdox isNotification returns false on id value not eq null
	 */
	public function isNotificationReturnsFalseOnIdValue() {
		$id_mock = $this->getMockBuilder('J\Value\Id')
			->setMethods(array('getValue'))
			->disableOriginalConstructor()
			->getMock();
		$id_mock->expects($this->any())
			->method('getValue')
			->will($this->returnValue('some_id'));
		$this->message->setId($id_mock);

		$this->assertFalse($this->message->isNotification());
	}

}
