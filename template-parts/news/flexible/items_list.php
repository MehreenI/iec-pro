<?php
/**
 * Flexible: items_list
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = $args['block'] ?? array();
$items = is_array( $block['items'] ?? null ) ? $block['items'] : array();
$text  = $block['optional_text'] ?? '';

if ( empty( $items ) && '' === $text ) {
	return;
}

$icon     = function_exists( 'iec_office_check_icon_svg' ) ? iec_office_check_icon_svg() : '';
$count    = count( $items );
$split_at = (int) floor( $count / 2 ) + 1;
$left     = array_slice( $items, 0, $split_at );
$right    = array_slice( $items, $split_at );
?>
<section class="iec_single_news_main_section iec_with_padding iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_single_news_main_content_warpper">
					<?php if ( '' !== $text ) : ?>
						<?= $text; ?>
					<?php endif; ?>

					<?php if ( $items ) : ?>
						<div class="iec_list_warpper">
							<div class="iec_list">
								<?php foreach ( $left as $item ) : ?>
									<span class="iec_list_item">
										<?= $icon; ?>
										<?= $item['text'] ?? ''; ?>
									</span>
								<?php endforeach; ?>
							</div>
							<?php if ( $right ) : ?>
								<div class="iec_list">
									<?php foreach ( $right as $item ) : ?>
										<span class="iec_list_item">
											<?= $icon; ?>
											<?= $item['text'] ?? ''; ?>
										</span>
									<?php endforeach; ?>
								</div>
							<?php endif; ?>
						</div>
					<?php endif; ?>

					<?php if ( ! empty( $block['url'] ) ) : ?>
						<a href="<?= $block['url']; ?>" class="iec_button iec_blue_gradient">
							<?= $block['button_text'] ?? ''; ?>
						</a>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>
