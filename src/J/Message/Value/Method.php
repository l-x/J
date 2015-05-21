<?php

namespace J\Message\Value;

/**
 * Class Method
 *
 * @package J\Message\Value
 */
final class Method extends AbstractValue {

    /**
     *{@inheritdoc}
     */
    public function isValid($value)
    {
        return is_string($value) && '' !== $value;
    }
}
