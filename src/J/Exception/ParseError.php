<?php

namespace J\Exception;

/**
 * Class ParseError
 *
 * @package J\Exception
 */
final class ParseError extends JsonRpcException {

    /**
     * @return string
     */
    protected function getFaultMessage()
    {
        return 'Parse error';
    }

    /**
     * @return int
     */
    protected function getFaultCode()
    {
        return -32700;
    }
}
