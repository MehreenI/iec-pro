<?php
/**
 * Starlink landing — video section.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();

if ( empty( $fields['title_video'] ) && empty( $fields['url_video'] ) ) {
	return;
}
?>
<section class="iec_defualt_position iec_video_section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="iec_section_heading text-blue"><?= $fields['title_video']; ?></h2>
				<div class="iec_iframe_box">
					<iframe width="1312" height="730" src="<?= $fields['url_video']; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
				</div>
			</div>
		</div>
	</div>
</section>
