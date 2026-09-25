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
				<ul class="iec_single_products_links_list">
					<?php if ( ! empty( $ctx['has_overview'] ) ) : ?>
						<li><a href="#overview"><?= 'Overview'; ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $ctx['has_key_features'] ) ) : ?>
						<li><a href="#key-feauters"><?= 'Key Features'; ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $ctx['has_markets'] ) ) : ?>
						<li><a href="#markets"><?= 'Markets'; ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $ctx['has_specifications'] ) ) : ?>
						<li><a href="#specifications"><?= 'Specifications'; ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $ctx['has_coverage'] ) ) : ?>
						<li><a href="#coverage"><?= 'Coverage map'; ?></a></li>
					<?php endif; ?>

					<?php if ( ! empty( $ctx['has_product_materials'] ) ) : ?>
						<li><a href="#product-materials"><?= 'Product Materials'; ?></a></li>
					<?php endif; ?>
					<li><a href="#our-products"><?= 'Related products'; ?></a></li>
					<li><a href="#contact"><?= 'Contact Us'; ?></a></li>
				</ul>
			</div>
		</div>
	</div>
</section>
