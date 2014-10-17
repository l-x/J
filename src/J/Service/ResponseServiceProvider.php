<?php

namespace J\Service;

use J\Response\Message\Error\Error;
use J\Response\Message\Error\ErrorHydrator;
use J\Response\Message\Message;
use J\Response\Message\MessageExtractor;
use J\Response\Response;
use J\Response\ResponseExtractor;
use \Pimple\Container;
use \Pimple\ServiceProviderInterface;

/**
 * Class ResponseServiceProvider
 *
 * @package J\Services
 */
class ResponseServiceProvider implements ServiceProviderInterface {

	/**
	 * @param Container $dic
	 *
	 * @return mixed
	 */
	public function register(Container $dic) {
		$dic['response'] = $dic->factory(function () {
				return new Response();
			}
		);

		$dic['response_message'] = $dic->factory(function() {
				return new Message();
			}
		);

		$dic['extract_response_message'] = function (Container $dic) {
			return new MessageExtractor($dic['error_hydrator']);
		};

		$dic['extract_response'] = function (Container $dic) {
			return new ResponseExtractor($dic['extract_response_message']);
		};

		$dic['error'] = $dic->factory(function () {
				return new Error();
			}
		);

		$dic['error_hydrator'] = function (Container $dic) {
			return new ErrorHydrator(
				$dic['exceptions'],
				$dic['value_factory']
			);
		};
	}
}
