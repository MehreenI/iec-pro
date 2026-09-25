<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero = $args['hero'] ?? array();
if ( ! is_array( $hero ) ) {
	$hero = array();
}

$office_title = get_the_title();
$prev_arrow   = '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M7.88999 1.58002L6.70332 0.400024L0.109985 7.00002L6.70999 13.6L7.88999 12.42L2.46999 7.00002L7.88999 1.58002Z" fill="#727DA3"></path></svg>';
$next_arrow   = '<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M0.110015 12.42L1.29668 13.6L7.89002 6.99998L1.29002 0.399975L0.110015 1.57997L5.53002 6.99998L0.110015 12.42Z" fill="#727DA3"></path></svg>';

$use_new_hero = function_exists( 'iec_office_hero_is_new_design' ) && iec_office_hero_is_new_design( $hero );

if ( $use_new_hero ) :
	$bg_slides = function_exists( 'iec_office_new_hero_bg_slides' ) ? iec_office_new_hero_bg_slides( $hero ) : array();
	if ( ! $bg_slides ) {
		return;
	}
	$color         = ( 'font_blue' === ( $hero['heading_color'] ?? '' ) ) ? 'text_blue' : 'text_white';
	$heading       = $hero['heading'] ?? '';
	$h1            = $heading ? $heading : $office_title;
	$body          = $hero['body'] ?? '';
	$link          = $hero['link'] ?? array();
	$hero_link_url = function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( $link ) : (string) ( $link['url'] ?? '' );
	$link_target   = is_array( $link ) ? (string) ( $link['target'] ?? '' ) : '';
	?>

	<!-- Hero. -->
	<section class="iec_banner_section iec_new_office_banner"<?php echo $h1 ? ' aria-label="' . esc_attr( wp_strip_all_tags( $h1 ) ) . '"' : ''; ?>>
		<div class="iec_single_office_banner_swiper_warpper">
			<div class="swiper iec_single_office_swiper">
				<div class="swiper-wrapper">
					<?php foreach ( $bg_slides as $index => $bg ) : ?>
						<div class="swiper-slide"<?php echo $index > 0 ? ' aria-hidden="true"' : ''; ?>>
							<div
								class="iec_single_office_banner_box"
								style="--desktopImage: url('<?php echo esc_url( $bg['desktop'] ); ?>'); --mobileImage: url('<?php echo esc_url( $bg['mobile'] ); ?>');"
								aria-hidden="true"
							></div>
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
			<div class="iec_office_hero_content_layer">
				<div class="iec_single_office_banner_box iec_single_office_banner_box--content-only">
					<div class="container">
						<div class="row">
							<div class="col-md-7">
								<div class="banner_content <?php echo esc_attr( $color ); ?>">

									<?php if ( $h1 ) : ?>
										<h1 class="<?php echo esc_attr( $color ); ?>"><?php echo $heading ? $heading : $office_title; ?></h1>
									<?php endif; ?>

									<?php if ( $body ) : ?>
										<div class="sub_head <?php echo esc_attr( $color ); ?>"><?php echo $body; ?></div>
									<?php endif; ?>

									<?php if ( $hero_link_url ) : ?>
										<a
											href="<?php echo esc_url( $hero_link_url ); ?>"
											class="gray_btn desk_show button_font"
											<?php if ( $link_target && '_self' !== $link_target ) : ?>
												target="<?php echo esc_attr( $link_target ); ?>" rel="noopener noreferrer"
											<?php endif; ?>
										>
											<?php echo $link['title'] ?? ''; ?>
										</a>
									<?php endif; ?>

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<?php
	return;
endif;

$slides = $hero['slider'] ?? array();
if ( ! $slides ) {
	return;
}
?>

<!-- Hero. -->
<section class="iec_banner_section"<?php echo $office_title ? ' aria-label="' . esc_attr( $office_title ) . '"' : ''; ?>>
	<div class="iec_single_office_banner_swiper_warpper">
		<div class="swiper iec_single_office_swiper">
			<div class="swiper-wrapper">
				<?php
				$first = true;
				foreach ( $slides as $banner ) :
					if ( ! is_array( $banner ) ) {
						continue;
					}
					$desktop_image = iec_resolve_media_to_url( $banner['banner'] ?? null );
					if ( ! $desktop_image ) {
						continue;
					}
					$mobile_image = iec_resolve_media_to_url( $banner['mobile_image'] ?? null );
					if ( ! $mobile_image ) {
						$mobile_image = $desktop_image;
					}
					$color         = ( 'font_blue' === ( $banner['heading_color'] ?? '' ) ) ? 'text_blue' : 'text_white';
					$heading       = $banner['heading'] ?? '';
					$is_first      = $first;
					$first         = false;
					$link          = $banner['link'] ?? array();
					$hero_link_url = function_exists( 'iec_resolve_wpml_url' )
						? iec_resolve_wpml_url( $link )
						: ( is_array( $link ) ? (string) ( $link['url'] ?? '' ) : '' );
					$link_target = is_array( $link ) ? (string) ( $link['target'] ?? '' ) : '';
					$slide_title = $heading ? $heading : ( $is_first ? $office_title : '' );
					$img_alt     = $heading ? wp_strip_all_tags( $heading ) : $office_title;
					$img_attrs   = array( 'alt' => $img_alt );
					if ( $is_first ) {
						$img_attrs['fetchpriority'] = 'high';
					} else {
						$img_attrs['loading'] = 'lazy';
					}
					?>
					<div class="swiper-slide"<?php echo $is_first ? '' : ' aria-hidden="true"'; ?>>
						<div
							class="iec_single_office_banner_box"
							style="--desktopImage: url('<?php echo esc_url( $desktop_image ); ?>'); --mobileImage: url('<?php echo esc_url( $mobile_image ); ?>');"
						>
							<div class="container">
								<div class="row">
									<div class="col-md-7">
										<div class="banner_content <?php echo esc_attr( $color ); ?>">

											<?php if ( $hero_link_url ) : ?>
												<a
													href="<?php echo esc_url( $hero_link_url ); ?>"
													class="gray_btn desk_show button_font"
													<?php if ( $link_target && '_self' !== $link_target ) : ?>
														target="<?php echo esc_attr( $link_target ); ?>" rel="noopener noreferrer"
													<?php endif; ?>
												>
													<?php echo $link['title'] ?? ''; ?>
												</a>
											<?php endif; ?>

											<?php if ( $slide_title ) : ?>
												<?php if ( $is_first ) : ?>
													<h1 class="<?php echo esc_attr( $color ); ?>"><?php echo $heading ? $heading : $office_title; ?></h1>
												<?php else : ?>
													<p class="<?php echo esc_attr( $color ); ?> iec-main-heading"><?php echo $heading; ?></p>
												<?php endif; ?>
											<?php endif; ?>

											<?php if ( ! empty( $banner['body'] ) ) : ?>
												<div class="sub_head <?php echo esc_attr( $color ); ?>"><?php echo $banner['body']; ?></div>
											<?php endif; ?>

											<?php if ( ! empty( $banner['content_image']['ID'] ) ) : ?>
												<?php echo wp_get_attachment_image( (int) $banner['content_image']['ID'], 'medium_large', false, $img_attrs ); ?>
											<?php elseif ( ! empty( $banner['content_image']['url'] ) ) : ?>
												<img src="<?php echo esc_url( $banner['content_image']['url'] ); ?>" <?php echo $is_first ? 'fetchpriority="high"' : 'loading="lazy"'; ?> alt="<?php echo esc_attr( $img_alt ); ?>">
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
