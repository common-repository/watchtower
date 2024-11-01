<?php
/**
 * Dashboard template.
 * 
 * @since 0.2
 */

namespace Watchtower;

use Watchtower\Admin\UI;

if ( empty( $data['section'] ) ) {
    return;
}

$section = $data['section'];

?>
<div class="watchtower-header">
    <div class="watchtower-header-inner">
        <?php if ( is_watchtower_authenticated() ) : ?>
            <a href="admin.php?page=<?php echo esc_attr( UI::SETTINGS_SLUG ); ?>" class="button"><?php esc_html_e( 'Settings', 'watchtower' ); ?></a>
        <?php endif; ?>
        
        <img src="<?php echo WATCHTOWER_URL . 'assets/images/logo.png'; ?>" class="logo" alt="<?php esc_html_e( 'Watchtower', 'watchtower' ); ?>" title="<?php esc_html_e( 'Watchtower', 'watchtower' ); ?>" />
        
        <ul>
            <li><a href="admin.php?page=<?php echo esc_attr( UI::DASHBOARD_SLUG ); ?>"<?php if ( 'overview' === $section ) echo ' class="selected"'; ?>><?php esc_html_e( 'Overview', 'watchtower' ); ?></a></li>
            <li><a href="admin.php?page=<?php echo esc_attr( UI::DASHBOARD_SLUG ); ?>&section=uptime"<?php if ( 'uptime' === $section ) echo ' class="selected"'; ?>><?php esc_html_e( 'Uptime', 'watchtower' ); ?></a></li>
            <li><a href="admin.php?page=<?php echo esc_attr( UI::DASHBOARD_SLUG ); ?>&section=performance"<?php if ( 'performance' === $section ) echo ' class="selected"'; ?>><?php esc_html_e( 'Performance', 'watchtower' ); ?></a></li>
            <li><a href="admin.php?page=<?php echo esc_attr( UI::DASHBOARD_SLUG ); ?>&section=security"<?php if ( 'security' === $section ) echo ' class="selected"'; ?>><?php esc_html_e( 'Security', 'watchtower' ); ?></a></li>
        </ul>
    </div>
</div>
