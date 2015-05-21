<?php

namespace J\Message\Value;

/**
 * Interface ValueInterface
 *
 * @package J\Message\Value
 */
interface ValueInterface {

    /**
     * Return the scalar value of the value object
     *
     * @return mixed
     */
    public function getValue();
}
