<?php
/**
 * Flexible: content_card_grid
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block   = $args['block'] ?? array();
$heading = $block['heading'] ?? '';
$content = $block['content'] ?? '';
$cards   = is_array( $block['cards'] ?? null ) ? $block['cards'] : array();

$card_items = array();

foreach ( $cards as $card ) {
	if ( ! is_array( $card ) ) {
		continue;
	}
	$label        = $card['label'] ?? '';
	$card_heading = $card['heading'] ?? '';
	$card_content = $card['content'] ?? '';
	if ( '' === $label && '' === $card_heading && '' === $card_content ) {
		continue;
	}
	$card_items[] = array(
		'label'   => $label,
		'heading' => $card_heading,
		'content' => $card_content,
	);
}

if ( '' === $heading && '' === $content && empty( $card_items ) ) {
	return;
}

$card_count = count( $card_items );
$grid_class = 'iec_single_news_content_card_grid';

if ( $card_count > 0 ) {
	$grid_class .= ( 0 === $card_count % 2 ) ? ' is-cols-2' : ' is-cols-3';
}
?>
<section class="iec_single_news_main_section iec_single_news_content_card_section iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( '' !== $heading ) : ?>
					<div class="iec_heading_section">
						<h2><?= $heading; ?></h2>
					</div>
				<?php endif; ?>

				<?php if ( '' !== $content ) : ?>
					<div class="iec_single_news_main_content_warpper">
						<?= $content; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $card_items ) ) : ?>
					<div class="<?= $grid_class; ?>">
						<?php foreach ( $card_items as $card_item ) : ?>
							<article class="iec_single_news_content_card">
								<?php if ( '' !== $card_item['label'] ) : ?>
									<span class="iec_single_news_content_card_label"><?= $card_item['label']; ?></span>
								<?php endif; ?>
								<?php if ( '' !== $card_item['heading'] ) : ?>
									<h3 class="iec_single_news_content_card_title"><?= $card_item['heading']; ?></h3>
								<?php endif; ?>
								<?php if ( '' !== $card_item['content'] ) : ?>
									<div class="iec_single_news_content_card_text"><?= $card_item['content']; ?></div>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
