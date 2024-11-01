<?php
/**
 * Dashboard template.
 * 
 * @since 0.1
 */

namespace Watchtower;

use function Watchtower\is_watchtower_authenticated;

$ui = Bootstrap::get_instance()->get_container( 'admin\ui' );

$section = 'overview';

if ( ! empty( $_GET['section'] ) ) {
	$section = sanitize_text_field( wp_unslash( $_GET['section'] ) );
}

// Check for data error.
if ( 'overview' === $section && ( empty( $ui->uptime ) || ! empty( $ui->uptime->error ) ) ) {
	$data_error = ! empty( $ui->uptime->error ) ? $ui->uptime->error : true;
}

if ( 'uptime' === $section && ( empty( $ui->uptime ) || ! empty( $ui->uptime->error ) ) ) {
	$data_error = ! empty( $ui->uptime->error ) ? $ui->uptime->error : true;
}

if ( 'performance' === $section && ! empty( $ui->performance->error ) ) {
	$data_error = ! empty( $ui->performance->error ) ? $ui->performance->error : true;
}

?>
<div class="watchtower">
	<?php render_template( 'admin/parts/header', [ 'section' => $section ] ); ?>

	<?php if ( ! is_watchtower_authenticated() ) : ?>
	
		<?php render_template( 'admin/parts/onboard' ); ?>

	<?php elseif ( ! empty( $data_error ) ) : ?>

		<?php if ( ! empty( $data_error->code ) && 3 === $data_error->code ) : ?>
		<div class="watchtower-body">
			<div class="watchtower-error">
				<h1><?php esc_html_e( 'Inactive site', 'watchtower' ); ?></h1>
				<p>
					<?php
					printf(
						esc_html__( 'This site appears to be inactive. This usually happens when you deactivate the Watchtower plugin and reactivate it again. Log in to your %s account to reactivate this site.', 'watchtower' ),
						'<a href="https://usewatchtower.com/account/" target="_blank">Watchtower</a>'
					);
					?>
				</p>
			</div>
		</div>
		<?php else : ?>
		<div class="watchtower-body">
			<div class="watchtower-error">
				<h1><?php esc_html_e( 'Oops, something went wrong!', 'watchtower' ); ?></h1>
				<p>
					<?php esc_html_e( 'We were unable to retrieve your data from our server. Please try again in a few minutes. If the problem persists, please contact Watchtower support.', 'watchtower' ); ?>
				</p>
			</div>
		</div>
		<?php endif; ?>
	
	<?php else : ?>

	<div class="watchtower-body">
		<?php		
		switch ( $section ) {
			case 'uptime' :
				render_template( 'admin/parts/uptime', [ 'ui' => $ui ] );
			break;

			case 'performance' :
				render_template( 'admin/parts/performance', [ 'ui' => $ui ] );
			break;

			case 'security' :
				render_template( 'admin/parts/security', [ 'ui' => $ui ] );
			break;
			
			default:
				render_template( 'admin/parts/overview', [ 'ui' => $ui ] );
			break;
		}
		?>
	</div>

	<?php endif; ?>
</div>
