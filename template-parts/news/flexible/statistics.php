<?php
/**
 * Flexible: statistics
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block   = $args['block'] ?? array();
$heading = $block['heading'] ?? '';
$content = $block['content'] ?? '';
$stats   = is_array( $block['stats'] ?? null ) ? $block['stats'] : array();

$stat_items = array();

foreach ( $stats as $stat ) {
	if ( ! is_array( $stat ) ) {
		continue;
	}
	$label = $stat['label'] ?? '';
	$parts = function_exists( 'iec_news_stat_number_parts' )
		? iec_news_stat_number_parts( (string) ( $stat['number'] ?? '' ) )
		: array(
			'display' => trim( (string) ( $stat['number'] ?? '' ) ),
			'count'   => '',
			'suffix'  => '',
			'animate' => false,
		);
	if ( '' === $parts['display'] || '' === $label ) {
		continue;
	}
	$stat_items[] = array(
		'label' => $label,
		'parts' => $parts,
	);
}

if ( empty( $stat_items ) ) {
	return;
}
?>
<section class="iec_single_news_main_section iec_single_news_statistics_section iec_defualt_position" data-iec-statistics-section>
	<div class="container">
		<?php if ( '' !== $heading || '' !== $content ) : ?>
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
				</div>
			</div>
		<?php endif; ?>

		<div class="row iec_single_news_statistics_cards" role="list">
			<?php foreach ( $stat_items as $stat_item ) : ?>
				<?php
				$label = $stat_item['label'];
				$parts = $stat_item['parts'];
				?>
				<div class="col-md-4 iec_single_news_statistics_card_warpper" role="listitem">
					<div class="iec_single_news_statistics_card">
						<span
							class="iec_single_news_statistics_number"
							<?php if ( $parts['animate'] ) : ?>
								data-iec-stat-counter
								data-count="<?= $parts['count']; ?>"
								<?php if ( '' !== $parts['suffix'] ) : ?>
									data-suffix="<?= $parts['suffix']; ?>"
								<?php endif; ?>
							<?php endif; ?>
						><?= $parts['animate'] ? '0' . $parts['suffix'] : $parts['display']; ?></span>
						<span class="iec_single_news_statistics_label"><?= $label; ?></span>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
