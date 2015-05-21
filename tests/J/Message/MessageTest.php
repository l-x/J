<?php

namespace J\Message;

use J\Message\Value\ValueInterface;

/**
 * Class MessageTest
 *
 * @package J\Message
 */
class MessageTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var MessageInterface
     */
    private $message;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->message = new Message();
    }

    /**
     * @return array
     */
    public function propertyMethodProvider()
    {
        return [
            'Id'        => ['setId', 'getId', new Value\Id('id')],
            'Jsonrpc'   => ['setJsonrpc', 'getJsonrpc', new Value\Jsonrpc('2.0')],
            'Method'    => ['setMethod', 'getMethod', new Value\Method('method')],
            'Params'    => ['setParams', 'getParams', new Value\Params((object) ['params'])],
        ];
    }

    /**
     * @test
     * @testdox setter and getter for message properties work as expected
     *
     * @dataProvider propertyMethodProvider
     * @param string $setter
     * @param string $getter
     * @param ValueInterface $value_object
     */
    public function propertyMethods($setter, $getter, ValueInterface $value_object)
    {
        $this->message->$setter($value_object);

        $this->assertSame(
            $value_object,
            $this->message->$getter()
        );
    }
}
