<?php
/**
 * Featured news — desktop grid + mobile swiper.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading       = $args['heading'] ?? 'Featured News';
$query         = $args['query'] ?? null;
$spacing       = $args['spacing'] ?? '';
$heading_class = $args['heading_class'] ?? '';
$grid_class    = $args['grid_class'] ?? '';
$card_class    = $args['card_class'] ?? '';
$heading_attrs = $args['heading_attrs'] ?? '';
$card_attrs    = $args['card_attrs'] ?? '';

if ( ! $query instanceof WP_Query || ! $query->have_posts() ) {
	return;
}

$stagger_attrs = '';
if ( false !== strpos( $grid_class, 'iec-anim-stagger-group' ) ) {
	$stagger_attrs = ' data-iec-anim-target=".iec_news_post_box_warpper" data-iec-anim-preset="iec-anim-fade-up" data-iec-anim-stagger="0.12"';
}

$post_ids = array();
while ( $query->have_posts() ) {
	$query->the_post();
	$post_ids[] = get_the_ID();
}
wp_reset_postdata();

$news_image = static function ( $post_id ) {
	$image_id = 0;

	if ( function_exists( 'get_field' ) ) {
		$image = get_field( 'image', $post_id );

		if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
			$image_id = (int) $image['ID'];

		} elseif ( is_numeric( $image ) ) {
			$image_id = (int) $image;
		}
	}

	if ( $image_id < 1 ) {
		$image_id = (int) get_post_thumbnail_id( $post_id );
	}

	if ( $image_id < 1 ) {
		return '';
	}

	return wp_get_attachment_image(
		$image_id,
		'large',
		false,
		array(
			'alt'      => get_the_title( $post_id ),
			'loading'  => 'lazy',
			'decoding' => 'async',
		)
	);
};

$read_more_icon = '<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M10.9199 4.25C10.9476 4.25026 10.9754 4.25351 11.0029 4.25977L11.0859 4.28809C11.1129 4.30067 11.1388 4.317 11.1641 4.33594L11.2363 4.40234L11.2422 4.4082L15.0996 8.59766C15.1509 8.65335 15.1925 8.72327 15.2188 8.80273L15.2393 8.88574C15.2549 8.9712 15.2534 9.05881 15.2344 9.1416L15.209 9.22266V9.22363C15.1828 9.29274 15.1454 9.35319 15.1006 9.40234L11.2432 13.5918L11.2373 13.5977C11.2148 13.623 11.1903 13.6451 11.165 13.6641L11.0869 13.7119C11.0331 13.737 10.9765 13.7495 10.9209 13.75L10.8379 13.7422L10.7549 13.7148C10.7278 13.7028 10.7013 13.6874 10.6758 13.6689L10.6035 13.6045C10.5806 13.5796 10.5596 13.5518 10.541 13.5215L10.4922 13.4229C10.4657 13.3525 10.4525 13.2754 10.4531 13.1973C10.4535 13.1582 10.4576 13.1196 10.4648 13.082L10.4961 12.9736C10.5099 12.9387 10.5269 12.9059 10.5459 12.876L10.6094 12.7939L10.6152 12.7881L12.8262 10.3867L13.5986 9.54785H3.21387C3.13219 9.54775 3.04797 9.52136 2.97266 9.4668L2.90039 9.40234C2.80833 9.30236 2.75011 9.15866 2.75 9.00098C2.75 8.88264 2.78272 8.77172 2.83789 8.68164L2.90039 8.59863C2.99112 8.50013 3.10483 8.45326 3.21387 8.45312H13.5986L12.8262 7.61426L10.6143 5.21191L10.6084 5.20605L10.5449 5.12402L10.4951 5.02637C10.4814 4.99168 10.4711 4.95533 10.4639 4.91797L10.4521 4.80273C10.4518 4.76352 10.4552 4.7244 10.4619 4.68652L10.4912 4.57715C10.5045 4.5419 10.5214 4.50891 10.54 4.47852L10.6025 4.39551C10.6253 4.37085 10.6495 4.34938 10.6748 4.33105L10.7539 4.28516C10.7811 4.27308 10.809 4.2636 10.8369 4.25781L10.9199 4.25Z" fill="white" stroke="#727DA3"></path></svg>';
?>

<section class="iec_defualt_position bd_do_featured_news iec_starlink_portfolio_featured_news <?= esc_attr( $spacing ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="<?= esc_attr( $heading_class !== '' ? $heading_class : 'iec_main_heading text_blue' ); ?>" <?= $heading_attrs; ?>><?= $heading; ?></h2>
			</div>
		</div>

		<div class="row iec_single_office_featured_news_margin <?= esc_attr( $grid_class ); ?>"<?= $stagger_attrs; ?>>
			<?php foreach ( $post_ids as $card_i => $post_id ) :
				$category    = iec_featured_news_category_label( $post_id );
				$delay_attrs = $card_attrs !== '' ? $card_attrs . ' data-aos-delay="' . esc_attr( (string) ( $card_i * 100 ) ) . '"' : '';
				?>
				<div class="col-md-4 iec_news_post_box_warpper" <?= $delay_attrs; ?>>
					<a href="<?= esc_url( get_permalink( $post_id ) ); ?>" class="iec_news_post_box <?= esc_attr( $card_class ); ?>">
						<?php $news_img = $news_image( $post_id ); ?>
						<?php if ( $news_img ) : ?>
							<div class="iec_news_post_box_image">
								<?= $news_img; ?>
							</div>
						<?php endif; ?>
						<div class="iec_news_post_box_meta">
							<?php if ( $category ) : ?>
								<span class="category_pill"><?= $category; ?></span>
							<?php endif; ?>
							<span class="date text_gray"><?= get_the_date( 'd M Y', $post_id ); ?></span>
						</div>
						<h3 class="iec_news_post_title"><?= get_the_title( $post_id ); ?></h3>
						<div class="iec_news_post_read_more_link">
							<span><?= __( 'Read more', 'bbtheme' ); ?></span>
							<?= $read_more_icon; ?>
						</div>
					</a>
				</div>
			<?php endforeach; ?>
		</div>

		<div class="row iec_single_office_featured_news_swiper">
			<div class="col-md-12">
				<div class="swiper iec_featured_news_swiper">
					<div class="swiper-wrapper"></div>

					<div class="iec_swiper_arrow_warpper">
						<div class="swiper-button-prev iec_featured_news_swiper_prev" aria-label="<?= esc_attr__( 'Previous slide', 'bbtheme' ); ?>">
							<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path d="M7.88999 1.58002L6.70332 0.400024L0.109985 7.00002L6.70999 13.6L7.88999 12.42L2.46999 7.00002L7.88999 1.58002Z" fill="#727DA3"></path>
							</svg>
						</div>
						<div class="swiper-button-next iec_featured_news_swiper_next" aria-label="<?= esc_attr__( 'Next slide', 'bbtheme' ); ?>">
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
