<?php

namespace J\Exception;

/**
 * Class GenericException
 *
 * @package J\Exception
 */
final class InternalError extends JsonRpcException {

    /**
     * @return string
     */
    protected function getFaultMessage()
    {
        return 'Internal error';
    }

    /**
     * @return int
     */
    protected function getFaultCode()
    {
        return -32603;
    }
}
