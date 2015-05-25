<?php

namespace J\Message\Command;

/**
 * Class CommandFactoryTest
 *
 * @package J\Message\Command
 */
class CommandFactoryTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var CommandFactoryInterface
     */
    private $factory;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->factory = new CommandFactory();
    }

    /**
     * @return array
     */
    public function factoryMethodProvider()
    {
        return [
            'createHydrate'             => [
                'createHydrate',
                'J\Message\Command\Hydrate',
                [$this->getMock('J\Message\Value\ValueFactoryInterface')]
            ],

            'createPrepareRequestData'  => [
                'createPrepareRequestData',
                'J\Message\Command\PrepareRequestData',
                []
            ],

            'createInvoke' => [
                'createInvoke',
                'J\Message\Command\Invoke',
                []
            ],
            'createDetermineControllerCallback' => [
                'createDetermineControllerCallback',
                'J\Message\Command\DetermineControllerCallback',
                [$this->getMock('Interop\Container\ContainerInterface')]
            ],
            'createExtract' => [
                'createExtract',
                'J\Message\Command\Extract',
                [
                    $this->getMock('J\Handler\ResultHandlerInterface'),
                    $this->getMock('J\Handler\ExceptionHandlerInterface'),
                ]
            ],
        ];
    }

    /**
     * @test
     * @testdox the creator methods return the proper command object
     *
     * @dataProvider factoryMethodProvider
     * @param string $creator_method
     * @param string $expected_class
     */
    public function factoryMethod($creator_method, $expected_class, $arguments)
    {
        $callback = [
            $this->factory,
            $creator_method,
        ];

        $result = call_user_func_array($callback, $arguments);

        $this->assertInstanceOf($expected_class, $result);
    }
}
