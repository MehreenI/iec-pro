<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function register_news_industry_taxonomy() {
    $labels = array(
        'name'          => 'Industries',
        'singular_name' => 'Industry',
        'search_items'  => 'Search Industries',
        'all_items'     => 'All Industries',
        'edit_item'     => 'Edit Industry',
        'update_item'   => 'Update Industry',
        'add_new_item'  => 'Add New Industry',
        'new_item_name' => 'New Industry Name',
        'menu_name'     => 'News Industries',
    );

    register_taxonomy(
        'news_industry',
        array( 'news', 'press-release' ),
        array(
            'hierarchical'      => false,
            'labels'            => $labels,
            'show_ui'           => true,
            'show_admin_column' => true,
            'rewrite'           => array( 'slug' => 'news-industry' ),
        )
    );
}
add_action( 'init', 'register_news_industry_taxonomy' );

function iec_register_footer_menus() {
    register_nav_menus(
        array(
            'footer-solutions'  => 'Footer — Solutions',
            'footer-industries' => 'Footer — Industries',
            'footer-services'   => 'Footer — Services',
            'footer-resources'  => 'Footer — Resources',
            'footer-company'    => 'Footer — Company',
        )
    );
}
add_action( 'after_setup_theme', 'iec_register_footer_menus' );

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

function language_selector_flags() {
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

    $show_missing = is_tax( 'news_type' );

    if ( $show_missing ) {
        $term = get_queried_object();

        if ( $term instanceof WP_Term ) {
            $base_url = get_term_link( $term, $term->taxonomy );

            if ( ! is_wp_error( $base_url ) ) {
                foreach ( $languages as $code => &$l ) {
                    $translated_url = apply_filters( 'wpml_permalink', $base_url, $code );

                    if ( is_string( $translated_url ) && '' !== $translated_url ) {
                        $l['url'] = $translated_url;
                    }
                }
                unset( $l );
            }
        }
    }

    echo '<ul class="menu language-menu">';
    foreach ( $languages as $l ) {
        if ( ! empty( $l['active'] ) || ( ! $show_missing && 0 !== (int) $l['missing'] ) ) {
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

function get_menu_items_list( $menu_name ) {
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

add_filter( 'nav_menu_css_class', 'add_custom_class_to_menu_item', 10, 4 );

function add_custom_class_to_menu_item( $classes, $item, $args = null, $depth = 0 ) {
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

class Custom_ACF {

    public function __construct() {
        add_action( 'admin_head', array( $this, 'accordion_style' ) );
        add_action( 'admin_footer', array( $this, 'acf_script' ) );
        add_action( 'acf/input/admin_footer', array( $this, 'dynamicTable' ) );
    }

    public function accordion_style()
    {
        ?>
        <style>
            .acf-label.acf-accordion-title:hover {
                background-color: #003b4d9e;
                color: white;
            }

            .acf-accordion.-open .acf-label.acf-accordion-title {
                background-color: #003B4D;
                color: white;
            }
            .acf-fc-layout-actions-wrap {
                background: #003B4D !important;
                color: white;
            }
            .acf-fc-layout-actions-wrap:hover{
                background: #003b4d9e !important;
            }

            span.acf-fc-layout-title {
                color: white
            }

            .acf-button.button.button-primary {
                background: #003B4D !important;
                border-color: #003B4D;
            }

            .acf-fc-layout-controls a , .acf-fc-layout-controls a span.acf-icon{
                color: white !important;
            }
            .acf-fc-layout-controls a span.acf-icon{
                background: white !important;
            }
            .acf-th{
                width: auto !important;
            }
        </style>
        <?php
    }

    public function acf_script()
    {
        ?>
        <script>
            jQuery(document).ready(function ($) {

                var $checkbox = $('#acf-field_696e3fd62f4d7');
                var $newGroup = $('#acf-group_694e9b0027427');
                var $oldGroup = $('#acf-group_5dba6849d4efe');
                var $maritime = $("#acf-field_ps_filter_application-maritime");
                var $land = $("#acf-field_ps_filter_application-land");
                var $accordion_maritime = $('.acf-field-69526ffd7aa6b');
                var $accordion_land = $(".acf-field-6952736b90744");
                var $starlink = $("#acf-field_ps_filter_operator-starlink");

                if (!$checkbox.length) return;

                function toggleACFGroups() {
                    if ($checkbox.is(':checked')) {
                        $newGroup.show();
                        $oldGroup.hide();
                    } else {
                        $newGroup.hide();
                        $oldGroup.show();
                    }

                    if ($maritime.is(':checked')) {
                        $accordion_maritime.show();
                    } else {
                        $accordion_maritime.hide();
                    }

                    if ($land.is(':checked')) {
                        $accordion_land.show();
                    } else {
                        $accordion_land.hide();
                    }

                    if ($starlink.is(':checked')) {
                        $("#coverage-map-img").hide();
                        $("#starlink-map").show();
                    } else {
                        $("#coverage-map-img").show();
                        $("#starlink-map").hide();
                    }
                }

                toggleACFGroups();

                $checkbox.on('change', toggleACFGroups);
                $maritime.on('change', toggleACFGroups);
                $land.on('change', toggleACFGroups);
                $starlink.on('change', toggleACFGroups);

            });
        </script>
        <?php
    }

    public function dynamicTable()
    {
        ?>
        <script type="text/javascript">
            (function ($) {

                if (typeof acf === 'undefined') return;

                acf.addAction('ready', function () {
                    initAllDynamicTables();
                });

                acf.addAction('append', function ($el) {
                    setTimeout(function () {
                        initAllDynamicTables();
                    }, 300);
                });

                function initAllDynamicTables() {
                    $('.layout[data-layout="dynamic_table_builder"]').each(function () {
                        initDynamicTable($(this));
                    });
                }

                function initDynamicTable($layout) {
                    if ($layout.data('table-init')) return;
                    $layout.data('table-init', true);

                    var $rowsField = $layout.find('[data-name="number_of_rows"] input');
                    var $colsField = $layout.find('[data-name="number_of_columns"] input');
                    var $repeater = $layout.find('[data-name="table"]');

                    if (!$rowsField.length || !$colsField.length || !$repeater.length) return;

                    $rowsField.on('change input', function () {
                        var rows = parseInt($(this).val()) || 0;
                        if (rows > 0) {
                            adjustRows($repeater, rows);
                        }
                    });

                    $colsField.on('change input', function () {
                        var cols = parseInt($(this).val()) || 0;
                        if (cols > 0 && cols <= 8) {
                            adjustColumns($repeater, cols);
                        }
                    });

                    setTimeout(function () {
                        var initialCols = parseInt($colsField.val()) || 0;
                        var initialRows = parseInt($rowsField.val()) || 0;

                        if (initialCols > 0) {
                            adjustColumns($repeater, initialCols);
                        }

                        if (initialRows > 0) {
                            adjustRows($repeater, initialRows);
                        }
                        highlightHeaderRow($repeater);
                    }, 500);
                }

                function adjustRows($repeater, targetRows) {
                    var $tbody = $repeater.find('tbody');
                    var $existingRows = $tbody.find('.acf-row:not(.acf-clone)');
                    var currentRows = $existingRows.length;

                    if (currentRows < targetRows) {
                        var $addButton = $repeater.find('.acf-actions .acf-repeater-add-row, .acf-actions [data-event="add-row"]');

                        for (var i = currentRows; i < targetRows; i++) {
                            $addButton.trigger('click');
                        }
                    }

                    if (currentRows > targetRows) {
                        $existingRows.slice(targetRows).each(function () {
                            $(this).find('[data-event="remove-row"]').trigger('click');
                        });
                    }

                    setTimeout(function () {
                        highlightHeaderRow($repeater);
                    }, 200);
                }

                function adjustColumns($repeater, targetCols) {

                    var columnFields = [
                        'column_1', 'column_2', 'column_3', 'column_4',
                        'column_5', 'column_6', 'column_7', 'column_8'
                    ];

                    $repeater.find('thead th').each(function () {
                        var $th = $(this);
                        var dataName = $th.data('name');

                        if (!dataName) return;

                        var colIndex = columnFields.indexOf(dataName);
                        if (colIndex !== -1) {
                            if (colIndex < targetCols) {
                                $th.show();
                            } else {
                                $th.hide();
                            }
                        }
                    });

                    $repeater.find('tbody tr').each(function () {
                        var $row = $(this);

                        columnFields.forEach(function (fieldName, index) {
                            var $cell = $row.find('[data-name="' + fieldName + '"]');
                            if (index < targetCols) {
                                $cell.show();
                            } else {
                                $cell.hide();
                            }
                        });
                    });
                }

                function highlightHeaderRow($repeater) {
                    var $rows = $repeater.find('tbody .acf-row:not(.acf-clone)');

                    $rows.removeClass('dtb-header-row');

                    $rows.first().addClass('dtb-header-row');
                }

            })(jQuery);

        </script>
        <?php
    }
}

new Custom_ACF();

class News_Type_Admin_Column {

    private const POST_TYPE = 'news';
    private const TAXONOMY  = 'news_type';
    private const FILTER_KEY = 'news_type_filter';

    private array $news_types = [
        6   => 'Events',
        40  => 'Insights',
        9   => 'Latest Updates',
        192 => 'Press Releases',
        8   => 'Publications',
    ];

    public function __construct() {
        $this->register_hooks();
    }

    private function register_hooks(): void {
        add_filter( 'manage_news_posts_columns',          [ $this, 'add_column' ] );
        add_action( 'manage_news_posts_custom_column',    [ $this, 'populate_column' ], 10, 2 );
        add_filter( 'manage_edit-news_sortable_columns',  [ $this, 'make_sortable' ] );
        add_action( 'restrict_manage_posts',              [ $this, 'render_filter_dropdown' ] );
        add_action( 'pre_get_posts',                      [ $this, 'apply_filter_to_query' ] );
    }

    public function add_column( array $columns ): array {
        $new_columns = [];

        foreach ( $columns as $key => $value ) {
            $new_columns[ $key ] = $value;
            if ( $key === 'title' ) {
                $new_columns[ self::TAXONOMY ] = 'News Type';
            }
        }

        return $new_columns;
    }

    public function populate_column( string $column, int $post_id ): void {
        if ( $column !== self::TAXONOMY ) return;

        $terms = get_the_terms( $post_id, self::TAXONOMY );

        if ( ! empty( $terms ) && ! is_wp_error( $terms ) ) {
            echo implode( ', ', wp_list_pluck( $terms, 'name' ) );
        } else {
            echo '—';
        }
    }

    public function make_sortable( array $columns ): array {
        $columns[ self::TAXONOMY ] = self::TAXONOMY;
        return $columns;
    }

    public function render_filter_dropdown(): void {
        global $typenow;

        if ( $typenow !== self::POST_TYPE ) return;

        $selected = isset( $_GET[ self::FILTER_KEY ] )
            ? sanitize_text_field( $_GET[ self::FILTER_KEY ] )
            : '';

        echo '<select name="' . esc_attr( self::FILTER_KEY ) . '">';
        echo '<option value="">All News Types</option>';

        foreach ( $this->news_types as $term_id => $label ) {
            printf(
                '<option value="%s"%s>%s</option>',
                esc_attr( $term_id ),
                selected( $selected, $term_id, false ),
                $label
            );
        }

        echo '</select>';
    }

    public function apply_filter_to_query( \WP_Query $query ): void {
        global $pagenow;

        if (
            ! is_admin()                                        ||
            $pagenow !== 'edit.php'                             ||
            ( $_GET['post_type'] ?? '' ) !== self::POST_TYPE   ||
            empty( $_GET[ self::FILTER_KEY ] )                 ||
            ! $query->is_main_query()
        ) {
            return;
        }

        $query->set( 'tax_query', [ [
            'taxonomy' => self::TAXONOMY,
            'field'    => 'term_id',
            'terms'    => intval( $_GET[ self::FILTER_KEY ] ),
        ] ] );
    }
}

new News_Type_Admin_Column();

class Product_Admin_Column {

    private const POST_TYPE = 'product';
    private const COLUMN_KEY = 'slug';

    public function __construct() {
        $this->register_hooks();
    }

    private function register_hooks(): void {
        add_filter( 'manage_product_posts_columns',       [ $this, 'add_column' ] );
        add_action( 'manage_product_posts_custom_column', [ $this, 'populate_column' ], 10, 2 );
    }

    public function add_column( array $columns ): array {
        $new_columns = [];
        foreach ( $columns as $key => $value ) {
            $new_columns[ $key ] = $value;
            if ( $key === 'title' ) {
                $new_columns[ self::COLUMN_KEY ] = 'Slug';
            }
        }
        return $new_columns;
    }

    public function populate_column( string $column, int $post_id ): void {
        if ( $column !== self::COLUMN_KEY ) return;

        $post = get_post( $post_id );

        if ( $post && ! empty( $post->post_name ) ) {
            echo $post->post_name;
        } else {
            echo '—';
        }
    }
}
new Product_Admin_Column();
