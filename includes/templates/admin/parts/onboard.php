<?php
/**
 * Onboard template.
 * 
 * @since 0.2
 */

namespace Watchtower;

use Watchtower\Core\Connect;

?>
<div class="watchtower-body">
    <div class="watchtower-onboard">
        <img src="<?php echo WATCHTOWER_URL . 'assets/images/icon.png'; ?>" class="icon" alt="<?php esc_html_e( 'Watchtower Icon', 'watchtower' ); ?>" title="<?php esc_html_e( 'Watchtower', 'watchtower' ); ?>" />
        <h2><?php esc_html_e( 'Welcome to Watchtower!', 'watchtower' ); ?></h2>
        <p><?php esc_html_e( 'Watchtower keeps you alerted of any issues with your WordPress website. We take the responsibility of looking after your website seriously.', 'watchtower' ); ?></p>
        <p>
            <?php
            printf(
                esc_html__( 'In order for Watchtower to do it\'s job, you need to connect it to the %s website. Why? Because if your WordPress website is down, the only way to find that out is if another website checks that it is down. Don\'t worry though, connecting and setting up an account is simple and takes just 1 minute! Just click the button below to get started.', 'watchtower' ),
                '<a href="https://usewatchtower.com" target="_blank">Watchtower</a>'
            );
            ?>
        </p>
        <p><a href="#connect" id="connect" class="button button-primary"><?php esc_html_e( 'Connect to Watchtower', 'watchtower' ); ?></a></p>
    </div>

    <script>
        jQuery( 'a#connect' ).on( 'click', function( e ) {
            e.preventDefault();

            jQuery.oauthpopup( {
                path: <?php echo wp_json_encode( Connect::get_auth_endpoint() ); ?>,
                callback: function() {
                    jQuery( '.watchtower-onboard' ).html( '<h3 class="connecting"><?php esc_html_e( 'Connecting... If this message does not disappear in 10 seconds, please manually refresh the page.', 'watchtower' ); ?></h3>' );
                    location.reload();
                }
            } );
        } );
    </script>
</div>
