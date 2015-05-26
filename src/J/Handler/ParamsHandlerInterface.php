<?php

namespace J\Handler;

/**
 * Interface ParamsHandlerInterface
 *
 * @package J
 */
interface ParamsHandlerInterface {

    /**
     * @param callable $callback
     * @param array    $params
     *
     * @return array
     */
    public function handle(callable $callback, $params);
}
