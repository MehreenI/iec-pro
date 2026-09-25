<?php
/**
 * Starlink Operator — solutions for every industry (flip cards).
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$contact_url = home_url( '/contact-us/' );
if ( function_exists( 'iec_resolve_wpml_url' ) ) {
	$contact_url = iec_resolve_wpml_url( $contact_url );
}

$cards = array(
	array(
		'num'   => '01',
		'title' => 'Enterprise & Branch Connectivity',
		'blurb' => 'Secure, high-performance internet for offices, retail, and distributed operations.',
		'back'  => 'Connected Everywhere.',
		'desc'  => 'Extend dependable connectivity to remote offices, branches and temporary sites without relying on traditional terrestrial infrastructure.',
		'bullets' => array( 'High-speed business internet', 'Secure branch connectivity', 'Fast deployment' ),
	),
	array(
		'num'   => '02',
		'title' => 'Maritime Connectivity',
		'blurb' => 'Stay connected at sea with high-speed internet for vessels of all sizes.',
		'back'  => 'Connectivity Beyond Shore.',
		'desc'  => 'Keep crews connected and operations productive with reliable communications across demanding maritime environments.',
		'bullets' => array( 'At-sea connectivity', 'Low-latency communications', 'Built for offshore environments' ),
	),
	array(
		'num'   => '03',
		'title' => 'Mobile & Land Connectivity',
		'blurb' => 'Keep your fleets, vehicles, and field teams connected in motion.',
		'back'  => 'Move Without Losing Signal.',
		'desc'  => 'Give mobile teams the connectivity they need across roads, remote sites and changing locations.',
		'bullets' => array( 'Connectivity on the move', 'Remote field operations', 'Flexible deployment' ),
	),
	array(
		'num'   => '04',
		'title' => 'Energy & Resources',
		'blurb' => 'Reliable connectivity for remote sites, exploration, and industrial operations.',
		'back'  => 'Powering Remote Operations.',
		'desc'  => 'Connect critical infrastructure, exploration sites and industrial teams where conventional networks cannot reach.',
		'bullets' => array( 'Remote-site connectivity', 'Industrial operations support', 'Rapid deployment' ),
	),
);
?>
<section class="slo-sec slo-industry" id="solutions" aria-labelledby="slo-industry-heading">
	<div class="container">
		<div class="slo-section-head slo-section-head--center slo-reveal">
			<span class="iec_home_eyebrow">Solutions for Every Industry</span>
			<h2 class="slo-h2" id="slo-industry-heading">Reliable Internet for Mission-Critical Operations</h2>
			<p class="slo-lead">Stay connected wherever your business takes you with reliable, high-performance satellite connectivity.</p>
		</div>

		<div class="slo-industry__grid">
			<?php foreach ( $cards as $i => $card ) : ?>
				<article class="slo-industry__card slo-reveal" style="--i:<?php echo (int) $i; ?>">
					<div class="slo-industry__inner">
						<div class="slo-industry__face slo-industry__face--front">
							<span class="slo-industry__num"><?php echo esc_html( $card['num'] ); ?></span>
							<div class="slo-industry__icon" aria-hidden="true">
								<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"/><path d="M8 12h8M12 8v8" stroke-linecap="round"/></svg>
							</div>
							<h3><?php echo esc_html( $card['title'] ); ?></h3>
							<p><?php echo esc_html( $card['blurb'] ); ?></p>
							<span class="slo-industry__hint">Hover to explore <b aria-hidden="true">↗</b></span>
						</div>
						<div class="slo-industry__face slo-industry__face--back">
							<span class="slo-industry__back-label"><?php echo esc_html( $card['num'] ); ?> / Solution</span>
							<h3><?php echo esc_html( $card['back'] ); ?></h3>
							<p><?php echo esc_html( $card['desc'] ); ?></p>
							<ul>
								<?php foreach ( $card['bullets'] as $bullet ) : ?>
									<li><?php echo esc_html( $bullet ); ?></li>
								<?php endforeach; ?>
							</ul>
							<a class="slo-industry__link" href="<?php echo esc_url( $contact_url ); ?>">Explore solution <span aria-hidden="true">→</span></a>
						</div>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
