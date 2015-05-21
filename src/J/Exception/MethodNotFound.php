<?php

namespace J\Exception;

/**
 * Class MethodNotFound
 *
 * @package J\Exception
 */
final class MethodNotFound extends JsonRpcException {

    /**
     * @return string
     */
    protected function getFaultMessage()
    {
        return 'Method not found';
    }

    /**
     * @return int
     */
    protected function getFaultCode()
    {
        return -32601;
    }
}
