<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$footer_heading        = get_config( 'footer_heading' );
$footer_copyright_text = get_config( 'footer_copyright_text' );
$footer_social_links   = get_config( 'footer_social_links' );
$cookie_notice         = get_config( 'cookie_notice' );
$privacy_policy_page   = get_config( 'iec_privacy_policy_page' );
$current_language = apply_filters( 'wpml_current_language', null );

?>
<footer>
    <?php
    if ( function_exists( 'iec_should_show_footer_enquiry_form' ) && iec_should_show_footer_enquiry_form() ) {
        get_template_part( 'template-parts/modules/contact-form' );
    }
    ?>

    <div class="iec_news_main_footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="iec_news_main_footer_top">
                        <div class="iec_news_main_footer_about">
                            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="iec_footer_logo">
                                <?php
                                $footer_logo     = get_config( 'header_logo_white' );
                                $footer_logo_url = iec_resolve_media_to_url( $footer_logo );
                                $footer_logo_alt = is_array( $footer_logo ) ? (string) ( $footer_logo['alt'] ?? '' ) : '';
                                if ( ! $footer_logo_url ) {
                                    $footer_logo     = get_config( 'header_logo' );
                                    $footer_logo_url = iec_resolve_media_to_url( $footer_logo );
                                    $footer_logo_alt = is_array( $footer_logo ) ? (string) ( $footer_logo['alt'] ?? '' ) : '';
                                }
                                if ( '' === $footer_logo_alt ) {
                                    $footer_logo_alt = 'IEC Telecom';
                                }
                                ?>
                                <?php if ( $footer_logo_url ) : ?>
                                    <img class="logo_light" src="<?php echo esc_url( $footer_logo_url ); ?>" alt="<?php echo esc_attr( $footer_logo_alt ); ?>">
                                <?php endif; ?>
                            </a>
                        </div>
                        <div class="iec_footer_menu_warper">
                            <?php
                            $footer_menu_cols = array(
                                array(
                                    'location' => 'footer-solutions',
                                    'title'    => __( 'Solutions', 'bbtheme' ),
                                ),
                                array(
                                    'location' => 'footer-industries',
                                    'title'    => __( 'Industries', 'bbtheme' ),
                                ),
                                array(
                                    'location' => 'footer-services',
                                    'title'    => __( 'Services', 'bbtheme' ),
                                ),
                                array(
                                    'location' => 'footer-resources',
                                    'title'    => __( 'Resources', 'bbtheme' ),
                                ),
                                array(
                                    'location' => 'footer-company',
                                    'title'    => __( 'Company', 'bbtheme' ),
                                ),
                            );

                            foreach ( $footer_menu_cols as $footer_col ) :
                                $menu_id = function_exists( 'iec_get_nav_menu_id_for_location' )
                                    ? iec_get_nav_menu_id_for_location( $footer_col['location'] )
                                    : 0;

                                if ( ! $menu_id && ! has_nav_menu( $footer_col['location'] ) ) {
                                    continue;
                                }
                                ?>
                                <div class="iec-footer-col">
                                    <h4><?php echo $footer_col['title']; ?></h4>
                                    <?php
                                    $menu_args = array(
                                        'walker'      => new WPML_Fallback_Walker_Nav_Menu(),
                                        'container'   => false,
                                        'depth'       => 1,
                                        'fallback_cb' => false,
                                        'items_wrap'  => '<ul>%3$s</ul>',
                                    );

                                    if ( $menu_id ) {
                                        $menu_args['menu'] = $menu_id;
                                    } else {
                                        $menu_args['theme_location'] = $footer_col['location'];
                                    }

                                    wp_nav_menu( $menu_args );
                                    ?>
                                </div>
                            <?php endforeach; ?>
                        </div>

                        <!-- Subscribe -->
                        <div class="iec_footer_newsletter">
                            <h4><?php echo __( 'Stay Connected', 'bbtheme' ); ?></h4>
                            <p><?php echo __( 'Subscribe for company news and industry insights.', 'bbtheme' ); ?></p>
                            <form>
                                <input type="email" placeholder="<?php echo esc_attr__( 'Enter your email', 'bbtheme' ); ?>">
                                <button type="submit" aria-label="<?php echo esc_attr__( 'Subscribe', 'bbtheme' ); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path d="M3.74902 9.00011H14.2502M8.99962 14.2507L14.2502 9.00011L8.99962 3.74951" stroke="#1B204C" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="iec_footer_bottom">
                        <div class="iec_footer_bottom_content">
                            <p>&copy; <?php echo gmdate( 'Y' ); ?> IEC Telecom. <?php echo __( 'All rights reserved.', 'bbtheme' ); ?></p>
                            <ul>
                                <?php
                                $privacy_url = function_exists( 'iec_resolve_wpml_url' )
                                    ? iec_resolve_wpml_url( home_url( '/privacy/' ) )
                                    : home_url( '/privacy/' );
                                $legal_url = function_exists( 'iec_resolve_wpml_url' )
                                    ? iec_resolve_wpml_url( home_url( '/legal/' ) )
                                    : home_url( '/legal/' );
                                ?>
                                <li><a href="<?php echo esc_url( $privacy_url ); ?>"><?php echo __( 'Privacy Policy', 'bbtheme' ); ?></a></li>
                                <li><a href="<?php echo esc_url( $legal_url ); ?>"><?php echo __( 'Terms of Use', 'bbtheme' ); ?></a></li>
                            </ul>
                        </div>
                        <?php if ( ! empty( $footer_social_links ) && is_array( $footer_social_links ) ) : ?>
                            <div class="iec_footer_social_links">
                                <?php foreach ( $footer_social_links as $link ) : ?>
                                    <?php if ( empty( $link['link'] ) ) : ?>
                                        <?php continue; ?>
                                    <?php endif; ?>
                                    <a href="<?php echo esc_url( $link['link'] ); ?>" target="_blank" rel="noopener noreferrer" class="<?php echo esc_attr( $link['type'] ?? '' ); ?>">
                                        <span class="screen-reader-text"><?php echo $link['type'] ?? ''; ?></span>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>


<div id="cookie-notice" class="cookie-notice-widget" style="display: none;">
    <div class="inner-content">
        <div class="message">
            <?php echo wp_kses_post( nl2br( (string) $cookie_notice ) ); ?>
        </div>
        <div class="buttons">
            <a href="#" class="accept"><?php _e( 'Accept', 'bbtheme' ); ?></a>
            <a href="#" class="reject"><?php _e( 'Decline', 'bbtheme' ); ?></a>
        </div>
        <div class="links">
            <?php if ( ! empty( $privacy_policy_page ) ) : ?>
                <a href="<?php echo esc_url( function_exists( 'iec_wpml_permalink' ) ? iec_wpml_permalink( (int) $privacy_policy_page ) : get_permalink( $privacy_policy_page ) ); ?>"><?php _e( 'Read our privacy policy', 'bbtheme' ); ?></a>
            <?php endif; ?>
        </div>
        <a href="#" class="close" aria-label="<?php esc_attr_e( 'Close cookie notice', 'bbtheme' ); ?>"></a>
    </div>
</div>

<script>
    (function() {
        function getParameterByName(name) {
            const url = new URL(window.location.href);
            return url.searchParams.get(name);
        }

        function setCookie(name, value, days) {
            const expires = new Date();
            expires.setTime(expires.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
        }

        function getCookie(name) {
            const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
            return match ? match[2] : null;
        }

        const utmParams = ['utm_source', 'utm_medium', 'utm_campaign', 'utm_id'];
        utmParams.forEach(function(param) {
            const value = getParameterByName(param);
            if (value) {
                setCookie(param, value, 30);
            }
        });

        document.addEventListener('DOMContentLoaded', function() {
            utmParams.forEach(function(param) {
                const cookieValue = getCookie(param);
                if (cookieValue) {
                    const input = document.querySelector('input[name="' + param + '"]');
                    if (input) {
                        input.value = cookieValue;
                    }
                }
            });
        });
    })();
</script>

<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TTNQ2WQ" height="0" width="0" style="display:none;visibility:hidden" title="<?php esc_attr_e( 'Google Tag Manager', 'bbtheme' ); ?>"></iframe>
</noscript>
