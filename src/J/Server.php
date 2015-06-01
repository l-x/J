<?php

namespace J;

use Interop\Container\ContainerInterface;
use J\Exception\InvalidRequest;
use J\Exception\ParseError;
use J\Handler\ExceptionHandlerInterface;
use J\Handler\ParamsHandlerInterface;
use J\Handler\ResultHandlerInterface;
use J\Message\Command\CommandFactory;
use J\Message\Command\CommandFactoryInterface;
use J\Message\TracerFactory;
use J\Message\TracerFactoryInterface;
use J\Message\TracerInterface;
use J\Message\Value\ValueFactory;
use J\Message\Value\ValueFactoryInterface;

/**
 * Class Server
 *
 * @package J
 */
final class Server implements ServerInterface
{

    /**
     * @var TracerFactoryInterface
     */
    private $tracer_factory;

    /**
     * @var CommandFactoryInterface
     */
    private $command_factory;

    /**
     * @var ValueFactoryInterface
     */
    private $value_factory;

    /**
     * @var ContainerInterface
     */
    private $controller_container;

    /**
     * @var string
     */
    private $controller_key_prefix;

    /**
     * @var ParamsHandlerInterface
     */
    private $params_handler;

    /**
     * @var ResultHandlerInterface
     */
    private $result_handler;

    /**
     * @var ExceptionHandlerInterface
     */
    private $exception_handler;

    /**
     * @param TracerFactoryInterface  $tracer_factory
     * @param ValueFactoryInterface   $value_factory
     * @param CommandFactoryInterface $command_factory
     */
    public function __construct(
        TracerFactoryInterface $tracer_factory,
        ValueFactoryInterface $value_factory,
        CommandFactoryInterface $command_factory

    ) {
        $this->tracer_factory = $tracer_factory;
        $this->value_factory = $value_factory;
        $this->command_factory = $command_factory;
    }

    /**
     * {@inheritdoc}
     */
    public function setControllerContainer(ContainerInterface $controller_container, $key_prefix = '')
    {
        $this->controller_container = $controller_container;
        $this->controller_key_prefix = $key_prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function setExceptionHandler(ExceptionHandlerInterface $exception_handler)
    {
        $this->exception_handler = $exception_handler;
    }

    /**
     * {@inheritdoc}
     */
    public function setParamsHandler(ParamsHandlerInterface $params_handler)
    {
        $this->params_handler = $params_handler;
    }

    /**
     * {@inheritdoc}
     */
    public function setResultHandler(ResultHandlerInterface $result_handler)
    {
        $this->result_handler = $result_handler;
    }

    /**
     * @param \stdClass $request
     *
     * @return \stdClass
     */
    private function handleMessage(TracerInterface $tracer)
    {
        if (!$tracer->getException()) {
            $tracer->execute($this->command_factory->createPrepareRequestData());
        }

        if (!$tracer->getException()) {
            $tracer->execute($this->command_factory->createHydrate($this->value_factory));
            $tracer->execute($this->command_factory->createDetermineControllerCallback($this->controller_container, $this->controller_key_prefix));
            $tracer->execute($this->command_factory->createInvoke($this->params_handler));
        }

        $tracer->execute($this->command_factory->createExtract($this->result_handler, $this->exception_handler));

        $response_data = $tracer->getResponseData();

        if ($tracer->isNotification() && !$tracer->getException()) {
            $response_data = null;
        }

        return $response_data;
    }

    /**
     * @param string $json_string
     *
     * @return array|\stdClass
     *
     * @throws InvalidRequest
     * @throws ParseError
     */
    private function jsonDecode($json_string)
    {
        $result = @json_decode($json_string, false);

        if (null === $result) {
            throw new ParseError();
        }

        if ([] === $result) {
            throw new InvalidRequest();
        }

        if (!is_array($result) && !is_object($result)) {
            $result = new \stdClass();
        }

        return $result;
    }

    /**
     * @param \stdClass|null $data
     *
     * @return string
     */
    private function jsonEncode($data)
    {
        if (!$data) {
            return '';
        }

        return json_encode($data);
    }


    /**
     * {@inheritdoc}
     */
    public function handle($json_request)
    {
        $batch_request = true;

        $request = null;
        $parse_error = null;
        try {
            $request = $this->jsonDecode($json_request);
        } catch (\Exception $exception) {
            $parse_error = $exception;
        }

        if (!is_array($request)) {
            $batch_request = false;
            $request = [$request];
        }

        $result = [];
        foreach ($request as $message) {
            $tracer = $this->tracer_factory->createTracer();

            if ($parse_error) {
                $tracer->setException($parse_error);
            } else {
                $tracer->setRequestData($message);
            }
            if ($message_result = $this->handleMessage($tracer)) {
                $result[] = $message_result;
            }
        }

        if (!$batch_request) {
            $result = current($result);
        }

        return $this->jsonEncode($result);
    }

    /**
     * {@inheritdoc}
     */
    public static function create()
    {
        $tracer_factory = new TracerFactory();
        $value_factory = new ValueFactory();
        $command_factory = new CommandFactory();

        $server = new self(
            $tracer_factory,
            $value_factory,
            $command_factory
        );

        return $server;
    }
}
