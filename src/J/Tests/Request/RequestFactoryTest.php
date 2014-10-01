<?php

namespace J\Tests\Request;

use J\Request\RequestFactory;

class RequestFactoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var RequestFactory
	 */
	private $factory;

	public function setUp() {
		$this->factory = new RequestFactory();
	}

	/**
	 * @test
	 * @testdox createMessage returns instance of Message
	 */
	public function createMessageReturnsMessage() {
		$this->assertInstanceOf('J\Request\Message', $this->factory->createMessage());
	}

	/**
	 * @test
	 * @testdox createRequest returns instance of Request
	 */
	public function createRequestReturnsRequest() {
		$this->assertInstanceOf('J\Request\Request', $this->factory->createRequest());
	}
}
