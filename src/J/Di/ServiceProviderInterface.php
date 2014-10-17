<?php

namespace J\Di;

/**
 * Interface ServiceProviderInterface
 *
 * @package J\Di
 */
interface ServiceProviderInterface {

	/**
	 * @param Container $dic
	 *
	 * @return mixed
	 */
	public function register(Container $dic);
}
