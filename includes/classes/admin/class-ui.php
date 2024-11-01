<?php
/**
 * Responsible for the admin interface UI.
 *
 * @since 0.1
 *
 * @package Watchtower
 */

namespace Watchtower\Admin;

use Watchtower\Bootstrap;
use Watchtower\Admin\Assets;

use function Watchtower\render_template;
use function Watchtower\is_watchtower_authenticated;
use function Watchtower\is_watchtower_admin;

/**
 * Class UI
 *
 * @since 0.1
 *
 * @package Watchtower\Admin
 */
class UI {

	/**
	 * Account data from the API.
	 * 
	 * @since 0.1
	 */
	public $account = [
		'level' => 'basic',
	];

	/**
	 * Alerts data from the API.
	 * 
	 * @since 0.2
	 */
	public $alerts = [];

	/**
	 * Contact data from the API.
	 * 
	 * @since 0.1
	 */
	public $contacts = [];

	/**
	 * Performance data from the API.
	 * 
	 * @since 0.2
	 */
	public $performance = [];

	/**
	 * Uptime data from the API.
	 * 
	 * @since 0.2
	 */
	public $uptime = [];

	/**
	 * Used to display a updated notice.
	 * 
	 * 1 = Success
	 * 2 = Failure
	 * 
	 * @since 0.1
	 */
	public static $updated = false;

	/**
	 * Slug for the dashboard menu page in WordPress.
	 * 
	 * @since 0.1
	 */
	const DASHBOARD_SLUG = 'watchtower';

	/**
	 * Slug for the settings menu page in WordPress.
	 * 
	 * @since 0.1
	 */
	const SETTINGS_SLUG = 'watchtower-settings';

	/**
	 * SVG icon for the admin menu.
	 */
	const ICON = 'data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0iaXNvLTg4NTktMSI/Pg0KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDE5LjAuMCwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPg0KPHN2ZyB2ZXJzaW9uPSIxLjEiIGlkPSJDYXBhXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4Ig0KCSB2aWV3Qm94PSIwIDAgNTEyIDUxMiIgc3R5bGU9ImVuYWJsZS1iYWNrZ3JvdW5kOm5ldyAwIDAgNTEyIDUxMjsiIHhtbDpzcGFjZT0icHJlc2VydmUiPg0KPGc+DQoJPGc+DQoJCTxwb2x5Z29uIHBvaW50cz0iMTI5LjE4MSwxNDEuMTggMTQyLjA2OSwxODkuODI5IDM2OS45MjksMTg5LjgyOSAzODIuODE2LDE0MS4xOCAJCSIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KCTxnPg0KCQk8cG9seWdvbiBwb2ludHM9IjIxOS42NzksMjIwLjE4MiAyMjUuNTY2LDMwMi44NTcgMjg2LjQzMiwzMDIuODU3IDI5Mi4zMTksMjIwLjE4MiAJCSIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KCTxnPg0KCQk8cG9seWdvbiBwb2ludHM9IjMyMi43NSwyMjAuMTgyIDMxNi44NjIsMzAyLjg1NyA0MTAuMjMxLDMwMi44NTcgNDI4LjEyLDIyMC4xODIgCQkiLz4NCgk8L2c+DQo8L2c+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTE1Mi43OTEsMzMzLjIxMXYxNjMuNjEyYzAsOC4zODIsNi43OTUsMTUuMTc3LDE1LjE3NywxNS4xNzdoMTc2LjA1N2M4LjM4MiwwLDE1LjE3Ny02Ljc5NSwxNS4xNzctMTUuMTc3VjMzMy4yMTENCgkJCUgxNTIuNzkxeiIvPg0KCTwvZz4NCjwvZz4NCjxnPg0KCTxnPg0KCQk8cG9seWdvbiBwb2ludHM9IjExNC44MDcsODYuOTE3IDEyMS4xNDEsMTEwLjgyNiAzOTAuODU3LDExMC44MjYgMzk3LjE5MSw4Ni45MTcgCQkiLz4NCgk8L2c+DQo8L2c+DQo8Zz4NCgk8Zz4NCgkJPHBhdGggZD0iTTI1Ni4wMDMsMGMtOC4zODIsMC0xNS4xNzcsNi43OTUtMTUuMTc3LDE1LjE3N3Y0MS4zODZoMzAuMzU0VjE1LjE3N0MyNzEuMTgsNi43OTUsMjY0LjM4NSwwLDI1Ni4wMDMsMHoiLz4NCgk8L2c+DQo8L2c+DQo8Zz4NCgk8Zz4NCgkJPHBvbHlnb24gcG9pbnRzPSIxODkuMjQ4LDIyMC4xODIgODMuODgsMjIwLjE4MiAxMDEuNzY4LDMwMi44NTcgMTk1LjEzNiwzMDIuODU3IAkJIi8+DQoJPC9nPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPGc+DQo8L2c+DQo8Zz4NCjwvZz4NCjxnPg0KPC9nPg0KPC9zdmc+DQo=';

	/**
	 * Hooks
	 *
	 * @since 0.1
	 */
	public function hooks() {
		add_action( 'admin_init', [ $this, 'fetch_data' ] );
		add_action( 'admin_menu', [ $this, 'admin_menu' ], 999 );
		add_action( 'admin_init', [ $this, 'save_contacts' ] );
	}

	/**
	 * Fetch and cache data from the Watchtower API.
	 * 
	 * @since 0.1
	 */
	public function fetch_data() {
		if ( is_admin() && is_watchtower_admin() && is_watchtower_authenticated() ) {
			$api = Bootstrap::get_instance()->get_container( 'core\watchtower_api' );

			// Attempt to fetch data just in time.
			if ( is_watchtower_admin( self::SETTINGS_SLUG ) ) {
				$this->account  = $api->get_account();
				$this->contacts = $api->get_contacts();
			}

			if ( is_watchtower_admin( self::DASHBOARD_SLUG ) ) {
				$section = 'overview';

				if ( ! empty( $_GET['section'] ) ) {
					$section = sanitize_text_field( wp_unslash( $_GET['section'] ) );
				}

				if ( 'overview' === $section ) {
					$this->account     = $api->get_account();
					$this->uptime      = $api->get_uptime( [ 'limit' => 30 ] );
					$this->performance = $api->get_performance( [ 'limit' => 10 ] );
				}
				
				if ( 'uptime' === $section ) {
					$this->alerts = $api->get_alerts( [ 'limit' => 10 ] );
					$this->uptime = $api->get_uptime( [ 'limit' => 30 ] );
				}
				
				if ( 'performance' === $section ) {
					$this->performance = $api->get_performance( [ 'limit' => 10 ] );
				}
			}
		}
	}

	/**
	 * Add the menu item and page to the WordPress admin.
	 * 
	 * @since 0.1
	 */
	public function admin_menu() {
		add_menu_page(
			__( 'Watchtower', 'watchtower' ),
			__( 'Watchtower', 'watchtower' ),
			'manage_options',
			self::DASHBOARD_SLUG,
			[ $this, 'render_dashboard' ],
			self::ICON,
			81
		);

		add_submenu_page(
			self::DASHBOARD_SLUG,
			__( 'Watchtower', 'watchtower' ),
			__( 'Dashboard', 'watchtower' ),
			'manage_options',
			self::DASHBOARD_SLUG
		);

		if ( is_watchtower_authenticated() ) {
			add_submenu_page(
				self::DASHBOARD_SLUG,
				__( 'Watchtower Settings', 'watchtower' ),
				__( 'Settings', 'watchtower' ),
				'manage_options',
				self::SETTINGS_SLUG,
				[ $this, 'render_settings' ]
			);
		}
	}

	/**
	 * Render the dashboard.
	 * 
	 * @since 0.1
	 */
	public function render_dashboard() {
		render_template( 'admin/dashboard' );
	}

	/**
	 * Render the settings.
	 * 
	 * @since 0.1
	 */
	public function render_settings() {
		render_template( 'admin/settings' );
	}

	/**
	 * Save the contacts.
	 * 
	 * @since 0.1
	 */
	public function save_contacts() {
		if ( is_admin() && is_watchtower_admin() && is_watchtower_authenticated() && ! empty( $_POST['watchtower_contacts'] ) && ! empty( $_POST['watchtower_nonce'] ) ) {
			// Verify nonce.
			$nonce_value = sanitize_text_field( wp_unslash( $_POST['watchtower_nonce'] ) );

			if ( ! \wp_verify_nonce( $nonce_value, Assets::SETTINGS_NONCE ) ) {
				return false;
			}

			$contacts = json_decode( wp_unslash( $_POST['watchtower_contacts'] ) ); // phpcs:ignore XSS okay.

			// Check valid JSON.
			if ( json_last_error() !== JSON_ERROR_NONE ) {
				return;
			}

			$api    = Bootstrap::get_instance()->get_container( 'core\watchtower_api' );
			$update = $api->update_contacts( wp_json_encode( $contacts ) );

			if ( ! empty( $update ) && empty( $update->error ) ) {
				// Success, clear cache and update contacts.
				$this->contacts = $update;
				$api->clear_cache();
				self::$updated = 1;
			} else {
				self::$updated = 2;
			}
		}
	}

}
