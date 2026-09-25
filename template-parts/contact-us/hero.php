<?php
/**
 * Contact Us — hero banner.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$hero         = $args['hero'] ?? array();
$bg_image     = $hero['background_image']['url'] ?? '';
$bg_image_id  = ! empty( $hero['background_image']['ID'] ) ? (int) $hero['background_image']['ID'] : 0;

if ( ! $bg_image && ! $bg_image_id ) {
	return;
}

if ( $bg_image_id && ! $bg_image ) {
	$bg_image = wp_get_attachment_image_url( $bg_image_id, 'full' );
}

if ( ! $bg_image ) {
	return;
}
?>

<section
	class="iec_hero_banner iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center iec-contact-us-hero"
	style="--bgImage: url('<?= esc_url( $bg_image ); ?>');"
	aria-label="<?php esc_attr_e( 'Contact us', 'bbtheme' ); ?>"
>
	<div class="container">
		<div class="row">
			<div class="col-md-12"></div>
		</div>
	</div>
</section>
