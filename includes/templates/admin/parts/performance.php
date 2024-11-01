<?php
/**
 * Overview template.
 * 
 * @since 0.2
 */

namespace Watchtower;

use Watchtower\Admin\UI;

use function Watchtower\determine_performance_severity_class;
use function Watchtower\determine_severity_class;

if ( empty( $data['ui'] ) ) {
    return;
}

$ui = $data['ui'];

// We've already checked for errors, proceed without any error checking.
?>
<div class="watchtower-blocks">
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
                <p><?php esc_html_e( 'Last audit:', 'watchtower' ); ?></p>
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

                <p class="label"><?php echo wp_kses_post( sprintf( __( 'Performance score from Lighthouse by Google. For tips on improvements, see %s', 'watchtower' ), '<a href="https://developers.google.com/speed/pagespeed/insights/" target="_blank">PageSpeed Insights</a>' ) ); ?></p>
            </div>
        </div>
    </div>

    <div class="watchtower-block">
        <div class="watchtower-block-inner">
            <div class="watchtower-block-header">
                <h3><?php esc_html_e( 'Web Vitals', 'watchtower' ); ?></h3>
                <p><?php echo wp_kses_post( sprintf( __( 'Performance metrics from %s by Google', 'watchtower' ), '<a href="https://web.dev/vitals/" target="_blank">Web Vitals</a>' ) ); ?></p>
            </div>

            <div class="watchtower-block-body">
                <?php if ( ! $performance_run ) : ?>
                    <p class="label"><?php esc_html_e( 'Awaiting performance audit results. Please check back soon.', 'watchtower' ); ?></p>
                <?php else : ?>
                <div class="watchtower-grid">
                    <div class="grid-item">
                        <div class="watchtower-wheel small<?php echo esc_attr( determine_severity_class( $ui->performance[0]->lcp_score * 100, 45, 75, '<' ) ); ?>">
                            <svg viewBox="0 0 36 36" class="circular-chart">
                                <path class="circle-bg"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                    stroke-dasharray="<?php echo floor( intval( $ui->performance[0]->lcp_score * 100 ) ); ?>, 100"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="23.35" class="percentage"><?php echo floor( intval( $ui->performance[0]->lcp_score * 100 ) ); ?></text>
                            </svg>
                        </div>
                    </div>
                    <div class="grid-item">
                        <h3><?php esc_html_e( 'Largest Contentful Paint (LCP)', 'watchtower' ); ?></h3>
                    </div>
                    <div class="grid-item">
                        <?php echo esc_html( number_format( $ui->performance[0]->lcp / 1000, 2 ) ); ?>s
                    </div>
                    <div class="grid-item">
                        <a href="https://web.dev/lcp/" target="_blank">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;fill:#ccd0d4;" xml:space="preserve"><g><g><g><rect x="192" y="192" width="42.667" height="128"/><path d="M213.333,0C95.467,0,0,95.467,0,213.333s95.467,213.333,213.333,213.333S426.667,331.2,426.667,213.333 S331.2,0,213.333,0z M213.333,384c-94.08,0-170.667-76.587-170.667-170.667S119.253,42.667,213.333,42.667 S384,119.253,384,213.333S307.413,384,213.333,384z"/><rect x="192" y="106.667" width="42.667" height="42.667"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                        </a>
                    </div>
                </div>

                <div class="watchtower-grid">
                    <div class="grid-item">
                        <div class="watchtower-wheel small<?php echo esc_attr( determine_severity_class( $ui->performance[0]->tbt_score * 100, 45, 75, '<' ) ); ?>">
                            <svg viewBox="0 0 36 36" class="circular-chart">
                                <path class="circle-bg"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                    stroke-dasharray="<?php echo floor( intval( $ui->performance[0]->tbt_score * 100 ) ); ?>, 100"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="23.35" class="percentage"><?php echo floor( intval( $ui->performance[0]->tbt_score * 100 ) ); ?></text>
                            </svg>
                        </div>
                    </div>
                    <div class="grid-item">
                        <h3><?php esc_html_e( 'Total Blocking Time (TBT/FID*)', 'watchtower' ); ?></h3>
                    </div>
                    <div class="grid-item">
                        <?php echo esc_html( number_format( $ui->performance[0]->tbt / 1000, 2 ) ); ?>s
                    </div>
                    <div class="grid-item">
                        <a href="https://web.dev/tbt/" taget="_blank">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;fill:#ccd0d4;" xml:space="preserve"><g><g><g><rect x="192" y="192" width="42.667" height="128"/><path d="M213.333,0C95.467,0,0,95.467,0,213.333s95.467,213.333,213.333,213.333S426.667,331.2,426.667,213.333 S331.2,0,213.333,0z M213.333,384c-94.08,0-170.667-76.587-170.667-170.667S119.253,42.667,213.333,42.667 S384,119.253,384,213.333S307.413,384,213.333,384z"/><rect x="192" y="106.667" width="42.667" height="42.667"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                        </a>
                    </div>
                </div>

                <div class="watchtower-grid">
                    <div class="grid-item">
                        <div class="watchtower-wheel small<?php echo esc_attr( determine_severity_class( $ui->performance[0]->cls_score * 100, 45, 75, '<' ) ); ?>">
                            <svg viewBox="0 0 36 36" class="circular-chart">
                                <path class="circle-bg"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                    stroke-dasharray="<?php echo floor( intval( $ui->performance[0]->cls_score * 100 ) ); ?>, 100"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="23.35" class="percentage"><?php echo floor( intval( $ui->performance[0]->cls_score * 100 ) ); ?></text>
                            </svg>
                        </div>
                    </div>
                    <div class="grid-item">
                        <h3><?php esc_html_e( 'Cumulative Layout Shift (CLS)', 'watchtower' ); ?></h3>
                    </div>
                    <div class="grid-item">
                        <?php echo esc_html( $ui->performance[0]->cls ); ?>
                    </div>
                    <div class="grid-item">
                        <a href="https://web.dev/cls/" target="_blank">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;fill:#ccd0d4;" xml:space="preserve"><g><g><g><rect x="192" y="192" width="42.667" height="128"/><path d="M213.333,0C95.467,0,0,95.467,0,213.333s95.467,213.333,213.333,213.333S426.667,331.2,426.667,213.333 S331.2,0,213.333,0z M213.333,384c-94.08,0-170.667-76.587-170.667-170.667S119.253,42.667,213.333,42.667 S384,119.253,384,213.333S307.413,384,213.333,384z"/><rect x="192" y="106.667" width="42.667" height="42.667"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                        </a>
                    </div>
                </div>

                <p class="label"><?php esc_html_e( '* We cannot automate testing FID due to the lack of user input, so we use TBT as an accurate alternative.', 'watchtower' ); ?></p>

                <h3><?php esc_html_e( 'Other useful metrics', 'watchtower' ); ?></h3>

                <div class="watchtower-grid">
                    <div class="grid-item">
                        <div class="watchtower-wheel small<?php echo esc_attr( determine_severity_class( $ui->performance[0]->ttfb_score * 100, 45, 75, '<' ) ); ?>">
                            <svg viewBox="0 0 36 36" class="circular-chart">
                                <path class="circle-bg"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                    stroke-dasharray="<?php echo floor( intval( $ui->performance[0]->ttfb_score * 100 ) ); ?>, 100"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="23.35" class="percentage"><?php echo floor( intval( $ui->performance[0]->ttfb_score * 100 ) ); ?></text>
                            </svg>
                        </div>
                    </div>
                    <div class="grid-item">
                        <h3><?php esc_html_e( 'Time To First Byte (TTFB)', 'watchtower' ); ?></h3>
                    </div>
                    <div class="grid-item">
                        <?php echo esc_html( number_format( $ui->performance[0]->ttfb / 1000, 2 ) ); ?>s
                    </div>
                    <div class="grid-item">
                        <a href="https://web.dev/time-to-first-byte/" target="_blank">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;fill:#ccd0d4;" xml:space="preserve"><g><g><g><rect x="192" y="192" width="42.667" height="128"/><path d="M213.333,0C95.467,0,0,95.467,0,213.333s95.467,213.333,213.333,213.333S426.667,331.2,426.667,213.333 S331.2,0,213.333,0z M213.333,384c-94.08,0-170.667-76.587-170.667-170.667S119.253,42.667,213.333,42.667 S384,119.253,384,213.333S307.413,384,213.333,384z"/><rect x="192" y="106.667" width="42.667" height="42.667"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                        </a>
                    </div>
                </div>

                <div class="watchtower-grid">
                    <div class="grid-item">
                        <div class="watchtower-wheel small<?php echo esc_attr( determine_severity_class( $ui->performance[0]->fcp_score * 100, 45, 75, '<' ) ); ?>">
                            <svg viewBox="0 0 36 36" class="circular-chart">
                                <path class="circle-bg"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <path class="circle"
                                    stroke-dasharray="<?php echo floor( intval( $ui->performance[0]->fcp_score * 100 ) ); ?>, 100"
                                    d="M18 2.0845
                                    a 15.9155 15.9155 0 0 1 0 31.831
                                    a 15.9155 15.9155 0 0 1 0 -31.831"
                                />
                                <text x="18" y="23.35" class="percentage"><?php echo floor( intval( $ui->performance[0]->fcp_score * 100 ) ); ?></text>
                            </svg>
                        </div>
                    </div>
                    <div class="grid-item">
                        <h3><?php esc_html_e( 'First Contentful Paint (FCP)', 'watchtower' ); ?></h3>
                    </div>
                    <div class="grid-item">
                        <?php echo esc_html( number_format( $ui->performance[0]->fcp / 1000, 2 ) ); ?>s
                    </div>
                    <div class="grid-item">
                        <a href="https://web.dev/fcp/" target="_blank">
                            <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 426.667 426.667" style="enable-background:new 0 0 426.667 426.667;fill:#ccd0d4;" xml:space="preserve"><g><g><g><rect x="192" y="192" width="42.667" height="128"/><path d="M213.333,0C95.467,0,0,95.467,0,213.333s95.467,213.333,213.333,213.333S426.667,331.2,426.667,213.333 S331.2,0,213.333,0z M213.333,384c-94.08,0-170.667-76.587-170.667-170.667S119.253,42.667,213.333,42.667 S384,119.253,384,213.333S307.413,384,213.333,384z"/><rect x="192" y="106.667" width="42.667" height="42.667"/></g></g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g><g></g></svg>
                        </a>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php
    if ( ! empty( $ui->performance ) ) :
        $labels = [];
        $data   = [];

        foreach ( array_reverse( $ui->performance ) as $key => $report ) {
            $labels[] = date( 'j M', strtotime( $report->date ) );
            $data[]   = floor( $report->performance * 100 );
        }
    ?>
    <div class="watchtower-block">
        <div class="watchtower-block-inner">
            <div class="watchtower-block-header">
                <h3><?php esc_html_e( 'Performance History', 'watchtower' ); ?></h3>
                <p><?php esc_html_e( 'Summary of performance over time', 'watchtower' ); ?></p>
            </div>

            <div class="watchtower-block-body">
                <canvas id="myChart" width="900" height="220"></canvas>
                <script>
                    var ctx = document.getElementById('myChart').getContext('2d');
                    var myChart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: <?php echo wp_json_encode( $labels ); ?>,
                            datasets: [{
                                label: 'Score',
                                data: <?php echo wp_json_encode( $data ); ?>,
                                backgroundColor: 'rgb(202, 232, 241)',
                                borderColor: 'rgb(0,160,210)'
                            }]
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
    <?php endif; ?>
</div>
