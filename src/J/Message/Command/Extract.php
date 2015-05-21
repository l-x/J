<?php

namespace J\Message\Command;

use J\Exception\InternalError;
use J\Exception\JsonRpcException;
use J\Handler\ExceptionHandlerInterface;
use J\Message\TracerInterface;
use J\Message\Value\Id;
use J\Handler\ResultHandlerInterface;

/**
 * Class Extract
 *
 * @package J\Message\Command
 */
final class Extract implements CommandInterface {

    /**
     * @var ResultHandlerInterface
     */
    private $result_handler;

    /**
     * @var ExceptionHandlerInterface
     */
    private $exception_handler;

    /**
     * @param ResultHandlerInterface    $result_handler
     * @param ExceptionHandlerInterface $exception_handler
     */
    public function __construct(
        ResultHandlerInterface $result_handler = null,
        ExceptionHandlerInterface $exception_handler = null
    ) {
        $this->result_handler = $result_handler;
        $this->exception_handler = $exception_handler;
    }

    /**
     * @param \Exception $exception
     *
     * @return \Exception
     */
    private function handleException(\Exception $exception)
    {
        if ($exception instanceof JsonRpcException) {
            return $exception;
        }

        if (null === $this->exception_handler) {
            return new InternalError();
        }

        try {
            return $this->exception_handler->handle($exception);
        } catch (\Exception $exception) {
            return new InternalError();
        }
    }

    /**
     * @param \Exception $exception
     *
     * @return object
     */
    private function extractException(\Exception $exception)
    {
        $exception = $this->handleException($exception);

        $error = (object) [
            'code'      => (int) $exception->getCode(),
            'message'   => (string) $exception->getMessage()
        ];

        return $error;
    }

    /**
     * @param mixed $result
     *
     * @return mixed
     */
    private function extractResult($result)
    {
        if (null !== $this->result_handler) {
            $result = $this->result_handler->handle($result);
        }

        return $result;
    }

    /**
     * @param Id $id
     *
     * @return null|string|int
     */
    private function getIdValue(Id $id = null)
    {
        $value = null;
        if ($id) {
            $value = $id->getValue();
        }

        return $value;
    }

    /**
     * @param TracerInterface $tracer
     *
     * @return \stdClass
     */
    private function prepareResponse(TracerInterface $tracer)
    {
        $message = $tracer->getMessage();
        $response = new \stdClass;
        $response->id = $this->getIdValue($message->getId());
        $response->jsonrpc = '2.0';

        return $response;
    }

    /**
     * @param TracerInterface $tracer
     *
     * @return void
     */
    public function actOn(TracerInterface $tracer)
    {
        $response = $this->prepareResponse($tracer);

        try {
            if ($exception = $tracer->getException()) {
                throw $exception;
            }
            $response->result = $this->extractResult($tracer->getResult());
        } catch (\Exception $exception) {
            $response->error = $this->extractException($exception);
        }

        $tracer->setResponseData($response);
    }
}
