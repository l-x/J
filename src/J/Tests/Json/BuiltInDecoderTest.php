<?php

namespace J\Tests\Json;

use J\Json\BuiltInDecoder;
use J\Json\Exception\ParseError;

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
	 * @return array
	 */
	public function validDataProvider() {
		$data = array(1, 2, 3, 42, 666);
		return array(
			array($data),
			array((object) $data),
		);
	}

	/**
	 * @return array
	 */
	public function invalidDataProvider() {
		return array(
			array(null),
		        array(''),
		        array(0),
		        array(false),
		        array(true),
		        array('string'),
		        array(4.2),
		);
	}

	/**
	 * @test
	 * @testdox succeeds for valid data types
	 * @dataProvider validDataProvider
	 *
	 * @param mixed $value
	 */
	public function succeedsForValidDatatypes($value) {
		require_once __DIR__.'/../Fixtures/json_decode.php';
		$this->assertEquals(
			$value,
			$this->decoder->decode($value)
		);
	}

	/**
	 * @test
	 * @tesdox fails for invalid data types
	 * @dataProvider invalidDataProvider
	 *
	 * @param $value
	 */
	public function failsForInvalidDatatypes($value) {
		require_once __DIR__.'/../Fixtures/json_decode.php';
		$this->setExpectedException('\J\Json\Exception\ParseError');

		$this->decoder->decode($value);
	}
}
