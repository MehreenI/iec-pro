<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$card = is_array( $args['card'] ?? null ) ? $args['card'] : array();
$icon = is_array( $card['icon'] ?? null ) ? $card['icon'] : array();
?>
	<article class="iec_advantage_card">
		<div class="iec_advantage_header">
			<h3 class="iec_advantage_title"><?= $card['title'] ?? ''; ?></h3>
			<div class="iec_advantage_icon">
				<?php if ( ! empty( $icon['url'] ) ) : ?>
					<img src="<?= $icon['url']; ?>" alt="<?= $icon['alt'] ?? ''; ?>">
				<?php endif; ?>
			</div>
		</div>
		<p class="iec_advantage_text"><?= $card['text'] ?? ''; ?></p>
	</article>
