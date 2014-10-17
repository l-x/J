<?php

namespace J\Json;

/**
 * Interface DecoderInterface
 *
 * @package J\Json
 */
interface DecoderInterface {

	/**
	 * @param string $data
	 *
	 * @return mixed
	 */
	public function __invoke($data);
} 
