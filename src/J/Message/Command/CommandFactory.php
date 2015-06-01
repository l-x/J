<?php

namespace J\Message\Command;

use Interop\Container\ContainerInterface;
use J\Handler\ExceptionHandlerInterface;
use J\Message\Value\ValueFactoryInterface;
use J\Handler\ParamsHandlerInterface;
use J\Handler\ResultHandlerInterface;

/**
 * Class CommandFactory
 *
 * @package J\Message\Command
 */
final class CommandFactory implements CommandFactoryInterface {

    /**
     * {@inheritdoc}
     */
    public function createHydrate(ValueFactoryInterface $value_factory) {
        return new Hydrate($value_factory);
    }

    /**
     * {@inheritdoc}
     */
    public function createPrepareRequestData()
    {
        return new PrepareRequestData();
    }

    /**
     * {@inheritdoc}
     */
    public function createInvoke(ParamsHandlerInterface $param_handler = null)
    {
        $invoke = new Invoke();

        if (null !== $param_handler) {
            $invoke->setParamsHandler($param_handler);
        }

        return $invoke;
    }

    /**
     * {@inheritdoc}
     */
    public function createDetermineControllerCallback(
        ContainerInterface $controller_container,
        $key_prefix = ''
    ) {
        return new DetermineControllerCallback(
            $controller_container,
            $key_prefix
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createExtract(
        ResultHandlerInterface $result_handler = null,
        ExceptionHandlerInterface $exception_handler = null
    ) {
        return new Extract(
            $result_handler,
            $exception_handler
        );
    }
}
