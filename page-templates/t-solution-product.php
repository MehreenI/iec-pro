<?php

/**
 * Template Name: Solution and Product Listing Page
 */

get_header();
?>

<?php
$fields       = get_fields();
$banner_image = $fields['image']['url'] ?? '';
$mobile_image = $fields['mobile_image']['url'] ?? '';
$overlay      = $fields['heading'] ?? '';
$sub_heading  = $fields['sub_heading'] ?? '';
$link_url     = function_exists( 'iec_resolve_wpml_url' )
    ? iec_resolve_wpml_url( $fields['link'] ?? array() )
    : ( $fields['link']['url'] ?? '' );
$link_title   = $fields['link']['title'] ?? __( 'Learn More', 'bbtheme' );
$link_target  = $fields['link']['target'] ?? '_self';
$sp_landing    = iec_sp_landing_page_context( get_queried_object_id() );
?>

<?php while (have_posts()) : the_post(); ?>

    <div id="main"<?= ! empty( $sp_landing['is_inner_products'] ) ? ' class="inner-products"' : ''; ?>>

        <section
                class="iec_hero_banner iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center"
            <?php if ( $banner_image ) : ?>
                style="--bgImage: url('<?= esc_url( $banner_image ); ?>');<?= $mobile_image ? " --mobileImage: url('" . esc_url( $mobile_image ) . "');" : ''; ?>"
            <?php endif; ?>
                aria-label="<?php esc_attr_e( 'Page hero', 'bbtheme' ); ?>"
        >
            <!-- Blinds/strip reveal overlay -->
            <div class="iec_hero_strips" aria-hidden="true">
                <span></span><span></span><span></span><span></span><span></span><span></span>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-5">
                        <div class="iec_hero_content_box">
                            <h1 class="iec-primary-heading js-split-reveal"><?= $overlay; ?></h1>
                            <h2 class="iec-sub-heading js-split-reveal"><?= $sub_heading; ?></h2>
                            <?php if($link_url):?>
                                <div class="btn js-fade-up">
                                    <a class="gray_btn linkto" href="<?= $link_url; ?>" target="<?= esc_attr( $link_target ); ?>"><?= $link_title; ?></a>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="iec_product_post_filter_forms filters-form">
            <form action="" id="filters-form" data-sp-landing-filters>
                <input type="hidden" name="start-at" value="<?= esc_attr( (string) $sp_landing['per_page'] ); ?>">
                <input type="hidden" name="type" value="<?= esc_attr( (string) $sp_landing['post_type'] ); ?>">
                <input type="hidden" name="category" value="<?= esc_attr( (string) ( $sp_landing['product_category'] ?? '' ) ); ?>">

                <div class="container">
                    <div class="filters-grid">

                        <?php if ( empty( $sp_landing['hide_application_filter'] ) ) : ?>
                            <div class="iec_filters_group_warpper first">

                                <div class="filters-group">
                                    <h6><?php _e( 'Application', 'bbtheme' ); ?></h6>
                                    <div class="toggle-fields-wrapper">
                                        <div class="toggle-fields-row single-column cf">
                                            <?php print_ps_filter( 'application' ); ?>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        <?php endif; ?>

                        <div class="iec_filters_group_warpper first">

                            <div class="filters-group">
                                <h6><?php _e( 'Set up', 'bbtheme' ); ?></h6>
                                <div class="toggle-fields-wrapper">
                                    <div class="toggle-fields-row single-column cf">
                                        <?php print_ps_filter( 'setup' ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="iec_filters_group_warpper second">
                            <div class="filters-group">
                                <h6><?php _e( 'Operator', 'bbtheme' ); ?></h6>
                                <div class="toggle-fields-wrapper">
                                    <div class="toggle-fields-row cf">
                                        <?php print_ps_filter( 'operator' ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="iec_filters_group_warpper third">
                            <div class="filters-group">
                                <h6><?php _e( 'Market', 'bbtheme' ); ?></h6>
                                <div class="toggle-fields-wrapper">
                                    <div class="toggle-fields-row cf">
                                        <?php print_ps_filter( 'market' ); ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        </section>

        <?php
        get_template_part(
            'template-parts/sp-landing/products',
            'section',
            $sp_landing
        );
        ?>

        <?php if($fields['show_text']):?>
            <section class="intro">
                <div class="container">
                    <div class="wyswig-content">
                        <?= $fields['content']; ?>
                    </div>
                </div>

            </section>
        <?php endif; ?>
    </div>

<?php endwhile; ?>

<?php get_footer(); ?>
