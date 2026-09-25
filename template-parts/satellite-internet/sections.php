<?php
/**
 * Satellite Internet — page ke sections.
 *
 * Saara text data/Page-data.docx se hai, waise ka waisa. Sirf headings aur
 * anchor labels design ke liye usi zubaan se banaye gaye hain. Sab kuch static
 * hai — dynamic banane ka kaam baad mein.
 *
 * Ye partial do jagah se chalta hai: Satellite Internet template, aur default
 * page ka khaali-state fallback. Markup ek hi jagah rahe, is liye dono isi ko
 * call karte hain.
 *
 * Poori section library Component Template mein hai:
 * template-parts/component-template/.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$img = trailingslashit(get_template_directory_uri()) . 'assets/img/';
?>
<div class="iec_flex_sections">
    <section class="iec_defualt_position iec_section_home_hero iec_hero_banner iec-banner iec-banner--bg-only d-flex align-items-center justify-content-center" aria-label="Satellite internet hero" data-strip-reveal="8" data-strip-direction="vertical">
        <div class="swiper iec-home-hero-swiper"  data-swiper="bg-only">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <picture>
                        <source media="(max-width: 767px)" srcset="https://staging.iec-telecom.com/wp-content/uploads/2026/09/Shipping_page_hero_mobile_banner_447x1000.webp">
                        <img class="iec_home_hero_bg_img" src="https://staging.iec-telecom.com/wp-content/uploads/2026/09/Shipping_page_hero_banner_1.webp" alt="" decoding="async">
                    </picture>
                </div>

                <div class="swiper-slide">
                    <picture>
                        <source media="(max-width: 767px)" srcset="https://staging.iec-telecom.com/wp-content/uploads/2026/09/01_Hero-Banners_Singapore_Crew-Welfare-_Mobile_447x800_Background.webp">
                        <img class="iec_home_hero_bg_img" src="https://staging.iec-telecom.com/wp-content/uploads/2026/09/1.webp" alt="" decoding="async">
                    </picture>

                </div>

                <div class="swiper-slide">
                    <picture>
                        <source media="(max-width: 767px)" srcset="https://staging.iec-telecom.com/wp-content/uploads/2026/09/new-mobile-2.webp">
                        <img class="iec_home_hero_bg_img" src="https://staging.iec-telecom.com/wp-content/uploads/2026/09/01_Hero-Banners_Singapore_Crew-Welfare_Background.webp" alt="" loading="lazy" decoding="async">
                    </picture>

                </div>
            </div>

            <div class="iec-banner-pagination"></div>

            <?php iec_module( 'swiper-arrows' ); ?>
        </div>

        <div class="iec_home_hero_shade" aria-hidden="true"></div>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="iec_banner_hero_content">
                    <span class="iec-eyebrow">Satellite internet / Managed connectivity</span>

                    <h1 class="iec-primary-heading text-white">Satellite Internet <br>for Remote Operations</h1>

                        <div class="iec_hero_desc wysiwyg-content">
                    <p>Satellite internet provides reliable connectivity for businesses operating in locations where
                        fibre, telephone lines, or other terrestrial networks are unavailable, unreliable, or too
                        expensive to install. </p>
                        </div>
                    <nav class="iec_hero_flat_actions navigation-buttons">
                        <a href="#contact" class="btn satellite-internet btn-primary is-in">Contact IEC Telecom <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M3 10h13M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>

                        <a href="#why-iec" class="btn outline-btn">How IEC Telecom helps</a>
                    </nav>

                    <div class="iec_hero_flat_stats satellite-internet ">
                        <div class="iec_hero_flat_stat">
                            <b>30+</b>

                            <span>Years of expertise</span>
                        </div>

                        <div class="iec_hero_flat_stat">
                            <b>10</b>

                            <span>Regional offices</span>
                        </div>

                        <div class="iec_hero_flat_stat">
                            <b>24/7</b>

                            <span>Global technical support</span>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <nav class="iec_anchor_bar iec_anchor_bar_dark" aria-label="Page sections">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <ul class="iec_anchor_bar_list">
                        <li class="is-active"><a href="#what-is">What it is</a></li>
                        <li><a href="#how-it-works">How it works</a></li>
                        <li><a href="#technologies">Technologies</a></li>
                        <li><a href="#applications">Applications</a></li>
                        <li><a href="#why-iec">Why IEC</a></li>
                        <li><a href="#services">Our services</a></li>
                        <li><a href="#contact">Contact</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <section class="iec_defualt_position p-3 iec_compare" id="what-is">
        <div class="container">

            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="iec_compare_copy">
                            <span class="iec-eyebrow">What it is</span>

                            <h2 class="iec-section-heading mb-1">Connectivity without <span class="highlight">fixed infrastructure</span></h2>

                        <div class="wysiwyg-content">
                            <p>Satellite internet provides an alternative by delivering connectivity through satellites
                                rather than relying on cables extended to the site. In T&uuml;rkiye, this type of
                                connectivity may also be described as &ldquo;altyap&#305;s&#305;z internet&rdquo;,
                                particularly when referring to internet access in locations without conventional fixed
                                infrastructure.</p>

                            <p>It can be used as the primary connection where terrestrial infrastructure is unavailable
                                or as a backup solution when existing networks experience an outage. When combined with
                                automatic failover, a backup connection can help reduce disruption and maintain access to
                                critical applications during a terrestrial network outage.</p>
                        </div>

                        <div class="iec_compare_note">
                            <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M10 18s6-5.1 6-9.3A6 6 0 0 0 4 8.7C4 12.9 10 18 10 18Z" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/><circle cx="10" cy="8.6" r="2.1" stroke="currentColor" stroke-width="1.6"/></svg>

                            <div class="wysiwyg-content">
                                <p>Because a new fibre or cable connection does not need to be extended to the site,
                                    satellite internet can often be deployed more quickly in remote or temporary
                                    locations.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="iec_compare_card primary-bg satelite_internet">
                        <h3 class="text-white">Traditional internet access typically depends on infrastructure such as</h3>

                        <ul class="iec_compare_list is-pairs text-white">
                            <li><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M5 5l10 10M15 5L5 15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>Fibre-optic cables</li>
                            <li><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M5 5l10 10M15 5L5 15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>ADSL or VDSL</li>
                            <li><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M5 5l10 10M15 5L5 15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>Telephone lines</li>
                            <li><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M5 5l10 10M15 5L5 15" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>Cable broadband</li>
                        </ul>

                        <hr class="iec_compare_rule">

                        <h3 class="is-lead text-white">Primary connection or backup</h3>

                        <ul class="iec_compare_list text-white is-ticks">
                            <li><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10.5l4 4 8-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>The primary connection where terrestrial infrastructure is unavailable</li>
                            <li><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10.5l4 4 8-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>A backup solution when existing networks experience an outage</li>
                            <li><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10.5l4 4 8-9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>Combined with automatic failover to help reduce disruption</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="iec_defualt_position p-3 iec_glass_band" id="technologies" style="--bandImage: url('<?= $img; ?>Market-images/Maritime-bg.png');">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-5">
                    <div class="iec_glass_band_copy">
                        <span class="iec-eyebrow">Satellite Technologies</span>

                        <h2 class="iec-section-heading mb-1 text-white">Satellite connectivity comparison</h2>

                        <div class="wysiwyg-content">
                            <p>The right technology depends on the location, operational requirements, available coverage,
                                local regulations, and the applications that need to be supported.</p>
                        </div>

                        <a href="#why-iec" class="iec_glass_band_cta">How IEC Telecom helps <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M3 10h13M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="grid-2 iec_glass_grid">
                        <div class="iec_glass_card">
                            <span class="iec_glass_card_icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.5" fill="none"/><path d="M3.5 12h17M12 3.5c2.2 2.3 3.3 5.3 3.3 8.5S14.2 18.2 12 20.5c-2.2-2.3-3.3-5.3-3.3-8.5S9.8 5.8 12 3.5Z" stroke="currentColor" stroke-width="1.5" fill="none"/></svg></span>

                            <h3>GEO satellite</h3>

                            <div class="wysiwyg-content">
                                <p>Wide coverage and established service availability</p>
                            </div>

                            <p class="iec_glass_card_role">Permanent and remote operations</p>
                        </div>

                        <div class="iec_glass_card">
                            <span class="iec_glass_card_icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M13.2 3 5.8 13.2h5.1L10.4 21l7.8-10.5h-5.3L13.2 3Z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/></svg></span>

                            <h3>LEO satellite</h3>

                            <div class="wysiwyg-content">
                                <p>High-speed, lower-latency connectivity</p>
                            </div>

                            <p class="iec_glass_card_role">Data-intensive business applications</p>
                        </div>

                        <div class="iec_glass_card">
                            <span class="iec_glass_card_icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 3l7 3v5.5c0 4.2-2.9 7.6-7 9-4.1-1.4-7-4.8-7-9V6l7-3Z" stroke="currentColor" stroke-width="1.5" fill="none" stroke-linejoin="round"/></svg></span>

                            <h3>L-band satellite services</h3>

                            <div class="wysiwyg-content">
                                <p>Resilient connectivity using compact equipment</p>
                            </div>

                            <p class="iec_glass_card_role">Critical communications and backup</p>
                        </div>

                        <div class="iec_glass_card">
                            <span class="iec_glass_card_icon" aria-hidden="true"><svg viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="4.6" cy="6.4" r="2.1" stroke="currentColor" stroke-width="1.5"/><circle cx="4.6" cy="17.6" r="2.1" stroke="currentColor" stroke-width="1.5"/><circle cx="19.4" cy="12" r="2.1" stroke="currentColor" stroke-width="1.5"/><path d="M6.6 7.4 17.4 11.2M6.6 16.6 17.4 12.8" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg></span>

                            <h3>Hybrid connectivity</h3>

                            <div class="wysiwyg-content">
                                <p>Combines multiple available networks</p>
                            </div>

                            <p class="iec_glass_card_role">Business continuity and redundancy</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="iec_defualt_position iec_price_factors is-bg-tint" id="pricing-factors">
        <div class="container">

            <div class="row">
                <div class="col-md-12">
                    <div class="iec_section_intro">
                        <h2 class="iec_section_intro_title">What Determines <span class="highlight">Satellite Internet Prices?</span></h2>
                        <p>Satellite internet prices generally include three main cost components:</p>
                    </div>
                </div>
            </div>

            <div class="row iec_price_factors_row">
                <div class="col-lg-4">
                    <article class="iec_step_card">
                        <span class="iec_step_card_num">1</span>
                        <div>
                            <h3>Equipment</h3>
                            <p>The cost of the satellite terminal, antenna, mounting equipment, and any required stabilisation system. Equipment requirements vary depending on whether the solution is fixed, portable, mobile, or maritime.</p>
                        </div>
                    </article>
                </div>

                <div class="col-lg-4">
                    <article class="iec_step_card">
                        <span class="iec_step_card_num">2</span>
                        <div>
                            <h3>Installation and commissioning</h3>
                            <p>This includes site assessment, equipment mounting, alignment, configuration, and testing. The cost depends on the location, operational environment, and complexity of the installation.</p>
                        </div>
                    </article>
                </div>

                <div class="col-lg-4">
                    <article class="iec_step_card">
                        <span class="iec_step_card_num">3</span>
                        <div>
                            <h3>Service plan</h3>
                            <p>The recurring cost of accessing the satellite network. Pricing may vary according to data usage, connection speed, coverage, required performance, and the selected satellite service.</p>
                        </div>
                    </article>
                </div>
            </div>

        </div>
    </section>

    <section class="iec_defualt_position p-3 iec_tile_band seprator-section" id="applications">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <span class="iec-eyebrow">Satellite Internet Applications</span>

                    <h2 class="iec-section-heading mb-1 text-mob-center text-white">Where can satellite internet be used?</h2>

                    <div class="wysiwyg-content">
                        <p class="iec_tile_band_intro  text-mob-center">Satellite internet is particularly useful for organisations
                            operating in remote, temporary, or challenging environments, including:</p>
                    </div>

                    <div class="iec_market_slider_warpper iec_tile_slider">
                        <div class="swiper-pagination"></div>

                        <div class="swiper iec_market_slider">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <a href="#contact" class="iec_tile" style="--cardImage: url('<?= $img; ?>Market-images/onshore.png');">
                                        <span class="iec_tile_title">Construction sites and temporary project offices</span>

                                        <span class="iec_tile_icon"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h11M10.5 5l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="#contact" class="iec_tile" style="--cardImage: url('<?= $img; ?>Market-images/offshore.png');">
                                        <span class="iec_tile_title">Mining and energy operations</span>

                                        <span class="iec_tile_icon"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h11M10.5 5l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="#contact" class="iec_tile" style="--cardImage: url('<?= $img; ?>Market-images/enterprose.png');">
                                        <span class="iec_tile_title">Rural businesses and agricultural facilities</span>

                                        <span class="iec_tile_icon"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h11M10.5 5l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="#contact" class="iec_tile" style="--cardImage: url('<?= $img; ?>Market-images/humanitarian.png');">
                                        <span class="iec_tile_title">Humanitarian and emergency-response missions</span>

                                        <span class="iec_tile_icon"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h11M10.5 5l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="#contact" class="iec_tile" style="--cardImage: url('<?= $img; ?>Market-images/gov.jpg');">
                                        <span class="iec_tile_title">Government and defence operations</span>

                                        <span class="iec_tile_icon"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h11M10.5 5l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="#contact" class="iec_tile" style="--cardImage: url('<?= $img; ?>Market-images/shipping.png');">
                                        <span class="iec_tile_title">Transport and logistics facilities</span>

                                        <span class="iec_tile_icon"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h11M10.5 5l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="#contact" class="iec_tile" style="--cardImage: url('<?= $img; ?>Market-images/Maritime-bg.png');">
                                        <span class="iec_tile_title">Maritime and offshore operations</span>

                                        <span class="iec_tile_icon"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h11M10.5 5l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="#contact" class="iec_tile" style="--cardImage: url('<?= $img; ?>Market-images/media.png');">
                                        <span class="iec_tile_title">Remote monitoring stations</span>

                                        <span class="iec_tile_icon"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h11M10.5 5l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                    </a>
                                </div>

                                <div class="swiper-slide">
                                    <a href="#contact" class="iec_tile" style="--cardImage: url('<?= $img; ?>Market-images/superyatch.jpg');">
                                        <span class="iec_tile_title">Critical facilities requiring backup connectivity</span>

                                        <span class="iec_tile_icon"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10h11M10.5 5l5 5-5 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="swiper-button-next" aria-label="Next slide"><svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none" aria-hidden="true"><path d="M0 0L15.2337 0L30.7269 15.022L15.3634 31L0 31L15.3634 15.5L0 0Z" fill="#727DA4" fill-opacity="0.5"/></svg></div>

                        <div class="swiper-button-prev" aria-label="Previous slide"><svg xmlns="http://www.w3.org/2000/svg" width="31" height="31" viewBox="0 0 31 31" fill="none" aria-hidden="true"><path d="M30.7271 31L15.4934 31L0.000180604 15.978L15.3636 -1.34311e-06L30.7271 0L15.3636 15.5L30.7271 31Z" fill="#727DA4" fill-opacity="0.5"/></svg></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="iec_defualt_position p-2 iec_step_section is-bg-tint">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="iec_section_intro">
                        <span class="iec-eyebrow">Why IEC Telecom</span>

                        <h2 class="iec_section_intro_title">One partner, <span class="highlight">assessment to support</span></h2>

                        <div class="wysiwyg-content">
                            <p>A connectivity environment designed around your location, applications, users and
                                operating conditions.</p>
                        </div>

                    </div>

                    <div class="grid-3 iec_step_grid">
                        <div class="iec_step_card">
                            <span class="iec_step_card_num" aria-hidden="true">1</span>

                            <div>
                                <h3>Assess requirements</h3>

                                <div class="wysiwyg-content">
                                    <p>Location, users, apps and backup needs</p>
                                </div>
                            </div>
                        </div>

                        <div class="iec_step_card">
                            <span class="iec_step_card_num" aria-hidden="true">2</span>

                            <div>
                                <h3>Design the solution</h3>

                                <div class="wysiwyg-content">
                                    <p>LEO, GEO, L-band, terrestrial or hybrid</p>
                                </div>
                            </div>
                        </div>

                        <div class="iec_step_card">
                            <span class="iec_step_card_num" aria-hidden="true">3</span>

                            <div>
                                <h3>Supply and deploy</h3>

                                <div class="wysiwyg-content">
                                    <p>Equipment, installation and training</p>
                                </div>
                            </div>
                        </div>

                        <div class="iec_step_card">
                            <span class="iec_step_card_num" aria-hidden="true">4</span>

                            <div>
                                <h3>Manage and monitor</h3>

                                <div class="wysiwyg-content">
                                    <p>OptiView and Voucher Management</p>
                                </div>
                            </div>
                        </div>

                        <div class="iec_step_card">
                            <span class="iec_step_card_num" aria-hidden="true">5</span>

                            <div>
                                <h3>Protect the network</h3>

                                <div class="wysiwyg-content">
                                    <p>OptiShield managed cybersecurity</p>
                                </div>
                            </div>
                        </div>

                        <div class="iec_step_card">
                            <span class="iec_step_card_num" aria-hidden="true">6</span>

                            <div>
                                <h3>Support global teams</h3>

                                <div class="wysiwyg-content">
                                    <p>24/7 technical assistance</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="iec_tag_row">
                        <p class="iec_tag_row_label">Value-added services</p>

                        <a href="#" class="iec_tag">OneAssist</a>
                        <a href="#" class="iec_tag">OneMonitor</a>
                        <a href="#" class="iec_tag">Traksat</a>
                        <a href="#" class="iec_tag">OneMail Pro</a>
                        <a href="#" class="iec_tag">OneHealth</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="iec_defualt_position p-3 iec_why_split " id="why-iec">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="iec_why_split_copy  text-mob-center">
                        <span class="iec-eyebrow">Why IEC</span>

                        <h2 class="iec-section-heading mb-1">How does IEC Telecom help?</h2>

                        <div class="wysiwyg-content">
                            <p>Establishing connectivity in a remote location involves more than selecting
                                    an internet package or installing a satellite terminal. The network must be designed around
                                    the organisation&rsquo;s location, applications, users, security requirements, and operating
                                    conditions.</p>
                            <p>IEC Telecom helps organisations build a complete connectivity
                                environment&mdash;from initial assessment and system design to installation, network
                                management, cybersecurity, and ongoing technical support.</p>
                        </div>

                        <a href="#contact" class="iec_promo_cta">Contact IEC Telecom <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M3 10h13M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="iec_why_split_panel">
                        <div class="wysiwyg-content">
                            <p class=" text-mob-center" >Where it starts:</p>
                        </div>

                        <ul class="iec_why_split_list ">
                            <li class=" text-mob-center">
                                <h3>1. Assessing Operational Requirements</h3>

                                <div class="wysiwyg-content">
                                    <p class="card_iec_text">IEC Telecom assesses the customer&rsquo;s location, coverage, users, applications,
                                        security requirements, and need for backup connectivity. This helps determine
                                        whether a satellite, terrestrial, or hybrid solution is most suitable.</p>
                                </div>

                            </li>

                            <li class=" text-mob-center">
                                <h3>2. Designing the Right Connectivity Solution</h3>

                                <div class="wysiwyg-content">
                                    <p class="card_iec_text">Based on this assessment, IEC Telecom designs a tailored solution using fixed or
                                        portable satellite systems, LEO, GEO, L-band, terrestrial networks, or a combination
                                        of technologies to balance performance, resilience, and cost.</p>
                                </div>

                            </li>

                            <li class=" text-mob-center">
                                <h3>3. Supplying and Deploying the Solution</h3>

                                <div class="wysiwyg-content">
                                    <p class="card_iec_text">IEC Telecom supports equipment supply, installation, activation, and configuration to
                                        bring remote sites online. Logistics, training, and maintenance services can also be
                                        provided to support reliable long-term operation.</p>
                                </div>

                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="iec_defualt_position p-3 iec_copy_aside_section bg-light-iec" id="managed-connectivity">
        <div class="container">
            <div class="iec_copy_aside">
                <div class="row">
                    <div class="col-md-12">
                        <div class="iec_copy_aside_head text-mob-center">
                            <span class="iec-eyebrow">Managed Connectivity</span>

                            <h2 class="iec-section-heading mb-1">From Satellite Internet to a <span class="highlight">Complete Operational Environment</span></h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-7">
                        <div class="iec_copy_aside_copy">
                            <div class="wysiwyg-content text-mob-center">
                                <p>Satellite internet is not simply about putting a remote location online. For
                                    businesses, it is about creating a reliable, secure, and manageable communication environment that
                                    supports people, applications, and operational processes.</p>

                                <p>IEC Telecom combines satellite and hybrid connectivity with network management, cybersecurity,
                                    digital services, installation, maintenance, and technical support.</p>

                                <p>Whether an organisation needs to connect a permanent remote facility, a temporary project site, a
                                    mobile team, or a critical operation, IEC Telecom can help design and manage a solution around its
                                    specific requirements.</p>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="iec_copy_aside_panel mt-2 satellite-internet-list ">
                            <h3>What OptiView shows</h3>

                            <ul class="iec_copy_aside_list text-mob-center">
                                <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M5.5 18v-4M10 18V9.5M14.5 18V6M19 18v-9" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round"/></svg>Network performance</li>
                                <li><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3.5" y="5" width="17" height="11" rx="2" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M9 19.5h6" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round"/></svg>Connected devices</li>
                                <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 15c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round"/><path d="M3 9c2 0 2-2 4-2s2 2 4 2 2-2 4-2 2 2 4 2" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round"/></svg>Data consumption across remote sites</li>
                                <li><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 3l7 3v5.5c0 4.2-2.9 7.6-7 9-4.1-1.4-7-4.8-7-9V6l7-3Z" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linejoin="round"/></svg>Unusual activity</li>
                                <li><svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M12 7.2V12l3.2 1.9" stroke="currentColor" stroke-width="1.6" fill="none" stroke-linecap="round" stroke-linejoin="round"/></svg>Available bandwidth</li>
                                <li><svg viewBox="0 0 24 24" aria-hidden="true"><rect x="5" y="10.5" width="14" height="9" rx="2" stroke="currentColor" stroke-width="1.6" fill="none"/><path d="M8.5 10.5V8a3.5 3.5 0 1 1 7 0v2.5" stroke="currentColor" stroke-width="1.6" fill="none"/></svg>User access and data allowances</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="iec_defualt_position p-3 iec_promo_pair">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid-2">
                        <div class="iec_promo_card">
                            <p class="iec_promo_card_label">Managed Services</p>

                            <h3>The complete <span class="highlight">connectivity lifecycle</span></h3>

                            <div class="wysiwyg-content">
                                <p>As an international satellite communications service provider, IEC Telecom supports the
                                    complete connectivity lifecycle&mdash;from assessing operational requirements and
                                    designing the right solution to supplying equipment, managing installation, securing the
                                    network, and providing global 24/7 technical support.</p>
                            </div>

                            <a href="#why-iec" class="iec_promo_cta">How IEC Telecom helps <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M3 10h13M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                        </div>

                        <div class="iec_promo_card">
                            <p class="iec_promo_card_label">Coverage</p>

                            <h3>Coverage decides <span class="highlight">the design</span></h3>

                            <div class="wysiwyg-content">
                                <p>The right technology depends on the location, operational requirements, available
                                    coverage, local regulations, and the applications that need to be supported.</p>
                            </div>

                            <a href="#technologies" class="iec_promo_cta">Satellite technologies <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M3 10h13M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="iec_defualt_position p-3 iec_team_band_section" id="choosing">
        <div class="container">
            <div class="row">
                <div class="col-md-12  text-mob-center">
                    <div class="iec_team_band">
                        <div class="iec_team_band_media">
                            <img src="<?= $img; ?>Market-images/gov.jpg" alt="" width="600" height="600" loading="lazy" decoding="async">
                        </div>

                        <div class="iec_team_band_copy">
                            <span class="iec-eyebrow">Choosing a provider</span>

                            <h2 class="iec-section-heading mb-1">What should you consider when choosing a satellite internet company?</h2>

                            <div class="wysiwyg-content ">
                                <p>Choosing the right satellite internet company involves more than comparing connection
                                    speeds. Organisations should also consider geographic coverage, available satellite
                                    networks, equipment options, installation capabilities, network management,
                                    cybersecurity, technical support, and compliance with local regulations.</p>
                            </div>

                            <a href="#why-iec" class="iec_team_band_link"><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M10 4v12M4 10h12" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/></svg>See the full lifecycle</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
    <section class="iec_defualt_position p-3 iec_promo_band_section bg-light-iec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="iec_promo_band">
                        <p class="iec_promo_card_label">Our Team</p>

                        <h2>Engineers who have <span class="highlight">been at sea</span></h2>

                        <div class="wysiwyg-content">
                            <p>Our field teams have installed and commissioned terminals on vessels, rigs and remote
                                sites across four continents &mdash; so the advice you get comes from people who have
                                stood on the deck, not just read the datasheet.</p>
                        </div>

                        <a href="#" class="iec_promo_cta">Meet the Team <svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M3 10h13M11 5l5 5-5 5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

</div>
