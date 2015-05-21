<?php

namespace J\Message;

/**
 * Class Message
 *
 * @package J\Message
 */
final class Message implements MessageInterface {

    /**
     * @var Value\Id
     */
    private $id;

    /**
     * @var Value\Jsonrpc
     */
    private $jsonrpc;

    /**
     * @var Value\Method
     */
    private $method;

    /**
     * @var Value\Params
     */
    private $params;

    /**
     * {@inheritdoc}
     */
    public function setId(Value\Id $id)
    {
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setJsonrpc(Value\Jsonrpc $jsonrpc)
    {
        $this->jsonrpc = $jsonrpc;
    }

    /**
     * {@inheritdoc}
     */
    public function getJsonrpc()
    {
        return $this->jsonrpc;
    }

    /**
     * {@inheritdoc}
     */
    public function setMethod(Value\Method $method)
    {
        $this->method = $method;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod()
    {
       return $this->method;
    }

    /**
     * {@inheritdoc}
     */
    public function setParams(Value\Params $params)
    {
        $this->params = $params;
    }

    /**
     * {@inheritdoc}
     */
    public function getParams()
    {

        return $this->params;
    }
}
