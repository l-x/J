<?php

namespace J\Message\Value;

/**
 * Class Params
 *
 * @package J\Message\Value
 */
final class Params extends AbstractValue {

    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        switch (true) {
            case is_array($value):
            case is_object($value):
                return true;
            default:
                return false;
        }
    }
}
