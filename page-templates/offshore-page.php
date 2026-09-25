<?php
/**
 * Template Name: Offshore Page 2
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$success_popup_html = '';

while ( have_posts() ) :
	the_post();

	$offshore_id        = get_the_ID();
	$usecases           = get_field( 'offshore_usecases', $offshore_id );
	$usecases           = is_array( $usecases ) ? $usecases : array();
	$success_popup_html = iec_enquiry_success_popup_html( 'iot-enquiry' );
	?>

	<main id="main" class="offshore">

		<?php
		get_template_part( 'template-parts/offshore/hero' );
		get_template_part( 'template-parts/offshore/portfolio' );

		iec_module(
			'use-cases',
			array(
				'enabled' => ! empty( $usecases['enabled'] ),
				'heading' => $usecases['heading'] ?? '',
				'items'   => $usecases['items'] ?? array(),
			)
		);

		iec_module( 'recommended-solutions' );

		get_template_part( 'template-parts/offshore/vas' );
		get_template_part( 'template-parts/offshore/news' );
		get_template_part( 'template-parts/offshore/products' );

		get_template_part(
			'template-parts/offshore/faqs',
			null,
			array(
				'faq'      => get_field( 'faqs', $offshore_id ),
				'show_faq' => get_field( 'show_faq', $offshore_id ),
			)
		);
		?>

	</main>

	<?php
endwhile;
?>

<div class="iec-modal-overlay iec-popup" id="iecEnquiryModal">
	<div class="iec-modal-content">
		<button class="iec-modal-close" id="iecEnquiryModalClose" aria-label="Close modal">
			<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
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

<?php
get_footer();
