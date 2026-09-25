<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$use_cases = is_array( $args['use_cases'] ?? null ) ? $args['use_cases'] : array();
$list      = is_array( $args['list'] ?? null ) ? $args['list'] : array();

if ( $list === array() ) {
	return;
}
?>
<section id="use-cases" class="iec_single_solution_use_cases">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2><?= $use_cases['heading'] ?? __( 'Use Cases', 'bbtheme' ); ?></h2>

				<div class="swiper use_cases_swiper iec_single_solution_use_cases_box_grid">
					<div class="swiper-wrapper">
						<?php foreach ( $list as $case ) : ?>
							<div class="swiper-slide">
								<?php get_template_part( 'template-parts/solution/use-case-card', null, array( 'case' => $case ) ); ?>
							</div>
						<?php endforeach; ?>
					</div>
					<div class="iec_swiper_arrow_warpper">
						<div class="swiper-button-prev use_cases_swiper_prev">
							<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path d="M7.88999 1.58002L6.70332 0.400024L0.109985 7.00002L6.70999 13.6L7.88999 12.42L2.46999 7.00002L7.88999 1.58002Z" fill="#727DA3"/>
							</svg>
						</div>
						<div class="swiper-button-next use_cases_swiper_next">
							<svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
								<path d="M0.110015 12.42L1.29668 13.6L7.89002 6.99998L1.29002 0.399975L0.110015 1.57997L5.53002 6.99998L0.110015 12.42Z" fill="#727DA3"/>
							</svg>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
