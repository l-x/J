<?php

namespace J\Message\Value;

/**
 * Class ValueFactory
 *
 * @package J\Message\Value
 */
final class ValueFactory implements ValueFactoryInterface {

    /**
     * {@inheritdoc}
     */
    public function createId($value)
    {
        return new Id($value);
    }

    /**
     * {@inheritdoc}
     */
    public function createJsonrpc($version)
    {
        return new Jsonrpc($version);
    }

    /**
     * {@inheritdoc}
     */
    public function createMethod($name)
    {
        return new Method($name);
    }

    /**
     * {@inheritdoc}
     */
    public function createParams($values)
    {
       return new Params($values);
    }
}
