<?php
/**
 * Template Name: News Landing Page
 *
 * Also used by taxonomy-news_type.php.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

if ( is_page() && have_posts() ) {
	the_post();
}

$category         = iec_news_landing_current_category();
$current_industry = isset( $_GET['industry'] ) ? sanitize_text_field( wp_unslash( $_GET['industry'] ) ) : '';
$current_location = isset( $_GET['location'] ) ? sanitize_text_field( wp_unslash( $_GET['location'] ) ) : '';
$news_base_url    = iec_news_landing_current_base_url();
$hub_url          = iec_news_landing_get_category_url();
$featured_title   = iec_news_landing_featured_title( $category );
$slider_query     = new WP_Query( IEC_News_Query::get_featured_args( $category ) );
$news_types       = class_exists( '\BlueBeetle\Press\Generic' )
	? \BlueBeetle\Press\Generic::get_instance()->get_taxonomy_news_type_terms()
	: array();
$industry_groups  = get_field( 'industries', iec_news_landing_get_page_id() ) ?: array();
$location_terms   = iec_news_landing_get_location_terms();
$filter_arrow     = '<svg width="9" height="14" viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M8.48171e-07 12.5432L1.37275 13.75L9 7L1.36504 0.249999L-1.2103e-07 1.45682L6.26992 7L8.48171e-07 12.5432Z" fill="#27284A"></path></svg>';
?>

	<main id="main" class="iec-news-landing-main news-landing-page">

		<?php if ( ! $slider_query->have_posts() ) : ?>
			<h1 class="screen-reader-text"><?= $featured_title ?: get_the_title(); ?></h1>
		<?php endif; ?>

		<?php if ( $slider_query->have_posts() ) : ?>
			<section class="ice_news_hero_banner ice_defualt_position">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<h1 style="text-transform: uppercase;">
								<span><?= $featured_title; ?></span>
							</h1>
						</div>
					</div>

					<div class="row ice_news_hero_desktop">
						<?php
						while ( $slider_query->have_posts() ) :
							$slider_query->the_post();
							get_template_part(
								'template-parts/news-landing/featured-card',
								null,
								array(
									'post_id' => get_the_ID(),
									'variant' => 'hero',
								)
							);
						endwhile;
						$slider_query->rewind_posts();
						?>
					</div>

					<div class="row iec_single_office_featured_news_swiper">
						<div class="col-md-12">
							<div class="swiper iec_featured_news_swiper">
								<div class="swiper-wrapper">
									<?php
									while ( $slider_query->have_posts() ) :
										$slider_query->the_post();
										?>
										<div class="swiper-slide">
											<?php
											get_template_part(
												'template-parts/news-landing/featured-card',
												null,
												array(
													'post_id' => get_the_ID(),
													'variant' => 'swiper',
												)
											);
											?>
										</div>
										<?php
									endwhile;
									wp_reset_postdata();
									?>
								</div>
								<div class="iec_swiper_arrow_warpper">
									<div class="swiper-button-prev iec_featured_news_swiper_prev">
										<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
											<path d="M7.88999 1.58002L6.70332 0.400024L0.109985 7.00002L6.70999 13.6L7.88999 12.42L2.46999 7.00002L7.88999 1.58002Z" fill="#727DA3"></path>
										</svg>
									</div>
									<div class="swiper-button-next iec_featured_news_swiper_next">
										<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
											<path d="M0.110015 12.42L1.29668 13.6L7.89002 6.99998L1.29002 0.399975L0.110015 1.57997L5.53002 6.99998L0.110015 12.42Z" fill="#727DA3"></path>
										</svg>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<section class="iec_main_news_posts_section">
			<div class="container">
				<div class="row">
					<div class="col-md-3">
						<div class="iec_news_posts_filters">
							<div class="iec_news_post_filter_box_warpper">
								<h2><?= __( 'Category', 'bbtheme' ); ?></h2>
								<div class="iec_news_post_filter_box">
									<a
										href="<?= $hub_url; ?>"
										class="iec_news_post_filter_item iec_news_post_main_filter_item<?= '' === $category ? ' iec_news_post_filter_item_active' : ''; ?>"
									>
										<?= __( 'All', 'bbtheme' ); ?>
										<?= $filter_arrow; ?>
									</a>
									<?php foreach ( $news_types as $term ) : ?>
										<?php
										if ( ! $term instanceof WP_Term ) {
											continue;
										}
										?>
										<a
											href="<?= iec_news_type_archive_url( $term ); ?>"
											data-category="<?= $term->slug; ?>"
											class="iec_news_post_filter_item<?= $category === $term->slug ? ' iec_news_post_filter_item_active' : ''; ?>"
										>
											<?= iec_news_landing_term_label( $term ); ?>
											<?= $filter_arrow; ?>
										</a>
									<?php endforeach; ?>
								</div>
							</div>

							<?php if ( ! empty( $industry_groups ) ) : ?>
								<div class="iec_news_post_filter_box_warpper">
									<h2><?= __( 'Industry', 'bbtheme' ); ?></h2>
									<div class="iec_news_post_filter_box">
										<?php foreach ( $industry_groups as $group ) : ?>
											<?php
											if ( ! is_array( $group ) ) {
												continue;
											}
											$group_title = $group['group_title'] ?? '';
											$items       = $group['industries'] ?? array();
											?>
											<div class="iec_news_post_filter_industry_box_wapper">
												<?php if ( '' !== $group_title ) : ?>
													<h3><?= $group_title; ?></h3>
												<?php endif; ?>
												<div class="iec_news_post_filter_industry_box">
													<?php foreach ( $items as $row ) : ?>
														<?php
														$term = $row['item'] ?? null;
														if ( ! $term instanceof WP_Term ) {
															continue;
														}
														$industry_url = add_query_arg(
															array_filter(
																array(
																	'category' => ( ! is_tax( 'news_type' ) && '' !== $category ) ? $category : null,
																	'industry' => $term->slug,
																)
															),
															$news_base_url
														);
														?>
														<a
															href="<?= $industry_url; ?>"
															data-industry="<?= $term->slug; ?>"
															class="iec_news_post_filter_sub__item<?= $current_industry === $term->slug ? ' iec_news_post_filter_item_active' : ''; ?>"
														>
															<?= $term->name; ?>
															<?= $filter_arrow; ?>
														</a>
													<?php endforeach; ?>
												</div>
											</div>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $location_terms ) ) : ?>
								<div class="iec_news_post_filter_box_warpper">
									<h2><?= __( 'Location', 'bbtheme' ); ?></h2>
									<div class="iec_news_post_filter_box">
										<?php foreach ( $location_terms as $term ) : ?>
											<?php
											if ( ! $term instanceof WP_Term ) {
												continue;
											}
											$location_url = add_query_arg(
												array_filter(
													array(
														'category' => ( ! is_tax( 'news_type' ) && '' !== $category ) ? $category : null,
														'location' => $term->slug,
													)
												),
												$news_base_url
											);
											?>
											<a
												href="<?= $location_url; ?>"
												data-location="<?= $term->slug; ?>"
												class="iec_news_post_filter_item<?= $current_location === $term->slug ? ' iec_news_post_filter_item_active' : ''; ?>"
											>
												<?= $term->name; ?>
												<?= $filter_arrow; ?>
											</a>
										<?php endforeach; ?>
									</div>
								</div>
							<?php endif; ?>
						</div>
					</div>
					<div class="col-md-9">
						<?php get_template_part( 'template-parts/news-landing/posts-list' ); ?>
					</div>
				</div>
			</div>
		</section>

	</main>

<?php
get_footer();
