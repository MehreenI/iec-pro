<?php
/**
 * Market detail — hero banner.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$banner         = $args['banner'] ?? array();
$banner_image   = $banner['image'] ?? array();
$banner_img_url = $banner_image['url'] ?? '';
$overlay_title  = $banner['overlay_title'] ?? '';

if ( ! $overlay_title && $banner_img_url === '' ) {
	return;
}

$style = 'background-color: #4a5568;';
if ( $banner_img_url !== '' ) {
	$style .= ' --bgImage: url(\'' . esc_url( $banner_img_url ) . '\');';
}
?>

<section class="iec_hero_banner iec_hero_content_banner iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center" style="<?= esc_attr( $style ); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( $overlay_title ) : ?>
					<div class="iec_hero_content_box">
						<h1 class="iec_main_heading"><?= $overlay_title; ?></h1>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
