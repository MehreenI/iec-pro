<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$query = null;

if ( ! empty( $args['query'] ) && $args['query'] instanceof WP_Query ) {
	$query = $args['query'];
} elseif ( isset( $slider_query ) && $slider_query instanceof WP_Query ) {
	$query = $slider_query;
}

if ( ! $query || ! $query->have_posts() ) {
	return;
}

$query->rewind_posts();
?>

<div class="row iec_single_office_featured_news_margin">
	<?php
	while ( $query->have_posts() ) :
		$query->the_post();
		iec_module(
			'featured-news-card',
			array(
				'post_id' => get_the_ID(),
				'variant' => 'hero',
			)
		);
	endwhile;
	wp_reset_postdata();
	?>
</div>

<?php $query->rewind_posts(); ?>

<div class="row iec_single_office_featured_news_swiper">
	<div class="col-md-12">
		<div class="swiper iec_featured_news_swiper">
			<div class="swiper-wrapper">
				<?php
				while ( $query->have_posts() ) :
					$query->the_post();
					?>
					<div class="swiper-slide">
						<?php
						iec_module(
							'featured-news-card',
							array(
								'post_id' => get_the_ID(),
								'variant' => 'swiper',
							)
						);
						?>
					</div>
				<?php endwhile; ?>
			</div>
			<div class="iec_swiper_arrow_warpper">
				<button type="button" class="swiper-button-prev iec_featured_news_swiper_prev" aria-label="<?php esc_attr_e( 'Previous slide', 'bbtheme' ); ?>">
					<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M7.88999 1.58002L6.70332 0.400024L0.109985 7.00002L6.70999 13.6L7.88999 12.42L2.46999 7.00002L7.88999 1.58002Z" fill="#727DA3"></path>
					</svg>
				</button>
				<button type="button" class="swiper-button-next iec_featured_news_swiper_next" aria-label="<?php esc_attr_e( 'Next slide', 'bbtheme' ); ?>">
					<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M0.110015 12.42L1.29668 13.6L7.89002 6.99998L1.29002 0.399975L0.110015 1.57997L5.53002 6.99998L0.110015 12.42Z" fill="#727DA3"></path>
					</svg>
				</button>
			</div>
		</div>
	</div>
</div>

<?php
wp_reset_postdata();
