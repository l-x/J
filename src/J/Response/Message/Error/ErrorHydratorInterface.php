<?php

namespace J\Response\Message\Error;

/**
 * Class ErrorHydratorInterface
 *
 * @package J\Response\Message\Error
 */
interface ErrorHydratorInterface {

	/**
	 * @param ErrorInterface $error
	 * @param \Exception $exception
	 *
	 * @return null
	 */
	public function __invoke(ErrorInterface $error, \Exception $exception);
}
