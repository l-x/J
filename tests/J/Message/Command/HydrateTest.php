<?php

namespace J\Message\Command;

use J\Exception\InvalidRequest;
use J\Message\MessageInterface;
use J\Message\TracerInterface;
use J\Message\Value\Id;
use J\Message\Value\Jsonrpc;
use J\Message\Value\Method;
use J\Message\Value\Params;
use J\Message\Value\ValueFactoryInterface;

/**
 * Class HydrateTest
 *
 * @package J\Message\Command
 */
class HydrateTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var Hydrate
     */
    private $hydrate;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|ValueFactoryInterface
     */
    private $value_factory_mock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|MessageInterface
     */
    private $message_prototype_mock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TracerInterface
     */
    private $tracer_mock;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->message_prototype_mock = $this->getMock(MessageInterface::class);
        $this->value_factory_mock = $this->getMock(ValueFactoryInterface::class);
        $this->hydrate = new Hydrate(
            $this->value_factory_mock,
            $this->message_prototype_mock
        );
        $this->tracer_mock = $this->getMock(TracerInterface::class);
    }

    /**
     * @test
     * @testdox actOn() behaves well for valid request data
     */
    public function actOnForValidData()
    {
        $request_data = (object) [
            'id'        => 'sna',
            'method'    => 'fu',
            'jsonrpc'   => '2.0',
            'params'    => [1, 3, 3, 7],
        ];

        $id = new Id($request_data->id);
        $jsonrpc = new Jsonrpc($request_data->jsonrpc);
        $method = new Method($request_data->method);
        $params = new Params($request_data->params);

        $this->value_factory_mock->expects($this->once())
            ->method('createId')
            ->with($request_data->id)
            ->willReturn($id);
        $this->value_factory_mock->expects($this->once())
            ->method('createJsonrpc')
            ->with($request_data->jsonrpc)
            ->willReturn($jsonrpc);
        $this->value_factory_mock->expects($this->once())
            ->method('createMethod')
            ->with($request_data->method)
            ->willReturn($method);
        $this->value_factory_mock->expects($this->once())
            ->method('createParams')
            ->with($request_data->params)
            ->willReturn($params);

        $this->tracer_mock->expects($this->any())
            ->method('getRequestData')
            ->willReturn($request_data);
        $this->tracer_mock->expects($this->never())
            ->method('setException');
        $this->tracer_mock->expects($this->any())
            ->method('getMessage')
            ->willReturn($this->message_prototype_mock);

        $this->hydrate->actOn($this->tracer_mock);
    }

    /**
     * @test
     * @testdox actOn() behaves well on invalid property values in request
     */
    public function actOnForInvalidnPropertyValues()
    {
        $request_data = (object) [
            'id'        => 'sna',
            'method'    => 'fu',
            'jsonrpc'   => '2.1',
            'params'    => [1, 3, 3, 7],
        ];

        $invalid_request = new InvalidRequest();

        $id = new Id($request_data->id);
        $method = new Method($request_data->method);
        $params = new Params($request_data->params);

        $this->value_factory_mock->expects($this->any())
            ->method('createId')
            ->with($request_data->id)
            ->willReturn($id);
        $this->value_factory_mock->expects($this->any())
            ->method('createJsonrpc')
            ->willThrowException($invalid_request);
        $this->value_factory_mock->expects($this->any())
            ->method('createMethod')
            ->with($request_data->method)
            ->willReturn($method);
        $this->value_factory_mock->expects($this->any())
            ->method('createParams')
            ->with($request_data->params)
            ->willReturn($params);

        $this->tracer_mock->expects($this->any())
            ->method('getRequestData')
            ->willReturn($request_data);
        $this->tracer_mock->expects($this->atLeastOnce())
            ->method('setException')
            ->with($invalid_request);
        $this->tracer_mock->expects($this->any())
            ->method('getMessage')
            ->willReturn($this->message_prototype_mock);

        $this->hydrate->actOn($this->tracer_mock);
    }
}
