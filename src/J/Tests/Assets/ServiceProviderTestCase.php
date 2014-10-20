<?php

namespace J\Tests\Assets;

use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

/**
 * Class ServiceProviderTestCase
 *
 * @package J\Tests\Assets
 */
abstract class ServiceProviderTestCase extends \PHPUnit_Framework_TestCase {

	/**
	 * @var Container
	 */
	protected  $container;

	/**
	 * @var ServiceProviderInterface
	 */
	protected $service_provider;

	/**
	 *
	 */
	public function setUp() {
		$this->container = new Container();
		$this->service_provider = $this->getServiceProvider();
		$this->service_provider->register($this->container);
	}

	/**
	 * @return ServiceProviderInterface
	 */
	abstract protected function getServiceProvider();

	/**
	 * @param string $key
	 * @param string $class
	 */
	protected function simpleServiceTest($key, $class) {
		$this->assertArrayHasKey($key, $this->container);
		$this->assertInstanceOf($class, $this->container[$key]);
	}
} 
