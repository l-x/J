<?php

namespace J\Service;

use J\Di\Container;
use J\Di\ServiceProviderInterface;

class ProtocolExceptionServiceProvider implements  ServiceProviderInterface {

	/**
	 * @var array
	 */
	private $base_exceptions = array(
		0                                       => array('Internal error', -32603),
		'J\Exception\ParseError'                => array('Parse error', -32700),
		'J\Exception\InvalidRequest'            => array('Invalid request', -32600),
	        'J\Exception\MethodNotFound'            => array('Method not found', -32601),
	);

	/**
	 * @param Container $dic
	 * @param string|int $key
	 * @param string $message
	 * @param int $code
	 */
	private function registerException(Container $dic, $key, $message, $code) {
		$class = $key;

		if (!class_exists($class)) {
			$class = '\Exception';
		}

		$dic[$key] = function () use ($class, $message, $code) {
			return new $class($message, $code);
		};
	}

	/**
	 * @param Container $dic
	 *
	 * @return null
	 */
	public function register(Container $dic) {
		foreach ($this->base_exceptions as $class => $config) {
			list($message, $code) = $config;
			$this->registerException($dic, $class, $message, $code);
		}
	}
}
