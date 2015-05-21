<?php

namespace J\Handler;

/**
 * Interface ExceptionHandlerInterface
 *
 * @package J\Handler
 */
interface ExceptionHandlerInterface {

    /**
     * @param \Exception $exception
     *
     * @return \Exception
     */
    public function handle(\Exception $exception);
}
