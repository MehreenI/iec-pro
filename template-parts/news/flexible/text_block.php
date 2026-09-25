<?php
/**
 * Flexible: text_block
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block   = $args['block'] ?? array();
$content = $block['content'] ?? '';

if ( '' === $content ) {
	return;
}
?>
<section class="iec_single_news_main_section iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_single_news_main_content_warpper">
					<?= $content; ?>
				</div>
			</div>
		</div>
	</div>
</section>
