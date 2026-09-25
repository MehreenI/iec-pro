<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iec_clear_all_caches() {
	$cleared = array();

	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
		$cleared[] = 'WP Rocket — page cache';
	}
	if ( function_exists( 'rocket_clean_minify' ) ) {
		rocket_clean_minify();
		$cleared[] = 'WP Rocket — minified CSS/JS';
	}
	if ( function_exists( 'rocket_clean_used_css' ) ) {
		rocket_clean_used_css();
		$cleared[] = 'WP Rocket — used CSS';
	}
	if ( function_exists( 'rocket_clean_cache_busting' ) ) {
		rocket_clean_cache_busting();
		$cleared[] = 'WP Rocket — cache busting';
	}

	$rocket_cache_dir = WP_CONTENT_DIR . '/cache/wp-rocket/';
	if ( is_dir( $rocket_cache_dir ) && is_writable( $rocket_cache_dir ) ) {
		iec_recursive_delete( $rocket_cache_dir, false );
		$cleared[] = 'WP Rocket — cache folder cleaned';
	}

	if ( function_exists( 'wp_cache_flush' ) ) {
		wp_cache_flush();
		$cleared[] = 'Redis — object cache flushed';
	}

	global $redis_object_cache;
	if ( isset( $redis_object_cache ) && method_exists( $redis_object_cache, 'flush' ) ) {
		$redis_object_cache->flush();
		$cleared[] = 'Redis — direct flush';
	}

	if ( function_exists( 'opcache_reset' ) ) {
		opcache_reset();
		$cleared[] = 'Apache — PHP OPcache reset';
	}

	if ( function_exists( 'apache_get_modules' ) ) {
		$modules = apache_get_modules();
		if ( in_array( 'mod_pagespeed', $modules, true ) ) {
			wp_remote_request( home_url( '/?ModPagespeed=off' ), array( 'timeout' => 5 ) );
			$cleared[] = 'Apache — mod_pagespeed';
		}
	}

	if ( function_exists( 'apcu_clear_cache' ) ) {
		apcu_clear_cache();
		$cleared[] = 'Apache — APCu cache';
	}

	$wp_cache_dir = WP_CONTENT_DIR . '/cache/';
	if ( is_dir( $wp_cache_dir ) ) {
		foreach ( array( 'min', 'minify', 'busting', 'critical-css' ) as $sub ) {
			$path = $wp_cache_dir . $sub . '/';
			if ( is_dir( $path ) && is_writable( $path ) ) {
				iec_recursive_delete( $path, false );
				$cleared[] = 'Cache — ' . $sub . ' folder';
			}
		}
	}

	global $wpdb;
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_transient_iec_%' OR option_name LIKE '_transient_timeout_iec_%'" );
	$wpdb->query( "DELETE FROM {$wpdb->options} WHERE option_name LIKE '_site_transient_iec_%' OR option_name LIKE '_site_transient_timeout_iec_%'" );
	$cleared[] = 'WordPress — iec transients';

	if ( defined( 'CF_API_KEY' ) && defined( 'CF_ZONE_ID' ) && defined( 'CF_EMAIL' ) ) {
		wp_remote_post(
			'https://api.cloudflare.com/client/v4/zones/' . CF_ZONE_ID . '/purge_cache',
			array(
				'headers' => array(
					'X-Auth-Email' => CF_EMAIL,
					'X-Auth-Key'   => CF_API_KEY,
					'Content-Type' => 'application/json',
				),
				'body'    => wp_json_encode( array( 'purge_everything' => true ) ),
				'timeout' => 15,
			)
		);
		$cleared[] = 'CloudFlare — edge cache';
	}

	return $cleared;
}

function iec_preload_cache() {
	if ( function_exists( 'run_rocket_sitemap_preload' ) ) {
		run_rocket_sitemap_preload();
		return array( 'WP Rocket — sitemap preload triggered' );
	}

	$urls = iec_get_urls_from_sitemap();

	if ( empty( $urls ) ) {
		$urls = array( home_url( '/' ) );
		$posts  = get_posts(
			array(
				'post_type'      => array( 'post', 'page', 'office', 'product', 'solution', 'news' ),
				'post_status'    => 'publish',
				'posts_per_page' => 200,
				'fields'         => 'ids',
			)
		);
		foreach ( $posts as $id ) {
			$urls[] = get_permalink( $id );
		}
	}

	$urls = array_unique( $urls );

	set_transient( 'iec_preload_queue', $urls, HOUR_IN_SECONDS );
	set_transient( 'iec_preload_total', count( $urls ), HOUR_IN_SECONDS );
	set_transient( 'iec_preload_done', 0, HOUR_IN_SECONDS );

	if ( ! wp_next_scheduled( 'iec_preload_batch_event' ) ) {
		wp_schedule_single_event( time() + 5, 'iec_preload_batch_event' );
	}

	return array( 'Preload — ' . count( $urls ) . ' URLs queued (background crawl started)' );
}

function iec_get_urls_from_sitemap() {
	$sitemap_candidates = array(
		home_url( '/sitemap.xml' ),
		home_url( '/sitemap_index.xml' ),
		home_url( '/wp-sitemap.xml' ),
	);

	$urls = array();

	foreach ( $sitemap_candidates as $sitemap_url ) {
		$response = wp_remote_get( $sitemap_url, array( 'timeout' => 10 ) );
		if ( is_wp_error( $response ) || 200 !== (int) wp_remote_retrieve_response_code( $response ) ) {
			continue;
		}

		$body = wp_remote_retrieve_body( $response );

		if ( false !== strpos( $body, '<sitemap>' ) ) {
			preg_match_all( '/<loc>(.*?)<\/loc>/s', $body, $index_matches );
			foreach ( $index_matches[1] as $child_sitemap ) {
				$child_response = wp_remote_get( trim( $child_sitemap ), array( 'timeout' => 10 ) );
				if ( ! is_wp_error( $child_response ) && 200 === (int) wp_remote_retrieve_response_code( $child_response ) ) {
					preg_match_all( '/<loc>(.*?)<\/loc>/s', wp_remote_retrieve_body( $child_response ), $url_matches );
					$urls = array_merge( $urls, array_map( 'trim', $url_matches[1] ) );
				}
			}
			break;
		}

		preg_match_all( '/<loc>(.*?)<\/loc>/s', $body, $url_matches );
		if ( ! empty( $url_matches[1] ) ) {
			$urls = array_merge( $urls, array_map( 'trim', $url_matches[1] ) );
			break;
		}
	}

	return $urls;
}

function iec_preload_batch_handler() {
	$queue = get_transient( 'iec_preload_queue' );
	if ( empty( $queue ) ) {
		return;
	}

	$batch = array_splice( $queue, 0, 10 );

	foreach ( $batch as $url ) {
		wp_remote_get(
			$url,
			array(
				'timeout'    => 8,
				'blocking'   => false,
				'user-agent' => 'IEC-Cache-Preloader/1.0',
				'sslverify'  => true,
			)
		);
	}

	$done = (int) get_transient( 'iec_preload_done' ) + count( $batch );
	set_transient( 'iec_preload_done', $done, HOUR_IN_SECONDS );

	if ( ! empty( $queue ) ) {
		set_transient( 'iec_preload_queue', $queue, HOUR_IN_SECONDS );
		wp_schedule_single_event( time() + 3, 'iec_preload_batch_event' );
	} else {
		delete_transient( 'iec_preload_queue' );
	}
}
add_action( 'iec_preload_batch_event', 'iec_preload_batch_handler' );

function iec_recursive_delete( $dir, $remove_dir = true ) {
	if ( ! is_dir( $dir ) ) {
		return;
	}

	$files = array_diff( scandir( $dir ), array( '.', '..' ) );
	foreach ( $files as $file ) {
		$path = $dir . DIRECTORY_SEPARATOR . $file;
		if ( is_dir( $path ) ) {
			iec_recursive_delete( $path );
		} else {

			@unlink( $path );
		}
	}

	if ( $remove_dir ) {

		@rmdir( $dir );
	}
}
