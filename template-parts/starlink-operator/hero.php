<?php
/**
 * Starlink Operator — hero + floating stats.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields       = $args['fields'] ?? array();
$banner       = $fields['banner'] ?? array();
$banner_image = $banner['image']['url'] ?? 'https://staging.iec-telecom.com/wp-content/uploads/2026/08/starlink-banner-1-1.webp';
$eyebrow      = $banner['eyebrow'] ?? 'Global Connectivity';
$title        = $banner['overlay_title'] ?? 'Starlink Connectivity Powered by IEC Telecom';
$lead         = $banner['sub_heading'] ?? 'High-speed, low-latency satellite internet for businesses, vessels, and remote operations — backed by IEC Telecom managed services.';

$contact_url = home_url( '/contact-us/' );
if ( function_exists( 'iec_resolve_wpml_url' ) ) {
	$contact_url = iec_resolve_wpml_url( $contact_url );
}
?>
<section
	class="iec-hero-banner"
	style="--slo-hero-bg: url('<?php echo esc_url( $banner_image ); ?>');"
	aria-label="Starlink hero"
>
	<div class="container">
        <div class="row">
            <div class="col-md-7">
                <span class="iec_home_eyebrow"><?php echo esc_html( $eyebrow ); ?></span>
                <h1 class="iec_section_heading"><?php echo esc_html( $title ); ?></h1>
                <div class="wyswig-content">
                    <p><?php echo wp_kses_post( $lead ); ?></p>
                </div>

                <div class="btns">
                    <a href="#products" class="iec_button iec_blue_gradient">Explore Starlink Products</a>
                    <a href="<?php echo esc_url( $contact_url ); ?>" class="gray_btn">Talk to a Specialist</a>
                </div>

            </div>

        </div>

	</div>
</section>

<!--<div class="slo-hero-stats">-->
<!--	<div class="container">-->
<!--		<div class="slo-hero-stats__card slo-reveal is-visible" role="list">-->
<!--			<div class="slo-hero-stats__item" role="listitem">-->
<!--				<div class="slo-hero-stats__icon" aria-hidden="true">-->
<!--					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M4 20V10M10 20V4M16 20v-7M22 20V13" stroke-linecap="round"/></svg>-->
<!--				</div>-->
<!--				<b>Low Earth Orbit</b>-->
<!--				<span>Low-latency broadband</span>-->
<!--			</div>-->
<!--			<div class="slo-hero-stats__item" role="listitem">-->
<!--				<div class="slo-hero-stats__icon" aria-hidden="true">-->
<!--					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2" stroke-linecap="round" stroke-linejoin="round"/></svg>-->
<!--				</div>-->
<!--				<b>Land</b>-->
<!--				<span>Fixed &amp; remote sites</span>-->
<!--			</div>-->
<!--			<div class="slo-hero-stats__item" role="listitem">-->
<!--				<div class="slo-hero-stats__icon" aria-hidden="true">-->
<!--					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M3 12h18M12 3c2.5 2.6 3.8 5.7 3.8 9s-1.3 6.4-3.8 9c-2.5-2.6-3.8-5.7-3.8-9s1.3-6.4 3.8-9Z" stroke-linecap="round"/></svg>-->
<!--				</div>-->
<!--				<b>Maritime</b>-->
<!--				<span>Vessels &amp; offshore</span>-->
<!--			</div>-->
<!--			<div class="slo-hero-stats__item" role="listitem">-->
<!--				<div class="slo-hero-stats__icon" aria-hidden="true">-->
<!--					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><path d="M12 3l7 3v6c0 4.5-3 7.5-7 9-4-1.5-7-4.5-7-9V6l7-3Z" stroke-linecap="round" stroke-linejoin="round"/><path d="M9 12l2 2 4-4" stroke-linecap="round" stroke-linejoin="round"/></svg>-->
<!--				</div>-->
<!--				<b>Mobility</b>-->
<!--				<span>In-motion connectivity</span>-->
<!--			</div>-->
<!--		</div>-->
<!--	</div>-->
<!--</div>-->
