<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class IEC_Asset_Loader {

    private string $ver;

    private array $preload_style_handles = array();

    private array $starlink_templates = array(
        'maritime-starlink-landing',
        'starlink-landing',
    );

    private array $no_swiper_templates = array(
        'about-introduction-page',
        'about-history-page',
        'about-management-page',
        'about-partners-page',
        'become-partner-page',
        'contact-us',
        'job-landing-page',
        'market-detail-page',
        't-market-landing',
        't-solution-product',
        'thankyou-landing',
        'vas-detail-page',
        'vas-landing-page',
        'offices-landing-page',
        'starlink-operator-page',
    );

    private array $swiper_templates = array(
        'home-page',
        'iot-page',
        'optiview-page',
        'news-landing-page',
        't-starlink-portfolio',
        'offshore-page',
        'tunisian-landing-page',
        't-vsat-portfolio',
        'voucher-management-template',
        'starlink-landing',
        'maritime-starlink-landing',
    );

    private array $aos_templates = array(
        'home-page',
        'offices-landing-page',
        'voucher-management-template',
        'offshore-page',
    );

    public function __construct() {
        $this->ver = defined( '_S_VERSION' ) ? (string) _S_VERSION : (string) wp_get_theme()->get( 'Version' );
        add_action( 'wp_enqueue_scripts', array( $this, 'global_assets' ), 20 );
        add_action( 'wp_enqueue_scripts', array( $this, 'page_assets' ), 25 );
        add_filter( 'style_loader_tag', array( $this, 'preload_style_tag' ), 10, 4 );
    }

    private function slug(): string {
        if ( is_tax( 'news_type' ) ) {
            return 'news-landing-page';
        }

        $qid = get_queried_object_id();

        if ( $qid ) {
            $template = get_page_template_slug( $qid );
            if ( $template ) {
                return str_replace( array( '.php', 'page-templates/' ), '', $template );
            }
        }

        if ( is_page() ) {
            return 'default-page';
        }

        if ( is_singular( 'product' ) ) {
            return 'single-product';
        }

        if ( is_singular( 'office' ) ) {
            return 'single-office';
        }

        if ( is_singular( 'solution' ) ) {
            return 'single-solution';
        }

        if ( is_singular( array( 'news', 'press-release' ) ) ) {
            return 'single-news';
        }

        if ( is_search() ) {
            return 'search';
        }

        return '';
    }

    private function is_starlink( string $slug ): bool {
        return in_array( $slug, $this->starlink_templates, true );
    }

    private function needs_swiper( string $slug ): bool {
        if ( is_singular( array( 'office', 'product', 'solution', 'news', 'press-release' ) ) ) {
            return true;
        }

        if ( ! $slug || in_array( $slug, $this->no_swiper_templates, true ) ) {
            return false;
        }

        return in_array( $slug, $this->swiper_templates, true );
    }

    private function needs_aos( string $slug ): bool {
        return in_array( $slug, $this->aos_templates, true );
    }

    private function find_asset( string $slug, string $type ): ?string {
        $paths = array(
            "{$type}/{$slug}.{$type}",
            "{$type}/pages/{$slug}.{$type}",
        );

        foreach ( $paths as $path ) {
            if ( file_exists( $this->asset_path( $path ) ) ) {
                return $this->asset( $path );
            }
        }

        return null;
    }

    private function page_style_handle( string $slug ): string {
        return 'iec-page-' . sanitize_title( $slug );
    }

    public function global_assets(): void {
        wp_enqueue_style( 'iec-base',           $this->asset( 'css/base.css' ),                 array(),                    $this->ver );
        wp_enqueue_style( 'iec-header-footer',  $this->asset( 'css/header-footer.css' ),        array( 'iec-base' ),        $this->ver );
        wp_enqueue_style( 'iec-sections',       $this->asset( 'css/sections.css' ),             array( 'iec-header-footer' ), $this->ver );
        wp_enqueue_style( 'iec-tablet',         $this->asset( 'css/tablet.css' ),               array( 'iec-header-footer' ), $this->ver );
        wp_enqueue_style( 'iec-responsive',     $this->asset( 'css/responsive.css' ),           array( 'iec-header-footer' ), $this->ver );

        $this->preload_style_handles[] = 'iec-base';
        $this->preload_style_handles[] = 'iec-header-footer';

        wp_enqueue_script(
            'iec-header-footer',
            $this->asset( 'js/plugins/header-footer.js' ),
            array( 'jquery' ),
            $this->ver,
            true
        );

        wp_enqueue_script( 'iec-accordion', $this->asset( 'js/plugins/accordion-init.js' ), array( 'jquery' ), $this->ver, true );
        wp_localize_script(
            'iec-accordion',
            'iecPartners',
            array(
                'labels' => array(
                    'downloadBrochure' => __( 'Download brochure', 'bbtheme' ),
                    'viewCoverageMap'  => __( 'View Coverage Map', 'bbtheme' ),
                ),
            )
        );
        wp_enqueue_script( 'iec-popup', $this->asset( 'js/plugins/popup.js' ), array( 'jquery' ), $this->ver, true );

        wp_enqueue_script(
            'iec-theme',
            $this->asset( 'js/plugins/iec-core.js' ),
            array( 'jquery', 'iec-header-footer', 'iec-accordion', 'iec-popup' ),
            $this->ver,
            true
        );
        wp_localize_script(
            'iec-theme',
            'iecConfig',
            array(
                'ajaxUrl' => admin_url( 'admin-ajax.php' ),
                'nonce'   => wp_create_nonce( 'iec_nonce' ),
            )
        );

        wp_enqueue_style( 'iec-animate', $this->asset( 'css/animate.css' ), array(), $this->ver );

        wp_enqueue_script(
            'iec-gsap',
            $this->vendor( 'gsap-3.12.7/gsap.min.js' ),
            array(),
            '3.12.7',
            true
        );
        wp_enqueue_script(
            'iec-gsap-scrolltrigger',
            $this->vendor( 'gsap-3.12.7/ScrollTrigger.min.js' ),
            array( 'iec-gsap' ),
            '3.12.7',
            true
        );
        wp_enqueue_script(
            'iec-animate',
            $this->asset( 'js/animate.js' ),
            array( 'iec-gsap', 'iec-gsap-scrolltrigger' ),
            $this->ver,
            true
        );

        $this->load_enquiry_assets();
    }

    private function load_enquiry_assets( bool $force = false ): void {
        if ( ! $force && function_exists( 'iec_needs_enquiry_assets' ) && ! iec_needs_enquiry_assets() ) {
            return;
        }

        wp_enqueue_style(
            'iec-intl-tel-input',
            $this->vendor( 'intl-tel-input-17/css/intlTelInput.css' ),
            array(),
            '17'
        );
        wp_enqueue_style(
            'iec-select2',
            $this->vendor( 'select2-4.1.0/select2.min.css' ),
            array(),
            '4.1.0-rc.0'
        );
        wp_enqueue_style(
            'iec-flag-icon',
            $this->vendor( 'flag-icon-css-3.5.0/css/flag-icon.min.css' ),
            array( 'iec-select2' ),
            '3.5.0'
        );

        wp_enqueue_script(
            'iec-intl-tel-input',
            $this->vendor( 'intl-tel-input-17/js/intlTelInput.min.js' ),
            array(),
            '17',
            true
        );
        wp_script_add_data( 'iec-intl-tel-input', 'strategy', 'defer' );

        wp_enqueue_script(
            'iec-select2',
            $this->vendor( 'select2-4.1.0/select2.min.js' ),
            array( 'jquery' ),
            '4.1.0-rc.0',
            true
        );
        wp_script_add_data( 'iec-select2', 'strategy', 'defer' );

        wp_enqueue_script(
            'iec-phone-plugin',
            $this->asset( 'js/plugins/phone-plugin.js' ),
            array( 'jquery', 'iec-intl-tel-input' ),
            $this->ver,
            true
        );
        wp_enqueue_script(
            'iec-country-select',
            $this->asset( 'js/plugins/country-select.js' ),
            array( 'jquery', 'iec-select2' ),
            $this->ver,
            true
        );
        wp_enqueue_script(
            'iec-interest-select',
            $this->asset( 'js/plugins/interest-select.js' ),
            array( 'jquery', 'iec-select2' ),
            $this->ver,
            true
        );
        wp_enqueue_script(
            'iec-hear-select',
            $this->asset( 'js/plugins/hear-select.js' ),
            array( 'jquery', 'iec-select2' ),
            $this->ver,
            true
        );

        wp_enqueue_script(
            'iec-enquiry-submit',
            $this->asset( 'js/plugins/enquiry-form-submit.js' ),
            array(
                'jquery',
                'iec-theme',
                'iec-phone-plugin',
                'iec-country-select',
                'iec-interest-select',
                'iec-hear-select',
            ),
            $this->ver,
            true
        );

        if ( function_exists( 'iec_enquiry_script_config' ) ) {
            wp_localize_script( 'iec-enquiry-submit', 'iecEnquiry', iec_enquiry_script_config() );
        }

        wp_enqueue_script(
            'iec-turnstile',
            'https://challenges.cloudflare.com/turnstile/v0/api.js?onload=iecTurnstileOnload&render=explicit',
            array( 'iec-enquiry-submit' ),
            null,
            true
        );
        wp_script_add_data( 'iec-turnstile', 'strategy', 'async' );
    }

    public function page_assets(): void {
        if ( is_admin() ) {
            return;
        }

        $slug = $this->slug();

        if ( ! $slug ) {
            return;
        }

        if ( $this->is_starlink( $slug ) ) {
            $this->load_starlink_assets( $slug );
            return;
        }

        if ( $this->needs_swiper( $slug ) ) {
            $this->load_swiper();
        }

        $css = $this->find_asset( $slug, 'css' );
        if ( $css ) {
            $handle = $this->page_style_handle( $slug );
            wp_enqueue_style( $handle, $css, array( 'iec-responsive' ), $this->ver );
            $this->preload_style_handles[] = $handle;
        }

        if ( $this->needs_aos( $slug ) ) {
            $this->load_aos();
        }

        if ( 'home-page' === $slug ) {
            $this->load_particles();
        }

        if ( 'single-product' === $slug ) {
            $this->load_easyzoom();
        }

        $js = $this->find_asset( $slug, 'js' );
        if ( ! $js ) {
            return;
        }

        $js_deps = array( 'jquery', 'iec-theme' );

        if ( $this->needs_swiper( $slug ) ) {
            $js_deps[] = 'iec-swiper';
            $js_deps[] = 'iec-swiper-init';
        }

        if ( 'single-office' === $slug && function_exists( 'iec_needs_enquiry_assets' ) && iec_needs_enquiry_assets() ) {
            $js_deps[] = 'iec-enquiry-submit';
        }

        if ( 'single-product' === $slug ) {
            $js_deps[] = 'iec-easyzoom';
        }

        if ( $this->needs_aos( $slug ) ) {
            $js_deps[] = 'iec-aos';
        }

        if ( 'home-page' === $slug ) {
            $js_deps[] = 'iec-particles';
        }

        $handle = 'iec-page-' . sanitize_title( $slug );
        wp_enqueue_script( $handle, $js, $js_deps, $this->ver, true );
        $this->localize_page_script( $handle, $slug );
    }

    private function localize_page_script( string $handle, string $slug ): void {
        $enquiry_pages = array(
            'become-partner-page' => 'iecBecomePartner',
            'iot-page'            => 'iecIot',
            'market-detail-page'  => 'iecMarketDetail',
        );

        if ( isset( $enquiry_pages[ $slug ] ) ) {
            $this->localize_enquiry_errors( $handle, $enquiry_pages[ $slug ] );
            return;
        }

        if ( 'job-landing-page' === $slug ) {
            $this->localize_enquiry_errors(
                $handle,
                'iecJobs',
                array(
                    104 => __( 'Please upload only PDF file.', 'bbtheme' ),
                )
            );
            return;
        }

        if ( 'single-product' === $slug ) {
            wp_localize_script(
                $handle,
                'iecProduct',
                array(
                    'errorMessages' => function_exists( 'iec_product_enquiry_error_messages' )
                        ? iec_product_enquiry_error_messages()
                        : array(),
                )
            );
            return;
        }

        if ( 't-solution-product' === $slug ) {
            $page_id       = get_queried_object_id();
            $show_solution = function_exists( 'get_field' ) ? get_field( 'show_solution', $page_id ) : false;

            wp_localize_script(
                $handle,
                'iecSpLanding',
                array(
                    'ajaxUrl'          => admin_url( 'admin-ajax.php' ),
                    'action'           => 'iec_sp_landing_get_products',
                    'pageId'           => $page_id,
                    'postType'         => $show_solution ? 'solution' : 'product',
                    'lang'             => apply_filters( 'wpml_current_language', 'en' ),
                    'loadingText'      => __( 'Loading..', 'bbtheme' ),
                    'noResultsText'    => __( 'No results found.', 'bbtheme' ),
                    'requestErrorText' => __( 'Error: Could not load results', 'bbtheme' ),
                )
            );
            return;
        }

        if ( 'news-landing-page' === $slug ) {
            wp_localize_script(
                $handle,
                'iecNewsLanding',
                array(
                    'restUrl'   => esc_url_raw( rest_url( 'iec-news/v1/data' ) ),
                    'page'      => 1,
                    'category'  => function_exists( 'iec_news_landing_current_category' ) ? iec_news_landing_current_category() : ( isset( $_GET['category'] ) ? sanitize_text_field( wp_unslash( $_GET['category'] ) ) : '' ),
                    'industry'  => isset( $_GET['industry'] ) ? sanitize_text_field( wp_unslash( $_GET['industry'] ) ) : '',
                    'location'  => isset( $_GET['location'] ) ? sanitize_text_field( wp_unslash( $_GET['location'] ) ) : '',
                    'lang'      => apply_filters( 'wpml_current_language', 'en' ),
                    'noResults' => __( 'No results found.', 'bbtheme' ),
                    'errorText' => __( 'Unable to load news.', 'bbtheme' ),
                )
            );
        }
    }

    private function localize_enquiry_errors( string $handle, string $object, array $extra = array() ): void {
        $messages = function_exists( 'iec_enquiry_error_messages' ) ? iec_enquiry_error_messages() : array();

        wp_localize_script(
            $handle,
            $object,
            array(
                'errorMessages' => $messages + $extra,
            )
        );
    }

    public function preload_style_tag( string $html, string $handle, string $href, string $media ): string {
        if ( ! in_array( $handle, $this->preload_style_handles, true ) ) {
            return $html;
        }

        return sprintf(
            '<link rel="preload" as="style" href="%1$s" onload="this.onload=null;this.rel=\'stylesheet\'">' . "\n" .
            '<noscript><link rel="stylesheet" href="%1$s"></noscript>' . "\n",
            esc_url( $href )
        );
    }

    private function load_aos(): void {
        wp_enqueue_style( 'iec-aos', $this->vendor( 'aos-2.3.1/aos.css' ), array(), '2.3.1' );
        wp_enqueue_script( 'iec-aos', $this->vendor( 'aos-2.3.1/aos.js' ), array(), '2.3.1', true );
    }

    private function load_particles(): void {
        wp_enqueue_script(
            'iec-particles',
            'https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js',
            array(),
            '2.0.0',
            true
        );
    }

    private function load_easyzoom(): void {
        wp_enqueue_script(
            'iec-easyzoom',
            $this->vendor( 'easyzoom-2.6.0/easyzoom.min.js' ),
            array( 'jquery' ),
            '2.6.0',
            true
        );
        wp_script_add_data( 'iec-easyzoom', 'strategy', 'defer' );
    }

    private function load_swiper(): void {
        wp_enqueue_style(
            'iec-swiper',
            $this->vendor( 'swiper-11/swiper-bundle.min.css' ),
            array(),
            '11'
        );

        wp_enqueue_script(
            'iec-swiper',
            $this->vendor( 'swiper-11/swiper-bundle.min.js' ),
            array(),
            '11',
            true
        );

        wp_enqueue_script(
            'iec-swiper-init',
            $this->asset( 'js/plugins/swiper-init.js' ),
            array( 'jquery', 'iec-swiper' ),
            $this->ver,
            true
        );
    }

    private function load_starlink_assets( string $slug ): void {
        $dir = $this->asset_path( 'css/starlink_maritime' );

        $this->load_swiper();

        $starlink_styles = array(
            'fonts',
            'reset',
            'index',
            'starlink-standart',
            'banner',
            'benefits',
            'sections-content',
            'video-section',
            'info-section',
            'functionality',
            'directions',
            'acordions',
            'custom',
        );

        $prev_handle = 'iec-responsive';

        foreach ( $starlink_styles as $name ) {
            $file = "{$dir}/{$name}.css";
            if ( ! file_exists( $file ) ) {
                continue;
            }

            $handle = 'iec-starlink-' . sanitize_title( $name );
            wp_enqueue_style(
                $handle,
                $this->asset( "css/starlink_maritime/{$name}.css" ),
                array( $prev_handle ),
                $this->ver
            );
            $prev_handle = $handle;
        }

        $page_css = $this->find_asset( $slug, 'css' );
        if ( $page_css ) {
            $handle = $this->page_style_handle( $slug );
            wp_enqueue_style( $handle, $page_css, array( $prev_handle ), $this->ver );
            $this->preload_style_handles[] = $handle;
        }

        $this->load_enquiry_assets( true );

        wp_enqueue_script(
            'iec-intl-tel-input-utils',
            $this->vendor( 'intl-tel-input-17/js/utils.js' ),
            array( 'iec-intl-tel-input' ),
            '17',
            true
        );

        wp_enqueue_script(
            'iec-starlink-phone',
            $this->asset( 'js/starlink_maritime/phone-input.js' ),
            array( 'jquery', 'iec-intl-tel-input', 'iec-intl-tel-input-utils', 'iec-phone-plugin' ),
            $this->ver,
            true
        );
        wp_enqueue_script(
            'iec-starlink-custom',
            $this->asset( 'js/starlink_maritime/custom.js' ),
            array( 'jquery', 'iec-swiper', 'iec-theme' ),
            $this->ver,
            true
        );
        wp_enqueue_script(
            'iec-starlink-form',
            $this->asset( 'js/starlink_maritime/stralink_form.js' ),
            array( 'jquery', 'iec-starlink-phone', 'iec-enquiry-submit' ),
            $this->ver,
            true
        );
        wp_enqueue_script(
            'iec-starlink-utm',
            $this->asset( 'js/starlink_maritime/utm.js' ),
            array( 'jquery' ),
            $this->ver,
            true
        );
    }

    private function asset_path( string $rel ): string {
        return get_template_directory() . '/assets/' . ltrim( $rel, '/' );
    }

    private function asset( string $rel ): string {
        return get_template_directory_uri() . '/assets/' . ltrim( $rel, '/' );
    }

    private function vendor( string $rel ): string {
        return $this->asset( 'vendor/' . ltrim( $rel, '/' ) );
    }
}

new IEC_Asset_Loader();
