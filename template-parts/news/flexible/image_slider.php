<?php
/**
 * Flexible: image gallery slider.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block      = $args['block'] ?? array();
$gallery    = $block['image_gallery'] ?? array();
$slider_id  = 'iec_single_news_detail_swiper_' . wp_unique_id();
$min_slides = 6;

if ( empty( $gallery ) ) {
	return;
}

$slider_gallery = $gallery;
while ( count( $slider_gallery ) < $min_slides ) {
	$slider_gallery = array_merge( $slider_gallery, $gallery );
}
$slider_gallery = array_slice( $slider_gallery, 0, max( $min_slides, count( $gallery ) ) );
?>

<section class="iec_single_news_main_section iec_single_news_slider_section iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_single_news_slider_warpper">
					<div class="swiper <?= esc_attr( $slider_id ); ?>">
						<div class="swiper-wrapper">
							<?php foreach ( $slider_gallery as $slide_image ) :
								$slide_url  = '';
								$slide_text = is_array( $slide_image ) ? ( $slide_image['title'] ?? '' ) : '';
								if ( is_array( $slide_image ) && ! empty( $slide_image['url'] ) ) {
									$slide_url = $slide_image['url'];
								} elseif ( is_string( $slide_image ) ) {
									$slide_url = $slide_image;
								}

								if ( ! $slide_url ) {
									continue;
								}
								$slide_alt = is_array( $slide_image ) ? ( $slide_image['alt'] ?? $slide_text ) : $slide_text;
								?>
								<div class="swiper-slide">
									<div class="iec_single_news_slider_box">
										<img src="<?= esc_url( $slide_url ); ?>" class="iec_single_news_slider_image iec_img_style" alt="<?= esc_attr( $slide_alt ); ?>">
										<?php if ( $slide_text ) : ?>
											<div class="iec_single_news_slider_image_text_box">
												<h3><?= $slide_text; ?></h3>
											</div>
										<?php endif; ?>
									</div>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="swiper-pagination iec_single_news_pagination"></div>
					<div class="swiper-button-prev iec_single_news_prev" aria-label="<?= esc_attr__( 'Previous slide', 'bbtheme' ); ?>">
						<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M30.7269 31L15.4932 31L1.31327e-06 15.978L15.3634 -1.34311e-06L30.7269 0L15.3634 15.5L30.7269 31Z" fill="#727DA4" fill-opacity="0.5"/>
						</svg>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="bd_stlp_mobile_icon" aria-hidden="true">
							<path d="M11.8899 2.5799L10.7032 1.3999L4.10986 7.9999L10.7099 14.5999L11.8899 13.4199L6.46986 7.9999L11.8899 2.5799Z" fill="#1B204C"></path>
						</svg>
					</div>
					<div class="swiper-button-next iec_single_news_next" aria-label="<?= esc_attr__( 'Next slide', 'bbtheme' ); ?>">
						<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M0 0L15.2337 0L30.7269 15.022L15.3634 31L0 31L15.3634 15.5L0 0Z" fill="#727DA4" fill-opacity="0.5"/>
						</svg>
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="bd_stlp_mobile_icon" aria-hidden="true">
							<path d="M4.11014 13.4201L5.2968 14.6001L11.8901 8.0001L5.29014 1.4001L4.11014 2.5801L9.53014 8.0001L4.11014 13.4201Z" fill="#1B204C"></path>
						</svg>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
