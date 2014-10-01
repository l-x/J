<?php

namespace J\Request;

use J\Value\Jsonrpc;
use J\Value\Id;
use J\Value\Method;
use J\Value\Params;

/**
 * Class Message
 *
 * @package J\Request
 */
class Message implements MessageInterface {

	/**
	 * @var Jsonrpc
	 */
	private $jsonrpc;

	/**
	 * @var Id
	 */
	private $id;

	/**
	 * @var Method
	 */
	private $method;

	/**
	 * @var Params
	 */
	private $params;

	/**
	 * @var null|\Exception
	 */
	private $exception = null;

	/**
	 * @return Id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @param Id $id
	 *
	 * @return null
	 */
	public function setId(Id $id) {
		$this->id = $id;
	}

	/**
	 * @return Jsonrpc
	 */
	public function getJsonrpc() {
		return $this->jsonrpc;
	}

	/**
	 * @param Jsonrpc $jsonrpc
	 *
	 * @return null
	 */
	public function setJsonrpc(Jsonrpc $jsonrpc) {
		$this->jsonrpc = $jsonrpc;
	}

	/**
	 * @return Method
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
	 * @param Method $method
	 *
	 * @return null
	 */
	public function setMethod(Method $method) {
		$this->method = $method;
	}

	/**
	 * @return Params
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * @param Params $params
	 *
	 * @return null
	 */
	public function setParams(Params $params) {
		$this->params = $params;
	}

	/**
	 * @param \Exception $exception
	 *
	 * @return null
	 */
	public function setException(\Exception $exception) {
		$this->exception = $exception;
	}

	/**
	 * @return \Exception|null
	 */
	public function getException() {
		return $this->exception;
	}

	/**
	 * @return bool
	 */
	public function isNotification() {
		return null == $this->getId() || null === $this->getId()->getValue();
	}
} 
