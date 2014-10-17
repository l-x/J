<?php

namespace J\Tests\Invoker;

use J\Invoker\Invoker;

/**
 * Class InvokerTest
 *
 * @package Invoker
 */
class InvokerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Invoker
	 */
	private $invoker;

	/**
	 * @var \PHPUnit_Framework_MockObject_Generator
	 */
	private $message;

	/**
	 * @var array
	 */
	private $params_value;

	/**
	 * @return null
	 */
	public function setUp() {
		$this->invoker = new Invoker();
		$this->message = $this->getMock('J\Request\Message\MessageInterface');

		$this->params_value = array('some', 'params');
		$params = $this->getMockBuilder('J\Value\Params')
			->disableOriginalConstructor()
			->setMethods(array('getValue'))
			->getMock();

		$params->expects($this->any())
			->method('getValue')
			->will($this->returnValue($this->params_value));

		$this->message->expects($this->any())
			->method('getParams')
			->will($this->returnValue($params));
	}

	/**
	 * @test
	 * @testdox __invoke succeeds for valid controller callback
	 */
	public function succeedsForValidCallback() {
		$callback = function ($some, $params) {
			return func_get_args();
		};

		$result = $this->invoker->__invoke($this->message, $callback);
		$this->assertEquals($this->params_value, $result);
	}

	/**
	 * @test
	 * @testdox __invoke fails for invalid controller callback
	 * @expectedException \RuntimeException
	 */
	public function failsForInvalidCallback() {
		$callback = 'invalid callback';
		$result = $this->invoker->__invoke($this->message, $callback);
	}
}
