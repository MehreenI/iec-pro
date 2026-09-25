<?php
/**
 * Starlink Operator — what is Starlink and IEC's role.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$logo_url = get_template_directory_uri() . '/assets/img/logo.svg';
?>
<section class="iec_defualt_position" id="role" aria-labelledby="role-heading">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-6">
				<div class="iec_content_box">
					<span class="iec-eyebrow"><?php esc_html_e( "What is Starlink & IEC's Role", 'bbtheme' ); ?></span>
					<h2 id="role-heading" class="iec-section-heading"><?php echo wp_kses( __( 'Global Connectivity.<br>Local Expertise.', 'bbtheme' ), array( 'br' => array() ) ); ?></h2>
					<div class="wysiwyg-content">
						<p><?php esc_html_e( 'Starlink is a satellite internet constellation developed by SpaceX to deliver high-speed, low-latency broadband to even the most remote locations on Earth.', 'bbtheme' ); ?></p>
						<p><?php esc_html_e( 'As an authorized Starlink Partner, IEC Telecom provides official Starlink hardware, expert consultation, seamless integration, and ongoing support to help businesses and organizations stay connected anywhere.', 'bbtheme' ); ?></p>
					</div>
					<nav class="navigation-buttons">
						<a href="#how-it-works" class="btn btn-primary"><?php esc_html_e( 'Learn More About Starlink', 'bbtheme' ); ?></a>
					</nav>
				</div>
			</div>
			<div class="col-md-6">
				<div class="iec_image_wrapper" aria-label="<?php esc_attr_e( 'IEC Telecom Starlink role', 'bbtheme' ); ?>">
					<span aria-hidden="true"></span>
					<div>
						<img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php esc_attr_e( 'IEC Telecom', 'bbtheme' ); ?>" width="170" height="48">
					</div>
					<div data-position="top">
						<div aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="m11 17 2 2a1 1 0 1 0 3-3"/><path d="m14 14 2.5 2.5a1 1 0 1 0 3-3l-3.88-3.88a3 3 0 0 0-4.24 0l-.36.36a3 3 0 0 1-4.24 0l-2.06-2.06a3 3 0 0 0-4.24 0L2 10"/><path d="m18 13 1.88-1.88a3 3 0 0 0 0-4.24l-.36-.36a3 3 0 0 0-4.24 0l-.36.36a3 3 0 0 1-4.24 0L6.4 9.4"/><path d="m2 10 6 6"/><path d="m7 14 8-8"/></svg>
						</div>
						<h3 class="iec-secondary-heading"><?php esc_html_e( 'Authorized Starlink Partner', 'bbtheme' ); ?></h3>
					</div>
					<div data-position="left">
						<div aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none"><path d="M12 3.2L19.4 6.3V12.2C19.4 16.2 16.4 19.6 12 20.8C7.6 19.6 4.6 16.2 4.6 12.2V6.3L12 3.2Z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/><path d="M8.8 12.2L11 14.4L15.3 9.9" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
						</div>
						<h3 class="iec-secondary-heading"><?php esc_html_e( 'Reliable Connectivity Wherever You Operate', 'bbtheme' ); ?></h3>
					</div>
					<div data-position="right">
						<div aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none"><circle cx="9" cy="8" r="2.4" stroke="currentColor" stroke-width="1.7"/><path d="M4.6 17.6C4.8 15.2 6.6 13.6 9 13.6C11.4 13.6 13.2 15.2 13.4 17.6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><circle cx="16.2" cy="8.4" r="2.1" stroke="currentColor" stroke-width="1.7"/><path d="M14.6 17.6C14.8 15.8 16.1 14.6 17.8 14.6C19.5 14.6 20.8 15.8 21 17.6" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
						</div>
						<h3 class="iec-secondary-heading"><?php esc_html_e( 'Expert Consultation & Solution Design', 'bbtheme' ); ?></h3>
					</div>
					<div data-position="bottom">
						<div aria-hidden="true">
							<svg viewBox="0 0 24 24" fill="none"><path d="M5 13V11C5 7.1 8.1 4 12 4C15.9 4 19 7.1 19 11V13" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><rect x="3.4" y="11.6" width="3.6" height="5.4" rx="1.6" stroke="currentColor" stroke-width="1.7"/><rect x="17" y="11.6" width="3.6" height="5.4" rx="1.6" stroke="currentColor" stroke-width="1.7"/><path d="M19 16.8V17.2C19 19.3 17.3 21 15.2 21H12.8" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
						</div>
						<h3 class="iec-secondary-heading"><?php esc_html_e( 'Deployment & Technical Support', 'bbtheme' ); ?></h3>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
