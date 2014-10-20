<?php

namespace J\Tests\Fixtures;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class TestControllerProvider
 *
 * @package Fixtures
 */
class TestControllerProvider implements ServiceProviderInterface {

	public function register(Container $dic) {
		$dic['test1'] = $dic->protect(
			function () {
				return func_get_args();
			}
		);
	}
}
