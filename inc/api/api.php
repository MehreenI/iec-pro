<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class IEC_News_Query {

    public const POST_TYPES = ['news', 'press-release'];

    public static function get_featured_args(string $category): array {
        $args = [
            'post_type'              => self::POST_TYPES,
            'post_status'            => 'publish',
            'posts_per_page'         => 3,
            'orderby'                => 'date',
            'order'                  => 'DESC',
            'no_found_rows'          => true,
            'update_post_meta_cache' => true,
            'update_post_term_cache' => true,
            'fields'                 => 'all',
        ];

        if ($category === 'press-release') {
            $args['tax_query'] = [
                'relation' => 'OR',
                [
                    'taxonomy' => 'news_type',
                    'field'    => 'slug',
                    'terms'    => 'press-release',
                ],
                [
                    'taxonomy' => 'news_type',
                    'operator' => 'NOT EXISTS',
                ],
            ];

            return $args;
        }

        if ($category !== '') {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'news_type',
                    'field'    => 'slug',
                    'terms'    => $category,
                ],
            ];
        }

        return $args;
    }

    public static function get_list_args(string $category, string $industry, string $location, int $page, int $per_page): array {
        $args = [
            'post_type'              => self::POST_TYPES,
            'post_status'            => 'publish',
            'posts_per_page'         => $per_page,
            'paged'                  => max(1, $page),
            'orderby'                => 'date',
            'order'                  => 'DESC',
            'suppress_filters'       => false,
            'update_post_meta_cache' => true,
            'update_post_term_cache' => true,
        ];

        $tax_query = [];

        if ($category === 'press-release') {
            // Include press-release CPT posts that have no news_type term assigned.
            $tax_query[] = [
                'relation' => 'OR',
                [
                    'taxonomy' => 'news_type',
                    'field'    => 'slug',
                    'terms'    => 'press-release',
                ],
                [
                    'taxonomy' => 'news_type',
                    'operator' => 'NOT EXISTS',
                ],
            ];
        } elseif ($category !== '') {
            $tax_query[] = [
                'taxonomy' => 'news_type',
                'field'    => 'slug',
                'terms'    => $category,
            ];
        }

        if ($industry !== '') {
            $tax_query[] = [
                'taxonomy' => 'news_industry',
                'field'    => 'slug',
                'terms'    => $industry,
            ];
        }

        if ($location !== '') {
            $tax_query[] = [
                'taxonomy' => 'news_location',
                'field'    => 'slug',
                'terms'    => $location,
            ];
        }

        if (count($tax_query) > 1) {
            $tax_query['relation'] = 'AND';
        }

        if ($tax_query !== []) {
            $args['tax_query'] = $tax_query;
        }

        return $args;
    }
}

final class IEC_News_API {

    private const ROUTE_NAMESPACE = 'iec-news/v1';
    private const ROUTE           = '/data';
    private const PER_PAGE        = 10;
    private const CACHE_TTL       = 120;

    public function __construct() {
        add_action('rest_api_init', [$this, 'register_routes']);
        add_action('save_post_news', [$this, 'bust_cache']);
        add_action('save_post_press-release', [$this, 'bust_cache']);
        add_action('edited_news_type', [$this, 'bust_cache']);
        add_action('created_news_type', [$this, 'bust_cache']);
        add_action('delete_news_type', [$this, 'bust_cache']);
        add_action('edited_news_industry', [$this, 'bust_cache']);
        add_action('edited_news_location', [$this, 'bust_cache']);

        if (function_exists('iec_news_landing_bust_static_cache')) {
            add_action('save_post_news', 'iec_news_landing_bust_static_cache');
            add_action('save_post_press-release', 'iec_news_landing_bust_static_cache');
        }
    }

    public function register_routes(): void {
        register_rest_route(self::ROUTE_NAMESPACE, self::ROUTE, [
            'methods'             => WP_REST_Server::READABLE,
            'callback'            => [$this, 'get_news'],
            'permission_callback' => '__return_true',
            'args'                => [
                'page'     => ['type' => 'integer', 'default' => 1, 'minimum' => 1],
                'category' => ['type' => 'string', 'default' => ''],
                'industry' => ['type' => 'string', 'default' => ''],
                'location' => ['type' => 'string', 'default' => ''],
                'lang'     => ['type' => 'string', 'default' => 'en'],
            ],
        ]);
    }

    public function get_news(WP_REST_Request $request): WP_REST_Response {
        $page     = (int) $request->get_param('page') ?: 1;
        $category = sanitize_text_field($request->get_param('category') ?: '');
        $industry = sanitize_text_field($request->get_param('industry') ?: '');
        $location = sanitize_text_field($request->get_param('location') ?: '');
        $per_page = self::PER_PAGE;
        $lang     = sanitize_text_field($request->get_param('lang') ?: 'en');

        $cache_key = 'iec_news_api_' . md5(wp_json_encode(compact('page', 'category', 'industry', 'location', 'lang')));
        $cached    = get_transient($cache_key);

        if (is_array($cached)) {
            return rest_ensure_response($cached);
        }

        do_action('wpml_switch_language', $lang);

        $query = new WP_Query(
            IEC_News_Query::get_list_args($category, $industry, $location, $page, $per_page)
        );
        $posts = [];

        while ($query->have_posts()) {
            $query->the_post();

            $fields     = get_fields();
            $news_terms = get_the_terms(get_the_ID(), 'news_type');
            $image_url  = !empty($fields['image']['url']) ? $fields['image']['url'] : '';
            $data       = $fields['caption'] ?? '';

            $category_label = '';

            if (!empty($news_terms) && !is_wp_error($news_terms)) {
                $category_label = $news_terms[0]->name;
            } elseif (get_post_type() === 'press-release') {
                $category_label = __('Press Release', 'bbtheme');
            }

            $posts[] = [
                'id'        => get_the_ID(),
                'title'     => html_entity_decode( get_the_title(), ENT_QUOTES, 'UTF-8' ),
                'permalink' => get_permalink(),
                'date'      => get_the_date('d M Y'),
                'excerpt'   => wp_trim_words(is_string($data) ? $data : '', 20),
                'image'     => $image_url,
                'category'  => $category_label,
            ];
        }

        wp_reset_postdata();

        $payload = [
            'posts'       => $posts,
            'total'       => (int) $query->found_posts,
            'total_pages' => (int) $query->max_num_pages,
            'current'     => $page,
        ];

        set_transient($cache_key, $payload, self::CACHE_TTL);

        return rest_ensure_response($payload);
    }

    public function bust_cache(): void {
        global $wpdb;

        $wpdb->query(
            $wpdb->prepare(
                "DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
                $wpdb->esc_like('_transient_iec_news_api_') . '%',
                $wpdb->esc_like('_transient_timeout_iec_news_api_') . '%'
            )
        );

        if (function_exists('iec_news_landing_bust_static_cache')) {
            iec_news_landing_bust_static_cache();
        }
    }
}

new IEC_News_API();

function iec_operators_highlight_search( $text, $search ) {
	$text = wp_strip_all_tags( (string) $text );
	if ( $search === '' ) {
		return $text;
	}
	$escaped = $text;
	$tokens  = preg_split( '/[\s,]+/u', trim( $search ), -1, PREG_SPLIT_NO_EMPTY );
	$tokens  = array_unique( $tokens );
	usort(
		$tokens,
		static function ( $a, $b ) {
			return mb_strlen( $b, 'UTF-8' ) - mb_strlen( $a, 'UTF-8' );
		}
	);
	foreach ( $tokens as $t ) {
		if ( mb_strlen( $t, 'UTF-8' ) < 1 ) {
			continue;
		}
		$pattern = '/' . preg_quote( $t, '/' ) . '/iu';
		$escaped = preg_replace( $pattern, '<mark class="iec-search-highlight">$0</mark>', $escaped );
	}

	return wp_kses(
		$escaped,
		array(
			'mark' => array(
				'class' => true,
			),
		)
	);
}
