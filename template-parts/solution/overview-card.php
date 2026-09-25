<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$item  = is_array( $args['item'] ?? null ) ? $args['item'] : array();
$image = is_array( $item['image'] ?? null ) ? $item['image'] : array();
$url   = $image['url'] ?? '';
$title = $item['title'] ?? '';
$desc  = $item['description'] ?? '';
$alt   = $image['alt'] ?? $title;

if ( ! $url ) {
	return;
}
?>
<button type="button" class="iec_single_solution_product_image_post" data-img="<?= esc_url( $url ); ?>" aria-label="<?= esc_attr( wp_strip_all_tags( $title ) ); ?>">
	<div class="iec_single_solution_image_warpper">
		<img src="<?= esc_url( $url ); ?>" class="iec_single_solution_product_image" alt="<?= esc_attr( wp_strip_all_tags( $alt ) ); ?>">
		<div class="iec_modal_image_icon"><?= iec_solution_expand_svg(); ?></div>
	</div>
	<div class="iec_single_product_image_content">
		<?php if ( $title ) : ?>
			<h3><?= $title; ?></h3>
		<?php endif; ?>
		<?php if ( $desc ) : ?>
			<p><?= $desc; ?></p>
		<?php endif; ?>
	</div>
</button>
