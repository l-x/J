<?php

namespace J\Json;

/**
 * Interface EncoderAwareInterface
 *
 * @package J\Json
 */
interface EncoderAwareInterface {

	/**
	 * @param EncoderInterface $encoder
	 *
	 * @return null
	 */
	public function setJsonEncoder(EncoderInterface $encoder);
} 
