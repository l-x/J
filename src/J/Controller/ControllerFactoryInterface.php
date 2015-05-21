<?php

namespace J\Controller;

/**
 * Interface ControllerFactoryInterface
 *
 * @package J\Controller
 */
interface ControllerFactoryInterface {

    /**
     * @param string $method_name
     *
     * @return bool
     */
    public function canCreate($method_name);

    /**
     * @param string $method_name
     *
     * @return callable
     */
    public function create($method_name);
}
