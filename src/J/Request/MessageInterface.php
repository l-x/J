<?php

namespace J\Request;

use J\Value\Params;
use J\Value\Id;
use J\Value\Method;
use J\Value\Jsonrpc;

/**
 * Class Message
 *
 * @package J\Request
 */
interface MessageInterface {

	/**
	 * @return Id
	 */
	public function getId();

	/**
	 * @param Id $id
	 *
	 * @return null
	 */
	public function setId(Id $id);

	/**
	 * @return Jsonrpc
	 */
	public function getJsonrpc();

	/**
	 * @param Jsonrpc $jsonrpc
	 *
	 * @return null
	 */
	public function setJsonrpc(Jsonrpc $jsonrpc);

	/**
	 * @return Method
	 */
	public function getMethod();

	/**
	 * @param Method $method
	 *
	 * @return null
	 */
	public function setMethod(Method $method);

	/**
	 * @return Params
	 */
	public function getParams();

	/**
	 * @param Params $params
	 *
	 * @return null
	 */
	public function setParams(Params $params);

	/**
	 * @param \Exception $exception
	 *
	 * @return null
	 */
	public function setException(\Exception $exception);

	/**
	 * @return \Exception|null
	 */
	public function getException();

	/**
	 * @return bool
	 */
	public function isNotification();
}
