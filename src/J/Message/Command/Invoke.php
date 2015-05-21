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
     */
    public function __construct(ParamsHandlerInterface $params_handler)
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
     * @param callable $callback
     *
     * @return \ReflectionParameter[]
     */
    private function getCallbackSignature(callable $callback)
    {
        if ($callback instanceof \Closure) {
            $reflection = new \ReflectionFunction($callback);
        } else {
            $reflection = new \ReflectionMethod($callback, '__invoke');
        }

        return $reflection->getParameters();
    }

    /**
     * @param \ReflectionParameter[] $callback_signature
     * @param array|object           $params_value
     *
     * @return array
     */
    private function makeParamsNamed($callback_signature, $params_value)
    {
        $param_array = (array) $params_value;
        $signature = [];
        $position = 0;

        foreach ($callback_signature as $parameter) {
            $name = $parameter->getName();
            $default_value = $parameter->isDefaultValueAvailable() ? $parameter->getDefaultValue() : null;

            if (isset($param_array[$name])) {
                $value = $param_array[$name];
            } else if (isset($param_array[$position])) {
                $value = $param_array[$position];
            } else {
                throw new InvalidParams();
            }

            $signature[$name] = $value;
            $position++;
        }

        return $signature;
    }

    /**
     * @param array $params_value
     *
     * @throws InvalidParams
     */
    private function handleParams(callable $callback, $params_value)
    {
        try {
            $parameter_reflection = $this->getCallbackSignature($callback);

            $params = $this->makeParamsNamed($parameter_reflection, $params_value);
            $params = $this->params_handler->handle($params);
            $params = $this->makeParamsNamed($parameter_reflection, $params);

            return $params;
        } catch (\Exception $exception) {;
            throw new InvalidParams();
        }
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
