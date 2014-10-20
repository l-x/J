<?php

namespace J\Tests\Fixtures;


use J\Request\Message\MessageInterface as RequestMessageInterface;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class TestServiceProvider implements ServiceProviderInterface {

	/**
	 * Registers services on the given container.
	 *
	 * This method should only be used to configure services and parameters.
	 * It should not get services.
	 *
	 * @param Container $pimple An Container instance
	 */
	public function register(Container $dic) {

		$dic['invoke'] = $dic->protect(
			function (RequestMessageInterface $message, $controller) {
				return array($message, $controller);
			}
		);
	}
}
