<?php
/**
 * VAS detail main section — copy, key points, actions.
 *
 * @package iec
 *
 * @var array $args { fields: array }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields = $args['fields'] ?? array();

$key_points = $fields['key_points'] ?? array();
$points     = $key_points['points'] ?? array();
$heading    = ! empty( $fields['caption'] ) ? $fields['caption'] : get_the_title();
?>
<section class="iec_background_image_section iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_left iec_main_contact_section iec_optisim_content" data-vas-detail-content>
	<div class="container">

		<div class="row">
			<div class="col-md-12">

				<?php if ( ! empty( $heading ) ) : ?>
					<h1 class="iec_primary_heading"><?= $heading; ?></h1>
				<?php endif; ?>

			</div>
		</div>
		<div class="row">
			<div class="col-md-6">

				<?php if ( ! empty( $fields['content'] ) ) : ?>
					<div class="wysiwyg-content">
						<?= $fields['content']; ?>
					</div>
				<?php endif; ?>

			</div>

			<div class="col-md-6">

				<?php if ( $points ) : ?>
					<div class="iec_key_points">

						<?php if ( ! empty( $key_points['caption'] ) ) : ?>
							<h2><?= $key_points['caption']; ?></h2>
						<?php endif; ?>

						<?php foreach ( $points as $key_point ) : ?>

							<?php if ( ! is_array( $key_point ) ) { continue; } ?>

							<div class="iec_key_point_box">
								<p><?= $key_point['text'] ?? ''; ?></p>
							</div>

						<?php endforeach; ?>
					</div>

				<?php endif; ?>

				<?php get_template_part( 'template-parts/vas/detail-actions', null, array( 'fields' => $fields ) ); ?>
			</div>
		</div>
	</div>
</section>
