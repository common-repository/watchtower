<?php
/**
 * Utilities that can be used across the whole plugin.
 *
 * @since 0.1
 *
 * @package Watchtower
 */

namespace Watchtower;

use Watchtower\Core\Connect;
use Watchtower\Admin\UI;
use Watchtower\Core\Watchtower_API;

/**
 * Checks to see if the current page is a Watchtower admin page.
 * 
 * @since 0.1
 * 
 * @param string $pagename Admin page to check.
 */
function is_watchtower_admin( $pagename = null ) {
	if ( ! empty( $_GET['page'] ) ) {
		$page = sanitize_text_field( wp_unslash( $_GET['page'] ) );

		if ( empty( $pagename ) ) {
			$watchtower_pages = [ UI::DASHBOARD_SLUG, UI::SETTINGS_SLUG ];
		} else {
			$watchtower_pages = [ $pagename ];
		}

		if ( in_array( $page, $watchtower_pages ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Checks to see if there is a connection to Watchtower.
 * 
 * @since 0.1
 */
function is_watchtower_authenticated() {
	return ! empty( get_option( Connect::TOKEN_KEY ) );
}

/**
 * Renders a template if it exists.
 *
 * @since 0.1
 *
 * @param string $template The template file slug excluding extension.
 * @param array  $data The data to be passed through to the template.
 */
function render_template( $template, $data = [] ) {
	$template_path = WATCHTOWER_DIR . 'includes/templates/' . $template . '.php';

	if ( file_exists( $template_path ) ) {
		include $template_path;
	}
}

/**
 * Returns a severity class based on and input score.
 * 
 * @since 0.2
 * 
 * @param int    $score The score to compare.
 * @param int    $red_limit The limit to show red.
 * @param int    $orange_limit The limit to show orange.
 * @param string $comparison How to compare the data (> or <).
 */
function determine_severity_class( $score, $red_limit, $orange_limit, $comparison ) {
	if ( '>' === $comparison ) {
		if ( $score > $red_limit ) {
			return ' red';
		}
	
		if ( $score > $orange_limit ) {
			return ' orange';
		}
	
		return ' green';
	}

	if ( $score < $red_limit ) {
		return ' red';
	}

	if ( $score < $orange_limit ) {
		return ' orange';
	}

	return ' green';
}

/**
 * Returns a severity class based on the performance percentage.
 * 
 * @since 0.1
 * 
 * @param int $percentage The performance percentage.
 */
function determine_performance_severity_class( $percentage ) {
	if ( $percentage < 50 ) {
		return ' red';
	}

	if ( $percentage < 80 ) {
		return ' orange';
	}

	return ' green';
}

/**
 * Returns a severity class based on the uptime percentage.
 * 
 * @since 0.1
 * 
 * @param int $percentage The uptime percentage.
 */
function determine_uptime_severity_class( $percentage ) {
	if ( $percentage < 80 ) {
		return ' red';
	}

	if ( $percentage < 98 ) {
		return ' orange';
	}

	return ' green';
}

/**
 * Used for the pricing table to add a class for the current plan.
 * 
 * @since 0.1
 * 
 * @param string $plan The plan being display.
 * @param string $current The current plan the user is on.
 */
function determine_plan_class( $plan, $current ) {
	if ( $plan === $current ) {
		return 'current';
	}

	return '';
}

/**
 * Returns the Watchtower auth endpoint.
 * 
 * @since 0.1
 */
function get_watchtower_auth_endpoint() {
	$endpoint = Connect::AUTH_ENDPOINT;

	// In case a WP config constant is set.
	if ( defined( 'WATCHTOWER_AUTH_ENDPOINT' ) ) {
		$endpoint = esc_url_raw( WATCHTOWER_AUTH_ENDPOINT );
	}

	/**
	 * Override the Watchtower auth endpoint. Useful for dev environments.
	 * 
	 * @since 0.1
	 * 
	 * @param string $endpoint The auth endpoint.
	 */
	return apply_filters( 'watchtower_auth_endpoint', $endpoint );
}

/**
 * Returns the Watchtower API endpoint.
 * 
 * @since 0.1
 */
function get_watchtower_api_endpoint() {
	$endpoint = Watchtower_API::WATCHTOWER_API;

	// In case a WP config constant is set.
	if ( defined( 'WATCHTOWER_API_ENDPOINT' ) ) {
		$endpoint = esc_url_raw( WATCHTOWER_API_ENDPOINT );
	}

	/**
	 * Override the Watchtower API endpoint. Useful for dev environments.
	 * 
	 * @since 0.1
	 * 
	 * @param string $endpoint The API endpoint.
	 */
	return apply_filters( 'watchtower_api_endpoint', $endpoint );
}
