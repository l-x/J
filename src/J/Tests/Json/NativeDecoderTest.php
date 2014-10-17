<?php

namespace J\Tests\Json;

use J\Json\NativeDecoder;

require_once __DIR__.'/../Fixtures/json_decode.php';

/**
 * Class NativeDecoderTest
 *
 * @package J\Tests\Json
 */
class NativeDecoderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var NativeEncoder
	 */
	private $decoder;

	/**
	 *
	 */
	public function setUp() {
		$this->decoder = new NativeDecoder();
	}

	/**
	 * @test
	 * @testdox calls native json_decode
	 */
	public function callsNativeDecoder() {
		$data = 'testdata';

		$this->assertEquals($data, $this->decoder->__invoke($data));
	}
}
