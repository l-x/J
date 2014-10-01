<?php

namespace J\Json;

/**
 * Class JsonFactory
 *
 * @package J\Json
 */
class JsonFactory implements JsonFactoryInterface {

	/**
	 * @return BuiltInDecoder
	 */
	public function createDecoder() {
		return new BuiltInDecoder();
	}

	/**
	 * @return BuiltInEncoder
	 */
	public function createEncoder() {
		return new BuiltInEncoder();
	}
} 
