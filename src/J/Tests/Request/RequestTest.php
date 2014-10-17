<?php

namespace J\Tests\Request;

use J\Request\Request;

/**
 * Class RequestTest
 *
 * @package J\Tests\Request
 */
class RequestTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Request
	 */
	private $request;

	/**
	 *
	 */
	public function setUp() {
		$this->request = new Request();
	}

	/**
	 * @test
	 * @testdox multi_call is initially false
	 */
	public function multicallIsInitiallyFalse() {
		$this->assertFalse($this->request->getMultiCall());
	}

	/**
	 * @test
	 * @testdox setting multi_call works as expected
	 */
	public function setMultiCall() {
		$this->request->setMultiCall(true);
		$this->assertTrue($this->request->getMultiCall());
		$this->request->setMultiCall(false);
		$this->assertFalse($this->request->getMultiCall());
	}

	/**
	 * @test
	 * @testdox addMessage works as expected
	 */
	public function addMessage() {
		$message = $this->getMock('J\Request\Message\MessageInterface');
		$this->request->addMessage($message);

		$this->assertSame(array($message), $this->request->getMessages());
	}
}
