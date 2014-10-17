<?php

namespace J\Service;

use J\Invoker\Invoker;
use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

/**
 * Class InvokerServiceProvider
 *
 * @package J\Services
 */
class InvokerServiceProvider implements ServiceProviderInterface {


	/**
	 * @param Container $dic
	 *
	 * @return mixed
	 */
	public function register(Container $dic) {
		$dic['invoke'] = function () {
			return new Invoker();
		};
	}
}
