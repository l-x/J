<?php

namespace J\Message\Command;

use Interop\Container\ContainerInterface;
use J\Exception\MethodNotFound;
use J\Message\TracerInterface;

/**
 * Class DetermineControllerCallback
 *
 * @package J\Message\Command
 */
final class DetermineControllerCallback implements CommandInterface {

    /**
     * @var ContainerInterface
     */
    private $controller_container;

    /**
     * @param ContainerInterface $controller_container
     */
    public function __construct(ContainerInterface $controller_container)
    {
        $this->controller_container = $controller_container;
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

        if ($this->controller_container->has($method_name)) {
            $controller = $this->controller_container->get($method_name);
            if (!is_callable($controller)) {
                throw new \RuntimeException('Callback container returned something not callable');
            }
            $tracer->setCallback($controller);
        } else {
            $tracer->setException(new MethodNotFound());
        }
    }
}
