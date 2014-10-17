<?php

namespace J\Service;

use J\Di\Container;
use J\Di\ServiceProviderInterface;

/**
 * Class JsonServiceProvider
 *
 * @package J\Services
 */
class JsonServiceProvider implements ServiceProviderInterface {

	/**
	 * @param Container $dic
	 *
	 * @return mixed
	 */
	public function register(Container $dic) {
		$dic['json_encoder::class'] = 'J\Json\NativeEncoder';
		$dic['json_encoder'] = function (Container $dic) {
			return new $dic['json_encoder::class']();
		};

		$dic['json_decoder::class'] = 'J\Json\NativeDecoder';
		$dic['json_decoder'] = function (Container $dic) {
			return new $dic['json_decoder::class']();
		};
	}
}
