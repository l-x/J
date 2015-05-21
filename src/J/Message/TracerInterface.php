<?php

namespace J\Message;

use J\Message\Command\CommandInterface;

/**
 * Interface TracerInterface
 *
 * @package J\Message
 */
interface TracerInterface {

    /**
     * @param \Exception $exception
     *
     * @return void
     */
    public function setException(\Exception $exception);

    /**
     * @return \Exception
     */
    public function getException();

    /**
     * @param MessageInterface $message
     *
     * @return void
     */
    public function setMessage(MessageInterface $message);

    /**
     * @return MessageInterface
     */
    public function getMessage();

    /**
     * @param mixed $data
     *
     * @return void
     */
    public function setRequestData($data);

    /**
     * @return \stdClass
     */
    public function getRequestData();

    /**
     * @param mixed $data
     *
     * @return void
     */
    public function setResult($data);

    /**
     * @return mixed
     */
    public function getResult();

    /**
     * @param callable $callback
     *
     * @return void
     */
    public function setCallback(callable $callback);

    /**
     * @return callable
     */
    public function getCallback();

    /**
     * @param \stdClass $data
     *
     * @return void
     */
    public function setResponseData(\stdClass $data);

    /**
     * @return \stdClass
     */
    public function getResponseData();

    /**
     * @param CommandInterface $command
     *
     * @return void
     */
    public function execute(CommandInterface $command);

    /**
     * @return bool
     */
    public function isNotification();
}
