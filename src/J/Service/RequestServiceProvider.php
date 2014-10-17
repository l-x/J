<?php

namespace J\Service;

use J\Request\Message\Message;
use J\Request\Message\MessageHydrator;
use J\Request\Request;
use J\Request\RequestHydrator;
use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

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
		$dic['request_message_hydrator'] = function (Container $dic) {
			return new MessageHydrator($dic['value_factory']);
		};

		$dic['request_message'] = $dic->factory(function () {
				return new Message();
			}
		);

		$dic['request'] = $dic->factory(function () {
				return new Request();
			}
		);

		$dic['request_hydrator'] = function (Container $dic) {
			return new RequestHydrator(
				$dic['request_message_hydrator'],
				$dic['request_message']
			);
		};
	}
}
