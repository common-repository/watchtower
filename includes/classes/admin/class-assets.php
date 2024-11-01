<?php
/**
 * Enqueues and handles assets.
 *
 * @since 0.1
 *
 * @package Watchtower
 */

namespace Watchtower\Admin;

use Watchtower\Bootstrap;
use Watchtower\Admin\UI;

use function Watchtower\is_watchtower_admin;
use function Watchtower\is_watchtower_authenticated;

/**
 * Class Assets
 *
 * @since 0.1
 *
 * @package Watchtower\Admin
 */
class Assets {

	/**
	 * Key for the settings nonce.
	 * 
	 * @since 0.1
	 */
	const SETTINGS_NONCE = 'watchtower_settins';

	/**
	 * Hooks
	 *
	 * @since 0.1
	 */
	public function hooks() {
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_scripts' ] );
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueue_styles' ], 9999 );
	}

	/**
	 * Enqueue the required scripts.
	 *
	 * @since 0.1
	 */
	public function enqueue_scripts() {
		if ( is_watchtower_admin() ) {
			wp_enqueue_script( 'watchtower-admin-js', WATCHTOWER_URL . 'assets/js/src/connect.js', [ 'jquery' ], '0.1' );
			wp_enqueue_script( 'watchtower-chart-js', WATCHTOWER_URL . 'assets/js/dist/chart.min.js', [ 'jquery' ], '2.9.3' );

			// Load React scripts on the Watchtower settings page.
			if ( is_watchtower_admin( UI::SETTINGS_SLUG ) && is_watchtower_authenticated() ) {
				$dependencies = [
					'wp-element',
				];

				wp_enqueue_script( 'watchtower-settings-js', WATCHTOWER_URL . 'assets/js/dist/index.js', [ 'wp-element' ], '0.1', true );

				$ui = Bootstrap::get_instance()->get_container( 'admin\ui' );

				wp_localize_script(
					'watchtower-settings-js',
					'watchtowerContacts',
					[
						'contacts'    => $ui->contacts,
						'accountPlan' => $ui->account->plan,
						'nonce'       => wp_create_nonce( self::SETTINGS_NONCE )
					]
				);
			}
		}
	}

	/**
	 * Enqueue the required styles.
	 *
	 * @since 0.1
	 */
	public function enqueue_styles() {
		if ( is_watchtower_admin() ) {
			wp_enqueue_style( 'watchtower-admin-css', WATCHTOWER_URL . 'assets/css/admin.css', [], '0.2' );
		}
	}

}
