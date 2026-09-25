<?php
/**
 * Market detail — recommended solutions grid.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$solutions        = $args['solutions'] ?? array();
$hero_has_image   = ! empty( $args['hero_has_image'] );
$primary_assigned = ! empty( $args['primary_thumb_assigned'] );

if ( ! is_array( $solutions ) || empty( $solutions ) ) {
	return;
}

$rec_sol_bg_url = get_template_directory_uri() . '/assets/img/rec_sol_v2_bg.png';

$solution_count = count( $solutions );
switch ( $solution_count ) {
	case 1:
	case 2:
		$col_class = 'col-lg-6';
		break;
	case 3:
		$col_class = 'col-lg-4';
		break;
	default:
		$col_class = 'col-lg-3';
		break;
}
?>

<section class="iec_recommended_solution_section iec_defualt_position iec_background iec_bg_repeat iec_bg_cover iec_bg_position_center" style="--bgImage: url('<?= esc_url( $rec_sol_bg_url ); ?>');">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h5><?= 'Value Added Services'; ?></h5>
			</div>
		</div>

		<div class="row">
			<?php
			foreach ( $solutions as $solution ) :
				$solution_id = is_object( $solution ) ? (int) $solution->ID : (int) $solution;
				if ( $solution_id < 1 ) {
					continue;
				}
				$permalink   = get_permalink( $solution_id );
				if ( ! $permalink ) {
					continue;
				}
				$page_title    = get_the_title( $solution_id );
				$caption       = get_field( 'caption', $solution_id );
				$summary       = get_field( 'summary', $solution_id );
				$landing_image = get_field( 'landing_image', $solution_id );
				$summary_text  = is_string( $summary ) ? trim( $summary ) : '';
				$caption_text  = is_string( $caption ) ? trim( $caption ) : '';
				$landing_url   = iec_resolve_media_to_url( $landing_image );
				$img_w = 0;
				$img_h = 0;
				if ( '' !== $landing_url ) {
					$img_src = bbtheme_get_image_or_placeholder( $landing_url );
					$dims    = iec_get_image_dimensions( $landing_image );
					$img_w   = $dims['width'];
					$img_h   = $dims['height'];
				} else {
					$thumb_url = iec_get_post_thumbnail_url( $solution_id );
					$img_src   = bbtheme_get_image_or_placeholder( $thumb_url );
					$thumb_id  = get_post_thumbnail_id( $solution_id );
					if ( $thumb_id > 0 ) {
						$dims  = iec_get_image_dimensions( $thumb_id );
						$img_w = $dims['width'];
						$img_h = $dims['height'];
					}
				}
				$heading = '' !== $caption_text ? $caption_text : $page_title;
				$body    = $summary_text;
				if ( $hero_has_image ) {
					$loading_attr = ' loading="lazy" decoding="async"';
				} elseif ( ! $primary_assigned ) {
					$loading_attr      = ' fetchpriority="high" decoding="async"';
					$primary_assigned  = true;
				} else {
					$loading_attr = ' loading="lazy" decoding="async"';
				}
				$dimensions_attr = ( $img_w > 0 && $img_h > 0 ) ? sprintf( ' width="%d" height="%d"', $img_w, $img_h ) : '';
				?>
				<div class="col-md-6 <?= esc_attr( $col_class ); ?> iec_recommended_solution_box_warpper">
					<a href="<?= esc_url( $permalink ); ?>" class="iec_recommended_solution_box">
						<div class="iec_recommended_solution_box_image_warpper">
							<img src="<?= esc_url( $img_src ); ?>" class="iec_img_style" alt="<?= esc_attr( $heading ); ?>"<?= $dimensions_attr . $loading_attr; ?>>
						</div>
						<h6><?= $heading; ?></h6>
						<?php if ( '' !== $body ) : ?>
							<p><?= $body; ?></p>
						<?php endif; ?>
					</a>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
