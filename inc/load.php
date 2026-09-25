<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$iec_inc = get_template_directory() . '/inc';

require_once $iec_inc . '/setup/theme-setup.php';
require_once $iec_inc . '/setup/runtime.php';
require_once $iec_inc . '/setup/enqueue.php';

require_once $iec_inc . '/helpers/helpers.php';
require_once $iec_inc . '/helpers/filters.php';
require_once $iec_inc . '/helpers/helpers-news-landing.php';
require_once $iec_inc . '/helpers/helpers-news.php';
require_once $iec_inc . '/helpers/helpers-office.php';
require_once $iec_inc . '/helpers/helpers-offices-landing.php';
require_once $iec_inc . '/helpers/helpers-product.php';
require_once $iec_inc . '/helpers/helpers-solution.php';

require_once $iec_inc . '/pages/page-tunisian.php';
require_once $iec_inc . '/pages/page-starlink.php';
require_once $iec_inc . '/pages/page-t-solution-product.php';
require_once $iec_inc . '/pages/page-optiview.php';
require_once $iec_inc . '/pages/page-operator.php';

require_once $iec_inc . '/api/api.php';

require_once $iec_inc . '/admin/cache-tools.php';
require_once $iec_inc . '/admin/cache-tools-admin.php';
