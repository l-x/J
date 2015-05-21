<?php

namespace J\Message;

/**
 * Class TracerFactory
 *
 * @package J\Message
 */
final class TracerFactory implements TracerFactoryInterface {

    /**
     * @return TracerInterface
     */
    public function createTracer()
    {
        return new Tracer(new Message());
    }
}
