<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading   = get_sub_field( 'heading' ) ?: get_sub_field( 'title' ) ?: '';
$video_url = get_sub_field( 'video_url' ) ?: get_sub_field( 'video' ) ?: get_sub_field( 'url' ) ?: '';
$thumb     = get_sub_field( 'thumbnail' ) ?: get_sub_field( 'poster' ) ?: get_sub_field( 'thumb' );

if ( ! $video_url ) {
	return;
}

$embed_url = $video_url;
if ( preg_match( '#(?:youtube\.com/watch\?v=|youtu\.be/)([a-zA-Z0-9_-]+)#', $video_url, $match ) ) {
	$embed_url = 'https://www.youtube.com/embed/' . $match[1];
} elseif ( preg_match( '#vimeo\.com/(?:video/)?(\d+)#', $video_url, $match ) ) {
	$embed_url = 'https://player.vimeo.com/video/' . $match[1];
}

$image_id = 0;
if ( is_array( $thumb ) && ! empty( $thumb['ID'] ) ) {
	$image_id = (int) $thumb['ID'];
} elseif ( is_numeric( $thumb ) ) {
	$image_id = (int) $thumb;
}
?>
<section class="iec-video-section" <?= $heading ? 'aria-labelledby="iec-voucher-video-title"' : ''; ?>>
	<div class="container">

		<?php if ( $heading ) : ?>
			<h2 id="iec-voucher-video-title" class="iec_section_heading"><?= $heading; ?></h2>
		<?php endif; ?>

		<div class="iec-video-player">
			<div class="iec-video-thumbnail">
				<?php if ( $image_id ) : ?>
					<?= wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'iec-video-thumb-img', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
				<?php endif; ?>
				<button type="button" class="iec-video-play-btn" id="iecPlayBtn" aria-label="<?= __( 'Play video', 'bbtheme' ); ?>">
					<svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<circle cx="32" cy="32" r="32" fill="white" fill-opacity="0.9"/>
						<path d="M26 20L44 32L26 44V20Z" fill="#1B204C"/>
					</svg>
				</button>
			</div>
			<div class="iec-video-iframe" data-src="<?= $embed_url; ?>" style="display:none;">
				<iframe
					src=""
					title="<?= $heading ?: __( 'Product video', 'bbtheme' ); ?>"
					allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
					allowfullscreen
					loading="lazy"
				></iframe>
			</div>
		</div>
	</div>
</section>
