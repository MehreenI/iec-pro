<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$list = is_array( $args['list'] ?? null ) ? $args['list'] : array();

if ( $list === array() ) {
	return;
}
?>
<section class="iec_defualt_position iec_specification_section" id="features">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<h2 class="iec_single_product_section_title"><?= __( 'Features', 'bbtheme' ); ?></h2>
				<div class="at_feature_wrapper">
					<div class="row">
						<?php foreach ( $list as $feature ) :
							if ( ! is_array( $feature ) ) {
								continue;
							}
							?>
							<div class="col-md-6">
								<div class="iec_single_product_feature_item">
									<div class="iec_single_product_feature_icon_wrapper">
										<?= $feature['icon_svg'] ?? ''; ?>
									</div>
									<div class="feature-content">
										<h3 class="iec_single_product_feature_heading"><?= $feature['title'] ?? ''; ?></h3>
										<p><?= $feature['body'] ?? ''; ?></p>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
