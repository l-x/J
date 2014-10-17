<?php

namespace J\Tests\Di;

use J\Di\Container;

/**
 * Class ContainerTest
 *
 * @package J\Tests\Di
 */
class ContainerTest extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Container
	 */
	private $container;

	/**
	 * @var
	 */
	private $service_provider;

	public function setUp() {
		$this->container = new Container();
		$this->service_provider = $this->getMock('J\Di\ServiceProviderInterface');
	}

	/**
	 * @test
	 * @testdox registration of service providers works as expected
	 */
	public function registerHandlesServiceProviderProperly() {
		$this->service_provider->expects($this->atLeastOnce())
			->method('register')
			->with($this->container);

		$this->container->register($this->service_provider);
	}

	/**
	 * @test
	 * @testdox setting options works as expected
	 */
	public function registerHandlesOptionsProperly() {
		$options = array('some' => 'option', 'another' => 'option');

		$this->container->register($this->service_provider, $options);

		$this->assertEquals(
			array_values($options),
			array(
				$this->container['some'],
				$this->container['another']
			)
		);
	}

	/**
	 * @test
	 * @testdox inherits \Pimple\Comtainer
	 */
	public function inheritsPimpleContainer() {
		$this->assertInstanceOf('\Pimple\Container', $this->container);
	}
}
