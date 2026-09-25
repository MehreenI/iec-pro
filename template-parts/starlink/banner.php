<?php
/**
 * Starlink landing — hero banner.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();

if ( empty( $fields['banner_title'] ) && empty( $fields['background_image'] ) && empty( $fields['top_block_image'] ) && empty( $fields['top_block_description'] ) ) {
	return;
}
?>
<section class="iec_banner iec_defualt_position">
	<img src="<?= $fields['background_image']; ?>" alt="" class="iec_banner_bg_image">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_banner_content_box mx-auto">
					<img class="iec_banner_image iec_img_style" src="<?= $fields['top_block_image']; ?>" alt="<?= $fields['banner_title']; ?>">
					<div class="iec_banner_text_warpper">
						<h1><?= $fields['banner_title']; ?></h1>
						<h2><?= $fields['top_block_description']; ?></h2>
					</div>
					<a href="#contact" class="iec_btn_transform banner-pop"><?php esc_attr_e( 'transform now', 'bbtheme' ); ?></a>
				</div>
			</div>
		</div>
	</div>
</section>
