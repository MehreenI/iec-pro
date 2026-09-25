<?php
/**
 * Single product — overview section.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$overview = $args['overview'] ?? array();
?>
<section id="overview" class="iec_single_products_overview">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( ! empty( $overview['heading'] ) ) : ?>
					<h2 class="iec_single_product_section_title"><?= $overview['heading']; ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $overview['contant'] ) ) : ?>
					<div class="iec_single_product_wyswig">
						<?= wp_kses_post( $overview['contant'] ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
