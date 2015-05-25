<?php

namespace J\Message\Value;

/**
 * Class ParamsTest
 *
 * @package J\Message\Value
 */
class ParamsTest extends ValueTestCase {

    /**
     * @return string
     */
    public function getTestClass()
    {
        return __NAMESPACE__.'\Params';
    }

    /**
     * @return array
     */
    public function getValidValues()
    {
        return [
            ['some', 'values'],
            (object) ['some values'],
        ];
    }

    /**
     * @return array
     */
    public function getInvalidValues()
    {
       return [
           true, false, null,
           'string',
           1337,
           1.337
       ];
    }
}
