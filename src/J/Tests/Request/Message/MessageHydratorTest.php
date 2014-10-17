<?php

namespace J\Tests\Request\Message;

use J\Request\Message\MessageHydrator;
use J\Request\Message\MessageInterface;
use J\Value\Exception\InvalidObjectValue;

/**
 * Class MessageHydratorTest
 *
 * @package J\Tests\Request\Message
 */
class MessageHydratorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var \J\Value\ValueFactoryInterface
	 */
	private $value_factory;

	/**
	 * @var MessageHydrator
	 */
	private $message_hydrator;

	/**
	 * @var MessageInterface
	 */
	private $message;

	/**
	 * @param string $class
	 * @param mixed $value
	 * @param null|mixed $invoke_count
	 *
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	private function createValueObjectMock($class, $value, $invoke_count = null) {
		if (null === $invoke_count) {
			$invoke_count = $this->any();
		}

		$mock = $this->getMockBuilder($class)
			->disableOriginalConstructor()
			->setMethods(array('getValue'))
			->getMock();

		$mock->expects($invoke_count)
			->method('getValue')
			->willReturn($value);

		return $mock;
	}

	/**
	 *
	 */
	public function setUp() {
		$this->msg_data = (object) array(
			'id'            => 'id',
			'jsonrpc'       => '2.0',
			'method'        => 'method',
			'params'        => 'params',
		);

		$this->id = $this->createValueObjectMock('J\Value\Id', 'id');
		$this->jsonrpc = $this->createValueObjectMock('J\Value\Jsonrpc', 'jsonrpc');
		$this->method = $this->createValueObjectMock('J\Value\Method', 'method');
		$this->params = $this->createValueObjectMock('J\Value\Params', 'params');

		$this->value_factory = $this->getMock('J\Value\ValueFactoryInterface');
		$this->value_factory->expects($this->any())->method('createId')->with($this->msg_data->id)->willReturn($this->id);
		$this->value_factory->expects($this->any())->method('createJsonrpc')->with($this->msg_data->jsonrpc)->willReturn($this->jsonrpc);
		$this->value_factory->expects($this->any())->method('createMethod')->with($this->msg_data->method)->willReturn($this->method);
		$this->value_factory->expects($this->any())->method('createParams')->with($this->msg_data->params)->willReturn($this->params);

		$this->message = $this->getMock('J\Request\Message\MessageInterface');


		$this->message_hydrator = new MessageHydrator($this->value_factory);

	}

	/**
	 * @test
	 */
	public function hydratesMessageProperly() {
		$this->message->expects($this->atLeastOnce())->method('setId')->with($this->id);
		$this->message->expects($this->atLeastOnce())->method('setJsonrpc')->with($this->jsonrpc);
		$this->message->expects($this->atLeastOnce())->method('setMethod')->with($this->method);
		$this->message->expects($this->atLeastOnce())->method('setParams')->with($this->params);

		$this->message_hydrator->__invoke(
			$this->message,
			$this->msg_data
		);


	}

	/**
	 * @test
	 * @testdox sets message's exception on invalid property value
	 */
	public function setsMessageExceptionOnInvalidPropertyValue() {
		$exception = new InvalidObjectValue();

		$this->value_factory->expects($this->any())
			->method('createId')
			->will($this->returnCallback(function () use ($exception) { throw $exception; }));

		$this->message->expects($this->never())->method('setId');
		$this->message->expects($this->atLeastOnce())->method('setJsonrpc')->with($this->jsonrpc);
		$this->message->expects($this->atLeastOnce())->method('setMethod')->with($this->method);
		$this->message->expects($this->atLeastOnce())->method('setParams')->with($this->params);
		$this->message->expects($this->once())->method('setException');

		$this->message_hydrator->__invoke(
			$this->message,
			$this->msg_data
		);
	}

	/**
	 * @test
	 * @testdox sets message's exception on request exception
	 */
	public function setsMessageExceptionOnRequestException() {

		$this->message->expects($this->any())->method('setId')->with($this->id);
		$this->message->expects($this->any())->method('setJsonrpc')->with($this->jsonrpc);
		$this->message->expects($this->any())->method('setMethod')->with($this->method);
		$this->message->expects($this->any())->method('setParams')->with($this->params);
		$this->message->expects($this->once())->method('setException');

		$this->msg_data->exception = new \Exception();

		$this->message_hydrator->__invoke(
			$this->message,
			$this->msg_data
		);
	}
}
