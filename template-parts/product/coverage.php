<?php
/**
 * Single product — coverage map section.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$coverage_map       = $args['coverage_map'] ?? array();
$has_starlink_map   = ! empty( $args['has_starlink_map'] );
$has_coverage_image = ! empty( $args['has_coverage_image'] );
?>
<section id="coverage" class="iec_defualt_position iec_coverage_section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( ! empty( $coverage_map['heading'] ) ) : ?>
					<h2 class="iec_single_product_section_title"><?= $coverage_map['heading']; ?></h2>
				<?php endif; ?>

				<?php if ( $has_starlink_map && ! empty( $coverage_map['starlink_map'] ) ) : ?>
					<?= do_shortcode( $coverage_map['starlink_map'] ); ?>
				<?php elseif ( $has_coverage_image ) :
					$img = $coverage_map['coverage_map_img'] ?? array();
					$alt = ! empty( $img['alt'] ) ? $img['alt'] : __( 'Coverage Map', 'bbtheme' );
					?>
					<img
						src="<?= esc_url( $img['url'] ?? '' ); ?>"
						alt="<?= esc_attr( $alt ); ?>"
						class="iec_coverage_map"
						loading="lazy"
					/>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
