<?php
/**
 * Single product — specifications section.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$specifications = $args['specifications'] ?? array();
?>
<section id="specifications" class="iec_defualt_position iec_specification_section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( ! empty( $specifications['heading'] ) ) : ?>
					<h2 class="iec_single_product_section_title"><?= $specifications['heading']; ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $specifications['specification_content'] ) ) : ?>
					<?= wp_kses_post( $specifications['specification_content'] ); ?>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>
