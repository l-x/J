<?php

namespace J\Response\Message;

use J\Response\Message\Error\ErrorInterface;
use J\Value\Id;
use J\Value\Jsonrpc;
use J\Value\Result;

/**
 * Class Message
 *
 * @package J\Response\Message
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
	 * @var Result
	 */
	private $result;

	/**
	 * @var Error
	 */
	private $error;

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
	 * @param Result $result
	 *
	 * @return null
	 */
	public function setResult(Result $result) {
		$this->result = $result;
	}

	/**
	 * @param ErrorInterface $error
	 *
	 * @return null
	 */
	public function setError(ErrorInterface $error) {
		$this->error = $error;
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
	 * @return Result
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * @return Error
	 */
	public function getError() {
		return $this->error;
	}
}
