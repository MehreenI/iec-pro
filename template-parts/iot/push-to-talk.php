<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section   = $args['section'] ?? array();
$title     = $section['title'] ?? '';
$body      = $section['description'] ?? '';
$video_url = $section['video_link'] ?? '';
$embed     = $video_url ? wp_oembed_get( $video_url ) : '';

if ( ! $title && ! $body && ! $embed ) {
	return;
}
?>
<section class="iec_iot_talk_solution_section iec_defualt_position">
	<div class="container">
		<div class="row align-items-center">
			<div class="col-md-7 col-lg-8">

				<?php if ( $title || $body ) : ?>
					<div class="iec_iot_talk_solution_content">

						<?php if ( $title ) : ?>
							<h2 class="iec_section_heading"><?= $title; ?></h2>
						<?php endif; ?>

						<?php if ( $body ) : ?>
							<div class="wysiwyg-content">
								<?= $body; ?>
							</div>
						<?php endif; ?>

					</div>
				<?php endif; ?>

			</div>

			<?php if ( $embed ) : ?>
				<div class="col-md-5 col-lg-4">
					<div class="iec_iot_talk_solution_content_video">
						<?= $embed; ?>
					</div>
				</div>
			<?php endif; ?>

		</div>
	</div>
</section>
