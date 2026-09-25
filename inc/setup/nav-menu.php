<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function iec_get_nav_menu_id_for_location( $location ) {
    $location = (string) $location;
    if ( '' === $location ) {
        return 0;
    }

    $locations = get_nav_menu_locations();
    if ( ! empty( $locations[ $location ] ) ) {
        return (int) $locations[ $location ];
    }

    $current_lang = apply_filters( 'wpml_current_language', null );
    $default_lang = apply_filters( 'wpml_default_language', null );

    if (
        ! is_string( $current_lang ) || '' === $current_lang
        || ! is_string( $default_lang ) || '' === $default_lang
        || $current_lang === $default_lang
    ) {
        return 0;
    }

    do_action( 'wpml_switch_language', $default_lang );
    $default_locations = get_nav_menu_locations();
    do_action( 'wpml_switch_language', $current_lang );

    if ( empty( $default_locations[ $location ] ) ) {
        return 0;
    }

    $default_menu_id = (int) $default_locations[ $location ];

    if ( has_filter( 'wpml_object_id' ) ) {
        $translated_menu_id = apply_filters( 'wpml_object_id', $default_menu_id, 'nav_menu', false, $current_lang );
        if ( $translated_menu_id ) {
            return (int) $translated_menu_id;
        }
    }

    return $default_menu_id;
}

function iec_language_selector_flags() {
    $languages = apply_filters(
        'wpml_active_languages',
        null,
        array(
            'skip_missing' => 0,
            'orderby'      => 'code',
        )
    );

    if ( empty( $languages ) ) {
        return;
    }

    uasort(
        $languages,
        static function ( $a, $b ) {
            return strcmp( $a['language_code'], $b['language_code'] );
        }
    );

    echo '<ul class="menu language-menu">';
    foreach ( $languages as $l ) {
        if ( 0 !== (int) $l['missing'] || ! empty( $l['active'] ) ) {
            continue;
        }

        $url  = esc_url( $l['url'] );
        $code = strtoupper( str_replace( 'zh-hans', 'ZH', $l['language_code'] ) );
        printf(
            '<li class="%1$s"><a href="%2$s" class="lang_sel_other"><span>%3$s</span></a></li>',
            esc_attr( $code ),
            $url,
             $code
        );
    }
    echo '</ul>';
}

function iec_nav_menu_item_classes_from_meta( $menu_item_post_id ) {
    if ( empty( $menu_item_post_id ) ) {
        return array();
    }

    $meta = get_post_meta( (int) $menu_item_post_id, '_menu_item_classes', true );
    $out  = array();

    if ( is_array( $meta ) ) {
        foreach ( $meta as $c ) {
            if ( ! is_string( $c ) ) {
                continue;
            }
            $c = trim( $c );
            if ( '' !== $c ) {
                $out[] = $c;
            }
        }
    } elseif ( is_string( $meta ) && '' !== trim( $meta ) ) {
        $out = preg_split( '/\s+/', $meta, -1, PREG_SPLIT_NO_EMPTY );
    }

    return array_values( $out );
}

function iec_nav_menu_item_user_classes( $item ) {
    $out = array();

    if ( ! empty( $item->classes ) && is_array( $item->classes ) ) {
        foreach ( $item->classes as $c ) {
            if ( ! is_string( $c ) ) {
                continue;
            }
            $c = trim( $c );
            if ( '' !== $c ) {
                $out[] = $c;
            }
        }
    }

    if ( ! empty( $out ) ) {
        return $out;
    }

    if ( empty( $item->ID ) ) {
        return array();
    }

    return iec_nav_menu_item_classes_from_meta( (int) $item->ID );
}

function iec_nav_menu_css_class_merge_meta_classes( $classes, $item, $args, $depth ) {
    if ( ! is_object( $item ) || empty( $item->ID ) ) {
        return $classes;
    }

    $classes = array_values( array_filter( (array) $classes ) );
    foreach ( iec_nav_menu_item_classes_from_meta( (int) $item->ID ) as $token ) {
        if ( ! in_array( $token, $classes, true ) ) {
            $classes[] = $token;
        }
    }

    return $classes;
}

add_filter( 'nav_menu_css_class', 'iec_nav_menu_css_class_merge_meta_classes', 5, 4 );

function iec_nav_menu_item_filtered_classes( $item, $depth = 0 ) {
    $classes   = iec_nav_menu_item_user_classes( $item );
    $classes[] = 'menu-item-' . (int) $item->ID;
    $args      = (object) array(
        'theme_location' => '',
        'before'         => '',
        'after'          => '',
        'link_before'    => '',
        'link_after'     => '',
    );
    $filtered  = apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, (int) $depth );

    return array_values( array_unique( array_filter( $filtered ) ) );
}

function iec_get_menu_items_list( $menu_name ) {
    $navbar_items = wp_get_nav_menu_items( $menu_name );

    if ( empty( $navbar_items ) || ! is_array( $navbar_items ) ) {
        return array();
    }

    $menu_items = array();

    foreach ( $navbar_items as $item ) {
        if ( $item->menu_item_parent ) {
            $menu_items[ $item->menu_item_parent ]['children'][] = $item;
        } else {
            $menu_items[ $item->ID ]['title']    = $item->title;
            $menu_items[ $item->ID ]['url']      = $item->url;
            $menu_items[ $item->ID ]['classes']  = iec_nav_menu_item_filtered_classes( $item, 0 );
            $menu_items[ $item->ID ]['children'] = array();
        }
    }

    return $menu_items;
}

function iec_nav_menu_class_attribute( $classes, $prepend = array() ) {
    $list = array();

    if ( ! empty( $prepend ) && is_array( $prepend ) ) {
        foreach ( $prepend as $c ) {
            $c = trim( (string) $c );
            if ( '' !== $c ) {
                $list[] = sanitize_html_class( $c );
            }
        }
    }

    if ( ! empty( $classes ) && is_array( $classes ) ) {
        foreach ( $classes as $c ) {
            $c = trim( (string) $c );
            if ( '' !== $c ) {
                $list[] = sanitize_html_class( $c );
            }
        }
    }

    $list = array_unique( array_filter( $list ) );
    if ( empty( $list ) ) {
        return '';
    }

    return ' class="' . esc_attr( implode( ' ', $list ) ) . '"';
}

add_filter( 'nav_menu_css_class', 'iec_add_custom_class_to_menu_item', 10, 4 );

function iec_add_custom_class_to_menu_item( $classes, $item, $args = null, $depth = 0 ) {
    if ( 'About IEC Telecom' === $item->title || 'Our Partners' === $item->title ) {
        $classes[] = 'iec_sub_main_menu';
    }

    if ( in_array( $item->title, array( 'SUPPORT HEADQUARTERS', 'OUR OFFER', 'HEADQUARTERS' ), true ) ) {
        $classes[] = 'support_headquarters';
    }

    if ( 'DOWNLOAD CENTER' === $item->title ) {
        $classes[] = 'download_center';
    }

    return $classes;
}

class WPML_Fallback_Walker_Nav_Menu extends Walker_Nav_Menu {

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        $current_lang = apply_filters( 'wpml_current_language', null );

        if ( is_string( $current_lang ) && '' !== $current_lang ) {
            $object = isset( $item->object ) ? (string) $item->object : '';

            if ( 'custom' !== $object && ! empty( $item->object_id ) && has_filter( 'wpml_object_id' ) ) {
                $translated_id = apply_filters( 'wpml_object_id', (int) $item->object_id, $object, true, $current_lang );
                $translated_id = $translated_id ? (int) $translated_id : 0;

                if ( $translated_id > 0 ) {
                    $translated_post = get_post( $translated_id );
                    if ( $translated_post instanceof WP_Post && 'publish' === $translated_post->post_status ) {
                        $permalink = get_permalink( $translated_id );
                        if ( $permalink ) {
                            $item->url = $permalink;
                        }
                        if ( $translated_id !== (int) $item->object_id ) {
                            $item->title = get_the_title( $translated_id );
                        }
                    }
                }
            } elseif ( ! empty( $item->url ) ) {

                if ( function_exists( 'iec_wpml_localize_url' ) ) {
                    $item->url = iec_wpml_localize_url( (string) $item->url );
                } elseif ( has_filter( 'wpml_permalink' ) ) {
                    $localized = apply_filters( 'wpml_permalink', (string) $item->url, $current_lang );
                    if ( is_string( $localized ) && '' !== $localized ) {
                        $item->url = $localized;
                    }
                }

                if ( ! empty( $item->post_title ) || ! empty( $item->title ) ) {
                    $title = (string) ( $item->title ?: $item->post_title );
                    $translated_title = apply_filters(
                        'wpml_translate_single_string',
                        $title,
                        'WordPress',
                        sprintf( 'menu item label: %s', $title )
                    );
                    if ( is_string( $translated_title ) && '' !== $translated_title ) {
                        $item->title = $translated_title;
                    }
                }
            }
        }

        parent::start_el( $output, $item, $depth, $args, $id );
    }
}

