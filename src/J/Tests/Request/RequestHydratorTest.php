<?php

namespace J\Tests\Request;

use J\Request\RequestHydrator;

/**
 * Class RequestHydratorTest
 *
 * @package J\Tests\Request
 */
class RequestHydratorTest extends \PHPUnit_Framework_TestCase {

	private $message;

	private $message_hydrator;

	private $request;

	/**
	 * @var RequestHydrator
	 */
	private $hydrator;

	public function setUp() {
		$this->message = $this->getMock('J\Request\Message\MessageInterface');
		$this->message_hydrator = $this->getMock('J\Request\Message\MessageHydratorInterface');


		$this->hydrator = new RequestHydrator($this->message_hydrator, $this->message);
		$this->request = $this->getMock('J\Request\RequestInterface');
	}

	/**
	 * @test
	 * @testdox throws InvalidRequest exception on invalid data
	 * @expectedException \J\Exception\InvalidRequest
	 */
	public function throwsExceptionOnInvalidData() {
		$this->hydrator->__invoke($this->request, 'invalid data');
	}

	/**
	 * @test
	 * @testdox sets multi_call when data is type of array
	 */
	public function setsMultiCallOnArrayData() {
		$this->request->expects($this->atLeastOnce())
			->method('setMultiCall')
			->with(true);

		$this->hydrator->__invoke($this->request, array());
	}

	/**
	 * @test
	 * @testdox wraps single request data object in array
	 */
	public function wrapsObjectInArray() {
		$data = new \stdClass();

		$this->request->expects($this->never())
			->method('setMultiCall');

		$this->message_hydrator->expects($this->once())
			->method('__invoke')
			->with($this->message, $data);

		$this->hydrator->__invoke($this->request, $data);
	}

	/**
	 * @test
	 * @testdox adds hydrated message to request object
	 */
	public function addsMessageToRequest() {
		$data = new \stdClass();

		$this->request->expects($this->once())
			->method('addMessage')
			->with($this->message);

		$this->hydrator->__invoke($this->request, array($data));

	}
}
