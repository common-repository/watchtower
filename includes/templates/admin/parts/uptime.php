<?php
/**
 * Uptime template.
 * 
 * @since 0.2
 */

namespace Watchtower;

use Watchtower\Admin\UI;
use Watchtower\Core\Uptime;

use function Watchtower\determine_uptime_severity_class;

if ( empty( $data['ui'] ) ) {
    return;
}

$ui     = $data['ui'];
$uptime = Uptime::stats_30_day_average( $ui->uptime );
?>
<?php if ( false && ! empty( $ui->stats->last_30_days ) ) : ?>
<div class="stats">
    <h2><?php esc_html_e( 'Last 30 days uptime', 'watchtower' ); ?></h2>
    <div class="box<?php echo esc_attr( determine_uptime_severity_class( (int) $ui->stats->last_30_days->percentage ) ); ?>">
        <h3><?php esc_html_e( 'Uptime', 'watchtower' ); ?></h3>
        <p class="stat"><?php echo esc_html( (float) number_format( $ui->stats->last_30_days->percentage, 2 ) ); ?>%</p>
        <p class="label"><?php echo intval( $ui->stats->last_30_days->incidents ); ?> <?php echo esc_html( _n( 'incident', 'incidents', $ui->stats->last_30_days->incidents, 'watchtower' ) ); ?></p>
    </div>
</div>
<?php endif; ?>

<?php if ( false && ! empty( $ui->stats->last_7_days ) ) : ?>
<div class="daily">
    <h2><?php esc_html_e( 'Last 7 days uptime', 'watchtower' ); ?></h2>

    <?php foreach ( $ui->stats->last_7_days as $day ) : ?>
    <div class="box<?php echo esc_attr( determine_uptime_severity_class( (int) $day->percentage ) ); ?>">
        <h3 class="stat"><?php echo esc_html( (float) number_format( $day->percentage, 2 ) ); ?>%</h3>
        <p class="date"><?php echo esc_html( date( 'j M', strtotime( $day->date ) ) ); ?></p>
        <p class="label"><?php echo intval( $day->incidents ); ?> <?php echo esc_html( _n( 'incident', 'incidents', $day->incidents, 'watchtower' ) ); ?></p>
    </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

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
            </div>
        </div>
    </div>

    <?php
    if ( ! empty( $ui->uptime ) ) {
        $labels    = [];
        $data      = [];
        $incidents = [];

        foreach ( $ui->uptime as $key => $day ) {
            $labels[]    = date( 'j M', strtotime( $day->date ) );
            $data[]      = floor( $day->percentage );
            $incidents[] = $day->incidents;

            if ( 6 === $key ) {
                break;
            }
        }
    }
    ?>
    <div class="watchtower-block">
        <div class="watchtower-block-inner">
            <div class="watchtower-block-header">
                <h3><?php esc_html_e( 'Last 7 days', 'watchtower' ); ?></h3>
                <p><?php echo intval( array_sum( $incidents ) ); ?> <?php echo esc_html( _n( 'incident', 'incidents', array_sum( $incidents ), 'watchtower' ) ); ?></p>
            </div>

            <div class="watchtower-block-body">
                <canvas id="myChart" width="400" height="220"></canvas>
                <script>
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?php echo wp_json_encode( $labels ); ?>,
                            datasets: [{
                                label: 'Uptime Percentage',
                                data: <?php echo wp_json_encode( $data ); ?>,
                                backgroundColor: 'rgb(202, 232, 241)',
                                borderColor: 'rgb(0,160,210)'
                            },
                            {
                                label: 'Incidents',
                                data: <?php echo wp_json_encode( $incidents ); ?>,
                                borderColor: 'rgb(220,50,50)',
                                fill: false
                            },
                            ]
                        },
                        options: {
                            responsive: true,
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            }
                        }
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<div class="watchtower-table">
    <h2><?php esc_html_e( 'Most recent incidents', 'watchtower' ); ?></h2>

    <?php if ( ! empty( $ui->alerts ) ) : ?>
    <table class="wp-list-table widefat">
        <thead>
            <tr>
                <th><?php esc_html_e( 'Opened', 'watchtower' ); ?></th>
                <th><?php esc_html_e( 'Closed', 'watchtower' ); ?></th>
                <th><?php esc_html_e( 'Response Code', 'watchtower' ); ?></th>
                <th><?php esc_html_e( 'Details', 'watchtower' ); ?></th>
                <th><?php esc_html_e( 'Alerted Via', 'watchtower' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ( $ui->alerts as $alert ) : ?>
            <tr>
                <td><?php echo esc_html( date( 'j F Y g:ia', strtotime( $alert->opened ) ) ); ?></td>
                <td><?php echo 'open' !== $alert->closed ? esc_html( date( 'j F Y g:ia', strtotime( $alert->closed ) ) ) : esc_html__( 'Ongoing', 'watchtower' ); ?></td>
                <td><?php echo esc_html( $alert->response_code ); ?></td>
                <td><?php echo esc_html( $alert->detail_text ); ?></td>
                <td><?php echo esc_html( $alert->alerted_via ); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php else: ?>
        <p><?php esc_html_e( 'No recent alerts.', 'watchtower' ); ?></p>
    <?php endif; ?>
</div>
