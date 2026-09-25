<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

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
		var ajax = <?php echo wp_json_encode( $ajax ); ?>;
		var nonce = <?php echo wp_json_encode( $nonce ); ?>;
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
