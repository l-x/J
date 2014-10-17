<?php

namespace J\Value;

/**
 * Class Message
 *
 * @package J\Value
 */
class Message implements ValueInterface {

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
		if (!is_string($this->value)) {
			throw new Exception\InvalidMessage();
		}
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}


}
