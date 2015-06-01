<?php
namespace J;

use J\Handler\ExceptionHandlerInterface;
use J\Handler\ParamsHandlerInterface;
use J\Handler\ResultHandlerInterface;
use Interop\Container\ContainerInterface;


/**
 * Interface Server
 *
 * @package J
 */
interface ServerInterface
{

    /**
     * @param ContainerInterface $controller_container
     *
     * @return void
     */
    public function setControllerContainer(ContainerInterface $controller_container, $key_prefix = '');

    /**
     * @param ExceptionHandlerInterface $exception_handler
     *
     * @return void
     */
    public function setExceptionHandler(ExceptionHandlerInterface $exception_handler);

    /**
     * @param ParamsHandlerInterface $params_handler
     *
     * @return void
     */
    public function setParamsHandler(ParamsHandlerInterface $params_handler);

    /**
     * @param ResultHandlerInterface $result_handler
     *
     * @return void
     */
    public function setResultHandler(ResultHandlerInterface $result_handler);

    /**
     * @param string $json_request
     *
     * @return string
     */
    public function handle($json_request);

    /**
     * @return Server
     */
    public static function create();
}
