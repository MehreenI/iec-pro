<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading = get_sub_field( 'heading' ) ?: get_sub_field( 'section_heading' ) ?: get_sub_field( 'title' ) ?: '';
$body    = get_sub_field( 'content' ) ?: get_sub_field( 'description' ) ?: get_sub_field( 'text' ) ?: '';
$list    = get_sub_field( 'list' ) ?: get_sub_field( 'items' ) ?: get_sub_field( 'points' ) ?: get_sub_field( 'features' ) ?: array();
$image   = get_sub_field( 'image' ) ?: get_sub_field( 'side_image' ) ?: get_sub_field( 'main_image' );

$image_id = 0;
if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
	$image_id = (int) $image['ID'];
} elseif ( is_numeric( $image ) ) {
	$image_id = (int) $image;
}

if ( ! $heading && ! $body && empty( $list ) ) {
	return;
}
?>
<section class="iec_defualt_position iec-support-section" <?= $heading ? 'aria-labelledby="iec-voucher-support-title"' : ''; ?>>
	<div class="container">
		<div class="row align-items-center gap-100">
			<div class="col-md-6">

				<?php if ( $heading ) : ?>
					<h2 id="iec-voucher-support-title" class="iec_section_heading iec-section-heading vmc_heading mb-0"><?= $heading; ?></h2>
				<?php endif; ?>

				<?php if ( $body ) : ?>
					<div class="iec_main_content_warpper wysiwyg-content">
						<?= $body; ?>
					</div>
				<?php endif; ?>

				<?php if ( is_array( $list ) && $list ) : ?>
					<ul class="iec_icon_list vmc_list">
						<?php foreach ( $list as $row ) : ?>
							<?php
							$text = is_array( $row ) ? ( $row['text'] ?? $row['item'] ?? '' ) : (string) $row;
							if ( ! $text ) {
								continue;
							}
							?>
							<li><?= $text; ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

			</div>

			<?php if ( $image_id ) : ?>
				<div class="col-md-6">
					<?= wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'iec-support-section__image', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
