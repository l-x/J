<?php

namespace J\Tests\Response;

use J\Response\Response;

/**
 * Class ResponseTest
 *
 * @package J\Tests\Response
 */
class ResponseTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Response
	 */
	private $response;

	public function setUp() {
		$this->response = new Response();
	}

	/**
	 * @test
	 * @testdox multi_call is initially false
	 */
	public function multiCallIsInitiallyFalse() {
		$this->assertFalse($this->response->getMultiCall());
	}

	/**
	 * @test
	 * @testdox setter and getter for multi_call work as expected
	 */
	public function multiCall() {
		$this->response->setMultiCall(true);
		$this->assertTrue($this->response->getMultiCall());

		$this->response->setMultiCall(false);
		$this->assertFalse($this->response->getMultiCall());
	}

	/**
	 * @test
	 * @testdox messages is initially an empty array
	 */
	public function messagesIsIntiallyEmpty() {
		$this->assertEquals(array(), $this->response->getMessages());
	}

	/**
	 * @test
	 * @testdox setter and getter for messages work as expected
	 */
	public function messages() {
		$message = $this->getMock('J\Response\Message\MessageInterface');
		$this->response->addMessage($message);

		$this->assertSame(array($message), $this->response->getMessages());
	}
}
