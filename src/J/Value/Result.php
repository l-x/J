<?php

namespace J\Value;

/**
 * Class Result
 *
 * @package J\Value
 */
class Result implements ValueInterface {

	/**
	 * @var mixed
	 */
	private $value;

	/**
	 * @param mixed $value
	 */
	public function __construct($value) {
		$this->value = $value;
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}
}
