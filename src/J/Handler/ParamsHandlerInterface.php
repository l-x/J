<?php

namespace J\Handler;

/**
 * Interface ParamsHandlerInterface
 *
 * @package J
 */
interface ParamsHandlerInterface {

    /**
     * @param callable     $callback
     *
     * @return array
     */
    public function handle($params);
}
