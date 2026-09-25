<?php
/**
 * Single product — hero slider + title / CTAs.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();
$filter = $args['filter'] ?? array();

$hero       = $fields['hero_section'] ?? array();
$hero_left  = $hero['left_side'] ?? array();
$hero_right = $hero['product_images'] ?? array();
$slides     = $hero_right['products'] ?? array();

?>
<section class="iec_single_product_hero_section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="iec_single_product_hero_swiper_wrapper">
					<div class="iec_single_product_hero_swiper_main_wrapper">
						<div class="iec_single_product_hero_slide_content">
							<?php if ( ! empty( $filter ) ) : ?>
								<ul class="iec_single_product_slide_pills iec-anim-stagger" data-iec-anim-on-load="true" data-iec-anim-stagger="0.1">
									<?php if ( in_array( 'land', $filter, true ) ) : ?>
										<li style="--bg: #DDC9A3;"><?= __( 'Land', 'bbtheme' ); ?></li>
									<?php endif; ?>

									<?php if ( in_array( 'maritime', $filter, true ) ) : ?>
										<li style="--bg: #92C0E9;"><?= __( 'Maritime', 'bbtheme' ); ?></li>
									<?php endif; ?>
								</ul>
							<?php endif; ?>

							<h1 class="iec_single_product_product_name iec-anim-split-words" data-iec-anim-on-load="true"><?= $hero_left['heading'] ?? get_the_title(); ?></h1>

							<ul class="iec_single_product_slide_buttons iec-anim-stagger" data-iec-anim-on-load="true" data-iec-anim-stagger="0.12">
								<li>
									<a href="#contact" class="download at_btn iec_blue_gradient">
										<?= $hero_left['button_label'] ?? ''; ?>
									</a>
								</li>
								<?php if ( ! empty( $hero_left['attachment']['url'] ) ) : ?>
									<li>
										<a href="<?= esc_url( $hero_left['attachment']['url'] ); ?>" download class="download at_btn iec_blue_gradient" target="_blank" rel="noopener noreferrer">
											<?= $hero_left['download_button'] ?? ''; ?>
											<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
												<path d="M4 16V17C4 17.7956 4.31607 18.5587 4.87868 19.1213C5.44129 19.6839 6.20435 20 7 20H17C17.7956 20 18.5587 19.6839 19.1213 19.1213C19.6839 18.5587 20 17.7956 20 17V16M16 12L12 16M12 16L8 12M12 16V4" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
											</svg>
										</a>
									</li>
								<?php endif; ?>
							</ul>
						</div>

						<div class="swiper iec_single_porduct_swiper_main_hero">
							<div class="swiper-wrapper">
								<?php
								foreach ( $slides as $index => $product ) :
									$url = iec_resolve_media_to_url( $product );
									if ( $url === '' ) {
										continue;
									}
									$is_lcp = ( 0 === (int) $index );
									?>
									<div class="swiper-slide">
										<div class="iec_single_porduct_hero_slide_wrapper">
											<div class="iec_single_porduct_hero_slide_image_wrapper easyzoom easyzoom--overlay">
												<a href="<?= esc_url( $url ); ?>">
													<img
														src="<?= esc_url( $url ); ?>"
														class="at_hero_slide_image"
														alt="<?= esc_attr( $hero_left['heading'] ?? '' ); ?>"
														<?= $is_lcp ? 'fetchpriority="high" loading="eager"' : 'loading="lazy"'; ?>
													/>
												</a>
											</div>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="iec_single_porduct_swiper_thumb_wrapper">
						<div class="swiper iec_single_porduct_swiper_thumb_hero">
							<div class="swiper-wrapper">
								<?php
								foreach ( $slides as $index => $product ) :
									$url = iec_resolve_media_to_url( $product );
									if ( $url === '' ) {
										continue;
									}
									?>
									<div class="swiper-slide">
										<img src="<?= esc_url( $url ); ?>" alt="<?= esc_attr( $hero_left['heading'] ?? '' ); ?>" <?= 0 === (int) $index ? '' : 'loading="lazy"'; ?> />
									</div>
								<?php endforeach; ?>
							</div>
						</div>
						<div class="hero-swiper-button-prev" aria-label="<?php esc_attr_e( 'Previous slide', 'bbtheme' ); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none" aria-hidden="true">
								<path d="M0 30.7269L1.8166e-07 15.4932L15.022 -3.63556e-06L31 15.3634L31 30.7269L15.5 15.3634L0 30.7269Z" fill="#727DA4"/>
							</svg>
						</div>
						<div class="hero-swiper-button-next" aria-label="<?php esc_attr_e( 'Next slide', 'bbtheme' ); ?>">
							<svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none" aria-hidden="true">
								<path d="M31 0L31 15.2337L15.978 30.7269L-6.71557e-07 15.3634L0 -1.35505e-06L15.5 15.3634L31 0Z" fill="#727DA4"/>
							</svg>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
