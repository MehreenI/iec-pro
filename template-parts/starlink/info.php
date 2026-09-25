<?php
/**
 * Starlink landing — additional info section.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();

if ( empty( $fields['additional_title'] ) && empty( $fields['description_video'] ) && empty( $fields['highlight_video'] ) ) {
	return;
}
?>
<section class="iec_defualt_position iec_starlink_info_section" id="info-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8 order-2 order-md-1">
				<div class="iec_starlink_info_content_box">
					<h2 class="iec_section_heading iec-section-heading"><?= $fields['additional_title']; ?></h2>
					<?= $fields['description_video']; ?>
				</div>
			</div>
			<div class="col-md-4 order-1 order-md-2">
				<div class="iec_starlink_info_right_box">
					<h3 class="iec_section_heading iec-section-heading">
						<span><?= $fields['highlight_video']; ?></span>
						<span><?= $fields['highlight_video']; ?></span>
						<span><?= $fields['highlight_video']; ?></span>
					</h3>
				</div>
			</div>
		</div>
	</div>
</section>
