<?php

namespace J\Message\Value;

use J\Exception\InvalidRequest;

/**
 * Class AbstractValue
 *
 * @package J\Message\Value
 */
abstract class AbstractValue implements ValueInterface {

    /**
     * @var mixed
     */
    private $value;

    /**
     * @param mixed $value
     *
     * @return bool
     */
    abstract public function isValid($value);

    /**
     * @param mixed $value
     *
     * @throws \Exception
     */
    final public function __construct($value)
    {
        $this->value = $value;
        $this->validate();
    }

    /**
     * Validates the scalar value passed to the constructor
     *
     * @throws \Exception
     *
     * @return void
     */
    final public function validate() {
        if (!$this->isValid($this->value)) {
            throw new InvalidRequest();
        }
    }

    /**
     * Return the scalar value of the value object
     *
     * @return mixed
     */
    final public function getValue()
    {
       return $this->value;
    }
}
