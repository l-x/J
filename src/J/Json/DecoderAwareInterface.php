<?php

namespace J\Json;

/**
 * Interface DecoderAwareInterface
 *
 * @package J\Json
 */
interface DecoderAwareInterface {

	/**
	 * @param DecoderInterface $decoder
	 *
	 * @return null
	 */
	public function setJsonDecoder(DecoderInterface $decoder);
} 
