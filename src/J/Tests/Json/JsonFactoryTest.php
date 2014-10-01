<?php

namespace J\Tests\Json;

use J\Json\JsonFactory;

class JsonFactoryTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var JsonFactory
	 */
	private $factory;

	public function setUp() {
		$this->factory = new JsonFactory();
	}

	/**
	 * @test
	 * @testdox createDecoder returns instance of BuiltinDecoder
	 */
	public function createDecoderReturnsDecoder() {
		$this->assertInstanceOf('J\Json\BuiltinDecoder', $this->factory->createDecoder());
	}

	/**
	 * @test
	 * @testdox createEncoder returns instance of BuiltinEncoder
	 */
	public function createEncoderReturnsEncoder() {
		$this->assertInstanceOf('J\Json\BuiltinEncoder', $this->factory->createEncoder());
	}
}
