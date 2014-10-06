<?php

namespace J\Value;

use J\Value\Exception\InvalidCode;

/**
 * Class Code
 *
 * @package J\Value\Error
 */
class Code implements ValueInterface {

	/**
	 * @var int
	 */
	private $value;

	/**
	 * @param int $value
	 */
	public function __construct($value) {
		$this->value = $value;
		$this->validate();
	}

	/**
	 * @throws InvalidCode
	 */
	private function validate() {
		if (!is_integer($this->value)) {
			throw new InvalidCode();
		}
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}
}
