<?php
/**
 * Flexible: system_panels
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block           = $args['block'] ?? array();
$eyebrow         = $block['eyebrow'] ?? '';
$heading         = $block['heading'] ?? '';
$content         = $block['content'] ?? '';
$panels_raw      = is_array( $block['panels'] ?? null ) ? $block['panels'] : array();
$notice_heading  = $block['notice_heading'] ?? '';
$notice_content  = $block['notice_content'] ?? '';

$panels = array();

foreach ( $panels_raw as $panel ) {
	if ( ! is_array( $panel ) ) {
		continue;
	}
	$tag           = $panel['tag'] ?? '';
	$panel_heading = $panel['heading'] ?? '';
	$panel_content = is_string( $panel['content'] ?? null ) ? trim( $panel['content'] ) : '';
	$specs         = array();
	foreach ( is_array( $panel['specs'] ?? null ) ? $panel['specs'] : array() as $spec ) {
		if ( ! is_array( $spec ) ) {
			continue;
		}
		$label = $spec['label'] ?? '';
		$value = $spec['value'] ?? '';
		if ( '' === $label && '' === $value ) {
			continue;
		}
		$specs[] = array(
			'label' => $label,
			'value' => $value,
		);
	}
	if ( '' === $tag && '' === $panel_heading && '' === $panel_content && empty( $specs ) ) {
		continue;
	}
	$panels[] = array(
		'tag'     => $tag,
		'heading' => $panel_heading,
		'content' => $panel_content,
		'specs'   => $specs,
	);
}

$notice_content_str = is_string( $notice_content ) ? trim( $notice_content ) : '';
$has_notice         = ( '' !== $notice_heading || '' !== $notice_content_str );
$content_str        = is_string( $content ) ? trim( $content ) : '';

if ( '' === $eyebrow && '' === $heading && '' === $content_str && empty( $panels ) && ! $has_notice ) {
	return;
}
?>
<section class="iec_single_news_main_section iec_single_news_system_panels_section iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( '' !== $eyebrow ) : ?>
					<p class="iec_single_news_system_panels_eyebrow"><?= $eyebrow; ?></p>
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

				<?php foreach ( $panels as $panel ) : ?>
					<article class="iec_single_news_system_panel">
						<div class="iec_single_news_system_panel_body">
							<?php if ( '' !== $panel['tag'] ) : ?>
								<span class="iec_single_news_system_panel_tag"><?= $panel['tag']; ?></span>
							<?php endif; ?>
							<?php if ( '' !== $panel['heading'] ) : ?>
								<h3 class="iec_single_news_system_panel_title"><?= $panel['heading']; ?></h3>
							<?php endif; ?>
							<?php if ( '' !== $panel['content'] ) : ?>
								<div class="iec_single_news_system_panel_content"><?= $panel['content']; ?></div>
							<?php endif; ?>
						</div>
						<?php if ( ! empty( $panel['specs'] ) ) : ?>
							<div class="iec_single_news_system_panel_specs" role="list">
								<?php foreach ( $panel['specs'] as $spec ) : ?>
									<div class="iec_single_news_system_panel_spec" role="listitem">
										<?php if ( '' !== $spec['label'] ) : ?>
											<b><?= $spec['label']; ?></b>
										<?php endif; ?>
										<?php if ( '' !== $spec['value'] ) : ?>
											<span><?= $spec['value']; ?></span>
										<?php endif; ?>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</article>
				<?php endforeach; ?>

				<?php if ( $has_notice ) : ?>
					<aside class="iec_single_news_system_panels_notice">
						<?php if ( '' !== $notice_heading ) : ?>
							<b class="iec_single_news_system_panels_notice_title"><?= $notice_heading; ?></b>
						<?php endif; ?>
						<?php if ( '' !== $notice_content_str ) : ?>
							<div class="wysiwyg-content"><?= $notice_content_str; ?></div>
						<?php endif; ?>
					</aside>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
