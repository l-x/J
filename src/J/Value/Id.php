<?php

namespace J\Value;

use J\Value\Exception\InvalidId;

class Id implements ValueInterface {

	/**
	 * @var array
	 */
	private static $allowed_types = array(
		'integer'       => true,
	        'float'         => true,
	        'double'        => true,
	        'string'        => true,
	        'null'          => true,
	);

	/**
	 * @var null|mixed
	 */
	private $value;

	/**
	 * @param $value
	 *
	 * @throws InvalidId
	 */
	public function __construct($value) {
		$this->value = $value;
		$this->validate();
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @throws InvalidId
	 */
	private function validate() {
		$type = strtolower(gettype($this->value));
		if (!isset(static::$allowed_types[$type])) {
			throw new InvalidId();
		}
	}
}
