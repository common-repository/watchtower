<?php
/**
 * Responsible for connecting to Watchtowr.
 *
 * @since 0.1
 *
 * @package Watchtower
 */

namespace Watchtower\Core;

use function Watchtower\render_template;

/**
 * Class Connect
 *
 * @since 0.1
 *
 * @package Watchtower\Core\Connect
 */
class Connect {

	/**
	 * Endpoint for the auth connection to Watchtower.
	 * 
	 * @since 0.1
	 */
	const AUTH_ENDPOINT = 'https://usewatchtower.com/connect/';

	/**
	 * Key for the Watchtower account key option.
	 * 
	 * @since 0.1
	 */
	const ACCOUNT_KEY = 'watchtower_account_key';

	/**
	 * Key for the Watchtower site key option.
	 * 
	 * @since 0.1
	 */
	const SITE_KEY = 'watchtower_site_key';

	/**
	 * Key for the Watchtower token option.
	 * 
	 * @since 0.1
	 */
	const TOKEN_KEY = 'watchtower_auth_token';
	
	/**
	 * Option key for the validation key,
	 * 
	 * @since 0.1
	 */
	const VALIDATION_KEY = 'watchtower_validation_key';

	/**
	 * Hooks
	 *
	 * @since 0.1
	 */
	public function hooks() {
		add_action( 'init', [ $this, 'validate' ] );
		add_action( 'init', [ $this, 'save_token_and_keys' ] );
	}

	/**
	 * Sets up an endpoint for watchtower to validate a site.
	 * 
	 * @since 0.1
	 */
	public function validate() {
		if ( ! empty( $_GET['watchtower-validate'] ) ) {
			$key_input = sanitize_text_field( wp_unslash( $_GET['watchtower-validate'] ) );

			if ( self::get_validation_key() === $key_input ) {
				wp_send_json_success();
			} else {
				wp_send_json_error();
			}
		}
	}

	/**
	 * Save a token that comes back from Watchtower.
	 * 
	 * @since 0.1
	 */
	public function save_token_and_keys() {
		if ( ! empty( $_GET['watchtower-token'] ) && ! empty( $_GET['watchtower-account-key'] ) && ! empty( $_GET['watchtower-site-key'] ) ) {
			$token = get_option( self::TOKEN_KEY );

			// Only save the token if it's not already set.
			if ( empty( $token ) ) {
				$token = sanitize_text_field( wp_unslash( $_GET['watchtower-token'] ) );
				update_option( self::TOKEN_KEY, $token );
			}

			$account_key = get_option( self::ACCOUNT_KEY );

			// Only save the account key if it's not already set.
			if ( empty( $account_key ) ) {
				$account_key = sanitize_text_field( wp_unslash( $_GET['watchtower-account-key'] ) );
				update_option( self::ACCOUNT_KEY, $account_key );
			}

			$site_key = get_option( self::SITE_KEY );

			// Only save the site key if it's not already set.
			if ( empty( $site_key ) ) {
				$site_key = sanitize_text_field( wp_unslash( $_GET['watchtower-site-key'] ) );
				update_option( self::SITE_KEY, $site_key );
			}

			render_template( 'save-token' );
			wp_die();
		}
	}

	/**
	 * Retrive (and sometimes generated) a validation key for this site.
	 * 
	 * @since 0.1
 	 */
	public static function get_validation_key() {
		$key = get_option( self::VALIDATION_KEY, false );

		if ( empty( $key ) ) {
			$key = uniqid();
			update_option( self::VALIDATION_KEY, $key, false );
		}

		return $key;
	}

	/**
	 * Get the auth endpoint for connecting to Watchtower.
	 * 
	 * @since 0.1
	 */
	public static function get_auth_endpoint() {
		return add_query_arg(
			[
				'plugin'         => 'watchtower',
				'site_url'       => urlencode( get_site_url() ),
				'validation_key' => self::get_validation_key(),
			],
			\Watchtower\get_watchtower_auth_endpoint()
		);
	}

}
