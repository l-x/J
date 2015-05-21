<?php

namespace J\Message\Command;

use J\Exception\InvalidRequest;
use J\Message\TracerInterface;

/**
 * Class PrepareRequestData
 *
 * @package J\Message\Command
 */
final class PrepareRequestData implements CommandInterface {

    /**
     * @param TracerInterface $tracer
     *
     * @return void
     */
    public function actOn(TracerInterface $tracer)
    {
        $this->applySchemaToRequestData($tracer);
    }

    /**
     * @return \stdClass
     */
    private function createSchema()
    {
        return (object) [
            'id'        => null,
            'jsonrpc'   => null,
            'method'    => null,
            'params'    => [],
        ];
    }

    /**
     * @param TracerInterface $tracer
     *
     * @return void
     * @throws \Exception
     */
    private function applySchemaToRequestData(TracerInterface $tracer)
    {
        $data = $tracer->getRequestData();
        if (!is_object($data)) {
            $tracer->setException(new InvalidRequest());
            return;
        }
        $wellformed_data = $this->createSchema();

        foreach (get_object_vars($data) as $key => $_) {
            if (!property_exists($wellformed_data, $key)) {
                $tracer->setException(new InvalidRequest());
                continue;
            }
            $wellformed_data->$key = $data->$key;
        }

        $tracer->setRequestData($wellformed_data);
    }
}
