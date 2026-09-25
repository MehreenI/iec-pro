<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$field = function_exists( 'get_fields' ) ? get_fields() : array();
	if ( ! is_array( $field ) ) {
		$field = array();
	}

	$is_tunisian = ! empty( $field['is_tunisian_page'] );
	?>

	<main class="iec-single-office-main" id="main">

		<?php if ( $is_tunisian && class_exists( 'IEC_Tunisian_Landing_Page' ) ) : ?>

			<!-- Tunisian landing. -->
			<?php
			IEC_Tunisian_Landing_Page::for_queried_page()->render( 'div' );
			$success_popup_html = function_exists( 'iec_enquiry_success_popup_html' )
				? iec_enquiry_success_popup_html( 'Department-enquiry' )
				: '';
			?>
			<div class="iec-modal-overlay iec-popup" id="iecEnquiryModal" role="dialog" aria-modal="true" aria-label="<?php esc_attr_e( 'Enquiry', 'bbtheme' ); ?>">
				<div class="iec-modal-content">
					<button type="button" class="iec-modal-close" id="iecEnquiryModalClose" aria-label="<?php esc_attr_e( 'Close', 'bbtheme' ); ?>">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M18 6L6 18M6 6L18 18" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
						</svg>
					</button>
					<?php
					get_template_part(
						'template-parts/modules/popup',
						null,
						array(
							'form_type'          => 'Department-enquiry',
							'success_popup_html' => $success_popup_html,
						)
					);
					?>
				</div>
			</div>

		<?php else : ?>

			<!-- Hero. -->
			<?php iec_module( 'office-hero-slider', array( 'hero' => $field['hero'] ?? array() ) ); ?>

			<!-- Office tabs. -->
			<?php get_template_part( 'template-parts/office/tabs', null, array( 'field' => $field ) ); ?>

		<?php endif; ?>

		<?php get_template_part( 'template-parts/modules/contact-form' ); ?>

	</main>

	<?php
endwhile;

get_footer();
