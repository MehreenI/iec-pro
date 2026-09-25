<?php
/**
 * Flexible: labeled_features
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block   = $args['block'] ?? array();
$eyebrow = $block['eyebrow'] ?? '';
$heading = $block['heading'] ?? '';
$content = $block['content'] ?? '';
$rows    = is_array( $block['features'] ?? null ) ? $block['features'] : array();

$features = array();

foreach ( $rows as $row ) {
	if ( ! is_array( $row ) ) {
		continue;
	}
	$label        = $row['label'] ?? '';
	$feature_body = $row['content'] ?? '';
	if ( '' === $label && '' === $feature_body ) {
		continue;
	}
	$features[] = array(
		'label'   => $label,
		'content' => $feature_body,
	);
}

$content_str = is_string( $content ) ? trim( $content ) : '';

if ( '' === $eyebrow && '' === $heading && '' === $content_str && empty( $features ) ) {
	return;
}
?>
<section class="iec_single_news_main_section iec_single_news_labeled_features_section iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( '' !== $eyebrow ) : ?>
					<p class="iec_single_news_labeled_features_eyebrow"><?= $eyebrow; ?></p>
				<?php endif; ?>

				<?php if ( '' !== $heading ) : ?>
					<div class="iec_heading_section">
						<h2><?= $heading; ?></h2>
					</div>
				<?php endif; ?>

				<?php if ( '' !== $content_str ) : ?>
					<div class="iec_single_news_main_content_warpper">
						<?= $content_str; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $features ) ) : ?>
					<ul class="iec_single_news_labeled_features_list">
						<?php foreach ( $features as $feature ) : ?>
							<li class="iec_single_news_labeled_features_item">
								<?php if ( '' !== $feature['label'] ) : ?>
									<span class="iec_single_news_labeled_features_label"><?= $feature['label']; ?></span>
								<?php endif; ?>
								<?php if ( '' !== $feature['content'] ) : ?>
									<div class="iec_single_news_labeled_features_text wysiwyg-content">
										<?= $feature['content']; ?>
									</div>
								<?php endif; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
