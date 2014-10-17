<?php

namespace J\Service;

use J\Value\ValueFactory;
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
		$dic['value_factory'] = function () {
			return new ValueFactory();
		};
	}
}
