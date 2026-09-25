<?php
/**
 * Template Name: Contact Us
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

while ( have_posts() ) :
    the_post();

    $fields = get_fields() ?: array();
    $hero   = $fields['hero'] ?? array();
    ?>

    <main id="main" class="iec-contact-us-main t-contact-us">

        <?php
        get_template_part(
            'template-parts/contact-us/hero',
            null,
            array( 'hero' => $hero )
        );

        get_template_part(
            'template-parts/contact-us/contact-form',
            null,
            array(
                'form_heading' => __( 'Contact Us', 'bbtheme' ),
                'form_type'    => 'enquiry',
            )
        );

        get_template_part(
            'template-parts/contact-us/regional-offices',
            null,
            array(
                'heading' => $fields['heading'] ?? '',
                'offices' => $fields['regional_office'] ?? array(),
            )
        );
        ?>

    </main>

<?php
endwhile;

get_footer();
