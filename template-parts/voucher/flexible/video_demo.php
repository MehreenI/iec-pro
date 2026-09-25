<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$embed_url = get_sub_field( 'vd_embed_url' ) ?: '';
$poster    = get_sub_field( 'vd_poster_image' ) ?: array();

if ( ! $embed_url && empty( $poster ) ) {
	return;
}

$image_id = 0;
if ( is_array( $poster ) && ! empty( $poster['ID'] ) ) {
	$image_id = (int) $poster['ID'];
} elseif ( is_numeric( $poster ) ) {
	$image_id = (int) $poster;
}
?>
<section class="iec-video-section">
	<div class="container">
		<div class="iec-video-player">
			<div class="iec-video-thumbnail">
				<?php if ( $image_id ) : ?>
					<?= wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'iec-video-thumb-img', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
				<?php endif; ?>
				<button type="button" class="iec-video-play-btn" id="iecPlayBtn" aria-label="<?= __( 'Play video', 'bbtheme' ); ?>">
					<svg width="60" height="60" viewBox="0 0 60 60" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M44.5501 31.3075C44.7255 31.032 44.8439 30.7241 44.8982 30.402C44.9524 30.0799 44.9415 29.7502 44.8659 29.4324C44.7904 29.1146 44.6518 28.8152 44.4584 28.552C44.265 28.2888 44.0207 28.0671 43.7401 27.9L18.9351 12.82C18.5318 12.5757 18.0691 12.4469 17.5976 12.4475C16.1976 12.4475 15.0651 13.555 15.0651 14.9225V45.075C15.0651 45.5375 15.1976 45.99 15.4476 46.3825C16.1876 47.5425 17.7476 47.8975 18.9351 47.175L43.7401 32.0975C44.0676 31.8975 44.3476 31.625 44.5526 31.305L44.5501 31.3075ZM46.4151 36.3L21.6126 51.3775C18.0501 53.545 13.3626 52.4775 11.1476 49C10.3964 47.8289 9.99802 46.4663 10.0001 45.075V14.925C10.0001 10.8225 13.4001 7.5 17.6001 7.5C19.0176 7.5 20.4076 7.8875 21.6126 8.62L46.4151 23.7C49.9776 25.865 51.0701 30.44 48.8526 33.92C48.2376 34.885 47.4026 35.7 46.4151 36.3Z" fill="white"/>
					</svg>
				</button>
			</div>
			<div class="iec-video-iframe" data-src="<?= $embed_url; ?>" style="display:none;">
				<iframe
					src=""
					title="<?= __( 'Product video', 'bbtheme' ); ?>"
					allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
					referrerpolicy="strict-origin-when-cross-origin"
					allowfullscreen
					loading="lazy"
				></iframe>
			</div>
		</div>
	</div>
</section>
