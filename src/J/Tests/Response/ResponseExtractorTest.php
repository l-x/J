<?php

namespace J\Tests\Response;


use J\Response\ResponseExtractor;

class ResponseExtractorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var ResponseExtractor
	 */
	private $extractor;

	private $message_extractor;

	private $response;

	/**
	 *
	 */
	public function setUp() {
		$this->message = $this->getMock('J\Response\Message\MessageInterface');

		$this->message_extractor = $this->getMockBuilder('J\Response\Message\MessageExtractor')
			->disableOriginalConstructor()
			->setMethods(array('__invoke'))
			->getMock();
		$this->message_extractor->expects($this->any())
			->method('__invoke')
			->will($this->returnArgument(0));

		$this->response = $this->getMock('J\Response\ResponseInterface');

		$this->extractor = new ResponseExtractor($this->message_extractor);
	}

	/**
	 * @test
	 * @testdox extracts multi_call response properly
	 */
	public function extractsMultiCallMessages() {
		$messages = array(
			clone $this->message,
		);

		$this->response->expects($this->any())
			->method('getMessages')
			->willReturn($messages);

		$this->response->expects($this->any())
			->method('getMultiCall')
			->willReturn(true);

		$this->assertSame($messages, $this->extractor->__invoke($this->response));
	}

	/**
	 * @test
	 * @testdox extracts non-multi_call response properly
	 */
	public function extractsSingleCallMessages() {
		$message = clone $this->message;

		$this->response->expects($this->any())
			->method('getMessages')
			->willReturn(array($message));

		$this->response->expects($this->any())
			->method('getMultiCall')
			->willReturn(false);

		$this->assertSame($message, $this->extractor->__invoke($this->response));
	}

}
