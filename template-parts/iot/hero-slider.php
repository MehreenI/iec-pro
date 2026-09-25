<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();
$slides = $fields['slider'] ?? array();

if ( empty( $slides ) || ! is_array( $slides ) ) {
	return;
}

$is_slider     = count( $slides ) > 1;
$wrapper_class = $is_slider ? 'swiper iec-iot-hero-swiper' : '';
?>
<section class="iec_iot_slider_section">
	<div class="<?= $wrapper_class; ?>">
		<div class="swiper-wrapper">

			<?php foreach ( $slides as $index => $item ) : ?>

				<?php
				if ( ! is_array( $item ) ) {
					continue;
				}

				$image    = $item['image'] ?? array();
				$image_id = 0;

				if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
					$image_id = (int) $image['ID'];

				} elseif ( is_numeric( $image ) ) {
					$image_id = (int) $image;
				}

				$caption     = $item['caption'] ?? '';
				$description = $item['description'] ?? '';
				$heading_tag = 0 === $index ? 'h1' : 'p';
				?>

				<div class="swiper-slide iec_bg_repeat iec_bg_cover">

					<?php if ( $image_id ) : ?>
						<?= wp_get_attachment_image( $image_id, 'full', false, array( 'alt' => '', 'class' => 'iec_iot_slide_bg' ) ); ?>
					<?php endif; ?>

					<div class="iec_iot_slide">
						<div class="container">
							<div class="row">
								<div class="col-md-12">

									<?php if ( $caption ) : ?>
										<div class="iec_iot_slide_title">
											<<?= $heading_tag; ?> class="iec_primary_heading"><?= $caption; ?></<?= $heading_tag; ?>>
										</div>
									<?php endif; ?>

									<?php if ( $description ) : ?>
										<div class="iec_iot_slide_content wysiwyg-content">
											<?= $description; ?>
										</div>
									<?php endif; ?>

								</div>
							</div>
						</div>
					</div>
				</div>

			<?php endforeach; ?>

		</div>

		<?php if ( $is_slider ) : ?>
			<div class="container">
				<div class="iec_iot_slide_arrow_warpper">
					<div class="slider-button-prev"></div>
					<div class="slider-button-next"></div>
				</div>
			</div>
		<?php endif; ?>

	</div>
</section>
