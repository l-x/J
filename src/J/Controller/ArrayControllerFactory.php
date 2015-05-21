<?php

namespace J\Controller;

/**
 * Class ArrayControllerFactory
 *
 * @package J\Controller
 */
final class ArrayControllerFactory implements ControllerFactoryInterface {

    /**
     * @var \ArrayAccess
     */
    private $data;

    public function __construct(\ArrayAccess $data)
    {
        $this->data = $data;
    }

    /**
     * @param string $method_name
     *
     * @return bool
     */
    public function canCreate($method_name)
    {
        return isset($this->data[$method_name]);
    }

    /**
     * @param string $method_name
     *
     * @return callable
     */
    public function create($method_name)
    {
        return $this->data[$method_name];
    }
}
