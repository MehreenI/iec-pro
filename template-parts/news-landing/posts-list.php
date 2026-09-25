<?php
/**
 * News landing — AJAX posts list shell.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div class="iec_news_main_posts_warpper" data-news-posts>
	<div class="iec_news_posts_list" role="feed" aria-live="polite"></div>
	<div class="iec_news_loader" aria-hidden="true">
		<div class="iec_news_spinner"></div>
	</div>
	<nav class="iec_paginate" aria-label="<?= __( 'News pagination', 'bbtheme' ); ?>"></nav>
</div>
