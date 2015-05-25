<?php

namespace J\Message;

use J\Message\Command\CommandInterface;
use J\Message\Value\Id;

/**
 * Class TracerTest
 *
 * @package J\Message
 */
class TracerTest extends \PHPUnit_Framework_TestCase {

    /**
     * @var TracerInterface
     */
    private $tracer;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject|MessageInterface
     */
    private $message_mock;

    /**
     * @return void
     */
    public function setUp()
    {
        $this->message_mock = $this->getMock('J\Message\MessageInterface');
        $this->tracer = new Tracer($this->message_mock);
    }

    /**
     * @return array
     */
    public function propertyMethodProvider()
    {
        return [
            'Exception'     => ['setException', 'getException', new \Exception()],
            'Message'       => ['setMessage', 'getMessage', $this->getMock('J\Message\MessageInterface')],
            'RequestData'   => ['setRequestData', 'getRequestData', (object) []],
            'Result'        => ['setResult', 'getResult', new \stdClass()],
            'Callback'      => ['setCallback', 'getCallback', function () {}],
            'ResponseData'  => ['setResponseData', 'getResponseData', new \stdClass()]
        ];
    }

    /**
     * @test
     * @testdox setter and getter for the properties work as expected
     *
     * @dataProvider propertyMethodProvider
     * @param string $setter
     * @param string $getter
     * @param mixed $value
     */
    public function propertyMethods($setter, $getter, $value)
    {
        $this->tracer->$setter($value);
        $this->assertSame(
            $value,
            $this->tracer->$getter()
        );
    }

    /**
     * @test
     * @testdox execute() calls proper command method
     */
    public function execute()
    {
        $command = $this->getMock('J\Message\Command\CommandInterface');
        $command->expects($this->once())
            ->method('actOn')
            ->with($this->tracer);

        $this->tracer->execute($command);
    }

    /**
     * @test
     * @testdox __construct() sets the initial values for request data and message
     */
    public function constructorSetsInitialValues()
    {
        $this->assertInstanceOf('stdClass', $this->tracer->getRequestData());
        $this->assertInstanceOf('J\Message\MessageInterface', $this->tracer->getMessage());
    }

    /**
     * @test
     * @testdox isNotification() returns false on existing message id
     */
    public function isNotificationOnExistingMessageId()
    {
        $this->message_mock->expects($this->any())
            ->method('getId')
            ->willReturn(new Id('fu'));
        $this->assertFalse($this->tracer->isNotification());
    }

    /**
     * @test
     * @testdox isNotification() returns true on  id value null
     */
    public function isNotificationOnNullId()
    {
        $this->message_mock->expects($this->any())
            ->method('getId')
            ->willReturn(new Id(null));
        $this->assertTrue($this->tracer->isNotification());
    }

    /**
     * @test
     * @testdox isNotification() returns true on missing id value object
     */
    public function isNotificationOnMissingId()
    {
        $this->message_mock->expects($this->any())
            ->method('getId')
            ->willReturn(null);
        $this->assertTrue($this->tracer->isNotification());
    }}
