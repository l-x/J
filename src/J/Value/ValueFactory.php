<?php

namespace J\Value;

/**
 * Class ValueFactory
 *
 * @package J\Value
 */
class ValueFactory implements ValueFactoryInterface {

	/**
	 * @param mixed $id
	 *
	 * @return Id
	 */
	public function createId($id) {
		return new Id($id);
	}

	/**
	 * @param string $version
	 *
	 * @return Jsonrpc
	 */
	public function createJsonrpc($version) {
		return new Jsonrpc($version);
	}

	/**
	 * @param $name
	 *
	 * @return Method
	 */
	public function createMethod($name) {
		return new Method($name);
	}

	/**
	 * @param array|object $params
	 *
	 * @return Params
	 */
	public function createParams($params) {
		return new Params($params);
	}
} 
