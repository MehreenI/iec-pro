<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$ctx = is_array( $args['ctx'] ?? null ) ? $args['ctx'] : array();

$items = array();

if ( ! empty( $ctx['has_overview'] ) ) {
	$items[] = array( 'href' => '#overview', 'label' => __( 'Overview', 'bbtheme' ) );
}

if ( ! empty( $ctx['has_use_cases'] ) ) {
	$items[] = array( 'href' => '#use-cases', 'label' => __( 'Use Cases', 'bbtheme' ) );
}
if ( ! empty( $ctx['has_markets'] ) ) {
	$items[] = array( 'href' => '#markets', 'label' => __( 'Markets', 'bbtheme' ) );
}
if ( ! empty( $ctx['has_industries'] ) ) {
	$items[] = array( 'href' => '#industries', 'label' => __( 'Industries', 'bbtheme' ) );
}
if ( ! empty( $ctx['has_specs'] ) ) {
	$items[] = array( 'href' => '#specifications', 'label' => __( 'Specifications', 'bbtheme' ) );
}
if ( ! empty( $ctx['has_features'] ) ) {
	$items[] = array( 'href' => '#features', 'label' => __( 'Features', 'bbtheme' ) );
}
if ( ! empty( $ctx['has_materials'] ) ) {
	$items[] = array( 'href' => '#product-materials', 'label' => __( 'Product Materials', 'bbtheme' ) );
}
if ( ! empty( $ctx['has_faqs'] ) ) {
	$items[] = array( 'href' => '#faqs', 'label' => __( 'FAQs', 'bbtheme' ) );
}

$items[] = array( 'href' => '#contact', 'label' => __( 'Contact Us', 'bbtheme' ) );

$odd_class = ( 1 === count( $items ) % 2 ) ? ' full-width-mb' : '';
?>
<section class="iec_single_products_links_section iec_with_half_bg">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<ul class="iec_single_products_links_list iec-anim-stagger<?= $odd_class; ?>" data-iec-anim-stagger="0.08">
					<?php foreach ( $items as $item ) : ?>
						<li><a class="iec-scroll-link" href="<?= esc_url( $item['href'] ); ?>"><?= $item['label']; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</section>
