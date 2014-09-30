<?php

namespace J\Tests\Value;

use J\Value;

class ValueFactoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Value\ValueFactory
	 */
	private $factory;

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
}
