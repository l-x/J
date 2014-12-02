<?php

namespace J\Tests\Services;

use J\Service\EssentialServiceProvider;
use J\Tests\Assets\ServiceProviderTestCase;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class EssentialServiceProviderTest
 *
 * @package J\Tests\Services
 */
class EssentialServiceProviderTest extends ServiceProviderTestCase {

	/**
	 * @return ServiceProviderInterface
	 */
	function getServiceProvider() {
		return new EssentialServiceProvider();
	}

	/**
	 *
	 */
	public function setUp() {
		parent::setUp();
		$this->container['exceptions'] = new Container();

	}

	public function testInvoker() {
		$this->simpleServiceTest('invoker', 'J\Invoker\InvokerInterface');
	}

	public function testJsonEncoder() {
		$this->simpleServiceTest('json.encoder', 'J\Json\EncoderInterface');
	}

	public function testJsonDecoder() {
		$this->simpleServiceTest('json.decoder', 'J\Json\DecoderInterface');
	}

	public function testValueFactory() {
		$this->simpleServiceTest('value.factory', 'J\Value\ValueFactoryInterface');
	}

	public function testRequestHydrator() {
		$this->simpleServiceTest('request.hydrator', 'J\Request\RequestHydrator');
	}

	public function testRequest() {
		$this->simpleServiceTest('request', 'J\Request\RequestInterface');
	}

	public function testRequestMessage() {
		$this->simpleServiceTest('request.message', 'J\Request\Message\MessageInterface');
	}

	public function testRequestMessageHydrator() {
		$this->simpleServiceTest('request.message.hydrator', 'J\Request\Message\MessageHydrator');
	}

	public function testResponseExtractor() {
		$this->simpleServiceTest('response.extractor', 'J\Response\ResponseExtractor');
	}

	public function testResponse() {
		$this->simpleServiceTest('response', 'J\Response\ResponseInterface');
	}

	public function testResponseMessageExtractor() {
		$this->simpleServiceTest('response.message.extractor', 'J\Response\Message\MessageExtractor');
	}

	public function testResponseMessage() {
		$this->simpleServiceTest('response.message', 'J\Response\Message\MessageInterface');
	}

	public function testError() {
		$this->simpleServiceTest('error', 'J\Response\Message\Error\Error');
	}

	public function testErrorHydrator() {
		$this->simpleServiceTest('error.hydrator', 'J\Response\Message\Error\ErrorHydrator');
	}

	public function testLogger() {
		$this->simpleServiceTest('logger', 'Psr\Log\LoggerInterface');
	}
}
