<?php

namespace J\Message\Command;

use Interop\Container\ContainerInterface;
use J\Handler\ExceptionHandlerInterface;
use J\Message\Value\ValueFactoryInterface;
use J\Handler\ParamsHandlerInterface;
use J\Handler\ResultHandlerInterface;

/**
 * Interface CommandFactoryInterface
 *
 * @package J\Message\Command
 */
interface CommandFactoryInterface {

    /**
     * @param ValueFactoryInterface $value_factory
     *
     * @return Hydrate
     */
    public function createHydrate(ValueFactoryInterface $value_factory);

    /**
     * @return PrepareRequestData
     */
    public function createPrepareRequestData();

    /**
     * @param ParamsHandlerInterface $param_handler
     *
     * @return Invoke
     */
    public function createInvoke(ParamsHandlerInterface $param_handler = null);

    /**
     * @param ContainerInterface $controller_container
     * @param string $key_prefix
     *
     * @return DetermineControllerCallback
     */
    public function createDetermineControllerCallback(
        ContainerInterface $controller_container,
        $key_prefix = ''
    );

    /**
     * @param ExceptionHandlerInterface $exception_handler
     *
     * @return Extract
     */
    public function createExtract(
        ResultHandlerInterface $result_handler = null,
        ExceptionHandlerInterface $exception_handler = null
    );

}
