<?php
/**
 * News Type taxonomy archive.
 *
 * Uses the same layout and assets as the News Landing Page,
 * scoped to the current news_type term.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require get_template_directory() . '/page-templates/news-landing-page.php';
