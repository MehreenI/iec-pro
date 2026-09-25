<?php
/**
 * Flexible: content_with_side_image
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block   = $args['block'] ?? array();
$image   = iec_resolve_media_to_url( $block['image'] ?? null );
$heading = $block['heading'] ?? '';
$content = $block['content'] ?? '';

if ( '' === $image && '' === $content && '' === $heading ) {
	return;
}

$class = ! empty( $block['is_right'] ) ? 'iec_single_news_image_right' : 'iec_single_news_image_left';
?>
<section class="iec_single_news_main_section iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_single_news_side_image_box_warpper">
					<?php if ( '' !== $image ) : ?>
						<div class="iec_single_news_side_image_box <?= $class; ?>">
							<img src="<?= $image; ?>" alt="<?= $heading; ?>" loading="lazy" decoding="async">
						</div>
					<?php endif; ?>
					<div class="iec_single_news_main_content_warpper">
						<?php if ( '' !== $heading ) : ?>
							<div class="iec_heading_section">
								<h2><?= $heading; ?></h2>
							</div>
						<?php endif; ?>
						<?= $content; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
