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
<section class="iec_iot_area_expert iec_defualt_position">
	<div class="container">

		<?php if ( $title ) : ?>
			<div class="row">
				<div class="col-md-12">
					<h2 class="iec_section_heading"><?= $title; ?></h2>
				</div>
			</div>
		<?php endif; ?>

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

				$link   = $item['link'] ?? array();
				$href   = $link['url'] ?? '';
				$label  = $link['title'] ?? '';
				$target = $link['target'] ?? '';
				$list   = $item['list'] ?? array();

				if ( $href ) {
					$href = apply_filters( 'wpml_permalink', $href );
				}
				?>

				<div class="col-md-6 iec_iot_area_expert_box_warpper">
					<div class="iec_iot_area_expert_box iec_defualt_position iec_bg_repeat iec_bg_cover iec_w_100 iec_h_100">

						<?php if ( $image_id ) : ?>
							<?= wp_get_attachment_image( $image_id, 'full', false, array( 'alt' => '', 'class' => 'iec_iot_area_expert_box_image' ) ); ?>
						<?php endif; ?>

						<div class="iec_iot_area_expert_content">

							<?php if ( ! empty( $item['caption'] ) ) : ?>
								<h3><?= $item['caption']; ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $list ) ) : ?>
								<ul>
									<?php foreach ( $list as $list_item ) : ?>
										<?php if ( ! empty( $list_item['list_item'] ) ) : ?>
											<li><?= $list_item['list_item']; ?></li>
										<?php endif; ?>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>

						</div>

						<?php if ( $href && $label ) : ?>
							<div class="iec_iot_area_expert_link">
								<a href="<?= $href; ?>"<?= $target ? ' target="' . $target . '" rel="noopener noreferrer"' : ''; ?>>
									<?= $label; ?>
								</a>
							</div>
						<?php endif; ?>

					</div>
				</div>

			<?php endforeach; ?>

		</div>
	</div>
</section>
