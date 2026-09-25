<?php
/**
 * Flexible: content_with_dark_bg
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block   = $args['block'] ?? array();
$heading = $block['heading'] ?? '';
$content = $block['content'] ?? '';
$notice  = $block['notice'] ?? '';
$cards   = is_array( $block['cards'] ?? null ) ? $block['cards'] : array();

$card_items = array();

foreach ( $cards as $card ) {
	if ( ! is_array( $card ) ) {
		continue;
	}
	$title = $card['title'] ?? '';
	$body  = $card['body'] ?? '';
	if ( '' === $title && '' === $body ) {
		continue;
	}
	$card_items[] = array(
		'title' => $title,
		'body'  => $body,
	);
}

if ( '' === $heading && '' === $content && empty( $card_items ) ) {
	return;
}

$card_count = count( $card_items );
$grid_class = 'iec_single_news_cards_grid ' . ( 0 === $card_count % 2 ? 'is-cols-2' : 'is-cols-3' );
?>
<section class="iec_single_news_main_section iec_single_news_cards_section iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<?php if ( '' !== $heading ) : ?>
					<div class="iec_heading_section">
						<h2><?= $heading; ?></h2>
					</div>
				<?php endif; ?>

				<?php if ( '' !== $content ) : ?>
					<div class="wysiwyg-content">
						<?= $content; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $card_items ) ) : ?>
					<div class="<?= $grid_class; ?>">
						<?php foreach ( $card_items as $card_item ) : ?>
							<article class="iec_single_news_cards_card">
								<?php if ( '' !== $card_item['title'] ) : ?>
									<h3 class="iec_single_news_cards_card_title"><?= $card_item['title']; ?></h3>
								<?php endif; ?>
								<?php if ( '' !== $card_item['body'] ) : ?>
									<p class="iec_single_news_cards_card_text"><?= $card_item['body']; ?></p>
								<?php endif; ?>
							</article>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

				<?php if ( '' !== $notice ) : ?>
					<div class="wysiwyg-content">
						<?= $notice; ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
