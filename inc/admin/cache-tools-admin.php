<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

add_action( 'init', function() {
	if ( ! isset( $_GET['clear_cache'] ) ) {
		return;
	}

	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( 'Access Denied', 'Access Denied', array( 'response' => 403 ) );
	}

	if ( ! defined( 'IEC_CACHE_KEY' ) || '' === IEC_CACHE_KEY || ! hash_equals( (string) IEC_CACHE_KEY, (string) wp_unslash( $_GET['clear_cache'] ) ) ) {
		wp_die( 'Invalid key', 'Access Denied', array( 'response' => 403 ) );
	}

	$cleared   = iec_clear_all_caches();
	$preloaded = iec_preload_cache();

	header( 'Content-Type: text/html; charset=utf-8' );
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>Cache Cleared — IEC Telecom</title>
		<meta name="robots" content="noindex,nofollow">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<style>
			* { box-sizing: border-box; }
			body { font-family: -apple-system, Arial, sans-serif; padding: 20px; background: linear-gradient(135deg,#1b204c 0%,#727da3 100%); margin: 0; min-height: 100vh; }
			.box { background: #fff; max-width: 540px; margin: 40px auto; padding: 40px; border-radius: 12px; box-shadow: 0 20px 50px rgba(0,0,0,0.25); }
			h1 { color: #1b204c; margin: 0 0 8px; font-size: 28px; }
			.meta { color: #666; font-size: 14px; margin-bottom: 24px; }
			ul { list-style: none; padding: 0; margin: 0; }
			li { padding: 11px 16px; background: #f0f4f8; margin: 6px 0; border-left: 4px solid #28a745; border-radius: 4px; font-size: 14px; color: #1b204c; }
			li.preload { border-left-color: #f57c00; background: #fff8f0; }
			.btn { display: inline-block; margin-top: 24px; padding: 13px 32px; background: #1b204c; color: #fff; text-decoration: none; border-radius: 6px; font-weight: 600; }
			.badge { display: inline-block; background: #28a745; color: #fff; padding: 4px 12px; border-radius: 20px; font-size: 12px; font-weight: 600; }
			.badge.preload { background: #f57c00; }
		</style>
	</head>
	<body>
		<div class="box">
			<h1>Cache Cleared + Preloading</h1>
			<p class="meta">
				<span class="badge"><?= count( $cleared ); ?> CACHES PURGED</span>
				<span class="badge preload">PRELOAD STARTED</span>
				<?= current_time( 'd M Y, H:i:s' ); ?>
			</p>
			<ul>
				<?php foreach ( $cleared as $item ) : ?>
					<li><?= $item; ?></li>
				<?php endforeach; ?>

				<?php foreach ( $preloaded as $item ) : ?>
					<li class="preload"><?= $item; ?></li>
				<?php endforeach; ?>
			</ul>
			<a href="<?= esc_url( home_url() ); ?>" class="btn">Back to Site</a>
		</div>
	</body>
	</html>
	<?php
	exit;
} );

add_action( 'wp_footer', function() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$nonce = wp_create_nonce( 'iec_clear_cache_ajax' );
	$ajax  = admin_url( 'admin-ajax.php' );
	?>
	<div id="iec-cache-fab" style="position:fixed;bottom:25px;right:25px;z-index:99999;font-family:Arial,sans-serif;">
		<button id="iec-cache-btn" type="button" style="display:flex;align-items:center;gap:10px;padding:14px 22px;background:linear-gradient(135deg,#1b204c,#727da3);color:#fff;border:none;border-radius:50px;cursor:pointer;font-size:14px;font-weight:600;box-shadow:0 6px 20px rgba(27,32,76,0.4);">
			<span id="iec-cache-icon">Clear</span>
			<span id="iec-cache-text">Cache</span>
		</button>
		<div id="iec-cache-result" style="display:none;margin-top:12px;padding:15px;background:#fff;border-radius:10px;box-shadow:0 6px 20px rgba(0,0,0,0.15);max-width:320px;font-size:13px;color:#1b204c;"></div>
	</div>
	<script>
	(function() {
		var btn = document.getElementById('iec-cache-btn');
		var box = document.getElementById('iec-cache-result');
		var ajax = <?= wp_json_encode( $ajax ); ?>;
		var nonce = <?= wp_json_encode( $nonce ); ?>;
		btn.addEventListener('click', function() {
			if (!confirm('Clear all caches and start preload?')) return;
			btn.disabled = true;
			var fd = new FormData();
			fd.append('action', 'iec_clear_all_cache');
			fd.append('_wpnonce', nonce);
			fetch(ajax, { method: 'POST', body: fd, credentials: 'same-origin' })
				.then(function(r) { return r.json(); })
				.then(function(data) {
					if (data.success) {
						box.style.display = 'block';
						box.innerHTML = data.data.count + ' caches cleared';
					}
					btn.disabled = false;
				})
				.catch(function() { btn.disabled = false; });
		});
	})();
	</script>
	<?php
} );

add_action( 'wp_ajax_iec_preload_progress', function() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die();
	}
	wp_send_json_success(
		array(
			'done'  => (int) get_transient( 'iec_preload_done' ),
			'total' => (int) get_transient( 'iec_preload_total' ),
			'queue' => count( (array) get_transient( 'iec_preload_queue' ) ),
		)
	);
} );

add_action( 'wp_ajax_iec_clear_all_cache', function() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_send_json_error( array( 'message' => 'Unauthorized' ), 403 );
	}
	check_ajax_referer( 'iec_clear_cache_ajax', '_wpnonce' );

	$cleared   = iec_clear_all_caches();
	$preloaded = iec_preload_cache();

	wp_send_json_success(
		array(
			'cleared'       => $cleared,
			'preloaded'     => $preloaded,
			'time'          => current_time( 'mysql' ),
			'count'         => count( $cleared ),
			'preload_total' => (int) get_transient( 'iec_preload_total' ),
		)
	);
} );
