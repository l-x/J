<?php

namespace J\Handler;

/**
 * Class ShortCircuitResultHandler
 *
 * @package J
 */
final class ShortCircuitResultHandler implements ResultHandlerInterface {

    /**
     * {@inheritdoc}
     */
    public function handle($params)
    {
        return $params;
    }
}
