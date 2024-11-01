<?php
/**
 * Manage template.
 * 
 * @since 0.2
 */

namespace Watchtower;

if ( empty( $data['ui'] ) ) {
    return;
}

$ui = $data['ui'];

?>
<div class="watchtower-table">
    <h2><?php esc_html_e( 'Manage connection', 'watchtower' ); ?></h2>
    <p>
        <?php esc_html_e( 'Current plan', 'watchtower' ); ?>: <b><?php echo esc_html( ucwords( $ui->account->plan ) ); ?></b>
        <?php if ( 'basic' === $ui->account->plan ) : ?>
        (<a href="https://usewatchtower.com/account/" target="_blank"><?php esc_html_e( 'upgrade', 'watchtower' ); ?></a>)
        <?php endif; ?>
    </p>
    <div style="overflow-x: auto;">
        <table class="wp-list-table widefat squish">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th class="<?php echo esc_attr( determine_plan_class( 'basic', $ui->account->plan ) ); ?>"><?php esc_html_e( 'Basic', 'watchtower' ); ?></th>
                    <th class="<?php echo esc_attr( determine_plan_class( 'pro', $ui->account->plan ) ); ?>"><?php esc_html_e( 'Pro', 'watchtower' ); ?></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="label"><?php esc_html_e( 'Uptime Checks', 'watchtower' ); ?></td>
                    <td class="<?php echo esc_attr( determine_plan_class( 'basic', $ui->account->plan ) ); ?>"><?php esc_html_e( 'Every 2 Hours', 'watchtower' ); ?></td>
                    <td class="<?php echo esc_attr( determine_plan_class( 'pro', $ui->account->plan ) ); ?>"><?php esc_html_e( 'Every 2 Minutes', 'watchtower' ); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php esc_html_e( 'Performance Audits', 'watchtower' ); ?></td>
                    <td class="<?php echo esc_attr( determine_plan_class( 'basic', $ui->account->plan ) ); ?>"><?php esc_html_e( 'Every week', 'watchtower' ); ?></td>
                    <td class="<?php echo esc_attr( determine_plan_class( 'pro', $ui->account->plan ) ); ?>"><?php esc_html_e( 'Every day', 'watchtower' ); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php esc_html_e( 'Sites', 'watchtower' ); ?></td>
                    <td class="<?php echo esc_attr( determine_plan_class( 'basic', $ui->account->plan ) ); ?>">1</td>
                    <td class="<?php echo esc_attr( determine_plan_class( 'pro', $ui->account->plan ) ); ?>">10</td>
                </tr>
                <tr>
                    <td class="label"><?php esc_html_e( 'Alerts', 'watchtower' ); ?></td>
                    <td class="<?php echo esc_attr( determine_plan_class( 'basic', $ui->account->plan ) ); ?>"><?php esc_html_e( 'Email', 'watchtower' ); ?></td>
                    <td class="<?php echo esc_attr( determine_plan_class( 'pro', $ui->account->plan ) ); ?>"><?php esc_html_e( 'Email / SMS', 'watchtower' ); ?></td>
                </tr>
                <tr>
                    <td class="label"><?php esc_html_e( 'Support', 'watchtower' ); ?></td>
                    <td class="<?php echo esc_attr( determine_plan_class( 'basic', $ui->account->plan ) ); ?>"><?php esc_html_e( 'WP.org Forum', 'watchtower' ); ?></td>
                    <td class="<?php echo esc_attr( determine_plan_class( 'pro', $ui->account->plan ) ); ?>"><?php esc_html_e( 'Email / Helpdesk', 'watchtower' ); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <p>
        <?php
        printf(
            esc_html__( 'To manage this connection, log in to your account on %s.', 'watchtower' ),
            '<a href="https://usewatchtower.com/account/" target="_blank">Watchtower</a>'
        );
        ?>
    </p>
</div>