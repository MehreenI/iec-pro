<?php
/**
 * Template Name: Market Detail Page
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$post_id    = (int) get_queried_object_id();
$acf_fields = ( $post_id && function_exists( 'get_fields' ) ) ? get_fields( $post_id ) : array();

if ( ! is_array( $acf_fields ) ) {
    $acf_fields = array();
}

$banner       = isset( $acf_fields['banner'] ) && is_array( $acf_fields['banner'] ) ? $acf_fields['banner'] : array();
$banner_image = isset( $banner['image'] ) && is_array( $banner['image'] ) ? $banner['image'] : array();
$lcp_url      = ! empty( $banner_image['url'] ) ? (string) $banner_image['url'] : '';

if ( $lcp_url !== '' ) {
    add_action(
        'wp_head',
        static function () use ( $lcp_url ) {
            printf(
                '<link rel="preload" as="image" href="%s" fetchpriority="high" />' . "\n",
                esc_url( $lcp_url )
            );
        },
        1
    );
}

get_header();

while ( have_posts() ) :
    the_post();

    $fields = $acf_fields;

    $success_popup_content     = get_config( 'enquiry_success_popup_content' );
    $success_popup_content_key = false;
    $success_popup_html        = '';

    if ( is_array( $success_popup_content ) ) {
        $success_popup_content_key = array_search( 'market-enquiry', array_column( $success_popup_content, 'form_type' ), true );
        if ( false !== $success_popup_content_key && isset( $success_popup_content[ $success_popup_content_key ]['content'] ) ) {
            $success_popup_html = $success_popup_content[ $success_popup_content_key ]['content'];
        }
    }

    $countries      = class_exists( '\BlueBeetle\Press\Common' )
        ? \BlueBeetle\Press\Common::get_instance()->get_countries()
        : array();
    $form_interests = get_config( 'enquiry_form_interest' ) ?: array();
    $hear_source    = get_config( 'form_hear_source' ) ?: array();

    $banner_image_url = $lcp_url;
    $has_hero_image   = ( $banner_image_url !== '' );
    ?>

    <main id="main" class="iec-market-detail-main market-detail-page">
        <?php
        get_template_part(
            'template-parts/market-detail/hero',
            null,
            array( 'banner' => $banner )
        );
        ?>

        <div class="iec_background_image_section iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center">

            <?php
            get_template_part(
                'template-parts/market-detail/enquiry-section',
                null,
                array(
                    'caption'            => $fields['caption'] ?? '',
                    'content'            => $fields['content'] ?? '',
                    'downloads'          => $fields['downloads'] ?? array(),
                    'countries'          => $countries,
                    'form_interests'     => $form_interests,
                    'hear_source'        => $hear_source,
                    'success_popup_html' => $success_popup_html,
                )
            );

            if ( ! empty( $fields['recommended_solutions'] ) && is_array( $fields['recommended_solutions'] ) ) {
                get_template_part(
                    'template-parts/market-detail/recommended-solutions',
                    null,
                    array(
                        'solutions'              => $fields['recommended_solutions'],
                        'hero_has_image'         => $has_hero_image,
                        'primary_thumb_assigned' => false,
                    )
                );
            }

            if ( ! empty( $fields['needs'] ) && is_array( $fields['needs'] ) ) {
                get_template_part(
                    'template-parts/market-detail/needs-accordion',
                    null,
                    array( 'needs' => $fields['needs'] )
                );
            }

            $recommended_products = ! empty( $fields['recommended_products'] ) && is_array( $fields['recommended_products'] )
                ? $fields['recommended_products']
                : array();

            iec_module(
                'products',
                array(
                    'heading'   => __( 'Recommended Products', 'bbtheme' ),
                    'products'  => $recommended_products,
                    'show_btn'  => true,
                    'block'     => array( 'link' => false ),
                    'post_type' => 'product',
                )
            );
            ?>

        </div>
    </main>

<?php
endwhile;

get_footer();
