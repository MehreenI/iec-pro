<?php
/**
 * Template Name: Voucher Management
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();
?>

<main id="main" class="iec-voucher-management" data-voucher-management-page>

	<?php get_template_part( 'template-parts/voucher/hero' ); ?>

	<?php
	if ( have_rows( 'page_sections' ) ) :
		while ( have_rows( 'page_sections' ) ) :
			the_row();
			get_template_part( 'template-parts/voucher/flexible/' . get_row_layout() );
		endwhile;
	endif;
	?>

</main>

<?php
get_footer();
