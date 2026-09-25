<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function iec_ps_filters() {
    return array(
        'application',
        'operator',
        'setup',
        'service',
        'type',
        'speed',
        'market',
        'region',
    );
}

function iec_ps_filter_items( $filter_name = null, $get_keys = false ) {
    static $built_filters = null;
    static $built_keys    = null;

    if ( null === $built_filters ) {
        $filters = array();

        $filters['application']['caption']  = 'Application';
        $filters['application']['locale']   = __( 'Application', 'bbtheme' );
        $filters['application']['required'] = false;
        $filters['application']['choices']  = array(
            array(
                'key'     => 'Maritime',
                'caption' => 'Maritime',
                'locale'  => __( 'Maritime', 'bbtheme' ),
            ),
            array(
                'key'     => 'Land',
                'caption' => 'Land',
                'locale'  => __( 'Land', 'bbtheme' ),
            ),
            array(
                'key'     => 'satellite-phones',
                'caption' => 'Satellite phones',
                'locale'  => __( 'Satellite phones', 'bbtheme' ),
            ),
        );

        $filters['operator']['caption']  = 'Operator';
        $filters['operator']['locale']   = __( 'Operator', 'bbtheme' );
        $filters['operator']['required'] = false;
        $filters['operator']['choices']  = array(
            array( 'key' => 'GlobalSatar', 'caption' => 'GlobalStar', 'locale' => __( 'GlobalStar', 'bbtheme' ) ),
            array( 'key' => 'Intesat', 'caption' => 'SES / Intelsat', 'locale' => __( 'SES / Intelsat', 'bbtheme' ) ),
            array( 'key' => 'Yahsat', 'caption' => 'Yahsat', 'locale' => __( 'Space42', 'bbtheme' ) ),
            array( 'key' => 'Iridium', 'caption' => 'Iridium', 'locale' => __( 'Iridium', 'bbtheme' ) ),
            array( 'key' => 'Inmarsat', 'caption' => 'Inmarsat', 'locale' => __( 'Inmarsat', 'bbtheme' ) ),
            array( 'key' => 'Thuraya', 'caption' => 'Space42', 'locale' => __( 'Space42', 'bbtheme' ) ),
            array( 'key' => 'Starlink', 'caption' => 'Starlink', 'locale' => __( 'Starlink', 'bbtheme' ) ),
            array( 'key' => 'Eutelsat', 'caption' => ' Eutelsat OneWeb', 'locale' => __( ' Eutelsat OneWeb', 'bbtheme' ) ),
            array( 'key' => 'Viasat', 'caption' => 'Viasat', 'locale' => __( 'Viasat', 'bbtheme' ) ),
        );

        $filters['setup']['caption']  = 'Set up';
        $filters['setup']['locale']   = __( 'Set up', 'bbtheme' );
        $filters['setup']['required'] = false;
        $filters['setup']['choices']  = array(
            array(
                'key'     => 'COTP',
                'caption' => 'COTP',
                'locale'  => __( 'COTP', 'bbtheme' ),
                'tooltip' => 'For stationary/ on the pause use only',
            ),
            array(
                'key'     => 'COTM',
                'caption' => 'COTM',
                'locale'  => __( 'COTM', 'bbtheme' ),
                'tooltip' => 'Mobile, including  maritime & vehicular use',
            ),
            array(
                'key'     => 'Portable',
                'caption' => 'Portable',
                'locale'  => __( 'Portable', 'bbtheme' ),
                'tooltip' => 'Lightweight portable terminal',
            ),
        );

        $filters['service']['caption']  = 'Service';
        $filters['service']['locale']   = __( 'Service', 'bbtheme' );
        $filters['service']['required'] = false;
        $filters['service']['choices']  = array(
            array( 'key' => 'Emails & optimised apps', 'caption' => 'Emails & optimised apps', 'locale' => __( 'Emails & optimised apps', 'bbtheme' ), 'class' => 'field-100' ),
            array( 'key' => 'Voice', 'caption' => 'Voice', 'locale' => __( 'Voice', 'bbtheme' ) ),
            array( 'key' => 'Data', 'caption' => 'Data', 'locale' => __( 'Data', 'bbtheme' ) ),
            array( 'key' => 'Video', 'caption' => 'Video', 'locale' => __( 'Video', 'bbtheme' ) ),
            array( 'key' => 'Else', 'caption' => 'Else', 'locale' => __( 'Else', 'bbtheme' ) ),
        );

        $filters['type']['caption']  = 'Type';
        $filters['type']['locale']   = __( 'Type', 'bbtheme' );
        $filters['type']['required'] = false;
        $filters['type']['choices']  = array(
            array( 'key' => 'Solution', 'caption' => 'Solution', 'locale' => __( 'Solution', 'bbtheme' ) ),
            array( 'key' => 'Product', 'caption' => 'Product', 'locale' => __( 'Product', 'bbtheme' ) ),
            array( 'key' => 'Accessory', 'caption' => 'Accessory', 'locale' => __( 'Accessory', 'bbtheme' ) ),
        );

        $filters['speed']['caption']  = 'Speed';
        $filters['speed']['locale']   = __( 'Speed', 'bbtheme' );
        $filters['speed']['required'] = false;
        $filters['speed']['choices']  = array(
            array( 'key' => 'Up to 200 Kbps', 'caption' => 'Up to 200 Kbps', 'locale' => __( 'Up to 200 Kbps', 'bbtheme' ) ),
            array( 'key' => 'Up to 700 Kbps', 'caption' => 'Up to 700 Kbps', 'locale' => __( 'Up to 700 Kbps', 'bbtheme' ) ),
            array( 'key' => 'Up to 2 Mbps', 'caption' => 'Up to 2 Mbps', 'locale' => __( 'Up to 2 Mbps', 'bbtheme' ) ),
            array( 'key' => 'Up to 20 Mbps', 'caption' => 'Up to 20 Mbps', 'locale' => __( 'Up to 20 Mbps', 'bbtheme' ) ),
            array( 'key' => 'Up to 50 Mbps', 'caption' => 'Up to 50 Mbps', 'locale' => __( 'Up to 50 Mbps', 'bbtheme' ) ),
            array( 'key' => 'Up to 400+ Mbps', 'caption' => 'Up to 400+ Mbps', 'locale' => __( 'Up to 400+ Mbps', 'bbtheme' ) ),
        );

        $filters['market']['caption']  = 'Market';
        $filters['market']['locale']   = __( 'Market', 'bbtheme' );
        $filters['market']['required'] = false;
        $filters['market']['choices']  = array(
            array( 'key' => 'Energy', 'caption' => 'Energy - Onshore', 'locale' => __( 'Energy - Onshore', 'bbtheme' ) ),
            array( 'key' => 'Humanitarian', 'caption' => 'Humanitarian', 'locale' => __( 'Humanitarian', 'bbtheme' ) ),
            array( 'key' => 'Offshore', 'caption' => 'Energy - Offshore', 'locale' => __( 'Energy - Offshore', 'bbtheme' ) ),
            array( 'key' => 'Enterprise', 'caption' => 'Enterprise', 'locale' => __( 'Enterprise', 'bbtheme' ) ),
            array( 'key' => 'Fishing', 'caption' => 'Fishing', 'locale' => __( 'Fishing', 'bbtheme' ) ),
            array( 'key' => 'Government', 'caption' => 'Government', 'locale' => __( 'Government', 'bbtheme' ) ),
            array( 'key' => 'Shipping', 'caption' => 'Shipping', 'locale' => __( 'Shipping', 'bbtheme' ) ),
            array( 'key' => 'Media', 'caption' => 'Media', 'locale' => __( 'Media', 'bbtheme' ) ),
            array( 'key' => 'super-yacht', 'caption' => 'Superyacht', 'locale' => __( 'Superyacht', 'bbtheme' ) ),
        );

        $filters['region']['caption']  = 'Region';
        $filters['region']['locale']   = __( 'Region', 'bbtheme' );
        $filters['region']['required'] = false;
        $filters['region']['choices']  = array(
            array( 'key' => 'Global', 'caption' => 'Global', 'locale' => __( 'Global', 'bbtheme' ) ),
            array( 'key' => 'Africa', 'caption' => 'Africa', 'locale' => __( 'Africa', 'bbtheme' ) ),
            array( 'key' => 'Asia_Pacific', 'caption' => 'Asia Pacific', 'locale' => __( 'Asia Pacific', 'bbtheme' ) ),
            array( 'key' => 'Central_America', 'caption' => 'Central America', 'locale' => __( 'Central America', 'bbtheme' ) ),
            array( 'key' => 'Central_Asia', 'caption' => 'Central Asia', 'locale' => __( 'Central Asia', 'bbtheme' ) ),
            array( 'key' => 'Europe', 'caption' => 'Europe', 'locale' => __( 'Europe', 'bbtheme' ) ),
            array( 'key' => 'Middle_East', 'caption' => 'Middle East', 'locale' => __( 'Middle East', 'bbtheme' ) ),
            array( 'key' => 'Northern_America', 'caption' => 'Northern America', 'locale' => __( 'Northern America', 'bbtheme' ) ),
            array( 'key' => 'Oceania', 'caption' => 'Oceania', 'locale' => __( 'Oceania', 'bbtheme' ) ),
            array( 'key' => 'South_America', 'caption' => 'South America', 'locale' => __( 'South America', 'bbtheme' ) ),
        );

        $filter_counts = array();
        if ( class_exists( '\BlueBeetle\Press\Generic' ) ) {
            $filter_counts = \BlueBeetle\Press\Generic::get_instance()->get_ps_filter_counts();
        }

        $filter_keys = array();
        foreach ( $filters as $f_key => $f_value ) {
            $filter_keys[ $f_key ] = array();
            foreach ( $f_value['choices'] as $c_index => $c_value ) {
                $sanitized_key = sanitize_title_for_query( $c_value['key'] );
                $db_key        = $f_key . '_' . $sanitized_key;
                $filters[ $f_key ]['choices'][ $c_index ]['key'] = $sanitized_key;
                $filter_keys[ $f_key ][]                         = $sanitized_key;
                if ( isset( $filter_counts[ $db_key ] ) ) {
                    $filters[ $f_key ]['choices'][ $c_index ]['count'] = $filter_counts[ $db_key ];
                } else {
                    $filters[ $f_key ]['choices'][ $c_index ]['count'] = 0;
                }
            }
        }

        $built_filters = $filters;
        $built_keys    = $filter_keys;
    }

    if ( $get_keys ) {
        return $built_keys;
    }

    if ( is_null( $filter_name ) ) {
        return $built_filters;
    }

    if ( isset( $built_filters[ $filter_name ] ) ) {
        return $built_filters[ $filter_name ];
    }

    return array();
}

function iec_ps_print_filter( $filter_name ) {
    $ps_values = iec_ps_filter_items( $filter_name );
    if ( empty( $ps_values ) ) {
        return;
    }

    foreach ( $ps_values['choices'] as $choice ) {
        if ( $choice['count'] <= 0 ) {
            continue;
        }

        $class = ! empty( $choice['class'] ) ? sanitize_html_class( $choice['class'] ) : '';
        $key   = esc_attr( $choice['key'] );

        echo '<div class="toggle-field ' . esc_attr( $class ) . '">';
        printf(
            '<input type="checkbox" value="%1$s" name="ps_filter[%2$s][]" id="psf_%2$s_%1$s" data-key="%1$s">',
            $key,
            esc_attr( $filter_name )
        );

        if ( ! empty( $choice['tooltip'] ) ) {
            echo '<div class="tooltip">';
            echo '<svg width="12" height="12" viewBox="0 0 32 33" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">';
            echo '<path d="M9.73913 1.60443C3.47826 4.3533 0 9.85104 0 16.9981C0 22.7707 0.695652 24.2826 4.5913 28.131C8.48696 31.9795 10.0174 32.6667 16 32.6667C21.9826 32.6667 23.513 31.9795 27.4087 28.131C31.3043 24.2826 32 22.7707 32 16.8607C32 11.088 31.3043 9.43871 27.687 5.72774C23.0957 1.1921 14.887 -0.594662 9.73913 1.60443ZM22.8174 5.04052C32.1391 9.85104 31.8609 24.6949 22.2609 28.9557C15.1652 32.1169 7.37391 29.9178 4.03478 23.5954C-2.50435 11.088 10.1565 -1.41932 22.8174 5.04052Z" fill="black"/>';
            echo '<path d="M11.8261 11.3333C9.46087 14 11.1304 15.6 13.913 13.3333C15.7217 12 16.4174 11.8667 17.8087 13.2C19.0609 14.5333 18.9217 15.2 17.113 16.5333C14.4696 18.4 13.7739 21.3333 15.7217 21.3333C17.6696 21.3333 21.5652 16.6667 21.5652 14.5333C21.5652 9.73334 15.0261 7.6 11.8261 11.3333Z" fill="black"/>';
            echo '<path d="M14.6087 24C14.6087 24.6667 15.3043 25.3333 16 25.3333C16.8348 25.3333 17.3913 24.6667 17.3913 24C17.3913 23.2 16.8348 22.6667 16 22.6667C15.3043 22.6667 14.6087 23.2 14.6087 24Z" fill="black"/>';
            echo '</svg>';
            echo '<span class="tooltiptext">' .  $choice['tooltip']  . '</span>';
            echo '</div>';
        }

        printf( '<label class="cf" for="psf_%1$s_%2$s">', esc_attr( $filter_name ), $key );
        echo '<div class="switch"></div>';
        echo '<div class="text">' .  $choice['locale']  . '</div>';
        echo '</label>';
        echo '</div>';
    }
}

function iec_ps_filter_choices( $filter_name ) {
    $filter_items = iec_ps_filter_items( $filter_name );
    $choices      = array();

    if ( ! empty( $filter_items['choices'] ) ) {
        foreach ( $filter_items['choices'] as $choice ) {
            $choices[ $choice['key'] ] = $choice['locale'];
        }
    }

    return $choices;
}

function iec_ps_operator_path_slug( $label ) {
    $s = strtolower( trim( (string) $label ) );
    $s = str_replace( '&', 'and', $s );
    $s = preg_replace( '/[^a-z0-9\s-]+/u', '', $s );
    $s = preg_replace( '/\s+/u', '-', $s );
    $s = preg_replace( '/-+/u', '-', $s );

    return trim( $s, '-' );
}

function iec_ps_operator_listing_url( $product_solution_page_url, $operator_caption ) {
    $slug = iec_ps_operator_path_slug( $operator_caption );
    if ( '' === $slug ) {
        return $product_solution_page_url;
    }

    return trailingslashit( $product_solution_page_url ) . rawurlencode( $slug ) . '/';
}

function iec_ps_product_solution_base_url() {
    if ( function_exists( 'get_config' ) ) {
        $id = get_config( 'iec_ps_page' );
        if ( is_numeric( $id ) && (int) $id > 0 ) {
            $status = get_post_status( (int) $id );
            if ( $status && in_array( $status, array( 'publish', 'private' ), true ) ) {
                $link = get_permalink( (int) $id );
                if ( $link ) {
                    return trailingslashit( $link );
                }
            }
        }
    }

    $page = get_page_by_path( 'product-solution', OBJECT, 'page' );
    if ( $page instanceof WP_Post && in_array( $page->post_status, array( 'publish', 'private' ), true ) ) {
        return trailingslashit( get_permalink( $page ) );
    }

    return trailingslashit( home_url( '/product-solution/' ) );
}

if ( ! function_exists( 'get_ps_filters' ) ) {
	function get_ps_filters() {
		return iec_ps_filters();
	}
}

if ( ! function_exists( 'get_ps_filter_items' ) ) {
	function get_ps_filter_items( $filter_name = null, $get_keys = false ) {
		return iec_ps_filter_items( $filter_name, $get_keys );
	}
}

if ( ! function_exists( 'print_ps_filter' ) ) {
	function print_ps_filter( $filter_name ) {
		iec_ps_print_filter( $filter_name );
	}
}

if ( ! function_exists( 'get_ps_filter_choices' ) ) {
	function get_ps_filter_choices( $filter_name ) {
		return iec_ps_filter_choices( $filter_name );
	}
}
