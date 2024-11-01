<?php
/**
 * Configs used throughout the plugin.
 *
 * @since 0.1
 *
 * @package Watchtower
 */

namespace Watchtower;

define( 'WATCHTOWER_DIR', trailingslashit( dirname( dirname( dirname( __FILE__ ) ) ) ) );
define( 'WATCHTOWER_URL', trailingslashit( plugins_url( 'watchtower', dirname( dirname( dirname( __FILE__ ) ) ) ) ) );
