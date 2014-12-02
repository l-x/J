<?php

namespace J\Response;

/**
 * Class ResponseExtractor
 *
 * @package J\Response
 */
interface ResponseExtractorInterface {

	/**
	 * @param ResponseInterface $response
	 *
	 * @return \stdClass[]|\stdClass
	 */
	public function __invoke(ResponseInterface $response);
}
