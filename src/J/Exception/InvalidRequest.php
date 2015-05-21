<?php

namespace J\Exception;

/**
 * Class InvalidRequest
 *
 * @package J\Exception
 */
final class InvalidRequest extends JsonRpcException {

    /**
     * @return string
     */
    protected function getFaultMessage()
    {
        return 'Invalid Request';
    }

    /**
     * @return int
     */
    protected function getFaultCode()
    {
        return -32600;
    }
}
