<?php

namespace J\Message;

/**
 * Interface MessageInterface
 *
 * @package J\Message
 */
interface MessageInterface {

    /**
     * @param Value\Id $id
     *
     * @return void
     */
    public function setId(Value\Id $id);

    /**
     * @return Value\Id
     */
    public function getId();

    /**
     * @param Value\Jsonrpc $jsonrpc
     *
     * @return void
     */
    public function setJsonrpc(Value\Jsonrpc $jsonrpc);

    /**
     * @return Value\Jsonrpc
     */
    public function getJsonrpc();

    /**
     * @param Value\Method $method
     *
     * @return void
     */
    public function setMethod(Value\Method $method);

    /**
     * @return Value\Method
     */
    public function getMethod();

    /**
     * @param Value\Params $params
     *
     * @return void
     */
    public function setParams(Value\Params $params);

    /**
     * @return Value\Params
     */
    public function getParams();
}
