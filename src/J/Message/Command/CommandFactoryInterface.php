<?php

namespace J\Message\Command;

use J\Controller\ControllerFactoryInterface;
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
     * @return mixed
     */
    public function createInvoke(ParamsHandlerInterface $param_handler = null);

    /**
     * @param ControllerFactoryInterface $controller_factory
     *
     * @return DetermineControllerCallback
     */
    public function createDetermineControllerCallback(ControllerFactoryInterface $controller_factory);

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
