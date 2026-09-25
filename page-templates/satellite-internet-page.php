<?php
/**
 * Template Name: Satellite Internet
 *
 * Renders the component library from the ACF group "Default Page — Content"
 * (hero style, anchor bar, page sections). Until page sections are filled in,
 * the original static sections are shown instead.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

get_header();

while ( have_posts() ) :
	the_post();

	$fields     = iec_page_fields();
	$rows       = iec_flex_rows( $fields['page_sections'] ?? null );
	$hero_style = (string) ( $fields['hero_style'] ?? '' );
	?>

	<main id="main" class="iec-default-page iec-satellite-internet">
		<?php
		if ( $rows ) {
			if ( 'none' !== $hero_style ) {
				get_template_part( 'template-parts/default-page/hero', $hero_style ?: null, array( 'fields' => $fields ) );
			}

			get_template_part( 'template-parts/default-page/anchor-nav', null, array( 'fields' => $fields ) );

			get_template_part( 'template-parts/default-page/sections', null, array( 'rows' => $rows ) );
		} else {
			get_template_part( 'template-parts/satellite-internet/sections' );
		}
		?>
	</main>

	<?php
endwhile;

get_footer();
