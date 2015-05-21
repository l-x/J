<?php

namespace J\Message\Value;

/**
 * Class JsonrpcTest
 *
 * @package J\Message\Value
 */
class JsonrpcTest extends ValueTestCase {

    /**
     * @return string
     */
    public function getTestClass()
    {
        return Jsonrpc::class;
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        return [
            '2.0',
        ];
    }

    /**
     * @return array
     */
    public function getInvalidValues()
    {
        return [
            true, false,
            [], ['some', 1337, 'data'],
            new \stdClass(),
            '2.1',
            2.0,
            2.1,
            '2.00000000000000000000000000000000000000000000001',
        ];
    }
}
