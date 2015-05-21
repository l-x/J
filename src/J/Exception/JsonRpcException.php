<?php

namespace J\Exception;

/**
 * Class JsonRpcException
 *
 * @package J\Exception
 */
abstract class JsonRpcException extends \Exception {

    /**
     *
     */
    public function __construct()
    {
        parent::__construct(
            $this->getFaultMessage(),
            $this->getFaultCode()
        );
    }

    /**
     * @return string
     */
    abstract protected function getFaultMessage();

    /**
     * @return int
     */
    abstract protected function getFaultCode();
}
