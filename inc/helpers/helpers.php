<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! function_exists( 'iec_resolve_media_to_url' ) ) {
    function iec_resolve_media_to_url( $value ) {
        if ( is_array( $value ) ) {
            if ( ! empty( $value['url'] ) ) {
                return (string) $value['url'];
            }
            $id = isset( $value['ID'] ) ? (int) $value['ID'] : 0;
            if ( $id > 0 ) {
                $url = wp_get_attachment_image_url( $id, 'large' );
                return $url ? (string) $url : '';
            }
            return '';
        }

        if ( is_numeric( $value ) && (int) $value > 0 ) {
            $url = wp_get_attachment_image_url( (int) $value, 'large' );
            return $url ? (string) $url : '';
        }

        if ( is_string( $value ) ) {
            $s = trim( $value );
            return '' !== $s ? $s : '';
        }
        return '';
    }
}

if ( ! function_exists( 'bbtheme_get_image_or_placeholder' ) ) {
    function bbtheme_get_image_or_placeholder( $url ) {
        $resolved = iec_resolve_media_to_url( $url );
        if ( $resolved !== '' ) {
            return $resolved;
        }

        return get_template_directory_uri() . '/assets/img/logo.svg';
    }
}

if ( ! function_exists( 'iec_get_post_thumbnail_url' ) ) {
    function iec_get_post_thumbnail_url( $post_id ) {
        $post_id = (int) $post_id;
        if ( $post_id < 1 ) {
            return '';
        }
        $thumb_id = get_post_thumbnail_id( $post_id );
        if ( $thumb_id < 1 ) {
            return '';
        }
        $url = wp_get_attachment_image_url( $thumb_id, 'large' );
        return $url ? (string) $url : '';
    }
}

if ( ! function_exists( 'iec_get_image_dimensions' ) ) {
    function iec_get_image_dimensions( $image, $size = 'large' ) {
        $width  = 0;
        $height = 0;

        if ( is_array( $image ) && isset( $image['width'], $image['height'] ) && (int) $image['width'] > 0 && (int) $image['height'] > 0 ) {
            return array(
                'width'  => (int) $image['width'],
                'height' => (int) $image['height'],
            );
        }

        $att_id = 0;
        if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
            $att_id = (int) $image['ID'];
        } elseif ( is_numeric( $image ) && (int) $image > 0 ) {
            $att_id = (int) $image;
        } elseif ( is_string( $image ) && trim( $image ) !== '' ) {
            $att_id = (int) attachment_url_to_postid( trim( $image ) );
        }

        if ( $att_id > 0 ) {
            $dims = wp_get_attachment_image_src( $att_id, $size );
            if ( is_array( $dims ) && ! empty( $dims[1] ) && ! empty( $dims[2] ) ) {
                $width  = (int) $dims[1];
                $height = (int) $dims[2];
            }
        }

        return array(
            'width'  => $width,
            'height' => $height,
        );
    }
}

if ( ! function_exists( 'iec_video_embed_url' ) ) {
    function iec_video_embed_url( string $url ): string {
        $url = trim( $url );
        if ( '' === $url ) {
            return '';
        }

        if ( str_contains( $url, 'youtube.com/embed' ) || str_contains( $url, 'player.vimeo.com' ) ) {
            return esc_url( $url );
        }

        if ( preg_match( '#(?:youtube\.com/watch\?v=|youtu\.be/)([a-zA-Z0-9_-]+)#', $url, $m ) ) {
            return 'https://www.youtube.com/embed/' . $m[1];
        }

        if ( preg_match( '#vimeo\.com/(?:video/)?(\d+)#', $url, $m ) ) {
            return 'https://player.vimeo.com/video/' . $m[1];
        }

        return esc_url( $url );
    }
}

function iec_module( string $name, array $args = array() ): void {
    get_template_part( 'template-parts/modules/' . $name, null, $args );
}

function iec_featured_news_image_url( $post ): string {
    $post_id = ( $post instanceof WP_Post ) ? $post->ID : (int) $post;

    if ( function_exists( 'iec_news_landing_post_image_url' ) ) {
        return iec_news_landing_post_image_url( $post_id );
    }

    if ( function_exists( 'get_field' ) ) {
        $image = get_field( 'image', $post_id );
        if ( is_array( $image ) && ! empty( $image['url'] ) ) {
            return (string) $image['url'];
        }
    }

    $thumb = get_the_post_thumbnail_url( $post_id, 'large' );
    return $thumb ? (string) $thumb : '';
}

function iec_featured_news_category_label( $post ): string {
    $post_id = ( $post instanceof WP_Post ) ? $post->ID : (int) $post;

    if ( function_exists( 'iec_news_landing_post_category_label' ) ) {
        return iec_news_landing_post_category_label( $post_id );
    }

    $terms = get_the_terms( $post_id, 'news_type' );
    if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
        return $terms[0]->name;
    }

    if ( 'press-release' === get_post_type( $post_id ) ) {
        return __( 'Press Release', 'bbtheme' );
    }

    return '';
}

function iec_config_permalink( string $config_key ): string {
    if ( ! function_exists( 'get_config' ) ) {
        return '';
    }

    $post_id = get_config( $config_key );
    if ( empty( $post_id ) ) {
        return '';
    }

    return iec_wpml_permalink( (int) $post_id );
}

function iec_extra_body_classes(): array {
    $classes = array();

    if ( is_search() ) {
        $classes[] = 'search-results-page';
        return $classes;
    }

    if ( is_tax( 'news_type' ) ) {
        $classes[] = 'news-landing-page';
        $classes[] = 'news-type-archive';
        return $classes;
    }

    if ( is_singular( 'office' ) ) {
        $classes[] = 'single-office-page';
        $classes[] = 'iec-single-office';
    } elseif ( is_singular( 'product' ) ) {
        $classes[] = 'single-product-page';
        $classes[] = 'iec-single-product';
    } elseif ( is_singular( 'solution' ) ) {
        $classes[] = 'single-solution-page';
    } elseif ( is_singular( 'press-release' ) ) {
        $classes[] = 'single-press-release-page';
        $classes[] = 'single-news-page';
    } elseif ( is_singular( 'news' ) ) {
        $classes[] = 'single-news-page';
        $slug      = function_exists( 'iec_news_single_type_slug' ) ? iec_news_single_type_slug() : 'default';
        if ( $slug ) {
            $classes[] = 'iec-single-news-' . sanitize_html_class( $slug );
        }
    }

    if ( ! is_page() ) {
        return $classes;
    }

    $map = array(
        'page-templates/offices-landing-page.php'     => array( 'offices-landing-page', 'regional-offices-page' ),
        'page-templates/optiview-page.php'            => 'optiview-page',
        'page-templates/sp-landing-page.php'          => 'sp-landing-page',
        'page-templates/t-solution-product.php'       => 't-solution-product',
        'page-templates/t-starlink-portfolio.php'     => 't-starlink-portfolio-page',
        'page-templates/thankyou-landing.php'           => array( 'thankyou-landing-page', 'thank-you' ),
        'page-templates/offshore-page.php'              => 'offshore-page',
        'page-templates/vas-detail-page.php'          => 'vas-detail-page',
        'page-templates/vas-landing-page.php'         => 'vas-landing-page',
        'page-templates/voucher-management-template.php' => array( 'voucher-management-page', 'iec-voucher-management' ),
    );

    $template = get_page_template_slug();
    if ( isset( $map[ $template ] ) ) {
        $extra = $map[ $template ];
        if ( is_array( $extra ) ) {
            $classes = array_merge( $classes, $extra );
        } else {
            $classes[] = $extra;
        }
    }

    return $classes;
}

function iec_page_fields( ?int $post_id = null ): array {
    static $cache = array();

    $post_id = $post_id ?? (int) get_the_ID();
    if ( $post_id < 1 ) {
        return array();
    }

    if ( ! isset( $cache[ $post_id ] ) ) {
        $fields = function_exists( 'get_fields' ) ? get_fields( $post_id ) : array();
        $cache[ $post_id ] = is_array( $fields ) ? $fields : array();
    }

    return $cache[ $post_id ];
}

function iec_wpml_current_language(): string {
    $lang = apply_filters( 'wpml_current_language', null );

    return ( is_string( $lang ) && '' !== $lang ) ? $lang : '';
}

function iec_sanitize_wpml_lang( $lang ): string {
    $lang = strtolower( trim( (string) $lang ) );
    $lang = preg_replace( '/[^a-z0-9\-]/', '', $lang );

    return is_string( $lang ) ? $lang : '';
}

function iec_wpml_default_language(): string {
    $lang = apply_filters( 'wpml_default_language', null );

    return ( is_string( $lang ) && '' !== $lang ) ? $lang : 'en';
}

function iec_wpml_translate_post_id( int $post_id, $post_type = null ): int {
    if ( $post_id < 1 || ! has_filter( 'wpml_object_id' ) ) {
        return $post_id;
    }

    $lang = iec_wpml_current_language();
    if ( '' === $lang ) {
        return $post_id;
    }

    if ( null === $post_type || '' === $post_type ) {
        $post_type = get_post_type( $post_id );
    }

    if ( ! $post_type ) {
        return $post_id;
    }

    $translated = apply_filters( 'wpml_object_id', $post_id, $post_type, true, $lang );

    return $translated ? (int) $translated : $post_id;
}

function iec_wpml_localize_url( string $url ): string {
    if ( '' === $url || '#' === $url ) {
        return $url;
    }

    if ( preg_match( '/^(mailto:|tel:|javascript:)/i', $url ) ) {
        return $url;
    }

    $post_id = function_exists( 'url_to_postid' ) ? (int) url_to_postid( $url ) : 0;
    if ( $post_id > 0 ) {
        $permalink = iec_wpml_permalink( $post_id );
        if ( $permalink ) {
            return $permalink;
        }
    }

    $lang = iec_wpml_current_language();
    if ( '' === $lang || ! has_filter( 'wpml_permalink' ) ) {
        return $url;
    }

    $localized = apply_filters( 'wpml_permalink', $url, $lang );

    return is_string( $localized ) && '' !== $localized ? $localized : $url;
}

function iec_wpml_permalink( $post, $post_type = null ): string {
    if ( $post instanceof WP_Post ) {
        $post_id   = (int) $post->ID;
        $post_type = $post_type ? $post_type : $post->post_type;
    } else {
        $post_id = (int) $post;
    }

    if ( $post_id < 1 ) {
        return '';
    }

    $post_id = iec_wpml_translate_post_id( $post_id, $post_type );
    $url     = get_permalink( $post_id );

    return $url ? (string) $url : '';
}

function iec_resolve_wpml_url( $link ): string {
    if ( empty( $link ) && '0' !== $link && 0 !== $link ) {
        return '';
    }

    if ( $link instanceof WP_Post || is_numeric( $link ) ) {
        return iec_wpml_permalink( $link );
    }

    if ( is_array( $link ) ) {
        if ( ! empty( $link['ID'] ) || ! empty( $link['id'] ) ) {
            $id = ! empty( $link['ID'] ) ? (int) $link['ID'] : (int) $link['id'];
            $pt = ! empty( $link['post_type'] ) ? (string) $link['post_type'] : null;
            $permalink = iec_wpml_permalink( $id, $pt );
            if ( $permalink ) {
                return $permalink;
            }
        }

        $url = isset( $link['url'] ) ? (string) $link['url'] : '';
        return iec_wpml_localize_url( $url );
    }

    return iec_wpml_localize_url( (string) $link );
}

function iec_enquiry_success_popup_html( string $form_type ): string {
    $content = get_config( 'enquiry_success_popup_content' );

    if ( is_string( $content ) ) {
        return $content;
    }

    if ( ! is_array( $content ) ) {
        return '';
    }

    $key = array_search( $form_type, array_column( $content, 'form_type' ), true );

    if ( false !== $key && isset( $content[ $key ]['content'] ) ) {
        return (string) $content[ $key ]['content'];
    }

    return '';
}

function iec_unique_countries(): array {
    static $cache = null;
    if ( null !== $cache ) {
        return $cache;
    }

    if ( ! class_exists( '\BlueBeetle\Press\Common' ) ) {
        $cache = array();
        return $cache;
    }

    $countries = \BlueBeetle\Press\Common::get_instance()->get_countries();
    if ( empty( $countries ) ) {
        $cache = array();
        return $cache;
    }

    $cache = array_values( array_map( 'unserialize', array_unique( array_map( 'serialize', $countries ) ) ) );
    return $cache;
}

function iec_page_has_primary_enquiry_form(): bool {
    if ( is_singular( 'product' ) || is_singular( 'office' ) || is_singular( 'news' ) ) {
        return true;
    }

    if ( ! is_page() ) {
        return false;
    }

    $skip_templates = array(
        'page-templates/home-page.php',
        'page-templates/contact-us.php',
        'page-templates/become-partner-page.php',
        'page-templates/iot-page.php',
        'page-templates/market-detail-page.php',
        'page-templates/thankyou-landing.php',
        'page-templates/offshore-page.php',
    );

    return in_array( get_page_template_slug(), $skip_templates, true );
}

function iec_should_show_footer_enquiry_form(): bool {
    return ! is_admin() && ! iec_page_has_primary_enquiry_form();
}

function iec_needs_enquiry_assets(): bool {
    if ( is_admin() ) {
        return false;
    }

    $slug = '';
    $qid  = get_queried_object_id();
    if ( $qid ) {
        $template = get_page_template_slug( $qid );
        if ( $template ) {
            $slug = str_replace( array( '.php', 'page-templates/' ), '', $template );
        }
    }

    $starlink = array( 'maritime-starlink-landing', 'starlink-landing' );
    if ( in_array( $slug, $starlink, true ) ) {
        return false;
    }

    if ( 'thankyou-landing' === $slug ) {
        return false;
    }

    return iec_should_show_footer_enquiry_form() || iec_page_has_primary_enquiry_form();
}

function iec_enquiry_thank_you_url(): string {
    if ( function_exists( 'iec_config_permalink' ) ) {
        foreach ( array( 'iec_thank_you_page', 'iec_thankyou_page', 'iec_enquire_page' ) as $key ) {
            $url = iec_config_permalink( $key );
            if ( $url !== '' ) {
                return $url;
            }
        }
    }

    $pages = get_posts(
        array(
            'post_type'      => 'page',
            'posts_per_page' => 1,
            'post_status'    => 'publish',
            'meta_key'       => '_wp_page_template',
            'meta_value'     => 'page-templates/thankyou-landing.php',
            'fields'         => 'ids',
        )
    );

    if ( ! empty( $pages[0] ) ) {
        $url = get_permalink( (int) $pages[0] );
        if ( $url ) {
            return $url;
        }
    }

    $lang = apply_filters( 'wpml_current_language', '' );
    if ( is_string( $lang ) && $lang !== '' && $lang !== 'en' ) {
        return trailingslashit( home_url( $lang ) ) . 'thank-you/';
    }

    return trailingslashit( home_url( '/thank-you' ) );
}

function iec_enquiry_error_messages(): array {
    return array(
        100 => __( 'Invalid method', 'bbtheme' ),
        101 => __( 'Invalid data', 'bbtheme' ),
        102 => __( 'Invalid email', 'bbtheme' ),
        103 => __( 'Captcha not validated', 'bbtheme' ),
    );
}

function iec_enquiry_script_config(): array {
    return array(
        'errorMessages' => iec_enquiry_error_messages(),
        'thankYouUrl'   => iec_enquiry_thank_you_url(),
        'odooUrl'       => home_url( '/crm_create_lead.php' ),
        'lang'          => apply_filters( 'wpml_current_language', 'en' ),
        'strings'       => array(
            'emailInvalid'      => __( 'Please enter a valid email address', 'bbtheme' ),
            'captchaRequired'   => __( 'Please complete the captcha verification', 'bbtheme' ),
            'networkError'      => __( 'Network error. Please try again.', 'bbtheme' ),
            'genericError'      => __( 'Something went wrong. Please try again.', 'bbtheme' ),
            'fieldRequired'     => __( 'This field is required', 'bbtheme' ),
            'phoneInvalid'      => __( 'Please enter a valid phone number', 'bbtheme' ),
        ),
    );
}

function iec_turnstile_site_key(): string {
    $key = '';
    if ( function_exists( 'get_config' ) ) {
        $key = (string) get_config( 'bbpress_google_captcha_site_key', '' );
    }
    return '' !== $key ? $key : '0x4AAAAAAENNS8FcNlPbWcAu';
}

function iec_turnstile_secret_key(): string {
    $key = '';
    if ( function_exists( 'get_config' ) ) {
        $key = (string) get_config( 'bbpress_google_captcha_secret_key', '' );
    }
    return '' !== $key ? $key : '0x4AAAAAAENNSwsGe_jCz5PGK53ayY4ILUw';
}

function iec_recaptcha_site_key(): string {
    return iec_turnstile_site_key();
}

function iec_turnstile_pre_http_request( $pre, $args, $url ) {
    if ( false !== $pre || ! is_string( $url ) ) {
        return $pre;
    }

    if ( false === strpos( $url, 'google.com/recaptcha/api/siteverify' )
        && false === strpos( $url, 'www.google.com/recaptcha/api/siteverify' ) ) {
        return $pre;
    }

    $secret = iec_turnstile_secret_key();
    if ( '' === $secret ) {
        return $pre;
    }

    $body = array();
    if ( ! empty( $args['body'] ) ) {
        if ( is_array( $args['body'] ) ) {
            $body = $args['body'];
        } elseif ( is_string( $args['body'] ) ) {
            parse_str( $args['body'], $body );
        }
    }

    $token = '';
    if ( ! empty( $body['response'] ) ) {
        $token = (string) $body['response'];
    } elseif ( ! empty( $_POST['cf-turnstile-response'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
        $token = sanitize_text_field( wp_unslash( $_POST['cf-turnstile-response'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
    } elseif ( ! empty( $_POST['g-recaptcha-response'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
        $token = sanitize_text_field( wp_unslash( $_POST['g-recaptcha-response'] ) ); // phpcs:ignore WordPress.Security.NonceVerification.Missing
    }

    $payload = array(
        'secret'   => $secret,
        'response' => $token,
    );
    if ( ! empty( $body['remoteip'] ) ) {
        $payload['remoteip'] = (string) $body['remoteip'];
    } elseif ( ! empty( $_SERVER['REMOTE_ADDR'] ) ) {
        $payload['remoteip'] = sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) );
    }

    remove_filter( 'pre_http_request', 'iec_turnstile_pre_http_request', 10 );
    $response = wp_remote_post(
        'https://challenges.cloudflare.com/turnstile/v0/siteverify',
        array(
            'timeout' => 15,
            'body'    => $payload,
        )
    );
    add_filter( 'pre_http_request', 'iec_turnstile_pre_http_request', 10, 3 );

    if ( is_wp_error( $response ) ) {
        return array(
            'headers'  => array(),
            'body'     => wp_json_encode(
                array(
                    'success'     => false,
                    'error-codes' => array( 'turnstile-request-failed' ),
                )
            ),
            'response' => array(
                'code'    => 200,
                'message' => 'OK',
            ),
            'cookies'  => array(),
            'filename' => null,
        );
    }

    return $response;
}
add_filter( 'pre_http_request', 'iec_turnstile_pre_http_request', 10, 3 );
