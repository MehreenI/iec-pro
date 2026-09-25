<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section   = $args['section'] ?? array();
$eyebrow   = $section['eyebrow'] ?? '';
$heading   = $section['heading'] ?? '';
$content   = $section['content'] ?? '';
$image     = $section['image'] ?? null;
$stats     = $section['statistics'] ?? array();
$image_id  = is_array( $image ) ? (int) ( $image['ID'] ?? 0 ) : ( is_numeric( $image ) ? (int) $image : 0 );
$image_url = is_array( $image ) ? ( $image['url'] ?? '' ) : '';

if ( ! $image_url && $image_id ) {
	$image_url = (string) wp_get_attachment_image_url( $image_id, 'large' );
}

if ( ! $image_url && function_exists( 'iec_resolve_media_to_url' ) ) {
	$image_url = (string) iec_resolve_media_to_url( $image );
}

$heading_id = 'iec-home-about-heading-' . wp_unique_id();

?>

<section
	class="iec_defualt_position iec_section_home_about iec_section_home_about--dark<?= $image_url ? ' iec_section_home_about--has-image' : ''; ?>"
	<?= $heading ? 'aria-labelledby="' . esc_attr( $heading_id ) . '"' : ''; ?>
	<?= $image_url ? "style=\"background-image: url('" . esc_url( $image_url ) . "');\"" : ''; ?>
>
	<div class="iec_home_about_curve iec_home_about_curve--flip" aria-hidden="true">
		<svg viewBox="0 0 1600 256" fill="none" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="none">
			<path d="M1600 109.572L1600 109.571C1600.06 91.4266 1594.58 74.1321 1584.02 60.1634L1583.26 59.1829C1570.91 43.3377 1552.64 33.324 1532.45 31.1625L1531.24 31.0428C1402.82 6.66982 1122.24 12.1282 812.491 44.9854L803.094 45.9903C520.306 76.4458 179.936 126.991 58.6836 178.719L55.0762 180.287C47.8302 182.395 40.9984 185.522 34.7822 189.54L33.46 190.412L32.8799 190.809C24.0398 196.906 16.6187 204.831 11.1162 214.053L10.3721 215.33C3.31053 227.689 -0.176412 241.709 0.00686569 255.998L0.00100632 256V0H1600V109.572Z" class="iec_home_about_curve__fill"></path>
		</svg>
	</div>
	<div class="container">
		<div class="row align-items-center iec_home_about_row">
			<div class="col-md-6">
				<div class="iec_home_about_content" data-aos="fade-up">

					<?php if ( $eyebrow ) : ?>

						<span class="iec_home_eyebrow iec-eyebrow"><?= esc_html( $eyebrow ); ?></span>

					<?php endif; ?>

					<?php if ( $heading ) : ?>

						<h2 class="iec_section_heading iec-section-heading" id="<?= esc_attr( $heading_id ); ?>"><?= esc_html( $heading ); ?></h2>

					<?php endif; ?>

					<?php if ( $content ) : ?>

						<div class="wysiwyg-content"><?= $content; ?></div>

					<?php endif; ?>

					<?php if ( $stats ) : ?>

						<div class="iec_home_about_stats" role="list">

							<?php foreach ( $stats as $stat ) : ?>

								<?php
								$value = $stat['value'] ?? '';
								$label = $stat['label'] ?? '';

								if ( ! $value && ! $label ) {
									continue;
								}
								?>

								<div class="iec_home_about_stat" role="listitem">

									<?php if ( $value ) : ?>

										<span class="iec_home_about_stat_number"><?= esc_html( $value ); ?></span>

									<?php endif; ?>

									<?php if ( $label ) : ?>

										<span class="iec_home_about_stat_label"><?= esc_html( $label ); ?></span>

									<?php endif; ?>

								</div>

							<?php endforeach; ?>

						</div>

					<?php endif; ?>
                    
				</div>
			</div>
			<?php if ( $image_url ) : ?>

				<div class="col-md-6" aria-hidden="true">
					<div class="iec_home_about_image_spacer"></div>
				</div>

			<?php endif; ?>
		</div>
	</div>
</section>
