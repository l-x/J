<?php

namespace J\Response\Message\Error;

use J\Value\ValueFactoryInterface;

/**
 * Class ErrorHydrator
 *
 * @package J\Response\Message\Error
 */
class ErrorHydrator implements ErrorHydratorInterface {

	const FALLBACK_KEY = 0;

	/**
	 * @var ValueFactoryInterface
	 */
	private $value_factory;

	/**
	 * @var \ArrayAccess
	 */
	private $error_registry;

	/**
	 * @param ValueFactoryInterface $value_factory
	 * @param \ArrayAccess $error_registry
	 */
	public function __construct(\ArrayAccess $error_registry, ValueFactoryInterface $value_factory) {
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

		return $code;
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
	 * @param \Exception $exception
	 *
	 * @return \Exception
	 */
	private function getErrorInfo(\Exception $exception) {
		$key = get_class($exception);

		if (!isset($this->error_registry[$key])) {
			$key = static::FALLBACK_KEY;
		}

		return $this->error_registry[$key];
	}

	/**
	 * @param ErrorInterface $error
	 * @param \Exception $exception
	 *
	 * @return null
	 */
	public function __invoke(ErrorInterface $error, \Exception $exception) {
		$value_factory = $this->value_factory;

		$error_info = $this->getErrorInfo($exception);
		$code = $this->getCode($exception, $error_info);
		$message = $this->getMessage($exception, $error_info);

		$error->setCode($value_factory->createCode($code));
		$error->setMessage($value_factory->createMessage($message));
	}
} 
