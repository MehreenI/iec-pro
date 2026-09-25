<?php
/**
 * Template Name: Market Landing
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$iec_market_img = trailingslashit( get_template_directory_uri() ) . 'assets/img/Market-images/';
?>

    <main id="main" class="t-market-landing">

        <section class="iec-industries-hero" style="background-image: url('https://staging.iec-telecom.com/wp-content/uploads/2026/08/new-side-img.webp');">
            <div class="container">

                <div class="row">
                    <div class="col-md-6">
                        <div class="iec-industries-hero__content">
                            <div class="iec-industries-hero__breadcrumb">
                                <a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo __( 'Home', 'bbtheme' ); ?></a>
                                <span class="iec-industries-hero__breadcrumb-sep" aria-hidden="true">
                                    <svg viewBox="0 0 9 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true"><path d="M8.48171e-07 12.5432L1.37275 13.75L9 7L1.36504 0.249999L-1.2103e-07 1.45682L6.26992 7L8.48171e-07 12.5432Z" fill="currentColor"></path></svg>
                                </span>
                                <span><?php echo __( 'Industries', 'bbtheme' ); ?></span>
                            </div>

                            <h1 class="iec-primary-heading">Connectivity solutions<br>built for every industry</h1>

                            <h3 class="iec-secondary-heading">
                                From land to sea and everywhere in between, IEC Telecom
                                delivers secure, reliable and high-performance connectivity
                                that keeps your operations moving.
                            </h3>

                            <a href="<?php echo esc_url( home_url( '/industries/' ) ); ?>" class="iec-industries-hero__btn">
                                <?php echo __( 'Explore All Industries', 'bbtheme' ); ?>
                            </a>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="iec-industries-hero__visual">
                        </div>
                    </div>



                </div>

            </div>
        </section>

        <!--        <section class="iec_hero_banner iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center" style="--bgImage: url('https://iec-telecom.com/wp-content/uploads/2026/07/Section-scaled.webp'); --mobileImage: url('https://iec-telecom.com/wp-content/uploads/2026/07/mobile-banner.webp');" aria-label="--><?php //echo esc_attr__( 'Page hero', 'bbtheme' ); ?><!--">-->
        <!--            <div class="container">-->
        <!--                <div class="row">-->
        <!--                    <div class="col-md-5">-->
        <!--                        <div class="iec_hero_content_box">-->
        <!--                            <h1 class="iec-primary-heading">--><?php //echo __( 'OUR MARKETS', 'bbtheme' ); ?><!--</h1>-->
        <!--                            <h2 class="iec-sub-heading">-->
        <!--                                --><?php //echo __( 'Connectivity for land and sea.', 'bbtheme' ); ?><!--<span class="highlight"> --><?php //echo __( 'Built for the field.', 'bbtheme' ); ?><!--</span>-->
        <!--                            </h2>-->
        <!--                            <div class="btn">-->
        <!--                                <a class="gray_btn" href="#contact">--><?php //echo __( 'Speak to an expert', 'bbtheme' ); ?><!--</a>-->
        <!--                            </div>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </div>-->
        <!--        </section>-->

        <section class="iec_market_landing_section iec-industry-types">
            <div class="container">
                <div class="iec-industry-types-grid">
                    <a href="#land-industries" class="iec-industry-type-card">
                        <div class="iec-industry-type-image">
                            <img src="<?php echo esc_url( $iec_market_img . 'enterprose.png' ); ?>" alt="<?php echo esc_attr__( 'IEC Telecom Land Industries', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-type-overlay"></div>
                        <div class="iec-industry-type-content">
                            <div class="iec-industry-type-icon">
                                <svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M24 4C16.8 4 11 9.8 11 17C11 27.5 24 42 24 42C24 42 37 27.5 37 17C37 9.8 31.2 4 24 4Z" stroke="currentColor" stroke-width="1.7"/><circle cx="24" cy="17" r="5.5" stroke="currentColor" stroke-width="1.7"/><path d="M7 39H41M10 34L16 31L23 34L31 29L39 33" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </div>
                            <span class="iec-industry-type-label"><?php echo __( 'LAND', 'bbtheme' ); ?></span>
                            <h2><?php echo __( 'Land Industries', 'bbtheme' ); ?></h2>
                            <p><?php echo __( 'Reliable connectivity for operations across governments, organisations, enterprises and onshore environments.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-type-link">
								<?php echo __( 'Explore Land Industries', 'bbtheme' ); ?>
								<svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
							</span>
                        </div>
                    </a>
                    <a href="#maritime-industries" class="iec-industry-type-card">
                        <div class="iec-industry-type-image">
                            <img src="<?php echo esc_url( $iec_market_img . 'Maritime-bg.png' ); ?>" alt="<?php echo esc_attr__( 'IEC Telecom Maritime Industries', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-type-overlay"></div>
                        <div class="iec-industry-type-content">
                            <div class="iec-industry-type-icon">
                                <svg viewBox="0 0 48 48" fill="none" aria-hidden="true"><path d="M24 5V35" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><path d="M24 8C21 8 19 10 19 13C19 16 21 18 24 18C27 18 29 16 29 13C29 10 27 8 24 8Z" stroke="currentColor" stroke-width="1.7"/><path d="M13 20H35" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><path d="M12 28C13.5 35 18 39 24 42C30 39 34.5 35 36 28" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/><path d="M8 28H18M30 28H40" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/></svg>
                            </div>
                            <span class="iec-industry-type-label"><?php echo __( 'MARITIME', 'bbtheme' ); ?></span>
                            <h2><?php echo __( 'Maritime Industries', 'bbtheme' ); ?></h2>
                            <p><?php echo __( 'Seamless communications for life at sea, offshore assets and operations across the global maritime supply chain.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-type-link">
								<?php echo __( 'Explore Maritime Industries', 'bbtheme' ); ?>
								<svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/></svg>
							</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="iec_market_landing_section iec-specialized-connectivity iec_market_landing_section--centered">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <span class="iec_home_eyebrow"><?php echo __( 'Specialized connectivity', 'bbtheme' ); ?></span>
                        <h2 class="iec_sub_section_heading iec_home_section_heading"><?php echo __( 'Specialized connectivity for the world\'s most demanding environments.', 'bbtheme' ); ?></h2>
                        <div class="wyswig-content">
                            <p><?php echo __( 'IEC Telecom partners with organizations across land and maritime sectors to deliver secure, high-performance connectivity that ensures safety, efficiency and mission success.', 'bbtheme' ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="iec-specialized-connectivity__grid">
                    <div class="iec-connectivity-feature">
                        <div class="iec-connectivity-feature__icon">
                            <svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><path d="M32 6C39.5 12 47 14.5 54 15.5V29C54 43.5 44.5 52.5 32 59C19.5 52.5 10 43.5 10 29V15.5C17 14.5 24.5 12 32 6Z" stroke="currentColor" stroke-width="2.4" stroke-linejoin="round"/><path d="M22 32L29 39L43 24" stroke="currentColor" stroke-width="2.8" stroke-linecap="round" stroke-linejoin="round"/></svg>
                        </div>
                        <h3><?php echo __( 'Always Connected', 'bbtheme' ); ?></h3>
                        <p><?php echo __( 'High-availability networks designed for continuous operations.', 'bbtheme' ); ?></p>
                    </div>
                    <div class="iec-connectivity-feature">
                        <div class="iec-connectivity-feature__icon">
                            <svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><rect x="14" y="28" width="36" height="28" rx="4" stroke="currentColor" stroke-width="2.4"/><path d="M21 28V21C21 14.9 25.9 10 32 10C38.1 10 43 14.9 43 21V28" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><circle cx="32" cy="40" r="3.5" stroke="currentColor" stroke-width="2.4"/><path d="M32 43.5V49" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                        </div>
                        <h3><?php echo __( 'Secure & Compliant', 'bbtheme' ); ?></h3>
                        <p><?php echo __( 'End-to-end security to protect data and critical communications.', 'bbtheme' ); ?></p>
                    </div>
                    <div class="iec-connectivity-feature">
                        <div class="iec-connectivity-feature__icon">
                            <svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><circle cx="32" cy="32" r="24" stroke="currentColor" stroke-width="2.4"/><path d="M8 32H56" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><path d="M32 8C38 14.5 41 22.5 41 32C41 41.5 38 49.5 32 56" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><path d="M32 8C26 14.5 23 22.5 23 32C23 41.5 26 49.5 32 56" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><path d="M13 20H51" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><path d="M13 44H51" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/></svg>
                        </div>
                        <h3><?php echo __( 'Built for Anywhere', 'bbtheme' ); ?></h3>
                        <p><?php echo __( 'Global coverage and expert support wherever you operate.', 'bbtheme' ); ?></p>
                    </div>
                    <div class="iec-connectivity-feature">
                        <div class="iec-connectivity-feature__icon">
                            <svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><circle cx="27" cy="25" r="12" stroke="currentColor" stroke-width="2.4"/><circle cx="27" cy="25" r="4" stroke="currentColor" stroke-width="2.4"/><path d="M27 7V13M27 37V43M9 25H15M39 25H45" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><path d="M14.3 12.3L18.5 16.5M35.5 33.5L39.7 37.7M39.7 12.3L35.5 16.5M18.5 33.5L14.3 37.7" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"/><path d="M45 32L48 34L52 33L54 37L58 38V43L61 46L58 50L57 54H52L49 57L45 55L41 57L38 53L34 52V47L31 44L34 40L35 36H40L45 32Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/><circle cx="46" cy="45" r="5" stroke="currentColor" stroke-width="2.2"/></svg>
                        </div>
                        <h3><?php echo __( 'Tailored Solutions', 'bbtheme' ); ?></h3>
                        <p><?php echo __( 'Connectivity designed for your exact operational needs.', 'bbtheme' ); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section id="land-industries" class="iec_market_landing_section iec-land-industries">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <span class="iec_home_eyebrow"><?php echo __( 'Land sectors', 'bbtheme' ); ?></span>
                        <h2 class="iec_sub_section_heading iec_home_section_heading"><?php echo __( 'Land Industries', 'bbtheme' ); ?></h2>
                        <div class="wyswig-content">
                            <p><?php echo __( 'Purpose-built connectivity solutions for organizations operating across the world\'s most demanding land-based environments.', 'bbtheme' ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="iec-land-industries__grid">
                    <a href="<?php echo esc_url( home_url( '/industries/government/' ) ); ?>" class="iec-industry-card">
                        <div class="iec-industry-card__image">
                            <img src="<?php echo esc_url( $iec_market_img . 'gov.jpg' ); ?>" alt="<?php echo esc_attr__( 'Government connectivity solutions', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-card__body">
                            <div class="iec-industry-card__icon industry-svg">
                                <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                    <path d="M12 26L32 13L52 26" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15 27H49" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M18 29V48M27 29V48M37 29V48M46 29V48" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M14 49H50M10 55H54" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M26 13V8H38V13" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h3><?php echo __( 'Government', 'bbtheme' ); ?></h3>
                            <p><?php echo __( 'Secure communication solutions for public safety, defence and government operations.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-card__link"><?php echo __( 'Learn More', 'bbtheme' ); ?><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </div>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/industries/humanitarian/' ) ); ?>" class="iec-industry-card">
                        <div class="iec-industry-card__image">
                            <img src="<?php echo esc_url( $iec_market_img . 'humanitarian.png' ); ?>" alt="<?php echo esc_attr__( 'Humanitarian connectivity solutions', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-card__body">
                            <div class="iec-industry-card__icon industry-svg">
                                <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                    <path d="M21 19C21 13.5 25 10 29 10C32 10 34 11.5 36 14C38 11.5 40 10 43 10C47 10 51 13.5 51 19C51 27 36 36 36 36C36 36 21 27 21 19Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M8 37L19 31C22 29 25 30 27 32L31 36" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M56 37L45 31C42 29 39 30 37 32L33 36" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M8 37V48L22 55L31 48V38" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M56 37V48L42 55L33 48V38" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <h3><?php echo __( 'Humanitarian', 'bbtheme' ); ?></h3>
                            <p><?php echo __( 'Reliable connectivity in crisis and remote areas to support life-saving missions.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-card__link"><?php echo __( 'Learn More', 'bbtheme' ); ?><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </div>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/industries/energy-onshore/' ) ); ?>" class="iec-industry-card">
                        <div class="iec-industry-card__image">
                            <img src="<?php echo esc_url( $iec_market_img . 'onshore.png' ); ?>" alt="<?php echo esc_attr__( 'Onshore connectivity', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-card__body">
                            <div class="iec-industry-card__icon industry-svg">
                                <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                    <circle cx="32" cy="25" r="4" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M32 29V56" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M29 23L14 17C19 12 27 14 32 21" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M35 23L42 8C47 14 45 22 37 26" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M35 28L51 33C46 38 38 37 32 30" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M24 56H40" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <h3><?php echo __( 'Onshore', 'bbtheme' ); ?></h3>
                            <p><?php echo __( 'Optimized network solutions for onshore exploration, production and energy operations.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-card__link"><?php echo __( 'Learn More', 'bbtheme' ); ?><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </div>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/industries/enterprise/' ) ); ?>" class="iec-industry-card">
                        <div class="iec-industry-card__image">
                            <img src="<?php echo esc_url( $iec_market_img . 'enterprose.png' ); ?>" alt="<?php echo esc_attr__( 'Enterprise connectivity', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-card__body">
                            <div class="iec-industry-card__icon industry-svg">
                                <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                    <rect x="12" y="11" width="28" height="43" rx="2" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M40 26H53V54H40" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M19 19H23M29 19H33 M19 28H23M29 28H33 M19 37H23M29 37H33 M46 34H49M46 42H49" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M8 54H56" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <h3><?php echo __( 'Enterprise', 'bbtheme' ); ?></h3>
                            <p><?php echo __( 'Business-grade connectivity that keeps teams, sites and applications connected.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-card__link"><?php echo __( 'Learn More', 'bbtheme' ); ?><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </div>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/industries/media/' ) ); ?>" class="iec-industry-card">
                        <div class="iec-industry-card__image">
                            <img src="<?php echo esc_url( $iec_market_img . 'media.png' ); ?>" alt="<?php echo esc_attr__( 'Media connectivity solutions', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-card__body">
                            <div class="iec-industry-card__icon industry-svg">
                                <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                    <path d="M32 51V29" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M24 55H40" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M24 51L32 29L40 51" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <circle cx="32" cy="24" r="4" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M20 20C23 14 27 11 32 11C37 11 41 14 44 20" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M15 17C19 8 25 4 32 4C39 4 45 8 49 17" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M44 28C40 34 36 37 32 37C28 37 24 34 20 28" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <h3><?php echo __( 'Media', 'bbtheme' ); ?></h3>
                            <p><?php echo __( 'High-quality connectivity for news, broadcasting and digital media operations.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-card__link"><?php echo __( 'Learn More', 'bbtheme' ); ?><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section id="maritime-industries" class="iec_market_landing_section iec-land-industries iec-maritime-industries">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <span class="iec_home_eyebrow"><?php echo __( 'Maritime sectors', 'bbtheme' ); ?></span>
                        <h2 class="iec_sub_section_heading iec_home_section_heading"><?php echo __( 'Maritime Industries', 'bbtheme' ); ?></h2>
                        <div class="wyswig-content">
                            <p><?php echo __( 'Purpose-built connectivity solutions for organizations operating across the world\'s most demanding maritime environments.', 'bbtheme' ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="iec-land-industries__grid">
                    <a href="<?php echo esc_url( home_url( '/industries/fishing/' ) ); ?>" class="iec-industry-card">
                        <div class="iec-industry-card__image">
                            <img src="<?php echo esc_url( $iec_market_img . 'fishing.png' ); ?>" alt="<?php echo esc_attr__( 'Fishing connectivity solutions', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-card__body">
                            <div class="iec-industry-card__icon industry-svg">
                                <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                    <path d="M12 40H53L47 49H20L12 40Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M22 40V25H40V40" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M28 25V15H35V25" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M35 17L43 23" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M17 53C20 55 23 55 26 53C29 51 32 51 35 53C38 55 41 55 44 53C47 51 50 51 53 53" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M10 34H22" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <h3><?php echo __( 'Fishing', 'bbtheme' ); ?></h3>
                            <p><?php echo __( 'Reliable connectivity for commercial fishing fleets operating far from shore.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-card__link"><?php echo __( 'Learn More', 'bbtheme' ); ?><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </div>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/industries/offshore/' ) ); ?>" class="iec-industry-card">
                        <div class="iec-industry-card__image">
                            <img src="<?php echo esc_url( $iec_market_img . 'offshore.png' ); ?>" alt="<?php echo esc_attr__( 'Offshore connectivity solutions', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-card__body">
                            <div class="iec-industry-card__icon industry-svg">
                                <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                    <path d="M10 46H54" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M13 46V32H28V46" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M16 32V26H25V32" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M15 26L20 19L25 26" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <circle cx="43" cy="25" r="3.5" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M43 28V47" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M40 23L30 18C34 15 39 17 43 22" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M45 22L50 11C53 16 51 22 46 25" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M46 27L56 31C52 34 47 33 43 28" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M9 52C13 50 17 50 21 52C25 54 29 54 33 52C37 50 41 50 45 52C49 54 53 54 57 52" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <h3><?php echo __( 'Offshore', 'bbtheme' ); ?></h3>
                            <p><?php echo __( 'Communications for offshore platforms, rigs and remote maritime assets.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-card__link"><?php echo __( 'Learn More', 'bbtheme' ); ?><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </div>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/industries/shipping/' ) ); ?>" class="iec-industry-card">
                        <div class="iec-industry-card__image">
                            <img src="<?php echo esc_url( $iec_market_img . 'shipping.png' ); ?>" alt="<?php echo esc_attr__( 'Shipping connectivity solutions', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-card__body">
                            <div class="iec-industry-card__icon industry-svg">
                                <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                    <path d="M9 39H55L49 49H17L9 39Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M17 39V31H47V39" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M22 31V24H42V31" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M27 24V18H37V24" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M30 18V13H35V18" stroke="currentColor" stroke-width="2.2"/>
                                    <path d="M11 54C15 52 19 52 23 54C27 56 31 56 35 54C39 52 43 52 47 54C51 56 55 56 58 54" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <h3><?php echo __( 'Shipping', 'bbtheme' ); ?></h3>
                            <p><?php echo __( 'Connectivity solutions for commercial shipping and global cargo operations.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-card__link"><?php echo __( 'Learn More', 'bbtheme' ); ?><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </div>
                    </a>
                    <a href="<?php echo esc_url( home_url( '/industries/superyacht/' ) ); ?>" class="iec-industry-card">
                        <div class="iec-industry-card__image">
                            <img src="<?php echo esc_url( $iec_market_img . 'superyatch.jpg' ); ?>" alt="<?php echo esc_attr__( 'Superyacht connectivity solutions', 'bbtheme' ); ?>">
                        </div>
                        <div class="iec-industry-card__body">
                            <div class="iec-industry-card__icon industry-svg">
                                <svg viewBox="0 0 64 64" fill="none" aria-hidden="true">
                                    <path d="M8 39H56L49 49H18L8 39Z" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M20 39L25 31H47L52 39" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M28 31L32 24H42L47 31" stroke="currentColor" stroke-width="2.2" stroke-linejoin="round"/>
                                    <path d="M35 24V18H40" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                    <path d="M10 54C14 52 18 52 22 54C26 56 30 56 34 54C38 52 42 52 46 54C50 56 54 56 58 54" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
                                </svg>
                            </div>
                            <h3><?php echo __( 'Superyacht', 'bbtheme' ); ?></h3>
                            <p><?php echo __( 'Premium connectivity for superyacht owners, crew and guests at sea.', 'bbtheme' ); ?></p>
                            <span class="iec-industry-card__link"><?php echo __( 'Learn More', 'bbtheme' ); ?><svg viewBox="0 0 20 20" fill="none" aria-hidden="true"><path d="M4 10H16M11 5L16 10L11 15" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"/></svg></span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <section class="iec_market_landing_section iec-global-coverage iec_market_landing_section--global iec_market_landing_section--dark">
            <div class="container">
                <div class="iec-global-coverage__container">
                    <div class="iec-global-coverage__content">
                        <span class="iec_home_eyebrow"><?php echo __( 'Global connectivity', 'bbtheme' ); ?></span>
                        <h2 class="iec_sub_section_heading iec_home_section_heading text-white"><?php echo __( 'One partner.', 'bbtheme' ); ?> <span class="iec_market_landing_heading_highlight"><?php echo __( 'Global coverage.', 'bbtheme' ); ?></span></h2>
                        <div class="wyswig-content">
                            <p><?php echo __( 'With satellite beams, terrestrial gateways and a trusted partner network, we deliver seamless connectivity across the globe — so you can focus on what matters most.', 'bbtheme' ); ?></p>
                        </div>
                        <div class="iec-global-coverage__features">
                            <div class="iec-global-feature">
                                <div class="iec-global-feature__icon">
                                    <svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><circle cx="32" cy="32" r="23" stroke="currentColor" stroke-width="2"/><path d="M9 32H55" stroke="currentColor" stroke-width="2"/><path d="M32 9C38 15 41 23 41 32C41 41 38 49 32 55" stroke="currentColor" stroke-width="2"/><path d="M32 9C26 15 23 23 23 32C23 41 26 49 32 55" stroke="currentColor" stroke-width="2"/><path d="M14 20H50" stroke="currentColor" stroke-width="2"/><path d="M14 44H50" stroke="currentColor" stroke-width="2"/></svg>
                                </div>
                                <div class="iec-global-feature__text">
                                    <strong><?php echo __( 'Global reach', 'bbtheme' ); ?></strong>
                                    <span><?php echo __( 'Worldwide connectivity', 'bbtheme' ); ?></span>
                                </div>
                            </div>
                            <div class="iec-global-feature">
                                <div class="iec-global-feature__icon">
                                    <svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><circle cx="32" cy="32" r="22" stroke="currentColor" stroke-width="2"/><path d="M32 19V33L41 39" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round"/><path d="M32 6V10M32 54V58M6 32H10M54 32H58" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                                </div>
                                <div class="iec-global-feature__text">
                                    <strong><?php echo __( '24/7 monitoring', 'bbtheme' ); ?></strong>
                                    <span><?php echo __( 'Continuous oversight', 'bbtheme' ); ?></span>
                                </div>
                            </div>
                            <div class="iec-global-feature">
                                <div class="iec-global-feature__icon">
                                    <svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><circle cx="32" cy="19" r="7" stroke="currentColor" stroke-width="2"/><path d="M20 38C21 30 26 27 32 27C38 27 43 30 44 38" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="15" cy="44" r="6" stroke="currentColor" stroke-width="2"/><circle cx="49" cy="44" r="6" stroke="currentColor" stroke-width="2"/><path d="M21 45H43" stroke="currentColor" stroke-width="2"/><path d="M32 38V53" stroke="currentColor" stroke-width="2"/></svg>
                                </div>
                                <div class="iec-global-feature__text">
                                    <strong><?php echo __( 'Tailored solutions', 'bbtheme' ); ?></strong>
                                    <span><?php echo __( 'Built around your needs', 'bbtheme' ); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="iec_market_landing_section iec-industries-video iec_market_landing_section--video iec_market_landing_section--dark">
            <div class="iec-industries-video__media">
                <video class="iec-industries-video__video" autoplay muted loop playsinline preload="metadata">
                    <source src="<?php echo esc_url( $iec_market_img . 'video.mp4' ); ?>" type="video/mp4">
                </video>
                <div class="iec-industries-video__overlay"></div>
            </div>
            <div class="container">
                <div class="row mx-auto text-align-center">
                    <div class="col-md-12">
                        <h2 class="iec-primary-heading"><?php echo __( 'Empowering critical operations', 'bbtheme' ); ?></h2>
                        <h3 class="iec-sub-heading"><?php echo __( 'with connectivity that never stops.', 'bbtheme' ); ?></h3>

                    </div>
                </div>
            </div>
        </section>

        <section class="iec_market_landing_section iec-our-solutions iec_market_landing_section--solutions iec_market_landing_section--dark iec_market_landing_section--centered">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <span class="iec_home_eyebrow"><?php echo __( 'What we deliver', 'bbtheme' ); ?></span>
                        <h2 class="iec_sub_section_heading iec_home_section_heading text-white"><?php echo __( 'Our solutions', 'bbtheme' ); ?></h2>
                        <div class="wyswig-content">
                            <p><?php echo __( 'Integrated technologies and managed services designed to keep critical operations connected, secure and efficient.', 'bbtheme' ); ?></p>
                        </div>
                    </div>
                </div>
                <div class="iec-our-solutions__grid">
                    <div class="iec-solution-item">
                        <div class="iec-solution-item__icon"><svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><circle cx="32" cy="32" r="5" stroke="currentColor" stroke-width="2"/><path d="M21 22C15 28 15 36 21 42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M43 22C49 28 49 36 43 42" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M14 15C4 25 4 39 14 49" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M50 15C60 25 60 39 50 49" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></div>
                        <h3><?php echo __( 'Managed Connectivity', 'bbtheme' ); ?></h3>
                        <p><?php echo __( 'Reliable satellite and terrestrial connectivity designed to maintain communications across remote, mobile and mission-critical operations.', 'bbtheme' ); ?></p>
                    </div>
                    <div class="iec-solution-item">
                        <div class="iec-solution-item__icon"><svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><circle cx="14" cy="18" r="6" stroke="currentColor" stroke-width="2"/><circle cx="50" cy="18" r="6" stroke="currentColor" stroke-width="2"/><circle cx="32" cy="48" r="6" stroke="currentColor" stroke-width="2"/><path d="M19 21L28 43" stroke="currentColor" stroke-width="2"/><path d="M45 21L36 43" stroke="currentColor" stroke-width="2"/><path d="M20 18H44" stroke="currentColor" stroke-width="2"/></svg></div>
                        <h3><?php echo __( 'Hybrid Networks', 'bbtheme' ); ?></h3>
                        <p><?php echo __( 'Combine satellite, cellular and terrestrial technologies into a resilient multi-network environment built around your operational needs.', 'bbtheme' ); ?></p>
                    </div>
                    <div class="iec-solution-item">
                        <div class="iec-solution-item__icon"><svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><rect x="9" y="12" width="46" height="34" rx="4" stroke="currentColor" stroke-width="2"/><path d="M18 36L25 28L31 33L40 21L47 27" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/><path d="M25 53H39" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M32 46V53" stroke="currentColor" stroke-width="2"/></svg></div>
                        <h3><?php echo __( 'Network Management', 'bbtheme' ); ?></h3>
                        <p><?php echo __( 'Centralized monitoring, optimization and control provide greater visibility into network health, performance and usage.', 'bbtheme' ); ?></p>
                    </div>
                    <div class="iec-solution-item">
                        <div class="iec-solution-item__icon"><svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><path d="M32 7C39 13 46 15 53 16V30C53 44 44 53 32 59C20 53 11 44 11 30V16C18 15 25 13 32 7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><rect x="24" y="28" width="16" height="13" rx="2" stroke="currentColor" stroke-width="2"/><path d="M27 28V24C27 21 29 19 32 19C35 19 37 21 37 24V28" stroke="currentColor" stroke-width="2"/></svg></div>
                        <h3><?php echo __( 'Cyber Security', 'bbtheme' ); ?></h3>
                        <p><?php echo __( 'Protect critical communications, devices and business data with layered security designed for distributed and remote environments.', 'bbtheme' ); ?></p>
                    </div>
                    <div class="iec-solution-item">
                        <div class="iec-solution-item__icon"><svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><path d="M20 47H46C53 47 57 42 57 36C57 30 52 26 47 26C45 17 38 12 30 13C22 14 17 19 16 27C10 28 7 32 7 37C7 43 12 47 20 47Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/><path d="M32 26V43" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><path d="M25 33L32 26L39 33" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg></div>
                        <h3><?php echo __( 'Cloud & IT Services', 'bbtheme' ); ?></h3>
                        <p><?php echo __( 'Secure cloud access, business applications and managed IT services support efficient operations wherever your teams are located.', 'bbtheme' ); ?></p>
                    </div>
                    <div class="iec-solution-item">
                        <div class="iec-solution-item__icon"><svg viewBox="0 0 64 64" fill="none" aria-hidden="true"><circle cx="32" cy="31" r="22" stroke="currentColor" stroke-width="2"/><path d="M17 34V29C17 21 24 15 32 15C40 15 47 21 47 29V34" stroke="currentColor" stroke-width="2"/><rect x="12" y="30" width="8" height="13" rx="3" stroke="currentColor" stroke-width="2"/><rect x="44" y="30" width="8" height="13" rx="3" stroke="currentColor" stroke-width="2"/><path d="M47 43C47 50 42 53 35 53" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></div>
                        <h3><?php echo __( '24/7 Expert Support', 'bbtheme' ); ?></h3>
                        <p><?php echo __( 'Global technical expertise and proactive support keep your network operating efficiently and help resolve issues whenever they arise.', 'bbtheme' ); ?></p>
                    </div>
                </div>
            </div>
        </section>


        <?php
        iec_module(
            'faq',
            array(
                'eyebrow'       => __( 'Frequently asked questions', 'bbtheme' ),
                'heading'       => __( 'Questions about industry connectivity?', 'bbtheme' ),
                'heading_class' => 'iec_home_section_heading',
                'faq'     => array(
                    array(
                        'question' => __( 'What industries does IEC Telecom support?', 'bbtheme' ),
                        'answer'   => __( 'IEC Telecom supports a wide range of land and maritime sectors, including government, humanitarian operations, onshore and offshore energy, enterprise, media, fishing, shipping and superyachts.', 'bbtheme' ),
                    ),
                    array(
                        'question' => __( 'What is the difference between land and maritime connectivity?', 'bbtheme' ),
                        'answer'   => __( 'Land solutions are designed for fixed and mobile operations across remote or terrestrial environments, while maritime solutions are built specifically for vessels, offshore assets and operations at sea.', 'bbtheme' ),
                    ),
                    array(
                        'question' => __( 'Can IEC Telecom provide connectivity in remote locations?', 'bbtheme' ),
                        'answer'   => __( 'Yes. IEC Telecom combines satellite, cellular and terrestrial technologies to provide resilient connectivity in remote, difficult-to-reach and mission-critical environments.', 'bbtheme' ),
                    ),
                    array(
                        'question' => __( 'Can multiple networks be combined into one solution?', 'bbtheme' ),
                        'answer'   => __( 'Yes. Hybrid connectivity can combine satellite, cellular and terrestrial networks to improve availability, performance and operational resilience.', 'bbtheme' ),
                    ),
                    array(
                        'question' => __( 'Does IEC Telecom provide network monitoring and support?', 'bbtheme' ),
                        'answer'   => __( 'IEC Telecom provides managed connectivity services, network monitoring and expert technical support to help customers maintain reliable operations around the clock.', 'bbtheme' ),
                    ),
                    array(
                        'question' => __( 'Are IEC Telecom solutions tailored to each organization?', 'bbtheme' ),
                        'answer'   => __( 'Yes. Solutions can be designed around location, operational requirements, bandwidth needs, security requirements and the networks available in each environment.', 'bbtheme' ),
                    ),
                    array(
                        'question' => __( 'How do I find the right solution for my industry?', 'bbtheme' ),
                        'answer'   => __( 'Start by selecting your industry or speak with an IEC Telecom connectivity specialist. The team can assess your operational environment and recommend an appropriate connectivity setup.', 'bbtheme' ),
                    ),
                ),
            )
        );
        ?>

    </main>

<?php
get_footer();
