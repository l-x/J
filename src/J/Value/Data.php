<?php

namespace J\Value;

use J\Value\Exception\InvalidData;

/**
 * Class Data
 *
 * @package J\Value
 */
class Data implements ValueInterface {

	/**
	 * @var mixed
	 */
	private $value;

	/**
	 * @param mixed $value
	 *
	 * @throws InvalidData
	 */
	public function __construct($value) {
		$this->value = $value;
		$this->validate();
	}

	/**
	 * @throws InvalidData
	 */
	private function validate() {
		if (is_resource($this->value)) {
			throw new InvalidData();
		}
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}
}
