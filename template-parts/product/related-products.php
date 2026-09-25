<?php
/**
 * Single product — related products grid.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id  = (int) ( $args['post_id'] ?? get_the_ID() );
$products = function_exists( 'iec_product_related_posts' )
    ? iec_product_related_posts( $post_id )
    : array();

if ( ! is_array( $products ) ) {
    $products = array();
}

?>
<section class="" id="our-products">
    <?php
    iec_module(
        'products',
        array(
            'heading'          => __( 'Related Products', 'bbtheme' ),
            'products'         => $products,
            'show_btn_product' => true,
            'post_type'        => 'product',
        )
    );
    ?>
</section>
