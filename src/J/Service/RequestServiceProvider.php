<?php

namespace J\Service;

use J\Di\Container;
use J\Di\ServiceProviderInterface;

/**
 * Class RequestServiceProvider
 *
 * @package J\Services
 */
class RequestServiceProvider implements ServiceProviderInterface {

	/**
	 * @param Container $dic
	 *
	 * @return null
	 */
	public function register(Container $dic) {

		$dic['request_message_hydrator::class'] = '\J\Request\Message\MessageHydrator';
		$dic['request_message_hydrator'] = function (Container $dic) {
			return new $dic['request_message_hydrator::class']($dic['value_factory']);
		};

		$dic['request_message::class'] = '\J\Request\Message\Message';
		$dic['request_message'] = $dic->factory(function (Container $dic) {
				return new $dic['request_message::class']();
			}
		);

		$dic['request::class'] = '\J\Request\Request';
		$dic['request'] = $dic->factory(function (Container $dic) {
				return new $dic['request::class']();
			}
		);

		$dic['request_hydrator::class'] = '\J\Request\RequestHydrator';
		$dic['request_hydrator'] = function (Container $dic) {
			return new $dic['request_hydrator::class'](
				$dic['request_message_hydrator'],
				$dic['request_message']
			);
		};
	}
}
