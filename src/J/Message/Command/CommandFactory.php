<?php

namespace J\Message\Command;

use Interop\Container\ContainerInterface;
use J\Handler\ExceptionHandlerInterface;
use J\Message\Value\ValueFactoryInterface;
use J\Handler\ParamsHandlerInterface;
use J\Handler\ResultHandlerInterface;
use J\Handler\ShortCircuitParamsHandler;
use J\Handler\ShortCircuitResultHandler;

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
    public function createInvoke(
        ParamsHandlerInterface $param_handler = null,
        ResultHandlerInterface $result_handler = null
    ) {

        if (null === $param_handler) {
            $param_handler = new ShortCircuitParamsHandler();
        }

        if (null === $result_handler) {
            $result_handler = new ShortCircuitResultHandler();
        }

        return new Invoke(
            $param_handler,
            $result_handler
        );
    }

    /**
     * {@inheritdoc}
     */
    public function createDetermineControllerCallback(ContainerInterface $controller_container)
    {
        return new DetermineControllerCallback($controller_container);
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
