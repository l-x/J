<?php

namespace J\Json;

/**
 * Class NativeEncoder
 *
 * @package J\Json
 */
class NativeEncoder implements EncoderInterface {

	/**
	 * @param mixed $data
	 *
	 * @return string|null
	 */
	public function __invoke($data) {
		return json_encode($data);
	}
}
