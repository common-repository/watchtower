<?php
/**
 * Responsible for connecting to dealing with uptime data.
 * 
 * @since 0.2
 *
 * @package Watchtower
 */

namespace Watchtower\Core;

/**
 * Class Uptime
 *
 * @since 0.2
 *
 * @package Watchtower\Core\Uptime
 */
class Uptime {

    /**
     * Takes an API response input and calculates the 30 day average.
     * 
     * @since 0.2
     * 
     * @param array $data API response from the uptime endpoint.
     */
	public static function stats_30_day_average( $data ) {
        $incidents  = 0;
        $percentage = 100;

        if ( ! empty( $data ) ) {
            $percentage_total = 0;

            foreach ( $data as $day ) {
                if ( $day->incidents > 0 ) {
                    $incidents += $day->incidents;
                }

                $percentage_total += $day->percentage;
            }

            $percentage_total = $percentage_total / count( $data );
        }

        return [
            'incidents'  => $incidents,
            'percentage' => $percentage_total,
        ];
    }

}
