<?php
/**
 * Created by PhpStorm.
 * User: lx
 * Date: 01.10.14
 * Time: 05:24
 */
namespace J\Value;

/**
 * Class ValueFactory
 *
 * @package J\Value
 */
interface ValueFactoryInterface {

	/**
	 * @param mixed $id
	 *
	 * @return Id
	 */
	public function createId($id);

	/**
	 * @param string $version
	 *
	 * @return Jsonrpc
	 */
	public function createJsonrpc($version);

	/**
	 * @param $name
	 *
	 * @return Method
	 */
	public function createMethod($name);

	/**
	 * @param array|object $params
	 *
	 * @return Params
	 */
	public function createParams($params);

	/**
	 * @param int $code
	 *
	 * @return Code
	 */
	public function createCode($code);

	/**
	 * @param string $message
	 *
	 * @return Message
	 */
	public function createMessage($message);

	/**
	 * @param mixed $data
	 *
	 * @return Data
	 */
	public function createData($data);
}
