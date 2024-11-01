<?php
/**
 * Dashboard template.
 * 
 * @since 0.1
 */

namespace Watchtower;

use Watchtower\Admin\UI;

use function Watchtower\is_watchtower_authenticated;

global $wp_version;

$ui = Bootstrap::get_instance()->get_container( 'admin\ui' );
?>
<div class="wrap watchtower-settings">
    <h1><?php esc_html_e( 'Settings', 'watchtower' ); ?></h1>

    <?php if ( ! is_watchtower_authenticated() ) : ?>

        <p><?php esc_html_e( 'You are not connected to Watchtower. Please connect by visiting the dashboard and following the connection wizard.', 'watchtower' ); ?></p>
    
    <?php elseif ( version_compare( $wp_version, '5.0', '<' ) ) : ?>

        <p><?php esc_html_e( 'You are not running version 5.0 or above of WordPress. Please upgrade to use Watchtower.', 'watchtower' ); ?></p>
    
    <?php else : ?>

        <h2 class="nav-tab-wrapper">
            <a href="" class="nav-tab nav-tab-active"><?php esc_html_e( 'Notifications', 'watchtower' ); ?></a>
        </h2>

        <?php if ( 1 === UI::$updated ) : ?>
            <div id="watchtower-settings_updated" class="notice notice-success is-dismissible"> 
                <p><strong><?php esc_html_e( 'Contacts saved.', 'watchtower' ); ?></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'watchtower' ); ?></span></button>
            </div>
        <?php elseif ( 2 === UI::$updated ) : ?>
            <div id="watchtower-settings_error" class="notice notice-error is-dismissible"> 
                <p><strong><?php esc_html_e( 'Failed to update contacts.', 'watchtower' ); ?></strong></p><button type="button" class="notice-dismiss"><span class="screen-reader-text"><?php esc_html_e( 'Dismiss this notice.', 'watchtower' ); ?></span></button>
            </div>
        <?php endif; ?>

        <p><?php esc_html_e( 'Add the contact details of the person who should be notified when your website goes down. SMS is only available on Pro plans and above.', 'watchtower' ); ?></p>

        <?php if ( ! empty( $ui->contacts->error ) ) : ?>
        <p><?php esc_html_e( 'We were unable to fetch your contacts.', 'watchtower' ); ?></p>
        <?php else: ?>
        <div id="watchtower-contacts">
            <p><?php esc_html_e( 'Loading...', 'watchtower' ); ?></p>
        </div>
        <?php endif; ?>

    <?php endif; ?>
</div>
