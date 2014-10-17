<?php

namespace J\Service;

use J\Di\Container;
use J\Di\ServiceProviderInterface;

/**
 * Class ValueObjectServiceProvider
 *
 * @package J\Services
 */
class ValueObjectServiceProvider implements ServiceProviderInterface {

	/**
	 * @param Container $dic
	 *
	 * @return mixed
	 */
	public function register(Container $dic) {
		$dic['value_factory::class'] = 'J\Value\ValueFactory';
		$dic['value_factory'] = function (Container $dic) {
			return new $dic['value_factory::class']();
		};
	}
}
