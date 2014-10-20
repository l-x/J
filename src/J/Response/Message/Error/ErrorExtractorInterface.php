<?php

namespace J\Response\Message\Error;

/**
 * Class ErrorExtractorInterface
 *
 * @package J\Response\Message\Error
 */
interface ErrorExtractorInterface {

	/**
	 * @param ErrorInterface $error
	 *
	 * @return \stdClass
	 */
	public function __invoke(ErrorInterface $error);
}
