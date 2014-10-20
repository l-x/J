<?php

namespace J\Response\Message\Error;

/**
 * Class ErrorExtractor
 *
 * @package J\Response\Message\Error
 */
class ErrorExtractor implements ErrorExtractorInterface {

	/**
	 * @param ErrorInterface $error
	 *
	 * @return \stdClass
	 */
	public function __invoke(ErrorInterface $error) {
		$data = array(
			'code'          => $error->getCode()->getValue(),
			'message'       => $error->getMessage()->getValue(),
		);

		return (object) $data;
	}
} 
