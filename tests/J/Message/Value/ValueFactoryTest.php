<?php

namespace J\Message\Value;

/**
 * Class ValueFactoryTest
 *
 * @package Message\Value
 */
class ValueFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var ValueFactoryInterface
     */
    private $factory;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->factory = new ValueFactory();
    }

    /**
     * @return array
     */
    public function factoryMethodProvider() {
        return [
            'createId'      => ['createId', __NAMESPACE__.'\Id', 1337],
            'createJsonrpc' => ['createJsonrpc', __NAMESPACE__.'\Jsonrpc', '2.0'],
            'createMethod'  => ['createMethod', __NAMESPACE__.'\Method', 'some.Method'],
            'createParams'  => ['createParams', __NAMESPACE__.'\Params', ['some', 'params']],
        ];
    }

    /**
     * @test
     * @testdox factory method returns proper value object
     *
     * @dataProvider factoryMethodProvider
     * @param string $creator_method
     * @param string $expected_class
     * @param miced $value
     */
    public function factoryMethod($creator_method, $expected_class, $value)
    {
        /** @var ValueInterface $value_object */
        $value_object = $this->factory->$creator_method($value);
        $this->assertInstanceOf($expected_class, $value_object);
        $this->assertEquals($value, $value_object->getValue());
    }
}
