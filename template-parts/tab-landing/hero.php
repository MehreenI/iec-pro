<?php
if ( ! defined( 'ABSPATH' ) || ! isset( $iec_tab_landing ) ) {
	return;
}

$hero   = $iec_tab_landing->field( 'hero', array() );
$slider = $hero['slider'] ?? array();

if ( ! $slider ) {
	return;
}

$office_title = get_the_title();
$prev_arrow   = '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M7.88999 1.58002L6.70332 0.400024L0.109985 7.00002L6.70999 13.6L7.88999 12.42L2.46999 7.00002L7.88999 1.58002Z" fill="#727DA3"/></svg>';
$next_arrow   = '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0.110015 12.42L1.29668 13.6L7.89002 6.99998L1.29002 0.399975L0.110015 1.57997L5.53002 6.99998L0.110015 12.42Z" fill="#727DA3"/></svg>';
?>

<!-- Hero. -->
<section class="iec_banner_section"<?php echo $office_title ? ' aria-label="' . esc_attr( $office_title ) . '"' : ''; ?>>
	<div class="iec_single_office_banner_swiper_warpper">
		<div class="swiper iec_single_office_swiper">
			<div class="swiper-wrapper">
				<?php
				$first = true;
				foreach ( $slider as $banner ) :
					if ( ! is_array( $banner ) ) {
						continue;
					}
					$desktop_image = $iec_tab_landing->image_url( $banner['banner'] ?? null );
					if ( ! $desktop_image ) {
						continue;
					}
					$mobile_image  = $iec_tab_landing->image_url( $banner['mobile_image'] ?? null, $desktop_image );
					$heading       = $banner['heading'] ?? '';
					$color         = ( 'font_blue' === ( $banner['heading_color'] ?? '' ) ) ? 'text_blue' : 'text_white';
					$link          = $banner['link'] ?? array();
					$link_url      = is_array( $link ) ? (string) ( $link['url'] ?? '' ) : '';
					$link_target   = is_array( $link ) ? (string) ( $link['target'] ?? '' ) : '';
					$content_img   = $iec_tab_landing->image_url( $banner['content_image'] ?? null );
					$logo_url      = $iec_tab_landing->image_url( $banner['logo'] ?? null );
					$title_image   = $iec_tab_landing->image_url( $banner['title_image'] ?? null );
					$is_first      = $first;
					$first         = false;
					$slide_title   = $heading ? $heading : ( $is_first ? $office_title : '' );
					$img_alt       = $heading ? wp_strip_all_tags( $heading ) : $office_title;
					?>
					<div class="swiper-slide"<?php echo $is_first ? '' : ' aria-hidden="true"'; ?>>
						<div
							class="iec_single_office_banner_box"
							style="--desktopImage: url('<?php echo esc_url( $desktop_image ); ?>'); --mobileImage: url('<?php echo esc_url( $mobile_image ); ?>');"
						>
							<div class="container">
								<div class="row align-items-center">
									<div class="col-md-7">
										<div class="banner_content <?php echo esc_attr( $color ); ?>">

											<?php if ( $link_url ) : ?>
												<a
													href="<?php echo esc_url( $link_url ); ?>"
													class="gray_btn desk_show button_font"
													<?php if ( $link_target && '_self' !== $link_target ) : ?>
														target="<?php echo esc_attr( $link_target ); ?>" rel="noopener noreferrer"
													<?php endif; ?>
												>
													<?php echo $link['title'] ?? __( 'Learn more', 'bbtheme' ); ?>
												</a>
											<?php endif; ?>

											<?php if ( $slide_title ) : ?>
												<?php if ( $is_first ) : ?>
													<h1 class="<?php echo esc_attr( $color ); ?>"><?php echo $heading ? $heading : $office_title; ?></h1>
												<?php else : ?>
													<p class="<?php echo esc_attr( $color ); ?> iec-main-heading"><?php echo $heading; ?></p>
												<?php endif; ?>
											<?php elseif ( $title_image ) : ?>
												<img src="<?php echo esc_url( $title_image ); ?>" class="iec_single_office_logo" alt="<?php echo esc_attr( $office_title ); ?>">
											<?php endif; ?>

											<?php if ( $logo_url ) : ?>
												<img src="<?php echo esc_url( $logo_url ); ?>" class="iec_single_office_logo" alt="<?php echo esc_attr( $img_alt ); ?>"<?php echo $is_first ? '' : ' loading="lazy" decoding="async"'; ?>>
											<?php endif; ?>

											<?php if ( ! empty( $banner['body'] ) ) : ?>
												<div class="sub_head <?php echo esc_attr( $color ); ?>"><?php echo $banner['body']; ?></div>
											<?php endif; ?>

											<?php if ( $content_img ) : ?>
												<img
													src="<?php echo esc_url( $content_img ); ?>"
													alt="<?php echo esc_attr( $img_alt ); ?>"
													width="300"
													height="200"
													<?php echo $is_first ? 'fetchpriority="high"' : 'loading="lazy"'; ?>
												>
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
				<button type="button" class="swiper-button-prev iec_single_office_swiper_prev" aria-label="<?php esc_attr_e( 'Previous slide', 'bbtheme' ); ?>">
					<?php echo $prev_arrow; ?>
				</button>
				<button type="button" class="swiper-button-next iec_single_office_swiper_next" aria-label="<?php esc_attr_e( 'Next slide', 'bbtheme' ); ?>">
					<?php echo $next_arrow; ?>
				</button>
			</div>
		</div>
	</div>
</section>
