<?php

namespace J\Message\Command;

use Interop\Container\ContainerInterface;
use J\Handler\ExceptionHandlerInterface;
use J\Message\Value\ValueFactoryInterface;
use J\Handler\ResultHandlerInterface;

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
                Hydrate::class,
                [$this->getMock(ValueFactoryInterface::class)]
            ],

            'createPrepareRequestData'  => [
                'createPrepareRequestData',
                PrepareRequestData::class,
                []
            ],

            'createInvoke' => [
                'createInvoke',
                Invoke::class,
                []
            ],
            'createDetermineControllerCallback' => [
                'createDetermineControllerCallback',
                DetermineControllerCallback::class,
                [$this->getMock(ContainerInterface::class)]
            ],
            'createExtract' => [
                'createExtract',
                Extract::class,
                [
                    $this->getMock(ResultHandlerInterface::class),
                    $this->getMock(ExceptionHandlerInterface::class),
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
