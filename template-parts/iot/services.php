<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = $args['section'] ?? array();
$title   = $section['section_title'] ?? '';
$items   = $section['items'] ?? array();

if ( empty( $items ) ) {
	return;
}
?>
<section class="iec_iot_our_services iec_defualt_position">
	<div class="container">
		<?php if ( $title ) : ?>
			<div class="row">
				<div class="col-md-12">
					<h2 class="iec_section_heading"><?= $title; ?></h2>
				</div>
			</div>
		<?php endif; ?>
	</div>
	<div class="iec_iot_our_service_sec_warpper iec_defualt_position">
		<div class="container">
			<div class="row">

				<?php foreach ( $items as $item ) : ?>

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
					?>

					<div class="col-md-6 iec_iot_service_box_warpper">
						<div class="iec_iot_service_box iec_bg_repeat">

							<?php if ( $image_id ) : ?>
								<?= wp_get_attachment_image( $image_id, 'full', false, array( 'alt' => '', 'class' => 'iec_iot_service_box_image' ) ); ?>
							<?php endif; ?>

							<?php if ( ! empty( $item['caption'] ) ) : ?>
								<h3><?= $item['caption']; ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $item['description'] ) ) : ?>
								<p><?= $item['description']; ?></p>
							<?php endif; ?>

						</div>
					</div>

				<?php endforeach; ?>

			</div>
		</div>
	</div>
</section>
