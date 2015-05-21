<?php

namespace J\Handler;

/**
 * Class ShortCircuitParamsHandler
 *
 * @package J
 */
final class ShortCircuitParamsHandler implements ParamsHandlerInterface {


    /**
     * {@inheritdoc}
     */
    public function handle($params)
    {
        return (array) $params;
    }
}
