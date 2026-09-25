<?php
/**
 * Single product — maritime / land market carousels.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$filter = $args['filter'] ?? array();
?>
<section id="markets" class="iec_single_product_section_markets">
	<?php if ( in_array( 'maritime', $filter, true ) ) :
		$market = function_exists( 'get_field' ) ? get_field( 'market-maritime', 'option' ) : array();
		$market = is_array( $market ) ? $market : array();
		$items  = $market['market-maritime'] ?? array();
		?>
		<div class="iec_single_product_market_wrapper">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php if ( ! empty( $market['heading'] ) ) : ?>
							<h2 class="iec_single_product_section_title"><?= $market['heading']; ?></h2>
						<?php endif; ?>
						<div class="iec_single_product_portfolio_swiper_wrapper">
							<div class="swiper market_swiper_0">
								<div class="swiper-wrapper">
									<?php foreach ( $items as $item ) :
										if ( ! is_array( $item ) ) {
											continue;
										}
										$img_url = $item['maritime_image']['url'] ?? '';
										$href    = function_exists( 'iec_resolve_wpml_url' )
											? (string) iec_resolve_wpml_url( $item['link'] ?? '' )
											: ( is_array( $item['link'] ?? null ) ? ( $item['link']['url'] ?? '' ) : '' );
										$tag     = $href ? 'a' : 'div';
										$href_attr = $href ? ' href="' . esc_url( $href ) . '"' : '';
										?>
										<div class="swiper-slide">
											<<?= $tag; ?><?= $href_attr; ?> class="iec_single_product_portfolio_swiper_content_wrapper">
												<?php if ( $img_url !== '' ) : ?>
													<img src="<?= esc_url( $img_url ); ?>" class="at_market_swiper_content_image" alt="<?= esc_attr( $item['text'] ?? '' ); ?>" loading="lazy" />
												<?php endif; ?>
												<div class="iec_single_product_portfolio_swiper_label">
													<span><?= $item['text'] ?? ''; ?></span>
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" aria-hidden="true"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
												</div>
											</<?= $tag; ?>>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="swiper-button-next swiper-button-next-0">
								<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<path d="M0 0L15.2337 0L30.7269 15.022L15.3634 31L0 31L15.3634 15.5L0 0Z" fill="#727DA4"/>
								</svg>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="iec_starlink_portfolio_mobile_icon" aria-hidden="true">
									<path d="M4.11014 13.4201L5.2968 14.6001L11.8901 8.0001L5.29014 1.4001L4.11014 2.5801L9.53014 8.0001L4.11014 13.4201Z" fill="#727DA3"></path>
								</svg>
							</div>
							<div class="swiper-button-prev swiper-button-prev-0">
								<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<path d="M30.7269 31L15.4932 31L-2.50143e-06 15.978L15.3634 -1.34311e-06L30.7269 0L15.3634 15.5L30.7269 31Z" fill="#727DA4"/>
								</svg>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="iec_starlink_portfolio_mobile_icon" aria-hidden="true">
									<path d="M11.8899 2.5799L10.7032 1.3999L4.10986 7.9999L10.7099 14.5999L11.8899 13.4199L6.46986 7.9999L11.8899 2.5799Z" fill="#727DA3"></path>
								</svg>
							</div>
							<div class="swiper-pagination swiper-pagination-0"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( in_array( 'land', $filter, true ) ) :
		$land  = function_exists( 'get_field' ) ? get_field( 'market-land', 'option' ) : array();
		$land  = is_array( $land ) ? $land : array();
		$items = $land['market-land'] ?? array();
		?>
		<div class="iec_single_product_market_wrapper">
			<div class="container">
				<div class="row">
					<div class="col-12">
						<?php if ( ! empty( $land['heading'] ) ) : ?>
							<h2 class="iec_single_product_section_title"><?= $land['heading']; ?></h2>
						<?php endif; ?>
						<div class="iec_single_product_portfolio_swiper_wrapper">
							<div class="swiper market_swiper_1">
								<div class="swiper-wrapper">
									<?php foreach ( $items as $item ) :
										if ( ! is_array( $item ) ) {
											continue;
										}
										$img_url = $item['market_land']['url'] ?? '';
										$href    = function_exists( 'iec_resolve_wpml_url' )
											? (string) iec_resolve_wpml_url( $item['link'] ?? '' )
											: ( is_array( $item['link'] ?? null ) ? ( $item['link']['url'] ?? '' ) : '' );
										$tag     = $href ? 'a' : 'div';
										$href_attr = $href ? ' href="' . esc_url( $href ) . '"' : '';
										?>
										<div class="swiper-slide">
											<<?= $tag; ?><?= $href_attr; ?> class="iec_single_product_portfolio_swiper_content_wrapper">
												<?php if ( $img_url !== '' ) : ?>
													<img src="<?= esc_url( $img_url ); ?>" class="at_market_swiper_content_image" alt="<?= esc_attr( $item['market_title'] ?? '' ); ?>" loading="lazy" />
												<?php endif; ?>
												<div class="iec_single_product_portfolio_swiper_label">
													<span><?= $item['market_title'] ?? ''; ?></span>
													<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" aria-hidden="true"><path d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z"/></svg>
												</div>
											</<?= $tag; ?>>
										</div>
									<?php endforeach; ?>
								</div>
							</div>
							<div class="swiper-button-next swiper-button-next-1">
								<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<path d="M0 0L15.2337 0L30.7269 15.022L15.3634 31L0 31L15.3634 15.5L0 0Z" fill="#727DA4"/>
								</svg>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="iec_starlink_portfolio_mobile_icon" aria-hidden="true">
									<path d="M4.11014 13.4201L5.2968 14.6001L11.8901 8.0001L5.29014 1.4001L4.11014 2.5801L9.53014 8.0001L4.11014 13.4201Z" fill="#727DA3"></path>
								</svg>
							</div>
							<div class="swiper-button-prev swiper-button-prev-1">
								<svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
									<path d="M30.7269 31L15.4932 31L-2.50143e-06 15.978L15.3634 -1.34311e-06L30.7269 0L15.3634 15.5L30.7269 31Z" fill="#727DA4"/>
								</svg>
								<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none" class="iec_starlink_portfolio_mobile_icon" aria-hidden="true">
									<path d="M11.8899 2.5799L10.7032 1.3999L4.10986 7.9999L10.7099 14.5999L11.8899 13.4199L6.46986 7.9999L11.8899 2.5799Z" fill="#727DA3"></path>
								</svg>
							</div>
							<div class="swiper-pagination swiper-pagination-1"></div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>
