<?php
/**
 * Template Name: Home Page v2
 *
 * @package iec
 */

get_header();

while ( have_posts() ) :
    the_post();

    $fields = get_fields() ?: array();

    $fields           = get_fields() ?: array();
    $hero             = $fields['hero_section'] ?? array();
    $vertical_markets = $fields['vertical_markets'] ?? array();
    $show_banner      = (bool) get_field( 'show_banner' );
    ?>

    <main id="main" class="iec-home-main">

        <?php
        get_template_part( 'template-parts/home/hero', null, array( 'hero' => $fields['hero_section'] ?? array() ) );

        get_template_part(
            'template-parts/home/partners',
            'marquee',
            array(
                'partners' => $fields['our_partners'] ?? array(),
                'label'    => $fields['partners_label'] ?? '',
            )
        );

        if ( ! isset( $fields['show_about'] ) || ! empty( $fields['show_about'] ) ) {
            get_template_part(
                'template-parts/home/about',
                null,
                array(
                    'section' => $fields['about_section'] ?? array(),
                )
            );
        }

        if ( ! empty( $fields['show_section'] ) ) {
            get_template_part( 'template-parts/home/solutions', null, array( 'section' => $fields['solution_section'] ?? array() ) );
        }

        if ( ! empty( $fields['show_services'] ) ) {
            get_template_part( 'template-parts/home/services', null, array( 'section' => $fields['services'] ?? array() ) );
        }

        if ( ! empty( $fields['show_industries'] ) ) {
            get_template_part( 'template-parts/home/industries', null, array( 'section' => $fields['industries'] ?? array() ) );
        }

        get_template_part( 'template-parts/home/section', 'cards', array( 'section' => $fields['why_us'] ?? array() ) );

        if ( ! empty( $fields['show_regional_offices'] ) ) {
            get_template_part( 'template-parts/home/regional', 'offices', array( 'section' => $fields['regional_offices'] ?? array() ) );
        }

        if ( ! empty( $fields['show_network_layers'] ) ) {
            get_template_part( 'template-parts/home/network', 'layers', array( 'section' => $fields['network_layer_section'] ?? array() ) );
        }
        ?>

        <?php get_template_part( 'template-parts/home/insights', 'resources' ); ?>

        <?php
        $contact = $fields['contact_us'] ?? array();
        get_template_part(
            'template-parts/modules/contact-form',
            null,
            array(
                'eyebrow' => $contact['eyebrow'] ?? '',
                'heading' => $contact['heading'] ?? '',
                'content' => $contact['content'] ?? '',
            )
        );
        ?>

    </main>

<?php
endwhile;

get_footer();