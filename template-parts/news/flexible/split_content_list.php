<?php
/**
 * Flexible: split_content_list
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block        = $args['block'] ?? array();
$heading      = $block['heading'] ?? '';
$content      = $block['content'] ?? '';
$list_heading = $block['list_heading'] ?? '';
$points       = is_array( $block['points'] ?? null ) ? $block['points'] : array();

$list_items = array();

foreach ( $points as $point ) {
	if ( ! is_array( $point ) ) {
		continue;
	}
	$text = '';
	foreach ( array( 'item', 'point', 'text', 'question', 'label' ) as $key ) {
		if ( ! empty( $point[ $key ] ) ) {
			$text = trim( (string) $point[ $key ] );
			break;
		}
	}
	if ( '' !== $text ) {
		$list_items[] = $text;
	}
}

if ( '' === $heading && '' === $content && empty( $list_items ) ) {
	return;
}
?>
<section class="iec_single_news_main_section iec_single_news_split_section iec_defualt_position">
	<div class="container">
		<div class="row iec_single_news_split_row">
			<div class="col-lg-6">
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
			</div>
			<?php if ( ! empty( $list_items ) ) : ?>
				<div class="col-lg-6">
					<?php if ( '' !== $list_heading ) : ?>
						<div class="iec_heading_section">
							<h2><?= $list_heading; ?></h2>
						</div>
					<?php endif; ?>
					<div class="iec_single_news_split_list_wrap">
						<ul class="iec_single_news_split_list">
							<?php foreach ( $list_items as $item ) : ?>
								<li class="iec_single_news_split_list_item">
									<span class="iec_single_news_split_list_marker" aria-hidden="true">?</span>
									<span class="iec_single_news_split_list_text"><?= $item; ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>
