<?php

namespace J\Message\Value;

/**
 * Class MethodTest
 *
 * @package J\Message\Value
 */
class MethodTest extends ValueTestCase {

    /**
     * @return string
     */
    public function getTestClass()
    {
        return Method::class;
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        return [
            'some method',
            'some.method',
            '\\some\\method',
            'somemethod',
            '_some_method_'
        ];
    }

    /**
     * @return array
     */
    public function getInvalidValues()
    {
        return [
            null, true, false,
            '',
            1337,
            1.337,
            []
        ];
    }
}
