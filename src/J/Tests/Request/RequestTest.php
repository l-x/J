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

	public function setUp() {
		$this->request = new Request();
	}

	/**
	 * @test
	 * @testdox addMessage adds message to request
	 */
	public function addMessageAddsMessage() {
		$message = $this->getMock('J\Request\MessageInterface');
		$this->request->addMessage($message);

		$this->assertContains($message, $this->request->getMessages());
	}

	/**
	 * @test
	 * @testdox addMessage sets multi call property correctly
	 */
	public function addMessageSetsMultiCall() {
		$this->assertEmpty($this->request->getMessages());

		$this->request->addMessage($this->getMock('J\Request\MessageInterface'));
		$this->assertFalse($this->request->isMultiCall());

		$this->request->addMessage($this->getMock('J\Request\MessageInterface'));
		$this->assertTrue($this->request->isMultiCall());
	}


}
