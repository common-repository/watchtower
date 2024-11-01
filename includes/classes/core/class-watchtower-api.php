<?php
/**
 * Responsible for making requests to Watchtower.
 *
 * @since 0.1
 *
 * @package Watchtower
 */

namespace Watchtower\Core;

/**
 * Class Watchtower_API
 *
 * @since 0.1
 *
 * @package Watchtower\Core\Watchtower_API
 */
class Watchtower_API {

    /**
     * The Watchtower API endpoint.
     * 
     * @since 0.1
     */
    const WATCHTOWER_API = 'https://usewatchtower.com/api/v1/';

    /**
     * The Watchtower API endpoint.
     * 
     * @since 0.2
     */
    const WATCHTOWER_CACHE_KEYS_OPTION = 'watchtower_cache_keys';

    /**
     * Available API routes.
     * 
     * @since 0.1
     */
    const ROUTES = [
        'deactivate_site'   => [ 'method' => 'PUT', 'route' => 'sites' ],
        'get_account'       => [ 'method' => 'GET', 'route' => 'account' ],
        'get_alerts'        => [ 'method' => 'GET', 'route' => 'alerts' ],
        'get_contacts'      => [ 'method' => 'GET', 'route' => 'contacts' ],
        'get_performance'   => [ 'method' => 'GET', 'route' => 'performance' ],
        'get_uptime'        => [ 'method' => 'GET', 'route' => 'uptime' ],
        'update_contacts'   => [ 'method' => 'PUT', 'route' => 'contacts' ],
    ];

    /**
     * Clear cached API data.
     * 
     * @since 0.1
     */
    public function clear_cache() {
        $cache_keys = get_option( self::WATCHTOWER_CACHE_KEYS_OPTION, [] );

        if ( ! empty( $cache_keys ) ) {
            foreach ( array_keys( $cache_keys ) AS $key ) {
                delete_transient( $key );
            }
        }
    }

    /**
     * Deactivate a site.
     * 
     * @since 0.1
     */
    public function deactivate_site() {
        return $this->request(
            self::ROUTES['deactivate_site']['method'],
            self::ROUTES['deactivate_site']['route'],
            [
                'key'    => get_option( Connect::SITE_KEY ),
                'active' => 0,
            ]
        );
    }

    /**
     * Get account details.
     * 
     * @since 0.1
     */
    public function get_account() {
        return $this->request(
            self::ROUTES['get_account']['method'],
            self::ROUTES['get_account']['route'],
            [],
            1 // One minute as account data can change frequently.
        );
    }

    /**
     * Get alerts.
     * 
     * @since 0.2
     */
    public function get_alerts( $params ) {
        $params = array_merge(
            [
                'site_key' => get_option( Connect::SITE_KEY )
            ],
            $params
        );
        
        return $this->request(
            self::ROUTES['get_alerts']['method'],
            self::ROUTES['get_alerts']['route'],
            $params
        );
    }

    /**
     * Get contacts.
     * 
     * @since 0.1
     */
    public function get_contacts() {
        return $this->request(
            self::ROUTES['get_contacts']['method'],
            self::ROUTES['get_contacts']['route'],
            [
                'site_key' => get_option( Connect::SITE_KEY )
            ],
            10080 // Cache for a week.
        );
    }

    /**
     * Get performance.
     * 
     * @since 0.2
     */
    public function get_performance( $params ) {
        $params = array_merge(
            [
                'site_key' => get_option( Connect::SITE_KEY )
            ],
            $params
        );

        return $this->request(
            self::ROUTES['get_performance']['method'],
            self::ROUTES['get_performance']['route'],
            $params
        );
    }

    /**
     * Get uptime.
     * 
     * @since 0.2
     */
    public function get_uptime( $params ) {
        $params = array_merge(
            [
                'site_key' => get_option( Connect::SITE_KEY )
            ],
            $params
        );
        
        return $this->request(
            self::ROUTES['get_uptime']['method'],
            self::ROUTES['get_uptime']['route'],
            $params
        );
    }

    /**
     * Update contacts.
     * 
     * @since 0.1
     * 
     * @param string $contacts JSON data of contacts to be updated.
     */
    public function update_contacts( $contacts ) {
        return $this->request(
            self::ROUTES['update_contacts']['method'],
            self::ROUTES['update_contacts']['route'],
            [
                'site_key' => get_option( Connect::SITE_KEY )
            ],
            null,
            $contacts
        );
    }

    /**
     * Make a request to the Watchtower API.
     * 
     * @since 0.1
     * 
     * @param string  $method The HTTP method for the request.
     * @param string  $route The API route to use.
     * @param array   $params The params to pass through.
     * @param integer $cache_minutes Number of minutes to cache the data.
     * @param boolean $json_body Data to be sent as JSON if needed.
     */
    public function request( $method, $route, $params, $cache_minutes = 15, $json_body = false ) {
        // Check cache first.
        $cache_key = $this->get_cache_key( $route, $method, $params );

        // Cache GET requests.
        $cache_enabled = true;

        if ( defined( 'WATCHTOWER_CACHE_ENABLED' ) ) {
            $cache_enabled = WATCHTOWER_CACHE_ENABLED;
        }

        if ( $cache_enabled && 'GET' === $method && ! empty( $cache = get_transient( $cache_key ) ) ) {
            return $cache;
        }

        // Add a timestamp for signature validations.
        $timestamp   = time();
        $endpoint    = trailingslashit( sprintf( '%s%s', \Watchtower\get_watchtower_api_endpoint(), $route ) );
        $account_key = get_option( Connect::ACCOUNT_KEY );
        $token       = get_option( Connect::TOKEN_KEY );
        $signature   = hash_hmac( 'sha256', $account_key . $timestamp, $token );
        
        $headers = [
            'Accept'        => 'application/json',
            'Authorization' => 'Basic ' . base64_encode( $account_key . ':' . $signature ),
        ];

        $body = '';
        
        if ( 'POST' === $method || 'PUT' === $method ) {
            $headers['Content-Type'] = $json_body ? 'application/json' : 'application/x-www-form-urlencoded';

            if ( $json_body ) {
                $endpoint = add_query_arg( $params, $endpoint );
                $body     = $json_body;
            } else {
                $body = $params;
            }

            // Add the timestamp to the endpoint.
            $endpoint = add_query_arg( 'ts', $timestamp, $endpoint );
        }

        if ( 'GET' === $method ) {
            // Add the timestamp to the data params before sending.
            $params['ts'] = $timestamp;
            $endpoint     = add_query_arg( $params, $endpoint );
        }

        $response = wp_remote_request(
            $endpoint,
            [
                'method'  => $method,
                'headers' => $headers,
                'body'    => $body,
            ]
        );
        
        if ( ! is_wp_error( $response ) ) {
            $data = json_decode( $response['body'] );

            if ( $response['response']['code'] == 200 || $response['response']['code'] == 201 )  {
                if ( $cache_enabled && 'GET' === $method ) {
                    set_transient( $cache_key, $data, $cache_minutes * MINUTE_IN_SECONDS );
                }
            }

            return $data;
        }

        return [ 'error' => [ 'code' => 6, 'message' => 'Unable to handle request' ] ];
    }

    /**
     * Generates a cache key for a given route. Also stores it in an option.
     * 
     * @since 0.1
     * 
     * @param string $route The API route.
     * @param string $method The HTTP request method.
     */
    public function get_cache_key( $route, $method, $params ) {
        $cache_key = sprintf(
            '%s_%s',
            'watchtower',
            md5( str_replace( '/', '', $route ) . strtolower( $method ) . serialize( $params ) )
        );

        // Add to list of cache keys.
        $stored_keys               = get_option( self::WATCHTOWER_CACHE_KEYS_OPTION, [] );
        $stored_keys[ $cache_key ] = 1;

        update_option( self::WATCHTOWER_CACHE_KEYS_OPTION, $stored_keys );

        return $cache_key;
    }

}
