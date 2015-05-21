<?php

namespace J\Message\Command;

use J\Message\TracerInterface;

/**
 * Class PrepareRequestDataTest
 *
 * @package J\Message\Command
 */
class PrepareRequestDataTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var PrepareRequestData
     */
    private $command;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|TracerInterface
     */
    private $tracer_mock;

    /**
     * @param $request_data
     *
     * @return \PHPUnit_Framework_MockObject_MockObject|TracerInterface
     */
    private function createTracerMock($request_data)
    {
        $mock = $this->getMock(TracerInterface::class);
        $mock->expects($this->any())
            ->method('getRequestData')
            ->willReturn($request_data);

        return $mock;
    }

    /**
     * @return void
     */
    public function setUp()
    {
        $this->command = new PrepareRequestData();
        $this->tracer_mock = $this->getMock(TracerInterface::class);
    }

    /**
     * @test
     * @testdox actOn() behaves well on empty request data object
     */
    public function actOnBehavesWellOnEmptyRequestData()
    {
        $expected_data = (object) [
            'id'        => null,
            'jsonrpc'   => null,
            'method'    => null,
            'params'    => [],
        ];
        $tracer_mock = $this->createTracerMock(new \stdClass);
        $tracer_mock->expects($this->atLeastOnce())
            ->method('setRequestData')
            ->with($expected_data);
        $tracer_mock->expects($this->never())
            ->method('setException');

        $this->command->actOn($tracer_mock);
    }

    /**
     * @test
     * @testdox actOn() behaes well on wellformed request data
     */
    public function actOnBehavesWellOnWellformedRequestData()
    {
        $expected_data = (object) [
            'id'        => 1,
            'jsonrpc'   => 2,
            'method'    => 3,
            'params'    => 4,
        ];
        $tracer_mock = $this->createTracerMock($expected_data);
        $tracer_mock->expects($this->atLeastOnce())
            ->method('setRequestData')
            ->with($expected_data);
        $tracer_mock->expects($this->never())
            ->method('setException');

        $this->command->actOn($tracer_mock);
    }

    /**
     * @test
     * @testdox actOn() behaes well on wellformed request data
     */
    public function actOnBehavesWellOnPartialWellformedRequestData()
    {
        $expected_data = (object) [
            'id'        => null,
            'jsonrpc'   => null,
            'method'    => 'fna',
            'params'    => [],
        ];

        $request_data = (object) [
            'method'    => $expected_data->method,
        ];

        $tracer_mock = $this->createTracerMock($request_data);
        $tracer_mock->expects($this->atLeastOnce())
            ->method('setRequestData')
            ->with($expected_data);
        $tracer_mock->expects($this->never())
            ->method('setException');

        $this->command->actOn($tracer_mock);
    }

    /**
     * @test
     * @testdox actOn() behaves well on unknown properties
     */
    public function actOnBehavesWellOnUnknownProperties()
    {
        $expected_data = (object) [
            'id'        => 1,
            'jsonrpc'   => 2,
            'method'    => 3,
            'params'    => 4,
        ];

        $request_data = clone $expected_data;
        $request_data->unknown = 'fu';

        $tracer_mock = $this->createTracerMock($request_data);
        $tracer_mock->expects($this->atLeastOnce())
            ->method('setRequestData')
            ->with($expected_data);
        $tracer_mock->expects($this->atLeastOnce())
            ->method('setException');

        $this->command->actOn($tracer_mock);
    }
}
