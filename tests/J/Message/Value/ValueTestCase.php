<?php

namespace J\Message\Value;

use J\Exception;

/**
 * Class ValueTestCase
 *
 * @package J\Message\Value
 */
abstract class ValueTestCase extends \PHPUnit_Framework_TestCase {

    /**
     * @return string
     */
    abstract public function getTestClass();

    /**
     * @return array
     */
    abstract public function getValidValues();

    /**
     * @return array
     */
    abstract public function getInvalidValues();

    /**
     * @param array $values
     *
     * @return array
     */
    final private function wrapValues(array $values)
    {
        return array_map(
            function ($value) {
                return [$value];
            },
           $values
        );
    }

    /**
     * @return array
     */
    final public function invalidDataProvider()
    {
        return $this->wrapValues($this->getInvalidValues());
    }

    /**
     * @return array
     */
    final public function validDataProvider()
    {
        return $this->wrapValues($this->getValidValues());
    }

    /**
     * @test
     * @testdox __construct() fails for invalid values
     *
     * @dataProvider invalidDataProvider
     * @param mixed $value
     */
    final public function constructorFailsForInvalidValues($value)
    {
        $this->setExpectedException('J\Exception\InvalidRequest');
        $value_class = $this->getTestClass();
        new $value_class($value);
    }

    /**
     * @test
     * @testdox __construct() succeeds for valid values
     *
     * @dataProvider validDataProvider
     * @param mixed $value
     */
    final public function constructorSucceedsForValidValues($value)
    {
        $value_class = $this->getTestClass();

        /** @var ValueInterface $value_object */
        $value_object = new $value_class($value);

        $this->assertEquals($value, $value_object->getValue());
    }
}
