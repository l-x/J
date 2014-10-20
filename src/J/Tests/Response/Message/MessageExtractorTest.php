<?php

namespace J\Tests\Response\Message;

use J\Response\Message\MessageExtractor;

/**
 * Class MessageExtractorTest
 *
 * @package J\Tests\Response\Message
 * @todo Remove code duplication in tests
 */
class MessageExtractorTest extends \PHPUnit_Framework_TestCase {

	public function setUp() {
		$this->error_extractor = $this->getMock('J\Response\Message\Error\ErrorExtractorInterface');

		$this->extractor = new MessageExtractor($this->error_extractor);
		$this->message = $this->getMock('J\Response\Message\MessageInterface');
	}

	/**
	 * @param string $class
	 * @param mixed $value
	 *
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	private function createValueObjectMock($class, $value) {
		$mock = $this->getMockBuilder($class)
			->disableOriginalConstructor()
			->setMethods(array('getValue'))
			->getMock();
		$mock->expects($this->any())
			->method('getValue')
			->willReturn($value);

		return $mock;
	}

	/**
	 * @test
	 */
	public function extractsResultProperly() {
		$data = (object) array(
			'id'            => 'some_id',
		        'jsonrpc'       => 'jsonrpc_version',
		        'result'        => 'some result',
		);

		$id =           $this->createValueObjectMock('J\Value\Id', $data->id);
		$json_rpc =     $this->createValueObjectMock('J\Value\Jsonrpc', $data->jsonrpc);
		$result =       $this->createValueObjectMock('J\Value\Result', $data->result);


		$this->message->expects($this->any())
			->method('getError')
			->willReturn(null);

		$this->message->expects($this->any())
			->method('getResult')
			->willReturn($result);

		$this->message->expects($this->any())
			->method('getId')
			->willReturn($id);

		$this->message->expects($this->any())
			->method('getJsonrpc')
			->willReturn($json_rpc);

		$this->assertEquals($data, $this->extractor->__invoke($this->message));
	}

	/**
	 * @test
	 */
	public function extractsErrorProperly() {

		$data = (object) array(
			'id'            => 'some_id',
			'jsonrpc'       => 'jsonrpc_version',
		        'error'         => $this->getMock('J\Response\Message\Error\ErrorInterface')
		);

		$id =           $this->createValueObjectMock('J\Value\Id', $data->id);
		$json_rpc =     $this->createValueObjectMock('J\Value\Jsonrpc', $data->jsonrpc);


		$this->message->expects($this->any())
			->method('getId')
			->willReturn($id);

		$this->message->expects($this->any())
			->method('getJsonrpc')
			->willReturn($json_rpc);


		$error = $this->getMock('J\Response\Message\Error\ErrorInterface');

		$this->message->expects($this->any())
			->method('getError')
			->willReturn($error);

		$this->error_extractor->expects($this->any())
			->method('__invoke')
			->with($error)
			->will($this->returnArgument(0));


		$this->assertEquals($data, $this->extractor->__invoke($this->message));
	}
}
