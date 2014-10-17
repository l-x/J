<?php

namespace J\Request\Message;

use J\Value\Id;
use J\Value\Jsonrpc;
use J\Value\Method;
use J\Value\Params;

/**
 * Class Message
 *
 * @package J\Request
 */
class Message implements MessageInterface {

	/**
	 * @var Id
	 */
	private $id;

	/**
	 * @var Jsonrpc
	 */
	private $jsonrpc;

	/**
	 * @var Method
	 */
	private $method;

	/**
	 * @var Params
	 */
	private $params;

	/**
	 * @var \Exception
	 */
	private $exception;

	/**
	 * @param Id $id
	 *
	 * @return null
	 */
	public function setId(Id $id) {
		$this->id = $id;
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
	 * @param Method $method
	 *
	 * @return null
	 */
	public function setMethod(Method $method) {
		$this->method = $method;
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
	 * @return Method
	 */
	public function getMethod() {
		return $this->method;
	}

	/**
	 * @return Params
	 */
	public function getParams() {
		return $this->params;
	}

	/**
	 * @return Id
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return Jsonrpc
	 */
	public function getJsonrpc() {
		return $this->jsonrpc;
	}

	/**
	 * @return bool
	 */
	public function isNotification() {
		return (
			null == $this->getId() ||
			null === $this->getId()->getValue()
		);
	}
}
