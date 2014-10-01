<?php

namespace J\Json;

/**
 * Class BuiltInEncoder
 *
 * @package J\Json
 */
class BuiltInEncoder implements EncoderInterface {

	/**
	 * @param string $json_string
	 *
	 * @return mixed
	 */
	public function encode($json_string) {
		return json_encode($json_string);
	}
}
