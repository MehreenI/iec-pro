<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$align_raw = get_sub_field( 'alignment' ) ?: get_sub_field( 'align' ) ?: get_sub_field( 'image_position' ) ?: '';
$align     = ( is_string( $align_raw ) && str_contains( strtolower( $align_raw ), 'right' ) ) ? 'right' : 'left';
$heading   = get_sub_field( 'heading' ) ?: get_sub_field( 'section_heading' ) ?: get_sub_field( 'title' ) ?: '';
$body      = get_sub_field( 'content' ) ?: get_sub_field( 'description' ) ?: get_sub_field( 'text' ) ?: '';
$list      = get_sub_field( 'list' ) ?: get_sub_field( 'items' ) ?: get_sub_field( 'points' ) ?: get_sub_field( 'features' ) ?: array();
$main      = get_sub_field( 'main_image' ) ?: get_sub_field( 'image' ) ?: get_sub_field( 'content_image' );
$shape     = get_sub_field( 'shape_image' ) ?: get_sub_field( 'background_shape' ) ?: get_sub_field( 'shape' );
$button    = get_sub_field( 'button' ) ?: get_sub_field( 'cta' );

$main_id = 0;
if ( is_array( $main ) && ! empty( $main['ID'] ) ) {
	$main_id = (int) $main['ID'];
} elseif ( is_numeric( $main ) ) {
	$main_id = (int) $main;
}

$shape_id = 0;
if ( is_array( $shape ) && ! empty( $shape['ID'] ) ) {
	$shape_id = (int) $shape['ID'];
} elseif ( is_numeric( $shape ) ) {
	$shape_id = (int) $shape;
}

$button_url    = is_array( $button ) ? ( $button['url'] ?? '' ) : '';
$button_title  = is_array( $button ) ? ( $button['title'] ?? $button['label'] ?? '' ) : '';
$button_target = is_array( $button ) ? ( $button['target'] ?? '_self' ) : '_self';

if ( $button_url ) {
	$button_url = apply_filters( 'wpml_permalink', $button_url );
}

if ( ! $heading && ! $body && ! $main_id && empty( $list ) ) {
	return;
}
?>
<section class="iec_defualt_position iec-content-section iec-content-<?= $align; ?>">

	<?php if ( $main_id || $shape_id ) : ?>
		<div class="ice_voucher_content_image_warpper">
			<?php if ( $shape_id ) : ?>
				<?= wp_get_attachment_image( $shape_id, 'full', false, array( 'class' => 'ice_voucher_content_shape_image', 'alt' => '', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
			<?php endif; ?>
			<?php if ( $main_id ) : ?>
				<?= wp_get_attachment_image( $main_id, 'full', false, array( 'class' => 'ice_voucher_content_main_image', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
			<?php endif; ?>
		</div>
	<?php endif; ?>

	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php if ( $heading ) : ?>
					<h2 class="iec_section_heading"><?= $heading; ?></h2>
				<?php endif; ?>

				<?php if ( $body ) : ?>
					<div class="iec_main_content_warpper vm_content wysiwyg-content">
						<?= $body; ?>
					</div>
				<?php endif; ?>

				<?php if ( is_array( $list ) && $list ) : ?>
					<ul class="iec_icon_list vmc_list split_media_text_list">
						<?php foreach ( $list as $row ) : ?>
							<?php
							if ( ! is_array( $row ) ) {
								continue;
							}
							$text = $row['text'] ?? $row['item'] ?? $row['description'] ?? '';
							if ( ! $text ) {
								continue;
							}
							?>
							<li><?= $text; ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $button_url ) : ?>
					<a class="iec_button iec_blue_gradient vmc_btn" href="<?= $button_url; ?>"<?= '_blank' === $button_target ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
						<?= $button_title ?: __( 'Learn more', 'bbtheme' ); ?>
					</a>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
