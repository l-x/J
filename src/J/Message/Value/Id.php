<?php

namespace J\Message\Value;

/**
 * Class Id
 *
 * @package J\Message\Value
 */
final class Id extends AbstractValue {

    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        switch (true) {
            case is_int($value):
            case is_null($value):
            case is_string($value) && '' !== $value:
                return true;
            default:
                return false;
        }
    }
}
