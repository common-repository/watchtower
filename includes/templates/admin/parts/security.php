<?php
/**
 * Security template.
 * 
 * @since 0.2
 */

namespace Watchtower;
?>
<div class="watchtower-table">
    <table class="wp-list-table widefat" style="margin: 10px 0;">
        <thead>
            <tr>
                <th width="80%"><?php esc_html_e( 'Test', 'watchtower' ); ?></th>
                <th width="20%"><?php esc_html_e( 'Result', 'watchtower' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><?php esc_html_e( 'SSL enabled', 'watchtower' ); ?></td>
                <td><?php is_ssl() || stripos( get_option('siteurl'), 'https://' ) === 0 ? esc_html_e( 'Passed', 'watchtower' ) : esc_html_e( 'Failed!', 'watchtower' ); ?></td>
            </tr>
        </tbody>
    </table>
</div>