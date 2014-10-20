<?php

namespace J\Tests\Response\Message\Error;

use J\Response\Message\Error\ErrorExtractor;

/**
 * Class ErrorExtractorTest
 *
 * @package J\Tests\Response\Message\Error
 */
class ErrorExtractorTest extends \PHPUnit_Framework_TestCase {

	private $extractor;

	public function setUp() {
		$this->extractor = new ErrorExtractor();
	}

	/**
	 * @param string $class
	 * @param mixed $value
	 *
	 * @return \PHPUnit_Framework_MockObject_MockObject
	 */
	private function createValueObjectMock($class, $value) {
		$mock = $this->getMockBuilder($class)
			->disableOriginalConstructor()
			->setMethods(array('getValue'))
			->getMock();
		$mock->expects($this->any())
			->method('getValue')
			->willReturn($value);

		return $mock;
	}

	/**
	 * @test
	 * @testdox extracts error information properly
	 */
	public function extractsErrorInformationProperly() {
		$data = (object) array(
			'code'          => 'error code',
		        'message'       => 'error message',
		);

		$code = $this->createValueObjectMock('J\Value\Code', $data->code);
		$message = $this->createValueObjectMock('J\Value\Message', $data->message);

		$error = $this->getMock('J\Response\Message\Error\ErrorInterface');

		$error->expects($this->any())
			->method('getCode')
			->willReturn($code);

		$error->expects($this->any())
			->method('getMessage')
			->willReturn($message);

		$this->assertEquals($data, $this->extractor->__invoke($error));
	}
}
