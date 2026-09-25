<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$overview = is_array( $args['overview'] ?? null ) ? $args['overview'] : array();
$images   = is_array( $args['images'] ?? null ) ? $args['images'] : array();
$content  = $overview['contant'] ?? '';
?>
<section id="overview" class="iec_single_solution_overview">
	<?php if ( $content ) : ?>
		<div class="iec_single_solution_overview_content_warpper">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="iec_single_product_wyswig">
							<?= wp_kses_post( $content ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>

	<?php if ( $images ) : ?>
		<div class="iec_single_solution_image_modal">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="swiper image-modal-swiper iec_single_solution_product_image_grid">
							<div class="swiper-wrapper">
								<?php foreach ( $images as $item ) : ?>
									<div class="swiper-slide">
										<?php get_template_part( 'template-parts/solution/overview-card', null, array( 'item' => $item ) ); ?>
									</div>
								<?php endforeach; ?>
							</div>
							<div class="iec_swiper_arrow_warpper">
								<div class="swiper-button-prev image_modal_swiper_prev">
									<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
										<path d="M7.88999 1.58002L6.70332 0.400024L0.109985 7.00002L6.70999 13.6L7.88999 12.42L2.46999 7.00002L7.88999 1.58002Z" fill="#727DA3"/>
									</svg>
								</div>
								<div class="swiper-button-next image_modal_swiper_next">
									<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
										<path d="M0.110015 12.42L1.29668 13.6L7.89002 6.99998L1.29002 0.399975L0.110015 1.57997L5.53002 6.99998L0.110015 12.42Z" fill="#727DA3"/>
									</svg>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php endif; ?>
</section>
