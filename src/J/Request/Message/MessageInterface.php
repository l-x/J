<?php

namespace J\Request\Message;

use J\Value\Id;
use J\Value\Jsonrpc;
use J\Value\Method;
use J\Value\Params;

/**
 * Interface MessageInterface
 *
 * @package J\Request
 */
interface MessageInterface {

	/**
	 * @param Id $id
	 *
	 * @return null
	 */
	public function setId(Id $id);

	/**
	 * @return Id
	 */
	public function getId();

	/**
	 * @param Jsonrpc $jsonrpc
	 *
	 * @return null
	 */
	public function setJsonrpc(Jsonrpc $jsonrpc);

	/**
	 * @return Jsonrpc
	 */
	public function getJsonrpc();

	/**
	 * @param Method $method
	 *
	 * @return null
	 */
	public function setMethod(Method $method);

	/**
	 * @return Method
	 */
	public function getMethod();

	/**
	 * @param Params $params
	 *
	 * @return null
	 */
	public function setParams(Params $params);

	/**
	 * @return Params
	 */
	public function getParams();

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
