<?php

namespace J\Message\Value;

/**
 * Class Jsonrpc
 *
 * @package J\Message\Value
 */
final class Jsonrpc extends AbstractValue {

    const VERSION = '2.0';

    /**
     * {@inheritdoc}
     */
    public function isValid($value)
    {
        return self::VERSION === $value;
    }
}
