<?php
/**
 * Default single news layout.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();
	$fields = function_exists( 'get_fields' ) ? ( get_fields() ?: array() ) : array();
	$term   = iec_news_single_primary_term();
	?>
	<main class="iec-single-news-main" id="main">
		<?php
		get_template_part(
			'template-parts/news/banner',
			null,
			array(
				'fields' => $fields,
				'term'   => $term,
			)
		);
		?>
		<section class="iec_single_news_main_section iec_defualt_position">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="iec_single_news_main_content_warpper">
							<?= wp_kses_post( $fields['content'] ?? '' ); ?>
						</div>
						<?php if ( ! empty( $fields['contact_us_caption'] ) ) : ?>
							<div class="iec_single_news_bottom_contact">
								<?= wp_kses_post( $fields['contact_us_caption'] ); ?>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</section>
	</main>
	<?php
endwhile;
