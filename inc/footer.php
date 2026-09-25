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
                            <a href="<?= esc_url( home_url( '/' ) ); ?>" class="iec_footer_logo">
                                <img class="logo_light" src="/wp-content/uploads/2020/03/logo-white.svg" alt="IEC TELECOM LOGO">
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
                                    <h4><?= $footer_col['title']; ?></h4>
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
                            <h4><?= 'Stay Connected'; ?></h4>
                            <p><?= 'Subscribe for company news and industry insights.'; ?></p>
                            <form>
                                <input type="email" placeholder="<?= esc_attr__( 'Enter your email', 'bbtheme' ); ?>">
                                <button type="submit" aria-label="<?= esc_attr__( 'Subscribe', 'bbtheme' ); ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                        <path d="M3.74902 9.00011H14.2502M8.99962 14.2507L14.2502 9.00011L8.99962 3.74951" stroke="#1B204C" stroke-width="2" stroke-linecap="round"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="iec_footer_bottom">
                        <div class="iec_footer_bottom_content">
                            <p>&copy; <?= gmdate( 'Y' ); ?> IEC Telecom. <?= 'All rights reserved.'; ?></p>
                            <ul>
                                <?php
                                $privacy_url = function_exists( 'iec_resolve_wpml_url' )
                                    ? iec_resolve_wpml_url( home_url( '/privacy/' ) )
                                    : home_url( '/privacy/' );
                                $legal_url = function_exists( 'iec_resolve_wpml_url' )
                                    ? iec_resolve_wpml_url( home_url( '/legal/' ) )
                                    : home_url( '/legal/' );
                                ?>
                                <li>
									<a href="<?= esc_url( $privacy_url ); ?>">
										<?= 'Privacy Policy'; ?>
									</a>
								</li>

								<li>
									<a href="<?= esc_url( $legal_url ); ?>">
										<?= 'Legal Notice'; ?>
									</a>
								</li>  
							</ul>
                        </div>
                        <?php if ( ! empty( $footer_social_links ) && is_array( $footer_social_links ) ) : ?>
                            <div class="iec_footer_social_links">
                                <?php foreach ( $footer_social_links as $link ) : ?>
                                    <?php if ( empty( $link['link'] ) ) : ?>
                                        <?php continue; ?>
                                    <?php endif; ?>
                                    <a href="<?= esc_url( $link['link'] ); ?>" target="_blank" rel="noopener noreferrer" class="<?= esc_attr( $link['type'] ?? '' ); ?>">
                                        <span class="screen-reader-text"><?= $link['type'] ?? ''; ?></span>
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
            <?= wp_kses_post( nl2br( (string) $cookie_notice ) ); ?>
        </div>
        <div class="buttons">
            <a href="#" class="accept"><?= 'Accept'; ?></a>
            <a href="#" class="reject"><?= 'Decline'; ?></a>
        </div>
        <div class="links">
            <?php if ( ! empty( $privacy_policy_page ) ) : ?>
                <a href="<?= esc_url( function_exists( 'iec_wpml_permalink' ) ? iec_wpml_permalink( (int) $privacy_policy_page ) : get_permalink( $privacy_policy_page ) ); ?>"><?= 'Read our privacy policy'; ?></a>
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

<!-- <script>
document.addEventListener('DOMContentLoaded', function() {
	const starlinkSubMenu = document.querySelector('#menu-new-secondary-menu-1 > li:nth-child(6) > .sub-menu');

	if (!starlinkSubMenu) {
		return;
	}

	const allItems = starlinkSubMenu.querySelectorAll('li.menu-item-has-children');

	allItems.forEach(function(item) {
		const link = item.querySelector('a');
		if (!link) {
			return;
		}
		const linkText = link.textContent.trim();
		if (linkText === 'OUR OFFER' || linkText === 'HEADQUARTERS') {
			item.classList.add('support_headquarters');
		}
	});
});
</script> -->

<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TTNQ2WQ" height="0" width="0" style="display:none;visibility:hidden" title="<?php esc_attr_e( 'Google Tag Manager', 'bbtheme' ); ?>"></iframe>
</noscript>
<script>
    document.querySelectorAll('.iec_menu_dropdown').forEach(dropdown => {
        const megaMenu = [...dropdown.parentElement.children].find(el =>
            el.classList.contains('iec_mega_menu_warpper')
        );

        dropdown.addEventListener('mouseenter', () => {
            megaMenu?.classList.add('iec_menu_visible');
        });

        dropdown.addEventListener('mouseleave', () => {
            setTimeout(() => {
                if (megaMenu && !megaMenu.matches(':hover')) {
                    megaMenu.classList.remove('iec_menu_visible');
                }
            }, 50);
        });
    });

    document.querySelectorAll('.iec_mega_menu_warpper').forEach(megaMenu => {
        megaMenu.addEventListener('mouseenter', () => {
            megaMenu.classList.add('iec_menu_visible');
        });

        megaMenu.addEventListener('mouseleave', () => {
            megaMenu.classList.remove('iec_menu_visible');
        });
    });
</script>

<script>
    jQuery(function ($) {
        $('.iec_mobile_menu_btn').on('click', function () {
            $(this).toggleClass('active');
            $('.iec_mobile_navigation').toggleClass('active');
            $('body').toggleClass('menu-open');
        });

        /* ==========================
           Top Level Accordion
        ========================== */
        $('.iec_mobile_toggle').on('click', function () {
            const parent = $(this).closest('.iec_mobile_dropdown');
            if (parent.hasClass('active')) {
                parent.removeClass('active');
                parent.find('> .iec_mobile_submenu').stop(true, true).slideUp(300);
            } else {
                $('.iec_mobile_dropdown').removeClass('active');
                $('.iec_mobile_submenu').stop(true, true).slideUp(300);
                parent.addClass('active');
                parent.find('> .iec_mobile_submenu').stop(true, true).slideDown(300);
            }
        });
        /* ==========================
           Second Level Accordion
        ========================== */
        $('.iec_mobile_card_toggle').on('click', function () {
            const card = $(this).closest('.iec_mobile_card');
            if (card.hasClass('active')) {
                card.removeClass('active');
                card.find('> .iec_mobile_links').stop(true, true).slideUp(250);
            } else {
                card
                    .siblings('.iec_mobile_card')
                    .removeClass('active')
                    .find('.iec_mobile_links')
                    .stop(true, true)
                    .slideUp(250);
                card.addClass('active');
                card.find('> .iec_mobile_links').stop(true, true).slideDown(250);
            }
        });
    });
</script>

<!-- Open in new Page  -->
<script>
jQuery(document).ready(function($) {
    var baseUrl = window.location.hostname;

    $('a').each(function() {
        var link = $(this).attr('href');

        if (link && link.indexOf('http') === 0) {
            var linkHost = $('<a>').prop('href', link).prop('hostname');

            if (linkHost !== baseUrl) {
                $(this).attr('target', '_blank');
                $(this).attr('rel', 'noopener noreferrer');
            }
        }
    });
});
</script>
