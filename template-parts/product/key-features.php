<?php
/**
 * Single product — key features grid.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$key_features = $args['key_features'] ?? array();
$items        = $key_features['core_features'] ?? array();
?>
<section id="key-feauters" class="iec_single_products_key_features_section">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<?php if ( ! empty( $key_features['heading'] ) ) : ?>
					<h2 class="iec_single_product_section_title"><?= $key_features['heading']; ?></h2>
				<?php endif; ?>
				<div class="iec_single_product_features_wrapper">
					<?php foreach ( $items as $key_feature ) :
						if ( ! is_array( $key_feature ) ) {
							continue;
						}
						$icon_url = $key_feature['image_icon']['url'] ?? '';
						?>
						<div class="iec_single_product_feature_item">
							<div class="iec_single_product_feature_icon_wrapper">
								<?php if ( $icon_url !== '' ) : ?>
									<img src="<?= esc_url( $icon_url ); ?>" class="img-fluid" alt="<?= esc_attr( wp_strip_all_tags( $key_feature['description'] ?? '' ) ); ?>" loading="lazy" />
								<?php else : ?>
									<?= iec_product_check_icon_svg(); ?>
								<?php endif; ?>
							</div>
							<div class="iec_single_product_feature_label">
								<?= wp_kses_post( $key_feature['description'] ?? '' ); ?>
							</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
	</div>
</section>
