<?php

namespace J\Message;

/**
 * Interface TracerFactoryInterface
 *
 * @package J\Message
 */
interface TracerFactoryInterface {

    /**
     * @return TracerInterface
     */
    public function createTracer();
}
