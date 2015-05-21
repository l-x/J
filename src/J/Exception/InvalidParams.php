<?php

namespace J\Exception;

/**
 * Class InvalidParams
 *
 * @package J\Exception
 */
final class InvalidParams extends JsonRpcException {

    /**
     * @return string
     */
    protected function getFaultMessage()
    {
        return 'Invalid params';
    }

    /**
     * @return int
     */
    protected function getFaultCode()
    {
        return -32602;
    }
}
