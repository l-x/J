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

	/**
	 * @param int $code
	 *
	 * @return Code
	 */
	public function createCode($code) {
		return new Code($code);
	}

	/**
	 * @param string $message
	 *
	 * @return Message
	 */
	public function createMessage($message) {
		return new Message($message);
	}

	/**
	 * @param mixed $data
	 *
	 * @return Data
	 */
	public function createData($data) {
		return new Data($data);
	}


	/**
	 * @param $result
	 *
	 * @return mixed
	 */
	public function createResult($result) {
		return new Result($result);
	}
}
