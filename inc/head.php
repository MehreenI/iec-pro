<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="google-site-verification" content="3VkurVEYKdL17fKZiFxT87AKz7tBq0vCkIR9PYzKxvo" />
    <title><?= wp_get_document_title(); ?></title>
    <?php wp_head(); ?>

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','GTM-TTNQ2WQ');</script>
    <!-- End Google Tag Manager -->

    <?php
    $gtm_container_id = get_config( 'bbpress_google_gtm_container_id' );
    $cookie_accepted  = isset( $_COOKIE['cookie_notice_accepted'] ) && filter_var( wp_unslash( $_COOKIE['cookie_notice_accepted'] ), FILTER_VALIDATE_BOOLEAN );
    ?>

    <?php if ( ! empty( $gtm_container_id ) ) : ?>
        <!-- Google Tag Manager (dynamic) -->
        <script>
            function addGTMScript( w, d, s, l, i ) {
                w[l] = w[l] || [];
                w[l].push( { 'gtm.start': new Date().getTime(), event: 'gtm.js' } );
                var f  = d.getElementsByTagName( s )[0],
                    j  = d.createElement( s ),
                    dl = l !== 'dataLayer' ? '&l=' + l : '';
                j.async = true;
                j.src   = 'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
                f.parentNode.insertBefore( j, f );
            }

            function initGTM() {
                if ( window.gtmDidInit ) {
                    return;
                }
                window.gtmDidInit = true;
                addGTMScript( window, document, 'script', 'dataLayer', '<?= esc_js( $gtm_container_id ); ?>' );
            }
        </script>
        <!-- End Google Tag Manager (dynamic) -->
    <?php endif; ?>

    <?php if ( is_single( 927 ) ) : ?>
        <!-- Google Ads: 10785844840 -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=AW-10785844840"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push( arguments ); }
            gtag( 'js', new Date() );
            gtag( 'config', 'AW-10785844840' );
            gtag( 'event', 'conversion', { 'send_to': 'AW-10785844840/sLzoCNWTwPkCEOjci5co' } );
        </script>
    <?php endif; ?>

    <?php if ( is_single() ) : ?>
        <script type="application/ld+json">
            {
                "@context": "https://schema.org",
                "@type": "BlogPosting",
                "mainEntityOfPage": {
                    "@type": "WebPage",
                    "@id": "<?= esc_url( get_permalink() ); ?>"
			},
			"headline": <?= wp_json_encode( get_the_title() ); ?>,
			"description": <?= wp_json_encode( wp_strip_all_tags( get_the_excerpt() ) ); ?>,
			"image": "<?= esc_url( get_the_post_thumbnail_url( null, 'full' ) ); ?>",
			"author": {
				"@type": "Organization",
				"name": "IEC Telecom",
				"url": "<?= esc_url( home_url( '/' ) ); ?>"
			},
			"publisher": {
				"@type": "Organization",
				"name": "IEC Telecom",
				"logo": {
					"@type": "ImageObject",
					"url": "<?= esc_url( get_template_directory_uri() . '/assets/img/logo.svg' ); ?>"
				}
			},
			"datePublished": "<?= esc_attr( get_the_date( 'c' ) ); ?>"
		}
        </script>
    <?php endif; ?>
</head>

<?php
$page_title   = get_the_title();
$page_slug    = sanitize_title( $page_title );
$body_classes = array( $page_slug );
if ( is_tax( 'news_type' ) ) {
    $body_classes[] = 'news-landing-page';
    $body_classes[] = 'news-type-archive';
}

if ( is_page() ) {
    $template_file = get_page_template_slug();

    if ( ! empty( $template_file ) ) {
        $body_classes[] = 'page-template-' . pathinfo( $template_file, PATHINFO_FILENAME );
    }

    $template_class_map = array(
        'page-templates/home-page.php'                  => 'home-page-v2',
        'page-templates/about-introduction-page.php'    => 'introduction-page',
        'page-templates/about-history-page.php'         => 'history-page',
        'page-templates/about-management-page.php'      => 'management-page',
        'page-templates/about-partners-page.php'        => 'partners-page',
        'page-templates/become-partner-page.php'        => 'become-partner-page',
        'page-templates/contact-us.php'                 => 'contact-us-page',
        'page-templates/iot-page.php'                   => 'iot-page',
        'page-templates/job-landing-page.php'           => 'job-landing-page',
        'page-templates/market-detail-page.php'         => 'market-detail-page',
        'page-templates/news-landing-page.php'          => 'news-landing-page',
        'page-templates/starlink-landing.php'           => 'starlink-landing-page',
        'page-templates/maritime-starlink-landing.php'  => 'maritime-starlink-landing-page',
    );

    if ( isset( $template_class_map[ $template_file ] ) ) {
        $body_classes[] = $template_class_map[ $template_file ];
    }
}

if ( function_exists( 'iec_extra_body_classes' ) ) {
    $body_classes = array_merge( $body_classes, iec_extra_body_classes() );
}
?>
<body <?php body_class( $body_classes ); ?> data-page="<?= esc_attr( $page_slug ); ?>">

<?php if ( ! empty( $gtm_container_id ) && $cookie_accepted ) : ?>
    <noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=<?= esc_attr( $gtm_container_id ); ?>"
                height="0" width="0" style="display:none;visibility:hidden" title="<?php esc_attr_e( 'Google Tag Manager', 'bbtheme' ); ?>"></iframe>
    </noscript>
<?php endif; ?>
