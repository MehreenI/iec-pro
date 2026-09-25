<?php
/**
 * Featured news card.
 *
 * @package iec
 *
 * Args: post_id, variant (hero|swiper|default).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$post_id = (int) ( $args['post_id'] ?? get_the_ID() );
$variant = $args['variant'] ?? 'default';

if ( $post_id < 1 ) {
	return;
}

$permalink = get_permalink( $post_id );
if ( ! $permalink ) {
	return;
}

$image_url      = iec_featured_news_image_url( $post_id );
$category_label = iec_featured_news_category_label( $post_id );
$is_hero        = ( 'hero' === $variant );
$use_hero_body  = $is_hero || 'swiper' === $variant;
$wrapper_class  = $is_hero ? 'col-md-4 iec_news_post_box_warpper' : 'iec_news_post_box_warpper';
$content_class  = $use_hero_body ? 'iec_hero_news_post_content' : 'iec_news_post_box_content';
?>

<div class="<?= esc_attr( $wrapper_class ); ?>">
	<a href="<?= esc_url( $permalink ); ?>" class="iec_news_post_box">
		<?php if ( $image_url !== '' ) : ?>
			<div class="iec_news_post_box_image">
				<img
					class="banner"
					src="<?= esc_url( $image_url ); ?>"
					alt="<?= esc_attr( get_the_title( $post_id ) ); ?>"
					loading="lazy"
					decoding="async"
				>
			</div>
		<?php endif; ?>
		<div class="<?= esc_attr( $content_class ); ?>">
			<div class="iec_news_post_box_meta">
				<?php if ( $category_label !== '' ) : ?>
					<span class="category_pill"><?= $category_label; ?></span>
				<?php endif; ?>
				<span class="date text_gray"><?= get_the_date( 'd M Y', $post_id ); ?></span>
			</div>
			<h3 class="iec_news_post_title"><?= get_the_title( $post_id ); ?></h3>
			<div class="iec_news_post_read_more_link">
				<span><?= __( 'Read more', 'bbtheme' ); ?></span>
				<svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path d="M10.9199 4.25C10.9476 4.25026 10.9754 4.25351 11.0029 4.25977L11.0859 4.28809C11.1129 4.30067 11.1388 4.317 11.1641 4.33594L11.2363 4.40234L11.2422 4.4082L15.0996 8.59766C15.1509 8.65335 15.1925 8.72327 15.2188 8.80273L15.2393 8.88574C15.2549 8.9712 15.2534 9.05881 15.2344 9.1416L15.209 9.22266V9.22363C15.1828 9.29274 15.1454 9.35319 15.1006 9.40234L11.2432 13.5918L11.2373 13.5977C11.2148 13.623 11.1903 13.6451 11.165 13.6641L11.0869 13.7119C11.0331 13.737 10.9765 13.7495 10.9209 13.75L10.8379 13.7422L10.7549 13.7148C10.7278 13.7028 10.7013 13.6874 10.6758 13.6689L10.6035 13.6045C10.5806 13.5796 10.5596 13.5518 10.541 13.5215L10.4922 13.4229C10.4657 13.3525 10.4525 13.2754 10.4531 13.1973C10.4535 13.1582 10.4576 13.1196 10.4648 13.082L10.4961 12.9736C10.5099 12.9387 10.5269 12.9059 10.5459 12.876L10.6094 12.7939L10.6152 12.7881L12.8262 10.3867L13.5986 9.54785H3.21387C3.13219 9.54775 3.04797 9.52136 2.97266 9.4668L2.90039 9.40234C2.80833 9.30236 2.75011 9.15866 2.75 9.00098C2.75 8.88264 2.78272 8.77172 2.83789 8.68164L2.90039 8.59863C2.99112 8.50013 3.10483 8.45326 3.21387 8.45312H13.5986L12.8262 7.61426L10.6143 5.21191L10.6084 5.20605L10.5449 5.12402L10.4951 5.02637C10.4814 4.99168 10.4711 4.95533 10.4639 4.91797L10.4521 4.80273C10.4518 4.76352 10.4552 4.7244 10.4619 4.68652L10.4912 4.57715C10.5045 4.5419 10.5214 4.50891 10.54 4.47852L10.6025 4.39551C10.6253 4.37085 10.6495 4.34938 10.6748 4.33105L10.7539 4.28516C10.7811 4.27308 10.809 4.2636 10.8369 4.25781L10.9199 4.25Z" fill="white" stroke="#727DA3"/>
				</svg>
			</div>
		</div>
	</a>
</div>
