<?php

namespace J\Di;

/**
 * Class Container
 *
 * @package J\Di
 */
class Container extends \Pimple\Container {

	/**
	 * @param ServiceProviderInterface $provider
	 * @param array $values
	 *
	 * @return Container
	 */
	public function register(ServiceProviderInterface $provider, array $values = array()) {
		$provider->register($this);

		foreach ($values as $key => $value) {
			$this->offsetSet($key, $value);
		}

		return $this;
	}
}
