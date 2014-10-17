<?php

namespace J\Service;

use J\Json\NativeDecoder;
use J\Json\NativeEncoder;
use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

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
		$dic['json_encoder'] = function () {
			return new NativeEncoder();
		};

		$dic['json_decoder'] = function () {
			return new NativeDecoder();
		};
	}
}
