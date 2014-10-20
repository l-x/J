<?php

namespace J\Tests\Services;


use J\Service\ProtocolExceptionServiceProvider;
use J\Tests\Assets\ServiceProviderTestCase;
use Pimple\ServiceProviderInterface;

/**
 * Class ProtocolExceptionServiceProviderTest
 *
 * @package J\Tests\Services
 */
class ProtocolExceptionServiceProviderTest extends ServiceProviderTestCase {

	/**
	 * @return ServiceProviderInterface
	 */
	protected function getServiceProvider() {
		return new ProtocolExceptionServiceProvider();
	}

	protected function checkExceptionConfig($key, $code, $message) {
		$this->assertEquals($code, $this->container[$key]->getCode());
		$this->assertEquals($message, $this->container[$key]->getMessage());
	}

	public function testFallback() {
		$this->simpleServiceTest(0, '\Exception');
		$this->checkExceptionConfig(0, -32603, 'Internal error');
	}

	public function testParseError() {
		$this->simpleServiceTest('J\Exception\ParseError', '\Exception');
		$this->checkExceptionConfig('J\Exception\ParseError', -32700, 'Parse error');
	}

	public function testInvalidRequest() {
		$this->simpleServiceTest('J\Exception\InvalidRequest', '\Exception');
		$this->checkExceptionConfig('J\Exception\InvalidRequest', -32600, 'Invalid request');
	}

	public function testMethodNotFound() {
		$this->simpleServiceTest('J\Exception\MethodNotFound', '\Exception');
		$this->checkExceptionConfig('J\Exception\MethodNotFound', -32601, 'Method not found');
	}
}
