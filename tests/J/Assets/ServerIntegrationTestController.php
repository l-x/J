<?php

namespace J\Assets;

return new \ArrayObject([
    'subtract'     => function ($minuend, $subtrahend)
    {
        return $minuend - $subtrahend;
    },
    'sum'           => function ($a, $b, $c)
    {
        return array_sum(func_get_args());
    },

    'update'        => function ()
    {

    },
    'notify_hello'  => function ()
    {

    },
    'get_data'      => function ()
    {
        return ['hello', 5];
    },

    'notify_sum'    => function ($a, $b)
    {

    },
    'default_param' => function ($a = 1, $b)
    {
        return $a - $b;
    }
]);
