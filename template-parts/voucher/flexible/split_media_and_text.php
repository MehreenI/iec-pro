<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$title   = get_sub_field( 'title' ) ?: '';
$body    = get_sub_field( 'body' ) ?: '';
$list    = get_sub_field( 'list' ) ?: array();
$image   = get_sub_field( 'image' ) ?: array();
$reverse = get_sub_field( 'reverse' ) ?: array();
$link    = get_sub_field( 'link' ) ?: array();
$anchor  = get_sub_field( 'jump_to_anchor' ) ?: '';

$is_reverse  = ! empty( $reverse ) && in_array( 'yes', (array) $reverse, true );
$section_dir = $is_reverse ? 'iec-content-left' : 'iec-content-right';

$link_url    = is_array( $link ) ? ( $link['url'] ?? '' ) : '';
$link_title  = is_array( $link ) ? ( $link['title'] ?? '' ) : '';
$link_target = is_array( $link ) ? ( $link['target'] ?? '' ) : '';

if ( $link_url ) {
	$link_url = apply_filters( 'wpml_permalink', $link_url );
}

$image_id = 0;
if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
	$image_id = (int) $image['ID'];
} elseif ( is_numeric( $image ) ) {
	$image_id = (int) $image;
}

$heading_id = $anchor ?: ( $title ? sanitize_title( $title ) : '' );

$check_icon = '<svg width="30" height="30" viewBox="0 0 30 30" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M26.2996 7.89829C26.4266 8.02492 26.5273 8.17535 26.596 8.34097C26.6647 8.50658 26.7001 8.68413 26.7001 8.86343C26.7001 9.04274 26.6647 9.22029 26.596 9.3859C26.5273 9.55152 26.4266 9.70195 26.2996 9.82857L14.0309 22.0973C13.9042 22.2243 13.7538 22.325 13.5882 22.3937C13.4226 22.4624 13.245 22.4978 13.0657 22.4978C12.8864 22.4978 12.7089 22.4624 12.5433 22.3937C12.3777 22.325 12.2272 22.2243 12.1006 22.0973L6.64782 16.6445C6.39185 16.3886 6.24805 16.0414 6.24805 15.6794C6.24805 15.3174 6.39185 14.9702 6.64782 14.7143C6.90379 14.4583 7.25096 14.3145 7.61296 14.3145C7.97496 14.3145 8.32213 14.4583 8.5781 14.7143L13.0657 19.2046L24.3693 7.89829C24.496 7.77134 24.6464 7.67062 24.812 7.6019C24.9776 7.53318 25.1552 7.4978 25.3345 7.4978C25.5138 7.4978 25.6913 7.53318 25.8569 7.6019C26.0226 7.67062 26.173 7.77134 26.2996 7.89829Z" fill="#727DA3"/></svg>';
?>
<section class="iec_defualt_position iec-content-section <?= $section_dir; ?>"<?= $heading_id ? ' aria-labelledby="' . $heading_id . '"' : ''; ?>>
	<div class="container">
		<div class="row align-items-center">

			<?php if ( $is_reverse ) : ?>
				<div class="col-md-6"></div>
			<?php endif; ?>

			<div class="col-md-5">

				<?php if ( $title ) : ?>
					<h2 class="iec_section_heading iec-section-heading"<?= $heading_id ? ' id="' . $heading_id . '"' : ''; ?>><?= $title; ?></h2>
				<?php endif; ?>

				<?php if ( $body ) : ?>
					<div class="iec_main_content_warpper vm_content wysiwyg-content">
						<?= $body; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $list ) ) : ?>
					<ul class="iec_icon_list split_media_text_list">
						<?php foreach ( $list as $item ) : ?>
							<?php if ( empty( $item['points'] ) ) : ?>
								<?php continue; ?>
							<?php endif; ?>
							<li>
								<span class="iec-list-icon" aria-hidden="true"><?= $check_icon; ?></span>
								<?= $item['points']; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $link_title && $link_url ) : ?>
					<a href="<?= $link_url; ?>" class="iec_button iec_blue_gradient vmc_btn"<?= '_blank' === $link_target ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
						<?= $link_title; ?>
					</a>
				<?php endif; ?>

			</div>

			<?php if ( ! $is_reverse ) : ?>
				<div class="col-md-6"></div>
			<?php endif; ?>

		</div>
	</div>

	<div class="ice_voucher_content_image_warpper" aria-hidden="true">
		<img src="/wp-content/uploads/2026/04/Ellipse-5.png" class="ice_voucher_content_shape_image" alt="">
		<?php if ( $image_id ) : ?>
			<?= wp_get_attachment_image( $image_id, 'full', false, array( 'class' => 'ice_voucher_content_main_image', 'alt' => '', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
		<?php endif; ?>
	</div>
</section>
