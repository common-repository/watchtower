<?php
/**
 * Bootstraps the plugin
 *
 * @since 0.1
 *
 * @package Watchtower
 */

namespace Watchtower;

use Watchtower\Admin\Assets;
use Watchtower\Admin\UI;
use Watchtower\Core\Connect;
use Watchtower\Core\Watchtower_API;
use Watchtower\Traits\Singleton;

/**
 * Class Bootstrap
 *
 * Gets the plugin started and holds plugin objects.
 *
 * @since 0.1
 *
 * @package Watchtower
 */
class Bootstrap {

	use Singleton;

	/**
	 * A container to hold objects.
	 *
	 * @since 0.1
	 *
	 * @var array Plugin objects.
	 */
	protected $container = [];

	/**
	 * Loads the different parts of the plugin and intializes the objects. Also
	 * stores the object in a container.
	 *
	 * @since 0.1
	 */
	public function load() {
		$this->container['core\connect']        = new Connect();
		$this->container['core\watchtower_api'] = new Watchtower_API();

		// These should only get added if we're in the WP admin.
		if ( is_admin() ) {
            $this->container['admin\assets'] = new Assets();
            $this->container['admin\ui'] = new UI();
        }

		// Init container objects.
		foreach ( $this->container as $object ) {
			$this->maybe_call_hooks( $object );
		}
	}

	/**
	 * Takes an object and call the hooks method if it is available.
	 *
	 * @since 0.1
	 *
	 * @param object $object The object to initiate.
	 */
	protected function maybe_call_hooks( $object ) {
		if ( is_callable( [ $object, 'hooks' ] ) ) {
			$object->hooks();
		}
	}

	/**
	 * Return the object container.
	 *
	 * @since 0.1
	 *
	 * @param string|bool|void $item The item identifier of the object to fetch.
	 *
	 * @return array|bool
	 */
	public function get_container( $item = false ) {
		if ( ! empty( $item ) ) {
			if ( ! empty( $this->container[ $item ] ) ) {
				return $this->container[ $item ];
			}

			return false;
		}

		return $this->container;
	}

}
