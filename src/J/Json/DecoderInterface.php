<?php

namespace J\Json;

use J\Json\Exception\ParseError;

/**
 * Interface DecoderInterface
 *
 * @package J\Json
 */
interface DecoderInterface {

	/**
	 * @param string $json_string
	 *
	 * @return mixed
	 * @throws ParseError
	 */
	public function decode($json_string);
} 
