<?php
/**
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields    = $args['fields'] ?? array();
$video_raw = $fields['video'] ?? '';
$embed_url = is_string( $video_raw ) ? iec_video_embed_url( $video_raw ) : '';

if ( '' === $embed_url ) {
	return;
}

$frame_1     = get_template_directory_uri() . '/assets/img/frame-1.png';
$frame_2     = get_template_directory_uri() . '/assets/img/frame-2.png';
$video_title = __( 'OptiView product video', 'bbtheme' );
?>
<section class="iec_optiview_video_section" style="--bgFrame1: url('<?= $frame_1; ?>'); --bgFrame2: url('<?= $frame_2; ?>');" aria-labelledby="iec-optiview-video-title">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 id="iec-optiview-video-title" class="sr-only"><?= $video_title; ?></h2>
				<div class="iec_optiview_video_box">
					<iframe
						width="900"
						height="506"
						src="<?= $embed_url; ?>"
						title="<?= $video_title; ?>"
						frameborder="0"
						allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
						referrerpolicy="strict-origin-when-cross-origin"
						allowfullscreen
						loading="lazy"
					></iframe>
				</div>
			</div>
		</div>
	</div>
</section>
