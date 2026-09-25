<?php
/**
 * Single product — in-page anchor navigation.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ctx = $args['ctx'] ?? array();
?>
<section class="iec_single_products_links_section iec_with_half_bg">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<ul class="iec_single_products_links_list iec-anim-stagger" data-iec-anim-stagger="0.08">
					<?php if ( ! empty( $ctx['has_overview'] ) ) : ?>
						<li><a class="iec-scroll-link" href="#overview"><?= __( 'Overview', 'bbtheme' ); ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $ctx['has_key_features'] ) ) : ?>
						<li><a class="iec-scroll-link" href="#key-feauters"><?= __( 'Key Features', 'bbtheme' ); ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $ctx['has_markets'] ) ) : ?>
						<li><a class="iec-scroll-link" href="#markets"><?= __( 'Markets', 'bbtheme' ); ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $ctx['has_specifications'] ) ) : ?>
						<li><a class="iec-scroll-link" href="#specifications"><?= __( 'Specifications', 'bbtheme' ); ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $ctx['has_coverage'] ) ) : ?>
						<li><a class="iec-scroll-link" href="#coverage"><?= __( 'Coverage map', 'bbtheme' ); ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $ctx['has_product_materials'] ) ) : ?>
						<li><a class="iec-scroll-link" href="#product-materials"><?= __( 'Product Materials', 'bbtheme' ); ?></a></li>
					<?php endif; ?>
					<li><a class="iec-scroll-link" href="#our-products"><?= __( 'Related products', 'bbtheme' ); ?></a></li>
					<li><a class="iec-scroll-link" href="#contact"><?= __( 'Contact Us', 'bbtheme' ); ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
