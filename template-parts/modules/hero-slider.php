<?php
/**
 * Hero banner slider (home page).
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero = $args['hero'] ?? array();

if ( empty( $hero['hero_slider'] ) || ! is_array( $hero['hero_slider'] ) ) {
	return;
}
?>

<section class="iec_banner_section iec_home_page_banner_section" aria-label="<?php esc_attr_e( 'Main Hero Banner', 'bbtheme' ); ?>">
	<div class="iec_single_office_banner_swiper_warpper">
		<div class="swiper iec_single_office_swiper">
			<div class="swiper-wrapper">
				<?php foreach ( $hero['hero_slider'] as $index => $banner ) : ?>
					<?php
					$desktop_image = $banner['banner_image_desktop']['url'] ?? '';
					$mobile_image  = ! empty( $banner['mobile_image']['url'] ) ? $banner['mobile_image']['url'] : $desktop_image;
					$color         = ( 'font_blue' === ( $banner['heading_color'] ?? '' ) ) ? 'text_blue' : 'text_white';
					$is_first      = ( 0 === $index );
					$img_attrs     = array( 'alt' => '' );

					if ( $is_first ) {
						$img_attrs['fetchpriority'] = 'high';
						$img_attrs['loading']       = 'eager';
					} else {
						$img_attrs['loading'] = 'lazy';
					}
					?>
					<div class="swiper-slide">
						<div
							class="iec_single_office_banner_box"
							style="--desktopImage: url('<?php echo esc_url( $desktop_image ); ?>'); --mobileImage: url('<?php echo esc_url( $mobile_image ); ?>');"
							role="img"
							aria-label="<?php echo esc_attr( $banner['heading'] ?? '' ); ?>"
						>
							<div class="container">
								<div class="row">
									<div class="col-md-7">
										<div class="banner_content <?php echo esc_attr( $color ); ?>">
											<?php if ( ! empty( $banner['button_link']['url'] ) ) : ?>
												<a
													href="<?php echo esc_url( $banner['button_link']['url'] ); ?>"
													class="btn secondary-btn desk_show button_font"
													aria-label="<?php echo esc_attr( sprintf( 'Learn more about %s', $banner['heading'] ?? '' ) ); ?>"
												>
													<?php echo ( $banner['button_link']['title'] ?? '' ); ?>
												</a>
											<?php endif; ?>

											<h1 class="<?php echo esc_attr( $color ); ?>">
												<?php echo ( $banner['heading'] ?? '' ); ?>
											</h1>

											<?php if ( ! empty( $banner['body'] ) ) : ?>
												<div class="sub_head <?php echo esc_attr( $color ); ?>">
													<?php echo wp_kses_post( $banner['body'] ); ?>
												</div>
											<?php endif; ?>

											<?php if ( ! empty( $banner['content_overlay_image']['ID'] ) ) : ?>
												<?php echo wp_get_attachment_image( (int) $banner['content_overlay_image']['ID'], 'large', false, $img_attrs ); ?>
											<?php endif; ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
			<div class="swiper-pagination"></div>
			<div class="iec_swiper_arrow_warpper">
				<div class="swiper-button-prev iec_single_office_swiper_prev" aria-label="<?php esc_attr_e( 'Previous slide', 'bbtheme' ); ?>">
					<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M7.88999 1.58002L6.70332 0.400024L0.109985 7.00002L6.70999 13.6L7.88999 12.42L2.46999 7.00002L7.88999 1.58002Z" fill="#727DA3"></path>
					</svg>
				</div>
				<div class="swiper-button-next iec_single_office_swiper_next" aria-label="<?php esc_attr_e( 'Next slide', 'bbtheme' ); ?>">
					<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M0.110015 12.42L1.29668 13.6L7.89002 6.99998L1.29002 0.399975L0.110015 1.57997L5.53002 6.99998L0.110015 12.42Z" fill="#727DA3"></path>
					</svg>
				</div>
			</div>
		</div>
	</div>
</section>
