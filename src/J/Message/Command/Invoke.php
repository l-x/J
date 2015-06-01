<?php

namespace J\Message\Command;


use J\Exception\InvalidParams;
use J\Message\TracerInterface;
use J\Handler\ParamsHandlerInterface;

/**
 * Class Invoke
 *
 * @package J\Message\Command
 */
final class Invoke implements CommandInterface {

    /**
     * @var ParamsHandlerInterface
     */
    private $params_handler;

    /**
     * @param ParamsHandlerInterface $params_handler
     *
     * @return void
     */
    public function setParamsHandler(ParamsHandlerInterface $params_handler)
    {
        $this->params_handler = $params_handler;
    }

    /**
     * @param TracerInterface $tracer
     *
     * @return void
     */
    public function actOn(TracerInterface $tracer)
    {
        if ($tracer->getException()) {
            return;
        }

        try{
            $result = $this->invoke($tracer);
            $tracer->setResult($result);
        } catch (\Exception $exception) {
            $tracer->setException($exception);
        }
    }

    /**
     * @param array $params_value
     *
     * @throws InvalidParams
     */
    private function handleParams(callable $callback, $params)
    {
        try {
            if ($this->params_handler) {
                $params = $this->params_handler->handle($callback, $params);
            }
        } catch (\Exception $exception) {;
            throw new InvalidParams();
        }

        return $params;
    }

    /**
     * @param TracerInterface $tracer
     *
     * @return mixed
     */
    private function invoke(TracerInterface $tracer)
    {
        $params_value = $tracer->getMessage()->getParams()->getValue();
        $callback = $tracer->getCallback();
        $params = $this->handleParams($callback, $params_value);

        $result = call_user_func_array(
            $tracer->getCallback(),
            $params
        );

        return $result;
    }
}
