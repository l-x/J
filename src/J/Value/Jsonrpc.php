<?php

namespace J\Value;

class Jsonrpc implements ValueInterface {

	/**
	 * @var string
	 */
	private $value;

	/**
	 * @param string $value
	 *
	 * @throws Exception\InvalidJsonrpc
	 */
	public function __construct($value) {
		$this->value = $value;
		$this->validate();
	}

	/**
	 * @throws Exception\InvalidJsonrpc
	 */
	private function validate() {
		if ($this->value !== '2.0') {
			throw new Exception\InvalidJsonrpc();
		}
	}

	/**
	 * @return string
	 */
	public function getValue() {
		return $this->value;
	}
}
