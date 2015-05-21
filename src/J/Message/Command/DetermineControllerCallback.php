<?php

namespace J\Message\Command;

use J\Controller\ControllerFactoryInterface;
use J\Exception\MethodNotFound;
use J\Message\TracerInterface;

/**
 * Class DetermineControllerCallback
 *
 * @package J\Message\Command
 */
final class DetermineControllerCallback implements CommandInterface {

    /**
     * @var ControllerFactoryInterface
     */
    private $controller_factory;

    /**
     * @param ControllerFactoryInterface $controller_factory
     */
    public function __construct(ControllerFactoryInterface $controller_factory)
    {
        $this->controller_factory = $controller_factory;
    }

    /**
     * @param TracerInterface $tracer
     *
     * @return void
     */
    public function actOn(TracerInterface $tracer)
    {
        if ($tracer->getException()) {
            return;
        }
        $method_name = $tracer->getMessage()->getMethod()->getValue();

        if ($this->controller_factory->canCreate($method_name)) {
            $controller = $this->controller_factory->create($method_name);
            $tracer->setCallback($controller);
        } else {
            $tracer->setException(new MethodNotFound());
        }
    }
}
