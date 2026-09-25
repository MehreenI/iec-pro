<?php
/**
 * About history timeline.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$history_items = $args['history'] ?? array();

if ( empty( $history_items ) || ! is_array( $history_items ) ) {
	return;
}

?>

<!-- History timeline. -->
<section class="iec_background_image_section iec_defualt_position">
	<div class="iec_history_timeline_warpper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="iec_history_timeline_list">
						<span class="line" aria-hidden="true"></span>
						<ul>

							<?php foreach ( $history_items as $item ) : ?>
								<?php
								$year        = $item['year'] ?? '';
								$caption     = $item['caption'] ?? '';
								$description = $item['description'] ?? '';
								?>
								<li class="iec_history_timeline_list_item">

									<?php if ( $year ) : ?>
										<time class="iec_history_timeline_year" datetime="<?php echo $year; ?>"><?php echo $year; ?></time>
									<?php endif; ?>

									<?php if ( $caption ) : ?>
										<h2 class="iec_history_timeline_caption"><?php echo $caption; ?></h2>
									<?php endif; ?>

									<?php if ( $description ) : ?>
										<div class="iec_history_timeline_description"><?php echo $description; ?></div>
									<?php endif; ?>

								</li>
							<?php endforeach; ?>

						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
