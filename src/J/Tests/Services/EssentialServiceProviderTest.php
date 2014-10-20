<?php

namespace J\Tests\Services;

use J\Service\EssentialServiceProvider;
use J\Tests\Assets\ServiceProviderTestCase;
use J\Tests\Fixtures\MockContainer;
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
		$this->simpleServiceTest('invoke', 'J\Invoker\InvokerInterface');
	}

	public function testJsonEncoder() {
		$this->simpleServiceTest('json_encoder', 'J\Json\EncoderInterface');
	}

	public function testJsonDecoder() {
		$this->simpleServiceTest('json_decoder', 'J\Json\DecoderInterface');
	}

	public function testValueFactory() {
		$this->simpleServiceTest('value_factory', 'J\Value\ValueFactoryInterface');
	}

	public function testRequestHydrator() {
		$this->simpleServiceTest('request_hydrator', 'J\Request\RequestHydrator');
	}

	public function testRequest() {
		$this->simpleServiceTest('request', 'J\Request\RequestInterface');
	}

	public function testRequestMessage() {
		$this->simpleServiceTest('request_message', 'J\Request\Message\MessageInterface');
	}

	public function testRequestMessageHydrator() {
		$this->simpleServiceTest('request_message_hydrator', 'J\Request\Message\MessageHydrator');
	}

	public function testResponseExtractor() {
		$this->simpleServiceTest('extract_response', 'J\Response\ResponseExtractor');
	}

	public function testResponse() {
		$this->simpleServiceTest('response', 'J\Response\ResponseInterface');
	}

	public function testResponseMessageExtractor() {
		$this->simpleServiceTest('extract_response_message', 'J\Response\Message\MessageExtractor');
	}

	public function testResponseMessage() {
		$this->simpleServiceTest('response_message', 'J\Response\Message\MessageInterface');
	}

	public function testError() {
		$this->simpleServiceTest('error', 'J\Response\Message\Error\Error');
	}

	public function testErrorHydrator() {
		$this->simpleServiceTest('error_hydrator', 'J\Response\Message\Error\ErrorHydrator');
	}
}
