<?php

namespace J\Json;

/**
 * Class JsonFactory
 *
 * @package J\Json
 */
interface JsonFactoryInterface {

	/**
	 * @return BuiltInDecoder
	 */
	public function createDecoder();

	/**
	 * @return BuiltInEncoder
	 */
	public function createEncoder();
}
