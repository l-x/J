<?php

namespace J\Tests\Json;

use J\Json\BuiltInEncoder;

/**
 * Class BuiltInDecoderTest
 *
 * @package J\Tests\Json
 */
class BuiltInEncoderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var BuiltInEncoder
	 */
	private $encoder;

	public function setUp() {
		$this->encoder = new BuiltInEncoder();
	}

	/**
	 * @test
	 * @testdox inherits DecoderInterface
	 */
	public function inheritsEncoderInterface() {
		$this->assertInstanceOf('J\Json\EncoderInterface', $this->encoder);
	}

	/**
	 * @test
	 * @testdox encode calls builtin json_encode properly
	 */
	public function callsBuiltInJsonEncode() {
		require_once __DIR__.'/../Fixtures/json_encode.php';
		$data = array('some', 'structure');

		$this->assertEquals(
			array($data),
			$this->encoder->encode($data)
		);
	}
}
