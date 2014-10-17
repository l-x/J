<?php

namespace J\Tests\Value;

use J\Value;
use J\Value\ValueFactory;

class ValueFactoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var ValueFactory
	 */
	private $factory;

	/**
	 *
	 */
	public function setUp() {
		$this->factory = new Value\ValueFactory();
	}

	/**
	 * @test
	 * @testdox createId returns Id value object instance
	 */
	public function createIdReturnsIdValue() {
		$this->assertInstanceOf('J\Value\Id', $this->factory->createId('id'));
	}

	/**
	 * @test
	 * @testdox createJsonrpc returns Jsonrpc value object instance
	 */
	public function createJsonrpcReturnsJsonrpcValue() {
		$this->assertInstanceOf('J\Value\Jsonrpc', $this->factory->createJsonrpc('2.0'));
	}

	/**
	 * @test
	 * @testdox createMethod returns Method value object instance
	 */
	public function createMethodReturnsMethodValue() {
		$this->assertInstanceOf('J\Value\Method', $this->factory->createMethod('some_method'));
	}

	/**
	 * @test
	 * @testdox createParams returns Params value object instance
	 */
	public function createParamsReturnsParamsValue() {
		$this->assertInstanceOf('J\Value\Params', $this->factory->createParams(array(6, 6, 6)));
	}

	/**
	 * @test
	 * @testdox createCode returns Code value object instance
	 */
	public function createCodeReturnsCodeValue() {
		$this->assertInstanceOf('J\Value\Code', $this->factory->createCode(4711));
	}

	/**
	 * @test
	 * @testdox createMessage returns Message value object instance
	 */
	public function createMessageReturnsMessageValue() {
		$this->assertInstanceOf('J\Value\Message', $this->factory->createMessage('message'));
	}

	/**
	 * @test
	 * @testdox createData returns Data value object instance
	 */
	public function createDataReturnsDataValue() {
		$this->assertInstanceOf('J\Value\Data', $this->factory->createData('data'));
	}

	/**
	 * @test
	 * @testdox createResult returns Result value object instance
	 */
	public function createResultReturnsResultValue() {
		$this->assertInstanceOf('J\Value\Result', $this->factory->createResult('some result'));
	}
}
