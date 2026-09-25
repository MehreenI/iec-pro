<?php
/**
 * Default page template.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$fields  = function_exists( 'get_fields' ) ? get_fields() : array();
	$fields  = is_array( $fields ) ? $fields : array();
	$caption = isset( $fields['caption'] ) ? (string) $fields['caption'] : get_the_title();
	$content = isset( $fields['content'] ) ? (string) $fields['content'] : '';
	?>
	<main id="main">
		<section class="iec_default_hero_section">
			<div class="container">
				<h1><?= $caption ?: get_the_title(); ?></h1>
			</div>
		</section>
		<section class="iec_default_content_section">
			<div class="container">
				<div class="iec_main_content_warpper">
					<?= wp_kses_post( $content ); ?>
				</div>
			</div>
		</section>
	</main>
	<?php
endwhile;

get_footer();
