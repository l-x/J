<?php

namespace J\Value;

/**
 * Class Method
 *
 * @package J\Value
 */
class Method implements ValueInterface {

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @param string $name
	 */
	public function __construct($name) {
		$this->value = $name;
		$this->validate();
	}

	/**
	 * @throws Exception\InvalidMethod
	 */
	private function validate() {
		$value = $this->value;
		if (!is_string($value) || !$value) {
			throw new Exception\InvalidMethod();
		}
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}


}
