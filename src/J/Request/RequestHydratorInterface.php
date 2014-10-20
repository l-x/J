<?php

namespace J\Request;

/**
 * Class RequestHydrator
 *
 * @package J\Request
 */
interface RequestHydratorInterface {

	/**
	 * @param RequestInterface $request
	 * @param \stdClass|\stdClass[] $data
	 *
	 * @throws InvalidRequest
	 */
	public function __invoke(RequestInterface $request, $data);
}
