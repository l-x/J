<?php

namespace J\Message\Command;

use J\Message\TracerInterface;

/**
 * Interface CommandInterface
 *
 * @package J\Message\Command
 */
interface CommandInterface {

    /**
     * @param TracerInterface $tracer
     *
     * @return void
     */
    public function actOn(TracerInterface $tracer);
}
