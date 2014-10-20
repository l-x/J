<?php

namespace J\Tests\Response\Message\Error;

use J\Response\Message\Error\ErrorHydrator;

/**
 * Class ErrorHydratorTest
 *
 * @package J\Tests\Response\Message\Error
 */
class ErrorHydratorTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var ErrorHydrator
	 */
	private $hydrator;

	public function setUp() {
		$this->error_registry = new \ArrayObject(array(
				0                              => new \Exception(), // Fallback exception
				'InvalidArgumentException'     => new \Exception(), // Registered exception
		                'RuntimeException'             => new \Exception('default error message'), // Exception with default message
		                'LogicException'               => new \Exception(null, 1312), // Exception with default code
			)
		);
		$this->value_factory = $this->getMock('J\Value\ValueFactoryInterface');
		$this->hydrator = new ErrorHydrator($this->error_registry, $this->value_factory);

		$this->error = $this->getMock('J\Response\Message\Error\ErrorInterface');
	}

	private function hydratorTest(\Exception $exception, $expected_code, $expected_message) {
		$code_obj = $this->getMockBuilder('J\Value\Code')
			->disableOriginalConstructor()
			->getMock();

		$message_obj = $this->getMockBuilder('J\Value\Message')
			->disableOriginalConstructor()
			->getMock();

		$this->value_factory->expects($this->any())
			->method('createCode')
			->with($expected_code)
			->willReturn($code_obj);

		$this->value_factory->expects($this->any())
			->method('createMessage')
			->with($expected_message)
			->willReturn($message_obj);

		$this->error->expects($this->atLeastOnce())
			->method('setCode')
			->with($code_obj);

		$this->error->expects($this->atLeastOnce())
			->method('setMessage')
			->with($message_obj);

		$this->hydrator->__invoke($this->error, $exception);
	}

	/**
	 * @test
	 * @testdox Hydrates properly on non-registered exceptions
	 */
	public function fallbackException() {
		$exception = new \Exception('error message', 42);
		$this->hydratorTest(
			$exception,
			$exception->getCode(),
			$exception->getMessage()
		);
	}

	/**
	 * @test
	 * @testdox Hydrates properly on registered exceptions
	 */
	public function registeredException() {
		$exception = new \InvalidArgumentException('error message', 42);
		$this->hydratorTest(
			$exception,
			$exception->getCode(),
			$exception->getMessage()
		);
	}

	/**
	 * @test
	 * @testdox Chooses default code when defined
	 */
	public function registeredExceptionWithDefaultCode() {
		$exception = new \LogicException('error message', 42);
		$this->hydratorTest(
			$exception,
			$this->error_registry[get_class($exception)]->getCode(),
			$exception->getMessage()
		);
	}

	/**
	 * @test
	 * @testdox Chooses default message when defined
	 */
	public function registeredExceptionWithDefaultMessage() {
		$exception = new \RuntimeException('error message', 42);
		$this->hydratorTest(
			$exception,
			$exception->getCode(),
			$this->error_registry[get_class($exception)]->getMessage()
		);
	}
}
