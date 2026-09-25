<?php
/**
 * About partners accordion.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$partners = $args['partners'] ?? array();

if ( empty( $partners ) ) {
	return;
}

$chunks = array_chunk( $partners, 5 );
?>

<!-- Partners accordion. -->
<section class="iec_defualt_position iec_background_image_section iec_bg_repeat iec_bg_cover iec_bg_position_center iec_partner_icon_accordian_section iec-colored-accordion-section iec-about-partners-section" data-iec-colored-accordion>
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php foreach ( $chunks as $chunk_index => $chunk ) : ?>
					<?php
					$first_caption      = '';
					$first_content      = '';
					$first_brochure_url = '';
					$first_map_url      = '';
					?>
					<ul class="iec_partner_accordian_list" data-group="<?php echo $chunk_index; ?>">

						<?php foreach ( $chunk as $partner_index => $partner ) : ?>
							<?php
							$partner_id = is_object( $partner ) ? ( $partner->ID ?? 0 ) : (int) $partner;

							if ( ! $partner_id ) {
								continue;
							}

							$data         = get_fields( $partner_id ) ?: array();
							$icon         = $data['icon'] ?? array();
							$caption      = $data['caption'] ?? '';
							$content      = $data['content'] ?? '';
							$brochure     = $data['brochure'] ?? array();
							$map          = $data['coverage_map'] ?? array();
							$icon_id      = $icon['ID'] ?? 0;
							$icon_url     = $icon['url'] ?? '';
							$icon_alt     = $icon['alt'] ?? ( $icon['title'] ?? $caption );
							$brochure_url = is_array( $brochure ) ? ( $brochure['url'] ?? '' ) : $brochure;
							$map_url      = is_array( $map ) ? ( $map['url'] ?? '' ) : $map;
							$is_first     = ( 0 === $partner_index );

							if ( $is_first ) {
								$first_caption      = $caption;
								$first_content      = $content;
								$first_brochure_url = $brochure_url;
								$first_map_url      = $map_url;
							}
							?>
							<li class="iec_partner_accordian_box_warpper<?php echo $is_first ? ' active' : ''; ?>" data-group="<?php echo $chunk_index; ?>">
								<button
									type="button"
									class="iec_partner_accordian_trigger"
									data-group="<?php echo $chunk_index; ?>"
									data-caption="<?php echo $caption; ?>"
									data-brochure-url="<?php echo $brochure_url; ?>"
									data-map-url="<?php echo $map_url; ?>"
									aria-expanded="<?php echo $is_first ? 'true' : 'false'; ?>"
								>
									<span class="iec_partner_accordian_box">
										<span class="iec_partner_accordian_image">

											<?php if ( $icon_id ) : ?>
												<?php echo wp_get_attachment_image( $icon_id, 'medium', false, array( 'alt' => $icon_alt, 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
											<?php elseif ( $icon_url ) : ?>
												<img src="<?php echo $icon_url; ?>" alt="<?php echo $icon_alt; ?>" loading="lazy" decoding="async">
											<?php endif; ?>

										</span>
										<span class="iec_partner_accordian_content">
											<span class="iec_partner_accordian_caption"><?php echo $caption; ?></span>
											<span class="toggle-icon" aria-hidden="true"></span>
										</span>
									</span>
								</button>

								<?php if ( $content ) : ?>
									<template class="iec-partner-content-source"><?php echo $content; ?></template>
								<?php endif; ?>

							</li>
						<?php endforeach; ?>

					</ul>
					<div class="iec_partner_accordian_below_content active" data-group="<?php echo $chunk_index; ?>">

						<?php if ( $first_caption ) : ?>
							<h2 class="iec-primary-heading"><?php echo $first_caption; ?></h2>
						<?php endif; ?>

						<?php if ( $first_content ) : ?>
							<div class="iec_para_content"><?php echo $first_content; ?></div>
						<?php endif; ?>

						<?php if ( $first_brochure_url || $first_map_url ) : ?>
							<div class="iec_partner_accordian_button_list">

								<?php if ( $first_brochure_url ) : ?>
									<div>
										<a href="<?php echo $first_brochure_url; ?>" class="download-brochure" target="_blank" rel="noopener noreferrer">Download brochure</a>
									</div>
								<?php endif; ?>

								<?php if ( $first_map_url ) : ?>
									<div>
										<button type="button" class="iec-partner-view-map view-map" data-map-url="<?php echo $first_map_url; ?>">View Coverage Map</button>
									</div>
								<?php endif; ?>

							</div>
						<?php endif; ?>

					</div>
				<?php endforeach; ?>

			</div>
		</div>
	</div>
	<dialog id="partner-coverage-map" class="iec-partner-coverage-dialog coverage-map-popup" aria-labelledby="partner-coverage-map-title">
		<button type="button" class="close" aria-label="Close"></button>
		<h2 id="partner-coverage-map-title" class="screen-reader-text">Coverage Map</h2>
		<img src="" alt="Coverage Map" width="800" height="600" decoding="async">
	</dialog>
</section>
