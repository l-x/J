<?php

namespace J\Message;

use J\Message\Command\CommandInterface;

/**
 * Class Tracer
 *
 * @package J\Message
 */
final class Tracer implements TracerInterface {

    /**
     * @var \Exception
     */
    private $exception;

    /**
     * @var MessageInterface
     */
    private $message;

    /**
     * @var \stdClass
     */
    private $request_data;

    /**
     * @var mixed
     */
    private $result;

    /**
     * @var callable
     */
    private $callback;

    /**
     * @var \stdClass
     */
    private $response_data;

    /**
     * @param MessageInterface $message
     */
    public function __construct(MessageInterface $message)
    {
        $this->setMessage($message);
        $this->request_data = new \stdClass();
        $this->response_data = new \stdClass();
    }

    /**
     * {@inheritdoc}
     */
    public function setException(\Exception $exception)
    {
        $this->exception = $exception;
    }

    /**
     * {@inheritdoc}
     */
    public function getException()
    {
        return $this->exception;
    }

    /**
     * {@inheritdoc}
     */
    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * {@inheritdoc}
     */
    public function setRequestData($data)
    {
        $this->request_data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestData()
    {
        return $this->request_data;
    }

    /**
     * {@inheritdoc}
     */
    public function setResult($data)
    {
        $this->result = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param CommandInterface $command
     *
     * @return void
     */
    public function execute(CommandInterface $command)
    {
        $command->actOn($this);
    }

    /**
     * {@inheritdoc}
     */
    public function setCallback(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function getCallback()
    {
        return $this->callback;
    }

    /**
     * @param \stdClass $data
     *
     * @return void
     */
    public function setResponseData(\stdClass $data)
    {
        $this->response_data = $data;
    }

    /**
     * @return \stdClass
     */
    public function getResponseData()
    {
        return $this->response_data;
    }

    /**
     * @return bool
     */
    public function isNotification()
    {
        $id = $this->getMessage()->getId();

        return !$id || !$id->getValue();
    }
}
