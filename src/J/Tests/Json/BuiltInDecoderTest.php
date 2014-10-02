<?php

namespace J\Tests\Json;

use J\Json\BuiltInDecoder;

/**
 * Class BuiltInDecoderTest
 *
 * @package J\Tests\Json
 */
class BuiltInDecoderTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var BuiltInDecoder
	 */
	private $decoder;

	public function setUp() {
		$this->decoder = new BuiltInDecoder();
	}

	/**
	 * @test
	 * @testdox inherits DecoderInterface
	 */
	public function inheritsDecoderInterface() {
		$this->assertInstanceOf('J\Json\DecoderInterface', $this->decoder);
	}

	/**
	 * @test
	 * @testdox succeeds when json_decode returns not null
	 */
	public function succeedsForValidJson() {
		require_once __DIR__.'/../Fixtures/json_decode.php';
		$value = 'not null';
		$this->assertEquals(
			$value,
			$this->decoder->decode($value)
		);
	}

	/**
	 * @test
	 * @testdox fails when json_decode returns null
	 *
	 * @expectedException \J\Json\Exception\ParseError
	 */
	public function failsForInvalidJson() {
		require_once __DIR__.'/../Fixtures/json_decode.php';
		$value = null;
		$this->decoder->decode(null);
	}
}
