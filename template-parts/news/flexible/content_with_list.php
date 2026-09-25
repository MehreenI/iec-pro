<?php
/**
 * Flexible: content_with_list
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
$order   = ! empty( $block['order'] );
$list    = is_array( $block['list'] ?? null ) ? $block['list'] : array();

$list_items = array();

foreach ( $list as $row ) {
	if ( ! is_array( $row ) ) {
		continue;
	}
	$point = $row['point'] ?? '';
	if ( '' !== $point ) {
		$list_items[] = $point;
	}
}

if ( '' === $heading && '' === $content && empty( $list_items ) ) {
	return;
}

$is_ordered   = $order;
$grid_class   = 'iec_single_news_content_list_grid' . ( $is_ordered ? ' is-ordered' : '' );
$tag          = $is_ordered ? 'ol' : 'div';
$item_tag     = $is_ordered ? 'li' : 'div';
$marker_class = $is_ordered ? 'iec_single_news_content_list_marker is-number' : 'iec_single_news_content_list_marker is-check';
?>
<section class="iec_single_news_main_section iec_single_news_content_list_section iec_defualt_position">
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

				<?php if ( ! empty( $list_items ) ) : ?>
					<<?= $tag; ?> class="<?= $grid_class; ?>"<?= $is_ordered ? '' : ' role="list"'; ?>>
						<?php foreach ( $list_items as $item ) : ?>
							<<?= $item_tag; ?> class="iec_single_news_content_list_item"<?= $is_ordered ? '' : ' role="listitem"'; ?>>
								<span class="<?= $marker_class; ?>" aria-hidden="true"><?= $is_ordered ? '' : '&#10003;'; ?></span>
								<span class="iec_single_news_content_list_text"><?= $item; ?></span>
							</<?= $item_tag; ?>>
						<?php endforeach; ?>
					</<?= $tag; ?>>
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
