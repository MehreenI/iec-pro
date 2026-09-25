<?php
/**
 * VAS landing service cards grid.
 *
 * @package iec
 *
 * @var array $args { sections: array }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$sections = $args['sections'] ?? array();
$spacing  = $args['spacing'] ?? '';

if ( empty( $sections ) || ! is_array( $sections ) ) {
	return;
}
?>
<div class="row <?= $spacing; ?>">

	<?php foreach ( $sections as $section ) : ?>

		<?php
		if ( ! is_array( $section ) ) {
			continue;
		}

		$image    = $section['image'] ?? null;
		$image_id = 0;
		$image_url = '';

		if ( is_array( $image ) ) {
			$image_id  = (int) ( $image['ID'] ?? $image['id'] ?? 0 );
			$image_url = (string) ( $image['url'] ?? '' );

		} elseif ( is_numeric( $image ) ) {
			$image_id = (int) $image;

		} elseif ( is_string( $image ) ) {
			$image_url = trim( $image );
		}

		if ( $image_id < 1 && $image_url ) {
			$image_id = (int) attachment_url_to_postid( $image_url );
		}

		$alt = '';

		if ( is_array( $image ) && ! empty( $image['alt'] ) ) {
			$alt = $image['alt'];

		} elseif ( $image_id > 0 ) {
			$alt = (string) get_post_meta( $image_id, '_wp_attachment_image_alt', true );
		}

		if ( '' === $alt && ! empty( $section['caption'] ) ) {
			$alt = $section['caption'];
		}

		$page = $section['page'] ?? null;
		$href = '';

		if ( is_array( $page ) && ! empty( $page['url'] ) ) {
			$href = $page['url'];

		} elseif ( $page instanceof WP_Post || ( is_numeric( $page ) && (int) $page > 0 ) ) {
			$href = (string) get_permalink( $page );

		} elseif ( is_string( $page ) ) {
			$href = trim( $page );
		}

		if ( '' === $href || '#' === $href ) {
			$href = '';
		}

		$box_style = '';

		if ( $image_id < 1 && '' !== $image_url ) {
			$box_style = ' style="background-image: url(\'' . $image_url . '\');"';
		}
		?>

		<div class="col-md-6 iec_value_added_services_box_warpper">

			<?php if ( $href ) : ?>

				<a href="<?= $href; ?>" class="iec_value_added_services_box iec_bg_repeat iec_bg_cover iec_bg_position_center"<?= $box_style; ?>>

			<?php else : ?>

				<div class="iec_value_added_services_box iec_bg_repeat iec_bg_cover iec_bg_position_center"<?= $box_style; ?>>

			<?php endif; ?>

				<?php if ( $image_id > 0 ) : ?>

					<?= wp_get_attachment_image( $image_id, 'large', false, array( 'class' => 'iec_value_added_services_box__image', 'alt' => $alt ) ); ?>

				<?php endif; ?>

				<div class="iec_value_added_services_box_content">

					<?php if ( ! empty( $section['caption'] ) ) : ?>

						<h2><?= $section['caption']; ?></h2>

					<?php endif; ?>

					<?php if ( ! empty( $section['summary'] ) ) : ?>

						<p><?= $section['summary']; ?></p>

					<?php endif; ?>

				</div>

			<?php if ( $href ) : ?>

				</a>

			<?php else : ?>

				</div>

			<?php endif; ?>

		</div>

	<?php endforeach; ?>

</div>
