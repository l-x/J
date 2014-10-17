<?php

namespace J\Service;

use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

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
