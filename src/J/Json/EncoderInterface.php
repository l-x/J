<?php

namespace J\Json;

/**
 * Interface EncoderInterface
 *
 * @package J\Json
 */
interface EncoderInterface {

	/**
	 * @param mixed $data
	 *
	 * @return string
	 */
	public function encode($data);
} 
