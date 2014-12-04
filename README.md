# /d͡ʒeɪ/

`AddController.php`
```php
<?php

class AddController {

    public function __invoke($number_one, $number_two) {
        return $number_one + $number_two;
    }
}

```

`MathControllerProvider.php`
```php
<?php

use \Pimple\ServiceProviderInterface;
use \Pimple\Container;

class MathControllerProvider implements ServiceProviderInterface {

    public function register(Container $container) {

        /**
         * Registering invokable class instance
         */
        $container['math.add'] = function () {
            return new AddController();
        };

        /**
         * Registering closure
         */
        $container['math.sub'] = $container->protect(
            function ($number_one, $number_two) {
                return $number_one - $number_two;
            }
        );
    }
}


```


`server.php`
```php
<?php

use \J\Server;

require_once 'vendor/autoload.php';

$server = new Server();
$server->registerControllers(new MathControllerProvider());

header("Content-Type: application/json");
echo $server->handle(file_get_contents('php://input'));

```
```sh
$ php -S 0.0.0.0:8888 server.php
$ curl -X POST http://localhost:8888 -d'[{"jsonrpc":"2.0","id":1,"method":"math.add","params":[13,29]},{"jsonrpc":"2.0","id":2,"method":"math.sub","params":[100,58]}]'

[{"jsonrpc":"2.0","id":1,"result":42},{"jsonrpc":"2.0","id":2,"result":42}]

```

----

[![Build Status](https://travis-ci.org/l-x/J.svg?branch=develop)](https://travis-ci.org/l-x/J)
[![Test Coverage](https://codeclimate.com/github/l-x/J/badges/coverage.svg)](https://codeclimate.com/github/l-x/J)
[![Code Climate](https://codeclimate.com/github/l-x/J/badges/gpa.svg)](https://codeclimate.com/github/l-x/J)
[![Stories in Ready](https://badge.waffle.io/l-x/j.svg?label=ready&title=Ready)](http://waffle.io/l-x/j)
