<?php get_template_part( 'inc/footer' ); ?>

<?php wp_footer(); ?>

<?php
$ads_post_id     = (int) apply_filters( 'iec_ads_conversion_post_id', 927 );
$cookie_accepted = isset( $_COOKIE['cookie_notice_accepted'] ) && filter_var( wp_unslash( $_COOKIE['cookie_notice_accepted'] ), FILTER_VALIDATE_BOOLEAN );
if ( $cookie_accepted && $ads_post_id && is_single( $ads_post_id ) ) :
?>
    <script>
        _linkedin_partner_id = '3965865';
        window._linkedin_data_partner_ids = window._linkedin_data_partner_ids || [];
        window._linkedin_data_partner_ids.push( _linkedin_partner_id );
        (function( l ) {
            if ( ! l ) {
                window.lintrk = function( a, b ) { window.lintrk.q.push( [a, b] ); };
                window.lintrk.q = [];
            }
            var s = document.getElementsByTagName( 'script' )[0];
            var b = document.createElement( 'script' );
            b.type  = 'text/javascript';
            b.async = true;
            b.src   = 'https://snap.licdn.com/li.lms-analytics/insight.min.js';
            s.parentNode.insertBefore( b, s );
        })( window.lintrk );
    </script>
    <noscript>
        <img height="1" width="1" style="display:none;" alt="" src="https://px.ads.linkedin.com/collect/?pid=3965865&fmt=gif">
    </noscript>
<?php endif; ?>

</body>
</html>
