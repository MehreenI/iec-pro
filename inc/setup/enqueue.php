<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IEC_Asset_Loader {

	private string $ver;

	private array $starlink = array( 'maritime-starlink-landing', 'starlink-landing' );

	private array $swiper = array(
		'home-page',
		'iot-page',
		'optiview-page',
		'news-landing-page',
		't-starlink-portfolio',
		'offshore-page',
		't-vsat-portfolio',
		'voucher-management-template',
		'starlink-landing',
		'maritime-starlink-landing',
		'operator-page',
		't-market-landing',
		'satellite-internet',
	);

	private array $aos = array(
		'home-page',
		'offices-landing-page',
		'voucher-management-template',
		'offshore-page',
	);

	public function __construct() {
		$this->ver = defined( '_S_VERSION' ) ? (string) _S_VERSION : '18.35.0';
		add_action( 'wp_enqueue_scripts', array( $this, 'page_assets' ), 20 );
		add_action( 'wp_enqueue_scripts', array( $this, 'global_assets' ), 25 );
	}

	public function global_assets(): void {
		$this->style( 'iec-base', $this->asset( 'css/base.css' ) );
		$this->style( 'iec-sections', $this->asset( 'css/sections.css' ), array( 'iec-base' ) );
		$this->style( 'iec-header-footer', $this->asset( 'css/header-footer.css' ), array( 'iec-base' ) );
		$this->style( 'iec-tablet', $this->asset( 'css/tablet.css' ), array( 'iec-base' ) );
		$this->style( 'iec-responsive', $this->asset( 'css/responsive.css' ), array( 'iec-base' ) );
		$this->style( 'iec-animate', $this->asset( 'css/animate.css' ) );

		$this->script( 'iec-accordion', $this->asset( 'js/plugins/accordion-init.js' ) );
		$this->script( 'iec-popup', $this->asset( 'js/plugins/popup.js' ) );
		$this->script( 'iec-header-footer', $this->asset( 'js/plugins/header-footer.js' ), array( 'jquery' ) );

		$swiper_init = array( 'jquery' );
		if ( wp_script_is( 'iec-swiper', 'enqueued' ) ) {
			$swiper_init[] = 'iec-swiper';
		}
		$this->script( 'iec-swiper-init', $this->asset( 'js/plugins/swiper-init.js' ), $swiper_init );
		$this->script( 'iec-theme', $this->asset( 'js/plugins/iec-core.js' ), array( 'jquery', 'iec-accordion', 'iec-popup', 'iec-swiper-init' ) );

		wp_localize_script(
			'iec-theme',
			'iecConfig',
			array(
				'ajaxUrl'      => admin_url( 'admin-ajax.php' ),
				'nonce'        => wp_create_nonce( 'iec_nonce' ),
				'intlTelUtils' => $this->vendor( 'intl-tel-input-17/js/utils.js' ),
			)
		);

		$this->script( 'iec-gsap', $this->vendor( 'gsap-3.12.7/gsap.min.js' ), array(), '3.12.7' );
		$this->script( 'iec-gsap-scrolltrigger', $this->vendor( 'gsap-3.12.7/ScrollTrigger.min.js' ), array( 'iec-gsap' ), '3.12.7' );
		$this->script( 'iec-animate', $this->asset( 'js/animate.js' ), array( 'iec-gsap', 'iec-gsap-scrolltrigger' ) );

		$this->load_enquiry();
	}

	public function page_assets(): void {
		if ( is_admin() ) {
			return;
		}

		$slug = $this->slug();
		if ( ! $slug ) {
			return;
		}

		if ( in_array( $slug, $this->starlink, true ) ) {
			$this->load_starlink( $slug );
			return;
		}

		if ( $this->needs_swiper( $slug ) ) {
			$this->load_swiper();
		}

		$css = $this->find_asset( $slug, 'css' );
		$page_handle = '';
		$css_deps    = array( 'iec-sections' );
		if ( 'single-solution' === $slug ) {
			$product_css = $this->find_asset( 'single-product', 'css' );
			if ( $product_css ) {
				$this->style( 'iec-page-single-product', $product_css, array( 'iec-sections' ) );
				$css_deps[] = 'iec-page-single-product';
			}
		}
		if ( $css ) {
			$page_handle = 'iec-page-' . sanitize_title( $slug );
			$this->style( $page_handle, $css, $css_deps );
		}

		if ( in_array( $slug, $this->aos, true ) ) {
			$this->load_aos();
		}
		if ( 'home-page' === $slug ) {
			$this->script( 'iec-particles', $this->vendor( 'particles-2.0.0/particles.min.js' ), array(), '2.0.0' );
		}
		if ( 'single-product' === $slug ) {
			$this->script( 'iec-easyzoom', $this->vendor( 'easyzoom-2.6.0/easyzoom.min.js' ), array( 'jquery' ), '2.6.0', true );
		}

		$js = $this->find_asset( $slug, 'js' );
		if ( ! $js ) {
			return;
		}

		$handle = 'iec-page-' . sanitize_title( $slug );
		$this->script( $handle, $js, $this->page_js_deps( $slug ) );

		$local = $this->page_script_data( $slug );
		if ( $local ) {
			wp_localize_script( $handle, $local[0], $local[1] );
		}
	}

	private function slug(): string {
		if ( is_tax( 'news_type' ) ) {
			return 'news-landing-page';
		}

		$qid = get_queried_object_id();
		if ( $qid ) {
			$template = get_page_template_slug( $qid );
			if ( $template ) {
				$slug = str_replace( array( '.php', 'page-templates/' ), '', $template );
				$map  = array(
					'starlink-operator-page'  => 'operator-page',
					'satellite-internet-page' => 'satellite-internet',
				);
				return $map[ $slug ] ?? $slug;
			}
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
		if ( is_page() ) {
			return 'default-page';
		}

		return '';
	}

	private function needs_swiper( string $slug ): bool {
		if ( is_singular( array( 'office', 'product', 'solution', 'news', 'press-release' ) ) ) {
			return true;
		}

		return $slug && in_array( $slug, $this->swiper, true );
	}

	private function page_js_deps( string $slug ): array {
		$deps = array( 'jquery', 'iec-theme' );

		if ( $this->needs_swiper( $slug ) ) {
			$deps[] = 'iec-swiper';
		}
		if ( 'single-office' === $slug && function_exists( 'iec_needs_enquiry_assets' ) && iec_needs_enquiry_assets() ) {
			$deps[] = 'iec-enquiry-submit';
		}
		if ( 'single-product' === $slug ) {
			$deps[] = 'iec-easyzoom';
		}
		if ( 't-vsat-portfolio' === $slug ) {
			$deps[] = 'iec-gsap';
			$deps[] = 'iec-gsap-scrolltrigger';
		}
		if ( in_array( $slug, $this->aos, true ) ) {
			$deps[] = 'iec-aos';
		}
		if ( 'home-page' === $slug ) {
			$deps[] = 'iec-particles';
		}

		return $deps;
	}

	private function page_script_data( string $slug ): ?array {
		$errors  = function_exists( 'iec_enquiry_error_messages' ) ? iec_enquiry_error_messages() : array();
		$page_id = get_queried_object_id();
		$lang    = apply_filters( 'wpml_current_language', 'en' );

		$map = array(
			'about-partners-page' => array(
				'iecPartners',
				array(
					'labels' => array(
						'downloadBrochure' => __( 'Download brochure', 'bbtheme' ),
						'viewCoverageMap'  => __( 'View Coverage Map', 'bbtheme' ),
					),
				),
			),
			'become-partner-page' => array( 'iecBecomePartner', array( 'errorMessages' => $errors ) ),
			'market-detail-page'  => array( 'iecMarketDetail', array( 'errorMessages' => $errors ) ),
			'job-landing-page'    => array(
				'iecJobs',
				array(
					'errorMessages' => $errors + array(
						104 => __( 'Please upload only PDF file.', 'bbtheme' ),
					),
				),
			),
			'single-product'      => array(
				'iecProduct',
				array(
					'errorMessages' => function_exists( 'iec_product_enquiry_error_messages' )
						? iec_product_enquiry_error_messages()
						: array(),
				),
			),
			'optiview-page'       => array(
				'iecOptiview',
				array(
					'ajaxUrl' => admin_url( 'admin-ajax.php' ),
					'nonce'   => wp_create_nonce( 'iec_nonce' ),
					'action'  => 'iec_optiview_notify',
					'strings' => array(
						'invalidEmail'    => __( 'Please enter a valid email address', 'bbtheme' ),
						'requestError'    => __( 'Something went wrong. Please try again.', 'bbtheme' ),
						'rateLimited'     => __( 'Please wait a moment and try again.', 'bbtheme' ),
						'consentRequired' => __( 'Please accept the privacy policy to continue.', 'bbtheme' ),
					),
				),
			),
			't-solution-product'  => array( 'iecSpLanding', $this->sp_landing_data( $page_id, $lang ) ),
			'news-landing-page'   => array(
				'iecNewsLanding',
				function_exists( 'iec_news_landing_script_data' )
					? iec_news_landing_script_data( $lang )
					: array(),
			),
		);

		return $map[ $slug ] ?? null;
	}

	private function sp_landing_data( int $page_id, $lang ): array {
		$show = function_exists( 'iec_sp_landing_page_field' )
			? iec_sp_landing_page_field( 'show_solution', $page_id )
			: get_field( 'show_solution', $page_id );

		return array(
			'ajaxUrl'          => admin_url( 'admin-ajax.php' ),
			'action'           => 'iec_sp_landing_get_products',
			'pageId'           => $page_id,
			'postType'         => $show ? 'solution' : 'product',
			'lang'             => $lang,
			'loadingText'      => __( 'Loading..', 'bbtheme' ),
			'noResultsText'    => __( 'No results found.', 'bbtheme' ),
			'requestErrorText' => __( 'Error: Could not load results', 'bbtheme' ),
		);
	}

	private function load_enquiry( bool $force = false ): void {
		if ( ! $force && function_exists( 'iec_needs_enquiry_assets' ) && ! iec_needs_enquiry_assets() ) {
			return;
		}

		$this->style( 'iec-intl-tel-input', $this->vendor( 'intl-tel-input-17/css/intlTelInput.css' ), array(), '17' );
		$this->style( 'iec-select2', $this->vendor( 'select2-4.1.0/select2.min.css' ), array(), '4.1.0-rc.0' );
		$this->style( 'iec-flag-icon', $this->vendor( 'flag-icon-css-3.5.0/css/flag-icon.min.css' ), array( 'iec-select2' ), '3.5.0' );

		$this->script( 'iec-intl-tel-input', $this->vendor( 'intl-tel-input-17/js/intlTelInput.min.js' ), array(), '17', true );
		$this->script( 'iec-select2', $this->vendor( 'select2-4.1.0/select2.min.js' ), array( 'jquery' ), '4.1.0-rc.0', true );
		$this->script( 'iec-intl-tel-input-utils', $this->vendor( 'intl-tel-input-17/js/utils.js' ), array( 'iec-intl-tel-input' ), '17' );
		$this->script( 'iec-phone-plugin', $this->asset( 'js/plugins/phone-plugin.js' ), array( 'jquery', 'iec-intl-tel-input', 'iec-intl-tel-input-utils' ) );
		$this->script( 'iec-country-select', $this->asset( 'js/plugins/country-select.js' ), array( 'jquery', 'iec-select2' ) );
		$this->script(
			'iec-enquiry-submit',
			$this->asset( 'js/plugins/enquiry-form-submit.js' ),
			array( 'jquery', 'iec-theme', 'iec-phone-plugin', 'iec-country-select' )
		);

		if ( function_exists( 'iec_enquiry_script_config' ) ) {
			wp_localize_script( 'iec-enquiry-submit', 'iecEnquiry', iec_enquiry_script_config() );
		}

		$this->script(
			'iec-turnstile',
			'https://challenges.cloudflare.com/turnstile/v0/api.js?onload=iecTurnstileOnload&render=explicit',
			array( 'iec-enquiry-submit' ),
			null
		);
	}

	private function load_aos(): void {
		$this->style( 'iec-aos', $this->vendor( 'aos-2.3.1/aos.css' ), array(), '2.3.1' );
		$this->script( 'iec-aos', $this->vendor( 'aos-2.3.1/aos.js' ), array(), '2.3.1' );
	}

	private function load_swiper(): void {
		$this->style( 'iec-swiper', $this->vendor( 'swiper-11/swiper-bundle.min.css' ), array(), '11' );
		$this->script( 'iec-swiper', $this->vendor( 'swiper-11/swiper-bundle.min.js' ), array(), '11', true );
	}

	private function load_starlink( string $slug ): void {
		$this->load_swiper();
		$this->load_enquiry( true );

		$prev = 'iec-sections';
		$sheets = array(
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

		foreach ( $sheets as $name ) {
			$path = get_template_directory() . '/assets/css/starlink_maritime/' . $name . '.css';
			if ( ! file_exists( $path ) ) {
				continue;
			}
			$handle = 'iec-starlink-' . sanitize_title( $name );
			$this->style( $handle, $this->asset( 'css/starlink_maritime/' . $name . '.css' ), array( $prev ) );
			$prev = $handle;
		}

		$page_css = $this->find_asset( $slug, 'css' );
		if ( $page_css ) {
			$this->style( 'iec-page-' . sanitize_title( $slug ), $page_css, array( $prev ) );
		}

		$this->script( 'iec-starlink-phone', $this->asset( 'js/starlink_maritime/phone-input.js' ), array( 'jquery', 'iec-intl-tel-input', 'iec-intl-tel-input-utils', 'iec-phone-plugin' ) );
		$this->script( 'iec-starlink-custom', $this->asset( 'js/starlink_maritime/custom.js' ), array( 'jquery', 'iec-swiper', 'iec-theme' ) );
		$this->script( 'iec-starlink-utm', $this->asset( 'js/starlink_maritime/utm.js' ) );
	}

	private function find_asset( string $slug, string $type ): ?string {
		foreach ( array( "assets/{$type}/{$slug}.{$type}", "assets/{$type}/pages/{$slug}.{$type}" ) as $path ) {
			if ( file_exists( get_template_directory() . '/' . $path ) ) {
				return get_template_directory_uri() . '/' . $path;
			}
		}

		return null;
	}

	private function style( string $handle, string $src, array $deps = array(), $ver = null ): void {
		wp_enqueue_style( $handle, $src, $deps, null === $ver ? $this->ver : $ver );
	}

	private function script( string $handle, string $src, array $deps = array( 'jquery' ), $ver = null, bool $defer = false ): void {
		wp_enqueue_script( $handle, $src, $deps, null === $ver ? $this->ver : $ver, true );
		if ( $defer ) {
			wp_script_add_data( $handle, 'strategy', 'defer' );
		}
	}

	private function asset( string $rel ): string {
		return get_template_directory_uri() . '/assets/' . ltrim( $rel, '/' );
	}

	private function vendor( string $rel ): string {
		return get_template_directory_uri() . '/assets/vendor/' . ltrim( $rel, '/' );
	}
}

new IEC_Asset_Loader();
