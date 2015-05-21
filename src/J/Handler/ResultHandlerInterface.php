<?php

namespace J\Handler;

/**
 * Interface ResultHandlerInterface
 *
 * @package J
 */
interface ResultHandlerInterface {

    /**
     * @param mixed $result
     *
     * @return mixed
     */
    public function handle($result);
}
