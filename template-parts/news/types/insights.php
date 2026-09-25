<?php
/**
 * Insights single news layout.
 *
 * ACF flexible: content_blocks → template-parts/news/flexible/{layout}.php
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();
	$post_id = (int) get_the_ID();
	$fields  = function_exists( 'get_fields' ) ? ( get_fields() ?: array() ) : array();
	$term    = iec_news_single_primary_term();
	$blocks  = is_array( $fields['content_blocks'] ?? null ) ? $fields['content_blocks'] : array();
	$related = empty( $fields['related_news'] ) ? iec_news_single_related_query( $post_id, $term ) : null;
	?>
	<main class="iec-single-news-main iec-single-news-insights" id="main">
		<article>
			<?php
			get_template_part(
				'template-parts/news/banner',
				null,
				array(
					'fields' => $fields,
					'term'   => $term,
				)
			);

			if ( $blocks ) {
				get_template_part(
					'template-parts/news/content',
					'blocks',
					array(
						'blocks' => $blocks,
					)
				);
			} elseif ( ! empty( $fields['content'] ) ) {
				?>
				<section class="iec_single_news_main_section iec_defualt_position">
					<div class="container">
						<div class="row">
							<div class="col-md-12">
								<div class="iec_single_news_main_content_warpper">
									<?= $fields['content']; ?>
								</div>
							</div>
						</div>
					</div>
				</section>
				<?php
			}

			if ( $related instanceof WP_Query && $related->have_posts() ) {
				get_template_part(
					'template-parts/modules/featured-news',
					null,
					array(
						'heading' => __( 'RELATED ARTICLES', 'bbtheme' ),
						'query'   => $related,
						'spacing' => 'px-20',
					)
				);
			}

			get_template_part(
				'template-parts/modules/contact-form',
				null,
				array(
					'form_type' => 'Enquiry',
				)
			);
			?>
		</article>
	</main>
	<?php
endwhile;
