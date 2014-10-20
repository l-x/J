<?php
namespace J\Response\Message;

use J\Response\Message\Error\Error;
use J\Response\Message\Error\ErrorInterface;
use J\Value\Id;
use J\Value\Jsonrpc;
use J\Value\Result;

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
	 * @param Result $result
	 *
	 * @return null
	 */
	public function setResult(Result $result);

	/**
	 * @return Result
	 */
	public function getResult();

	/**
	 * @param ErrorInterface $error
	 *
	 * @return null
	 */
	public function setError(ErrorInterface $error);

	/**
	 * @return Error
	 */
	public function getError();
}
