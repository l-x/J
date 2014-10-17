<?php

namespace J\Service;

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
		$dic['invoke::class'] = '\J\Invoker\Invoker';
		$dic['invoke'] = function (Container $dic) {
			return new $dic['invoke::class']();
		};
	}
}
