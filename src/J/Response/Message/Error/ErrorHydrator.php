<?php

namespace J\Response\Message\Error;

use J\Value\ValueFactory;

/**
 * Class ErrorHydrator
 *
 * @package J\Response\Message\Error
 */
class ErrorHydrator {

	const FALLBACK_KEY = 0;

	/**
	 * @var ValueFactory
	 */
	private $value_factory;

	/**
	 * @var \ArrayAccess
	 */
	private $error_registry;

	/**
	 * @param ValueFactory $value_factory
	 * @param \ArrayAccess $error_registry
	 */
	public function __construct(\ArrayAccess $error_registry, ValueFactory $value_factory) {
		$this->value_factory = $value_factory;
		$this->error_registry = $error_registry;
	}

	/**
	 * @param \Exception $exception
	 * @param ErrorInformation $error_information
	 *
	 * @return int
	 */
	private function getCode(\Exception $exception, \Exception $exception_preset) {
		if (!$code = $exception_preset->getCode()) {
			$code = $exception->getCode();
		}

		return (int) $code;
	}

	/**
	 * @param \Exception $exception
	 * @param ErrorInformation $error_information
	 *
	 * @return string
	 */
	private function getMessage(\Exception $exception, \Exception $exception_preset) {
		if (!$message = $exception_preset->getMessage()) {
			$message = $exception->getMessage();
		}

		return (string) $message;
	}

	/**
	 * @param Error $error
	 * @param \Exception $exception
	 *
	 * @return null
	 */
	public function hydrate(Error $error, \Exception $exception) {
		$registry = $this->error_registry;
		$value_factory = $this->value_factory;

		$exception_class = get_class($exception);

		if (isset($registry[$exception_class])) {
			$key = $exception_class;
		} else {
			$key = static::FALLBACK_KEY;
		}

		/** @var \Exception $error_info */
		$error_info = $registry[$key];

		$code = $this->getCode($exception, $error_info);
		$message = $this->getMessage($exception, $error_info);

		$error->setCode($value_factory->createCode($code));
		$error->setMessage($value_factory->createMessage($message));
	}

	/**
	 * @param Error $error
	 *
	 * @return \stdClass
	 */
	public function extract(Error $error) {
		$data = array(
			'code'          => $error->getCode()->getValue(),
		        'message'       => $error->getMessage()->getValue(),
		);

		return (object) $data;
	}
} 
