<?php
/**
 * Product / solution post grid.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading      = $args['heading'] ?? '';
$products     = $args['products'] ?? array();
$query        = $args['query'] ?? null;
$show_btn     = ! empty( $args['show_btn'] ) || ! empty( $args['show_btn_product'] );

if ( $query instanceof WP_Query ) {
	$products = $query->posts;
	wp_reset_postdata();
}
$block        = $args['block'] ?? array();
$layout       = $args['layout'] ?? 'default';
$min_products = $args['min_products'] ?? 0;
$post_type    = $args['post_type'] ?? 'product';

if ( ! is_array( $products ) ) {
	$products = array();
}

if ( function_exists( 'iec_module_product_posts' ) ) {
	$products = iec_module_product_posts( $products, $min_products, $post_type );
} else {
	$products = array_values( array_filter( $products ) );
}

if ( empty( $products ) ) {
	return;
}

$is_office      = ( 'office' === $layout );
$section_class  = $args['section_class'] ?? ( $is_office ? 'iec_products_posts_sec iec_defualt_position' : 'iec-products-section iec-product-solution-section' );
$heading_class  = $args['heading_class'] ?? '';
$heading_attrs  = $args['heading_attrs'] ?? '';
$card_attrs     = $args['card_attrs'] ?? '';
$stagger_target = $args['stagger_target'] ?? '.iec-product-solution-wrapper';
$heading_text   = $heading !== '' ? $heading : ( $is_office ? __( 'IN HIGH DEMAND', 'bbtheme' ) : '' );
$block_link     = ( $is_office && is_array( $block['link'] ?? null ) ) ? $block['link'] : null;

$has_stagger = false !== strpos( $section_class, 'iec-anim-stagger-group' );
$grid_attrs  = '';
if ( $has_stagger ) {
	$grid_attrs = ' data-iec-anim-target="' . esc_attr( $stagger_target ) . '" data-iec-anim-preset="iec-anim-scale-in" data-iec-anim-stagger="0.1"';
}

if ( function_exists( 'iec_resolve_wpml_url' ) ) {
	$products_cta_url = iec_resolve_wpml_url( $block_link );
} else {
	$products_cta_url = is_array( $block_link ) ? ( $block_link['url'] ?? '' ) : '';
}

$view_all_url = function_exists( 'iec_config_permalink' ) ? iec_config_permalink( 'iec_ps_page' ) : '';
if ( ! $view_all_url && function_exists( 'iec_wpml_localize_url' ) ) {
	$view_all_url = iec_wpml_localize_url( home_url( '/satellite-terminals/' ) );
}

if ( ! $view_all_url ) {
	$view_all_url = home_url( '/satellite-terminals/' );
}
?>

<section class="<?= esc_attr( $section_class ); ?>"<?= $has_stagger ? ' data-iec-anim-stagger-group' : ''; ?>>
	<div class="container">
		<?php if ( $heading_text !== '' ) : ?>
			<div class="row">
				<div class="col-md-12">
					<h2 class="<?= esc_attr( $heading_class !== '' ? $heading_class : ( $is_office ? 'iec_section_heading iec-section-heading' : 'iec_main_heading text_blue' ) ); ?>" <?= $heading_attrs; ?>><?= ucfirst( strtolower( $heading_text ) ); ?></h2>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<div class="col-md-12">
				<div class="iec-grid-wrap" <?= $card_attrs; ?>>
					<div class="iec-grid"<?= $grid_attrs; ?>>
						<?php foreach ( $products as $product ) : ?>
							<?php
							get_template_part(
								'template-parts/sp-landing/product',
								'card',
								array(
									'post' => $product,
								)
							);
							?>
						<?php endforeach; ?>
					</div>
				</div>
			</div>
		</div>

		<?php if ( $products_cta_url ) : ?>
			<div class="row">
				<div class="col-md-12">
					<div class="right_text solution_btn">
						<a
							href="<?= esc_url( $products_cta_url ); ?>"
							class="iec_button iec_blue_gradient"
							<?= ! empty( $block_link['target'] ) ? 'target="' . esc_attr( $block_link['target'] ) . '"' : ''; ?>
						>
							<?= $block_link['title'] ?? ''; ?>
						</a>
					</div>
				</div>
			</div>
		<?php elseif ( $show_btn ) : ?>
			<div class="row">
				<div class="col-md-12<?= $is_office ? '' : ' text-center'; ?>">
					<div class="<?= $is_office ? 'center_text solution_btn' : 'btn-left'; ?>">
						<a href="<?= esc_url( $view_all_url ); ?>" class="iec_button iec_blue_gradient"<?= $is_office ? ' style="margin: auto; margin-top: 20px"' : ''; ?>>
							<?= __( 'View all', 'bbtheme' ); ?>
						</a>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</section>
