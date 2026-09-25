<?php
/**
 * Starlink landing — directions slider (top).
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();

$areas = $fields['areas'] ?? array();

// Keep only rows that actually have content so empty/blank rows do not render.
$areas = array_filter(
	$areas,
	static function ( $area ) {
		return ! empty( $area['title'] ) || ! empty( $area['description'] ) || ! empty( $area['image'] ) || ! empty( $area['background'] );
	}
);

if ( empty( $areas ) ) {
	return;
}
?>
<section class="iec_defualt_position iec_starlink_directions_section">
	<div class="iec_starlink_directions_bg">
		<?php foreach ( $areas as $area ) { ?>
			<img src="<?= $area['background']; ?>" alt="<?= $area['area_title']; ?>">
		<?php } ?>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_starlink_directions_wrapper">
					<div class="iec_starlink_directions_container">
						<div class="iec_starlink_directions_main">
							<h2><?= $fields['area_title']; ?></h2>
						</div>
						<div class="swiper iec_starlink_swiper_direction_left">
							<div class="swiper-wrapper">
								<?php foreach ( $areas as $area ) { ?>
									<div class="swiper-slide">
										<div class="iec_starlink_direction_title">
											<?= $area['title']; ?>
										</div>
										<div class="iec_starlink_direction_desc">
											<?= $area['description']; ?>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="swiper iec_starlink_swiper_direction_right">
							<div class="swiper-wrapper">
								<?php foreach ( $areas as $area ) { ?>
									<div class="swiper-slide">
										<img src="<?= $area['image']; ?>" alt="<?= $area['title']; ?>">
									</div>
								<?php } ?>
							</div>
						</div>
						<div class="swiper-button-next iec_starlink_swiper_direction_next">
							<svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M0 0.5L15.2337 0.5L30.7269 15.522L15.3634 31.5L0 31.5L15.3634 16L0 0.5Z" fill="#727DA4" fill-opacity="0.5"/>
							</svg>
						</div>
						<div class="swiper-button-prev iec_starlink_swiper_direction_prev">
							<svg width="31" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M30.7269 31.5L15.4932 31.5L-2.50143e-06 16.478L15.3634 0.499999L30.7269 0.5L15.3634 16L30.7269 31.5Z" fill="#727DA4" fill-opacity="0.5"/>
							</svg>
						</div>
					</div>
					<div class="swiper-pagination iec_starlink_swiper_direction_pagination"></div>
				</div>
			</div>
		</div>
	</div>
</section>
