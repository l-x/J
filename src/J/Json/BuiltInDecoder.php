<?php

namespace J\Json;

use J\Json\Exception\ParseError;

/**
 * Class BuiltInDecoder
 *
 * @package J\Json
 */
class BuiltInDecoder implements DecoderInterface {


	/**
	 * @param string $json_string
	 *
	 * @return mixed
	 * @throws ParseError
	 */
	public function decode($json_string) {
		$data = json_decode($json_string);

		if (!$data || !(is_array($data) || is_object($data))) {
			throw new ParseError();
		}

		return $data;
	}
}
