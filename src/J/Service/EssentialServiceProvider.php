<?php

namespace J\Service;

use J\Invoker\Invoker;
use J\Json\NativeDecoder;
use J\Json\NativeEncoder;
use J\Request\Message\Message as RequestMessage;
use J\Request\Message\MessageHydrator;
use J\Request\Request;
use J\Request\RequestHydrator;
use J\Response\Message\Error\Error;
use J\Response\Message\Error\ErrorExtractor;
use J\Response\Message\Error\ErrorHydrator;
use J\Response\Message\Message as ResponseMessage;
use J\Response\Message\MessageExtractor;
use J\Response\Response;
use J\Response\ResponseExtractor;
use J\Value\ValueFactory;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Psr\Log\NullLogger;

/**
 * Class EssentialServiceProvider
 *
 * @package J\Service
 */
final class EssentialServiceProvider implements ServiceProviderInterface {

	/**
	 * @param Container $dic
	 *
	 * @return null
	 */
	private function registerInvokerServices(Container $dic) {
		$dic['invoker'] = function () {
			return new Invoker();
		};

		return $this;
	}

	/**
	 * @param Container $dic
	 *
	 * @return null
	 */
	private function registerJsonServices(Container $dic) {
		$dic['json.encoder'] = function () {
			return new NativeEncoder();
		};

		$dic['json.decoder'] = function () {
			return new NativeDecoder();
		};
	}

	/**
	 * @param Container $dic
	 *
	 * @return null
	 */
	private function registerRequestServices(Container $dic) {
		$dic['request.message.hydrator'] = function (Container $dic) {
			return new MessageHydrator($dic['value.factory']);
		};

		$dic['request.message'] = $dic->factory(function () {
				return new RequestMessage();
			}
		);

		$dic['request'] = $dic->factory(function () {
				return new Request();
			}
		);

		$dic['request.hydrator'] = function (Container $dic) {
			return new RequestHydrator(
				$dic['request.message.hydrator'],
				$dic['request.message']
			);
		};
	}

	/**
	 * @param Container $dic
	 *
	 * @return null
	 */
	private function registerResponseServices(Container $dic) {
		$dic['response'] = $dic->factory(function () {
				return new Response();
			}
		);

		$dic['response.message'] = $dic->factory(function() {
				return new ResponseMessage();
			}
		);

		$dic['response.message.extractor'] = function (Container $dic) {
			return new MessageExtractor($dic['error.extractor']);
		};

		$dic['response.extractor'] = function (Container $dic) {
			return new ResponseExtractor($dic['response.message.extractor']);
		};

		$dic['error'] = $dic->factory(function () {
				return new Error();
			}
		);

		$dic['error.hydrator'] = function (Container $dic) {
			return new ErrorHydrator(
				$dic['exceptions'],
				$dic['value.factory']
			);
		};

		$dic['error.extractor'] = function (Container $dic) {
			return new ErrorExtractor();
		};
	}

	/**
	 * @param Container $dic
	 *
	 * @return null
	 */
	private function registerValueObjectServices(Container $dic) {
		$dic['value.factory'] = function () {
			return new ValueFactory();
		};
	}

	/**
	 * @param Container $dic
	 *
	 * @return null
	 */
	private function registerLogger(Container $dic) {
		$dic['logger'] = function() {
			return new NullLogger();
		};
	}

	/**
	 * @param Container $dic
	 *
	 * @return null
	 */
	public function register(Container $dic) {
		$this->registerInvokerServices($dic);
		$this->registerJsonServices($dic);
		$this->registerRequestServices($dic);
		$this->registerResponseServices($dic);
		$this->registerValueObjectServices($dic);
		$this->registerLogger($dic);
	}
}
