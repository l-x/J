<?php

namespace J\Json;

/**
 * Class NativeDecoder
 *
 * @package J\Json
 */
class NativeDecoder implements DecoderInterface {

	/**
	 * @param string $data
	 *
	 * @return mixed
	 */
	public function __invoke($data) {
		return json_decode($data, false);
	}
}
