<?php

namespace J\Message\Command;

use J\Message\TracerInterface;
use J\Message\Value\ValueFactoryInterface;

/**
 * Class Hydrate
 *
 * @package J\Message\Command
 */
final class Hydrate implements CommandInterface {

    /**
     * @var ValueFactoryInterface
     */
    private $value_factory;

    /**
     * @param ValueFactoryInterface $value_factory
     */
    public function __construct(ValueFactoryInterface $value_factory)
    {
        $this->value_factory = $value_factory;
    }



    /**
     * @param string                $property_name
     * @param string                $creator_method
     * @param string                $setter_method
     * @param TracerInterface       $tracer
     *
     * @return void
     */
    private function hydrateProperty($property_name, $creator_method, $setter_method, TracerInterface $tracer)
    {
        $property_value = $tracer->getRequestData()->$property_name;
        try {
            $property = $this->value_factory->$creator_method($property_value);
            $tracer->getMessage()->$setter_method($property);
        } catch (\Exception $exception) {
            $tracer->setException($exception);
        }
    }

    /**
     * @param TracerInterface $tracer
     *
     * @return void
     */
    private function hydrateId(TracerInterface $tracer)
    {
        $this->hydrateProperty('id', 'createId', 'setId', $tracer);
    }

    /**
     * @param TracerInterface $tracer
     *
     * @return void
     */
    private function hydrateJsonrpc(TracerInterface $tracer)
    {
        $this->hydrateProperty('jsonrpc', 'createJsonrpc', 'setJsonrpc', $tracer);
    }

    /**
     * @param TracerInterface $tracer
     *
     * @return void
     */
    private function hydrateMethod(TracerInterface $tracer)
    {
        $this->hydrateProperty('method', 'createMethod', 'setMethod', $tracer);
    }

    /**
     * @param TracerInterface $tracer
     *
     * @return void
     */
    private function hydrateParams(TracerInterface $tracer)
    {
        $this->hydrateProperty('params', 'createParams', 'setParams', $tracer);
    }

    /**
     * {@inheritdoc}
     */
    public function actOn(TracerInterface $tracer)
    {
        $this->hydrateId($tracer);
        $this->hydrateMethod($tracer);
        $this->hydrateParams($tracer);
        $this->hydrateJsonrpc($tracer);
    }
}
