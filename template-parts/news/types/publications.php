<?php
/**
 * Publications single news layout.
 *
 * ACF: content_blocks (text_block_w_read_article, text_block, text_with_image), video_url.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

while ( have_posts() ) :
	the_post();
	$post_id     = (int) get_the_ID();
	$fields      = function_exists( 'get_fields' ) ? ( get_fields() ?: array() ) : array();
	$term        = iec_news_single_primary_term();
	$blocks      = is_array( $fields['content_blocks'] ?? null ) ? $fields['content_blocks'] : array();
	$video_url   = $fields['video_url'] ?? '';
	$video_embed = ( $video_url && function_exists( 'iec_video_embed_url' ) ) ? iec_video_embed_url( $video_url ) : $video_url;
	$related     = empty( $fields['related_news'] ) ? iec_news_single_related_query( $post_id, $term ) : null;
	?>
	<main class="iec-single-news-main" id="main">
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
			?>

			<section class="iec_single_news_main_section iec_defualt_position">
				<div class="container">
					<div class="iec_single_news_main_content_warpper">
						<?php if ( $blocks ) : ?>
							<?php foreach ( $blocks as $block ) : ?>
								<?php
								if ( ! is_array( $block ) || empty( $block['acf_fc_layout'] ) ) {
									continue;
								}
								$layout     = $block['acf_fc_layout'];
								$content    = $block['content'] ?? '';
								$side_image = iec_resolve_media_to_url( $block['image'] ?? null );
								$image_alt  = is_array( $block['image'] ?? null ) ? ( $block['image']['alt'] ?? get_the_title() ) : get_the_title();
								$btn_text   = ! empty( $block['button_text'] ) ? $block['button_text'] : __( 'READ ARTICLE', 'bbtheme' );
								$btn_url    = $block['article_url'] ?? '';
								?>

								<?php if ( 'text_block_w_read_article' === $layout ) : ?>
									<div class="row">
										<div class="col-lg-8">
											<?= $content; ?>
										</div>
										<div class="col-lg-4">
											<div class="iec_single_news_image_section">
												<?php if ( $side_image ) : ?>
													<img src="<?= $side_image; ?>" alt="<?= $image_alt; ?>" loading="lazy" decoding="async">
												<?php endif; ?>
												<?php if ( $btn_url ) : ?>
													<a target="_blank" rel="noopener noreferrer" href="<?= $btn_url; ?>"><?= $btn_text; ?></a>
												<?php endif; ?>
											</div>
										</div>
									</div>
								<?php elseif ( 'text_block' === $layout ) : ?>
									<div class="row">
										<div class="col-md-12">
											<?= $content; ?>
										</div>
									</div>
								<?php elseif ( 'text_with_image' === $layout ) : ?>
									<div class="row iec_single_publication_main_content_with_image">
										<div class="col-lg-4">
											<div class="iec_single_news_image_section">
												<?php if ( $side_image ) : ?>
													<img src="<?= $side_image; ?>" alt="<?= $image_alt; ?>" loading="lazy" decoding="async">
												<?php endif; ?>
											</div>
										</div>
										<div class="col-lg-8">
											<?= $content; ?>
										</div>
									</div>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php elseif ( ! empty( $fields['content'] ) ) : ?>
							<div class="row">
								<div class="col-md-12">
									<?= $fields['content']; ?>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( $video_embed ) : ?>
							<div class="iec_single_news_main_video_section">
								<iframe
									width="100%"
									height="700"
									src="<?= $video_embed; ?>"
									title="<?= __( 'Video', 'bbtheme' ); ?>"
									frameborder="0"
									allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
									referrerpolicy="strict-origin-when-cross-origin"
									allowfullscreen
									loading="lazy"
								></iframe>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</section>

			<?php get_template_part( 'template-parts/modules/contact-form' ); ?>

			<?php
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
			?>
		</article>
	</main>
	<?php
endwhile;
