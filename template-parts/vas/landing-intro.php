<?php
/**
 * VAS landing intro — caption and description below hero.
 *
 * @package iec
 *
 * @var array $args { banner: array }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$banner  = $args['banner'] ?? array();
$caption = is_string( $banner['caption'] ?? '' ) ? $banner['caption'] : '';
$overlay = is_string( $banner['overlay_title'] ?? '' ) ? $banner['overlay_title'] : '';
$heading = '';

if ( '' !== $caption ) {
	$heading = $caption;

} elseif ( '' === $overlay ) {
	$heading = get_the_title();
}

if ( '' === $heading && empty( $banner['description'] ) ) {
	return;
}
?>
<div class="row">
	<div class="col-lg-12">

		<?php if ( '' !== $heading ) : ?>

			<h1 class="iec_primary_heading"><?= $heading; ?></h1>

		<?php endif; ?>

		<?php if ( ! empty( $banner['description'] ) ) : ?>

			<div class="wysiwyg-content">
				<?= wp_kses_post( $banner['description'] ); ?>
			</div>

		<?php endif; ?>

	</div>
</div>
