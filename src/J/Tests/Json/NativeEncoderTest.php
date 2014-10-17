<?php

namespace J\Tests\Json;

use J\Json\NativeEncoder;

require_once __DIR__.'/../Fixtures/json_encode.php';

/**
 * Class NativeEncoderTest
 *
 * @package J\Tests\Json
 */
class NativeEncoderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var NativeEncoder
	 */
	private $encoder;

	/**
	 *
	 */
	public function setUp() {
		$this->encoder = new NativeEncoder();
	}

	/**
	 * @test
	 * @testdox calls native json_encode
	 */
	public function callsNativeEncoder() {
		$data = 'testdata';

		$this->assertEquals($data, $this->encoder->__invoke($data));
	}
}
