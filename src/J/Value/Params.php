<?php

namespace J\Value;

/**
 * Class Params
 *
 * @package J\Value
 */
class Params implements ValueInterface {

	/**
	 * @var array
	 */
	private $value;

	/**
	 * @param array $name
	 */
	public function __construct($params) {
		$this->value = $params;
		$this->validate();
	}

	/**
	 * @throws Exception\InvalidMethod
	 */
	private function validate() {
		if (!is_null($this->value) && !is_array($this->value) && !is_object($this->value)) {
			throw new Exception\InvalidParams();
		}
	}

	/**
	 * @return mixed
	 */
	public function getValue() {
		return $this->value;
	}


}
