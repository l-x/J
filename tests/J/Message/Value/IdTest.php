<?php

namespace J\Message\Value;

/**
 * Class IdTest
 *
 * @package J\Message\Value
 */
class IdTest extends ValueTestCase {

    /**
     * @return string
     */
    public function getTestClass()
    {
        return __NAMESPACE__.'\Id';
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        return [
            null,
            'id',
            'i d',
            '1337',
            1337,
            PHP_INT_MAX,
            PHP_INT_MAX * -1
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
        ];
    }
}
