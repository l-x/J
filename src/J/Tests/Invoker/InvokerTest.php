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
	}

	/**
	 * @param $params_value
	 *
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	protected function createMessageMock($params_value = array('some', 'params')) {
		$message = $this->getMock('J\Request\Message\MessageInterface');

		$params = $this->getMockBuilder('J\Value\Params')
			->disableOriginalConstructor()
			->setMethods(array('getValue'))
			->getMock();

		$params->expects($this->any())
			->method('getValue')
			->will($this->returnValue($params_value));

		$message->expects($this->any())
			->method('getParams')
			->will($this->returnValue($params));

		return $message;
	}

	/**
	 * @test
	 * @testdox __invoke succeeds for valid controller callback
	 */
	public function succeedsForValidCallback() {
		$callback = function ($some, $params) {
			return func_get_args();
		};

		$result = $this->invoker->__invoke($this->createMessageMock(array('some', 'params')), $callback);
		$this->assertEquals(array_values(array('some', 'params')), $result);
	}

	/**
	 * @test
	 * @testdox __invoke fails for invalid controller callback
	 * @expectedException \RuntimeException
	 */
	public function failsForInvalidCallback() {
		$callback = 'invalid callback';
		$this->invoker->__invoke($this->createMessageMock(), $callback);
	}

	/**
	 * @test
	 */
	public function succeedsForNullParam() {
		$callback = function ($some = null, $params = null) {
			return func_get_args();
		};

		$result = $this->invoker->__invoke($this->createMessageMock(null), $callback);
		$this->assertEquals(array_values(array()), $result);
	}
}
