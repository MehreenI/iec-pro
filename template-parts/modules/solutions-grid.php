<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = $args['block'] ?? array();
$raw   = $block['add_solutions'] ?? array();

if ( function_exists( 'iec_module_product_posts' ) ) {
	$solutions = iec_module_product_posts( $raw, 0, 'solution' );
} else {
	$solutions = array_values( array_filter( $raw ) );
}

if ( ! $solutions ) {
	return;
}

$heading = $block['section_heading'] ?? __( 'Our Solutions', 'bbtheme' );
$no_nav  = count( $solutions ) <= 3;

$render_card = static function ( $solution ) {
	$post_id = $solution instanceof WP_Post ? (int) $solution->ID : (int) $solution;
	if ( $post_id < 1 ) {
		return;
	}

	get_template_part(
		'template-parts/sp-landing/product',
		'card',
		array(
			'post'               => $post_id,
			'hide_card_category' => true,
		)
	);
};
?>

<!-- Solutions. -->
<section class="iec_solution_section iec_products_posts_sec iec_defualt_position<?php echo $no_nav ? ' iec_solution_no_nav' : ''; ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="iec_section_heading iec-section-heading"><?php echo $heading; ?></h2>

				<div class="iec_solution_swiper_warpper">
					<button type="button" class="swiper-button-prev custom-arrow" aria-label="<?php esc_attr_e( 'Previous', 'bbtheme' ); ?>">
						<svg width="26" height="31" viewBox="0 0 26 31" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M25.5 31L13.1056 31L0.499999 15.978L13 -1.09278e-06L25.5 0L13 15.5L25.5 31Z" fill="#727DA4" fill-opacity="0.5"/>
						</svg>
					</button>
					<div class="swiper solution_swiper iec_solution_swiper">
						<div class="swiper-wrapper">
							<?php foreach ( $solutions as $solution ) : ?>
								<div class="swiper-slide">
									<?php $render_card( $solution ); ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<button type="button" class="swiper-button-next custom-arrow" aria-label="<?php esc_attr_e( 'Next', 'bbtheme' ); ?>">
						<svg width="26" height="31" viewBox="0 0 26 31" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
							<path d="M0.5 0L12.8944 0L25.5 15.022L13 31H0.5L13 15.5L0.5 0Z" fill="#727DA4" fill-opacity="0.5"/>
						</svg>
					</button>
				</div>

				<ul class="iec_solution_mobile_posts">
					<?php foreach ( $solutions as $solution ) : ?>
						<li class="iec_solution_mobile_post_item">
							<?php $render_card( $solution ); ?>
						</li>
					<?php endforeach; ?>
				</ul>

				<div class="swiper-controls">
					<div class="swiper-pagination iec_solution_pagination"></div>
				</div>
			</div>
		</div>
	</div>
</section>
