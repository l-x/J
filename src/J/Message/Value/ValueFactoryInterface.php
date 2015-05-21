<?php

namespace J\Message\Value;

/**
 * Interface ValueFactoryInterface
 *
 * @package J\Message\Value
 */
interface ValueFactoryInterface {

    /**
     * @param null|string|int $value
     *
     * @return Id
     */
    public function createId($value);

    /**
     * @param string $version
     *
     * @return Jsonrpc
     */
    public function createJsonrpc($version);

    /**
     * @param string $name
     *
     * @return Method
     */
    public function createMethod($name);

    /**
     * @param array|object $values
     *
     * @return Params
     */
    public function createParams($values);
}
