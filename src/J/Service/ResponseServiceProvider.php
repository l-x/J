<?php

namespace J\Service;

use J\Di\Container;
use J\Di\ServiceProviderInterface;

/**
 * Class ResponseServiceProvider
 *
 * @package J\Services
 */
class ResponseServiceProvider implements ServiceProviderInterface {

	/**
	 * @param \J\Di\Container $dic
	 *
	 * @return mixed
	 */
	public function register(Container $dic) {
		$dic['response::class'] = '\J\Response\Response';
		$dic['response'] = $dic->factory(function (Container $dic) {
				return new $dic['response::class']();
			}
		);

		$dic['response_message::class'] = '\J\Response\Message\Message';
		$dic['response_message'] = $dic->factory(function(Container $dic) {
				return new $dic['response_message::class'];
			}
		);

		$dic['response_message_hydrator::class'] = '\J\Response\Message\MessageExtractor';
		$dic['extract_response_message'] = function (Container $dic) {
			return new $dic['response_message_hydrator::class']($dic['error_hydrator']);
		};

		$dic['response_extractor::class'] = '\J\Response\ResponseExtractor';
		$dic['extract_response'] = function (Container $dic) {
			return new $dic['response_extractor::class']($dic['extract_response_message']);
		};

		$dic['error::class'] = '\J\Response\Message\Error\Error';
		$dic['error'] = $dic->factory(function (Container $dic) {
				return new $dic['error::class'];
			}
		);

		$dic['error_hydrator::class'] = '\J\Response\Message\Error\ErrorHydrator';
		$dic['error_hydrator'] = function (Container $dic) {
			return new $dic['error_hydrator::class'](
				$dic['exceptions'],
				$dic['value_factory']
			);
		};
	}
}
