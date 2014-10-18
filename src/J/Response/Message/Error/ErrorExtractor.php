<?php

namespace J\Response\Message\Error;

use J\Value\ValueFactoryInterface;

/**
 * Class ErrorExtractor
 *
 * @package J\Response\Message\Error
 */
class ErrorExtractor {

	/**
	 * @param Error $error
	 *
	 * @return \stdClass
	 */
	public function __invoke(Error $error) {
		$data = array(
			'code'          => $error->getCode()->getValue(),
			'message'       => $error->getMessage()->getValue(),
		);

		return (object) $data;
	}
} 
