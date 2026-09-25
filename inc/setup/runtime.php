<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iec_disable_feed() {
	wp_die( 'No feed available, please visit the <a href="' . esc_url( home_url( '/' ) ) . '">homepage</a>!' );
}

add_action( 'do_feed', 'iec_disable_feed', 1 );
add_action( 'do_feed_rdf', 'iec_disable_feed', 1 );
add_action( 'do_feed_rss', 'iec_disable_feed', 1 );
add_action( 'do_feed_rss2', 'iec_disable_feed', 1 );
add_action( 'do_feed_atom', 'iec_disable_feed', 1 );
add_action( 'do_feed_rss2_comments', 'iec_disable_feed', 1 );
add_action( 'do_feed_atom_comments', 'iec_disable_feed', 1 );

add_filter(
	'script_loader_tag',
	function( $tag, $handle ) {
		if ( is_admin() ) {
			return $tag;
		}

		// Do not defer jQuery: many templates still have inline jQuery() in the body.
		$defer_handles = array(
			'browser-redirect',
			'sweetalert',
			'chosen-jquery',
			'jscolor',
			'wpml-auto-detect-redirect',
		);

		if ( in_array( $handle, $defer_handles, true ) ) {
			return str_replace( ' src=', ' defer="defer" src=', $tag );
		}

		return $tag;
	},
	10,
	2
);

function iec_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';

	return $mimes;
}
add_filter( 'upload_mimes', 'iec_mime_types' );

function iec_remove_protected_title_prefix() {
	return '%s';
}
add_filter( 'protected_title_format', 'iec_remove_protected_title_prefix' );

add_action(
	'rest_api_init',
	function() {
		if ( session_status() === PHP_SESSION_ACTIVE ) {
			session_write_close();
		}
	},
	1
);

add_action(
	'wp_loaded',
	function() {
		$should_close = (
			( defined( 'REST_REQUEST' ) && REST_REQUEST ) ||
			( defined( 'DOING_CRON' ) && DOING_CRON ) ||
			( defined( 'WP_CLI' ) && WP_CLI ) ||
			( defined( 'XMLRPC_REQUEST' ) && XMLRPC_REQUEST ) ||
			( defined( 'DOING_AJAX' ) && DOING_AJAX )
		);

		if ( $should_close && session_status() === PHP_SESSION_ACTIVE ) {
			session_write_close();
		}
	},
	999
);

add_filter(
	'http_request_args',
	function( $args, $url ) {
		if ( strpos( $url, home_url() ) === 0 && session_status() === PHP_SESSION_ACTIVE ) {
			session_write_close();
		}

		return $args;
	},
	10,
	2
);

add_action(
	'init',
	function() {
		$session_active = ( session_status() === PHP_SESSION_ACTIVE );
		$needs_session  = (
			is_admin() ||
			( $session_active && ! empty( $_SESSION['user_hash'] ) ) ||
			( ! empty( $_POST ) )
		);

		if ( ! $needs_session && $session_active ) {
			session_write_close();
		}
	},
	100
);

add_action(
	'init',
	function() {
		global $pagenow;

		if ( ! in_array( $pagenow, array( 'post.php', 'post-new.php' ), true ) ) {
			wp_deregister_script( 'heartbeat' );
		}
	},
	1
);

add_filter(
	'heartbeat_settings',
	function( $settings ) {
		$settings['interval'] = 60;

		return $settings;
	}
);

add_action(
	'init',
	function() {
		add_post_type_support( 'news', 'thumbnail' );
		add_post_type_support( 'solution', 'thumbnail' );
	},
	20
);

add_action(
	'admin_footer',
	function() {
		$screen = get_current_screen();

		if ( ! $screen || 'page' !== $screen->post_type ) {
			return;
		}
		?>
		<script>
		jQuery(document).ready(function($) {
			var $newDesign = $('#acf-field_6a62107fa2b91');
			var $template  = $('#page_template');

			function toggleTemplate() {
				var newValue = $newDesign.is(':checked')
					? 'page-templates/offshore-page.php'
					: 'page-templates/market-detail-page.php';

				if ($template.val() !== newValue) {
					$template.val(newValue);
					$template.trigger('change');
					var el = $template.get(0);
					if ( el ) {
						el.dispatchEvent(new Event('change', { bubbles: true }));
					}
				}
			}

			$newDesign.on('change', toggleTemplate);
		});
		</script>
		<?php
	}
);

function iec_sync_wpml_translation_slug( $post_id ) {
	if ( ! function_exists( 'wpml_get_language_information' ) ) {
		return;
	}

	$lang_info = apply_filters( 'wpml_post_language_details', null, $post_id );
	if ( ! $lang_info || empty( $lang_info['source_language_code'] ) ) {
		return;
	}

	$original_id = apply_filters( 'wpml_object_id', $post_id, get_post_type( $post_id ), false, $lang_info['source_language_code'] );
	if ( ! $original_id ) {
		return;
	}

	$original_slug = get_post_field( 'post_name', $original_id );
	$current_slug  = get_post_field( 'post_name', $post_id );

	if ( $original_slug && $current_slug !== $original_slug ) {
		remove_action( 'save_post', 'iec_sync_wpml_translation_slug', 20 );
		wp_update_post(
			array(
				'ID'        => $post_id,
				'post_name' => $original_slug,
			)
		);
		add_action( 'save_post', 'iec_sync_wpml_translation_slug', 20 );
	}
}
add_action( 'save_post', 'iec_sync_wpml_translation_slug', 20 );

add_filter( 'rank_math/sitemap/enable_caching', '__return_false' );
