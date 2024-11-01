<?php
/**
 * Watchtower
 *
 * @package   Watchtower
 * @author    Watchtower <support@usewatchtower.com>
 * @copyright 2020 Watchtower
 * @license   GPL-2.0+ http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * @wordpress-plugin
 * Plugin Name: Watchtower
 * Plugin URI:  https://usewatchtower.com
 * Description: Uptime and performance auditing, monitoring and alerting for WordPress.
 * Version:     0.2
 * Author:      Watchtower
 * Author URI:  https://usewatchtower.com
 * Text Domain: watchtower
 *
 * Copyright:   © 2019 Watchtower
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 *
 * Fire up the engines! Main plugin file which is simply used for getting
 * things started.
 *
 * @since 0.1
 */

namespace Watchtower;

use Watchtower\Core\Connect;

// Autoload classes.
require_once 'includes/helpers/autoloader.php';

// Load config.
require_once 'includes/config/config.php';

// Load helpers.
require_once 'includes/helpers/utilities.php';

$bootstrap = Bootstrap::get_instance();
$bootstrap->load();

register_deactivation_hook( __FILE__, '\Watchtower\watchtower_deactivation' );

/**
 * Deactivate the connection when the user deactivates the plugin.
 * 
 * @since 0.1
 */
function watchtower_deactivation() {
    $api = Bootstrap::get_instance()->get_container( 'core\watchtower_api' );
    
    // Disconnect the service.
    $api->deactivate_site();

    // Remove tokens and keys.
    delete_option( Connect::ACCOUNT_KEY );
    delete_option( Connect::SITE_KEY );
    delete_option( Connect::VALIDATION_KEY );
    delete_option( Connect::TOKEN_KEY );
}
