<?php
/**
 * Overview template.
 * 
 * @since 0.2
 */

namespace Watchtower;

use Watchtower\Admin\UI;
use Watchtower\Core\Uptime;

use function Watchtower\determine_performance_severity_class;
use function Watchtower\determine_uptime_severity_class;

if ( empty( $data['ui'] ) ) {
    return;
}

$ui = $data['ui'];

// We've already checked for errors, proceed without any error checking.

$uptime = Uptime::stats_30_day_average( $ui->uptime );
?>
<div class="watchtower-blocks">
    <div class="watchtower-block<?php echo esc_attr( determine_uptime_severity_class( floor( $uptime['percentage'] ) ) ); ?>">
        <div class="watchtower-block-inner">
            <div class="watchtower-block-header">
                <h3><?php esc_html_e( 'Uptime', 'watchtower' ); ?></h3>
                <p><?php esc_html_e( 'Last 30 days', 'watchtower' ); ?> - <?php echo intval( $uptime['incidents'] ); ?> <?php echo esc_html( _n( 'incident', 'incidents', $uptime['incidents'], 'watchtower' ) ); ?></p>
            </div>

            <div class="watchtower-block-body">
                <div class="watchtower-wheel">
                    <svg viewBox="0 0 36 36" class="circular-chart">
                        <path class="circle-bg"
                            d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                            stroke-dasharray="<?php echo esc_attr( floor( $uptime['percentage'] ) ); ?>, 100"
                            d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="23.35" class="percentage"><?php echo esc_attr( floor( $uptime['percentage'] ) ); ?></text>
                    </svg>
                </div>

                <p class="label">
                    <?php
                    if ( floor( $uptime['percentage'] ) < 80 ) {
                        echo esc_html_e( 'Needs attention!', 'watchtower' );
                    } elseif ( floor( $uptime['percentage'] ) < 98 ) {
                        echo esc_html_e( 'Significant downtime', 'watchtower' );
                    } else {
                        echo esc_html_e( 'Nothing to worry about!', 'watchtower' );
                    }
                    ?>
                </p>
            </div>

            <div class="watchtower-block-action">
                <p>
                    <a href="admin.php?page=<?php echo esc_attr( UI::DASHBOARD_SLUG ); ?>&section=uptime">
                        <svg enable-background="new 0 0 223.413 223.413" version="1.1" viewBox="0 0 223.41 223.41" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><polygon points="57.179 223.41 51.224 217.28 159.92 111.71 51.224 6.127 57.179 0 172.19 111.71" fill="#aaaaaa"/></svg>
                        <?php esc_html_e( 'Detailed uptime stats', 'watchtower' ); ?>
                    </a>
                </p>
            </div>
        </div>
    </div>

    <?php
    $performance_run        = false;
    $performance_last_audit = __( 'Not yet run', 'watchtower' );
    $performance_score      = 0;

    if ( ! empty( $ui->performance[0]->performance ) ) {
        $performance_run        = true;
        $performance_last_audit = human_time_diff( strtotime( $ui->performance[0]->date ), current_time( 'timestamp' ) ) . ' ' . __( 'ago', 'watchtower' ) ;
        $performance_score      = floor( $ui->performance[0]->performance * 100 );
    }
    ?>
    <div class="watchtower-block<?php echo $performance_run ? esc_attr( determine_performance_severity_class( $performance_score ) ) : ''; ?>">
        <div class="watchtower-block-inner">
            <div class="watchtower-block-header">
                <h3><?php esc_html_e( 'Performance', 'watchtower' ); ?></h3>
                <p><?php esc_html_e( 'Last audit:', 'watchtower' ); ?> <?php echo esc_html( $performance_last_audit ); ?></p>
            </div>

            <div class="watchtower-block-body">
                <div class="watchtower-wheel">
                    <svg viewBox="0 0 36 36" class="circular-chart">
                        <path class="circle-bg"
                            d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <path class="circle"
                            stroke-dasharray="<?php echo esc_attr( $performance_score ); ?>, 100"
                            d="M18 2.0845
                            a 15.9155 15.9155 0 0 1 0 31.831
                            a 15.9155 15.9155 0 0 1 0 -31.831"
                        />
                        <text x="18" y="23.35" class="percentage"><?php echo esc_attr( $performance_score ); ?></text>
                    </svg>
                </div>

                <p class="label">
                    <?php
                    if ( floor( $uptime['percentage'] ) < 50 ) {
                        echo esc_html_e( 'Needs attention!', 'watchtower' );
                    } elseif ( floor( $uptime['percentage'] ) < 80 ) {
                        echo esc_html_e( 'Could use some improvement', 'watchtower' );
                    } else {
                        echo esc_html_e( 'Super fast!', 'watchtower' );
                    }
                    ?>
                </p>
            </div>

            <div class="watchtower-block-action">
                <p>
                    <a href="admin.php?page=<?php echo esc_attr( UI::DASHBOARD_SLUG ); ?>&section=performance">
                        <svg enable-background="new 0 0 223.413 223.413" version="1.1" viewBox="0 0 223.41 223.41" xml:space="preserve" xmlns="http://www.w3.org/2000/svg"><polygon points="57.179 223.41 51.224 217.28 159.92 111.71 51.224 6.127 57.179 0 172.19 111.71" fill="#aaaaaa"/></svg>
                        <?php esc_html_e( 'Advanced performance metrics', 'watchtower' ); ?>
                    </a>
                </p>
            </div>
        </div>
    </div>

</div>

<?php render_template( 'admin/parts/manage', [ 'ui' => $ui ] ); ?>
