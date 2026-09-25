<?php
/**
 * Template Name: VSAT Portfolio
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$hero_title    = get_field( 'hero_title' ) ?: get_the_title();
	$hero_subtitle = get_field( 'hero_subtitle' );
	$desktop_bg    = iec_resolve_media_to_url( get_field( 'hero_bg_desktop' ) );
	$mobile_bg     = iec_resolve_media_to_url( get_field( 'hero_bg_mobile' ) );
	$mobile_bg     = $mobile_bg ? $mobile_bg : $desktop_bg;

	$hero_style = '';
	if ( $desktop_bg ) {
		$hero_style = "--desktopImage: url('" . $desktop_bg . "'); --mobileImage: url('" . $mobile_bg . "');";
	}

	$show_geo      = (bool) get_field( 'show_geo' );
	$show_freq     = (bool) get_field( 'show_freq' );
	$show_service  = (bool) get_field( 'show_service' );
	$show_rec      = (bool) get_field( 'show_rec' );
	$show_faq      = (bool) get_field( 'show_faq' );
	$show_partners = (bool) get_field( 'show_partners' );

	$hero_buttons = array();

	if ( $show_geo ) {
		$hero_buttons[] = array(
			'href'  => '#iec_solution_section',
			'label' => __( 'Why Geo', 'bbtheme' ),
			'icon'  => 'geo',
		);
	}

	if ( $show_freq ) {
		$hero_buttons[] = array(
			'href'  => '#iec_frequency_section',
			'label' => __( 'Frequency Bands', 'bbtheme' ),
			'icon'  => 'freq',
		);
	}

	if ( $show_service ) {
		$hero_buttons[] = array(
			'href'  => '#iec_service_models_section',
			'label' => __( 'Service Models', 'bbtheme' ),
			'icon'  => 'service',
		);
	}

	if ( $show_rec ) {
		$hero_buttons[] = array(
			'href'  => '#recommended_solutions',
			'label' => __( 'Solutions', 'bbtheme' ),
			'icon'  => 'solutions',
		);
	}

	if ( $show_faq ) {
		$hero_buttons[] = array(
			'href'  => '#faq',
			'label' => __( 'FAQ', 'bbtheme' ),
			'icon'  => 'faq',
		);
	}

	$geo_cards = array();
	if ( have_rows( 'geo_cards' ) ) {
		while ( have_rows( 'geo_cards' ) ) {
			the_row();
			$geo_cards[] = array(
				'title' => get_sub_field( 'title' ),
				'icon'  => get_sub_field( 'icon' ),
				'text'  => get_sub_field( 'text' ),
			);
		}
	}

	$geo_eyebrow     = get_field( 'geo_eyebrow' );
	$geo_title       = get_field( 'geo_title' );
	$geo_description = get_field( 'geo_description' );

	$freq_bands = array();
	if ( have_rows( 'freq_bands' ) ) {
		while ( have_rows( 'freq_bands' ) ) {
			the_row();
			$features = array();
			if ( have_rows( 'features' ) ) {
				while ( have_rows( 'features' ) ) {
					the_row();
					$features[] = get_sub_field( 'feature' );
				}
			}
			$freq_bands[] = array(
				'title'       => get_sub_field( 'title' ),
				'subtitle'    => get_sub_field( 'subtitle' ),
				'description' => get_sub_field( 'description' ),
				'features'    => $features,
				'link'        => get_sub_field( 'link' ),
			);
		}
	}

	$freq_eyebrow     = get_field( 'freq_eyebrow' );
	$freq_title       = get_field( 'freq_title' );
	$freq_description = get_field( 'freq_description' );

	$service_cards = array();
	if ( have_rows( 'service_cards' ) ) {
		while ( have_rows( 'service_cards' ) ) {
			the_row();
			$service_cards[] = array(
				'title'       => get_sub_field( 'title' ),
				'description' => get_sub_field( 'description' ),
				'image'       => get_sub_field( 'image' ),
				'best_for'    => get_sub_field( 'best_for' ),
			);
		}
	}

	$service_eyebrow     = get_field( 'service_eyebrow' );
	$service_title       = get_field( 'service_title' );
	$service_description = get_field( 'service_description' );

	$success_popup_html = iec_enquiry_success_popup_html( 'iot-enquiry' );
	?>

	<main id="main" class="t-vsat-portfolio">

		<section
			class="iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center iec_vsat_hero iec_vsat_hero_reveal"
			aria-labelledby="iec-vsat-page-title"
		>
			<div class="iec_vsat_hero_bg"<?= $hero_style ? ' style="' . $hero_style . '"' : ''; ?> aria-hidden="true"></div>

			<div class="iec_vsat_hero_curtains" aria-hidden="true">
				<span></span><span></span><span></span>
			</div>

			<div class="container iec_vsat_hero_inner">
				<div class="row">
					<div class="col-md-12">
						<div class="iec_vsat_hero_content">
							<h1 id="iec-vsat-page-title" class="js-vsat-hero-heading"><?= $hero_title; ?></h1>
							<?php if ( $hero_subtitle ) : ?>
								<p class="iec_vsat_hero_subheading js-vsat-split-reveal"><?= $hero_subtitle; ?></p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>

			<div class="container iec_vsat_hero_inner">
				<?php
				get_template_part(
					'template-parts/t-vsat-portfolio/hero-buttons',
					null,
					array(
						'buttons' => $hero_buttons,
					)
				);
				?>
			</div>
		</section>

		<?php
		if ( $show_partners ) {
			iec_module(
				'partners-marquee',
				array(
					'label'      => get_field( 'partners_label' ),
					'partners'   => get_field( 'partners' ) ?: array(),
					'section_id' => 'iec_solution_section',
				)
			);
		}
		?>

		<?php if ( $show_geo && ( $geo_title || $geo_cards ) ) : ?>
			<section class="iec_why_geo" aria-labelledby="iec-vsat-geo-title">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="iec_section_heading">
								<?php if ( $geo_eyebrow ) : ?>
									<span class="iec_home_eyebrow iec-eyebrow"><?= $geo_eyebrow; ?></span>
								<?php endif; ?>
								<?php if ( $geo_title ) : ?>
									<h2 id="iec-vsat-geo-title" class="iec-section-heading js-vsat-section-title"><?= $geo_title; ?></h2>
								<?php endif; ?>
								<?php if ( $geo_description ) : ?>
									<p class="iec_section_description"><?= $geo_description; ?></p>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="swiper iec_advantage_slider iec_advantage_grid">
								<div class="swiper-wrapper">
									<?php foreach ( $geo_cards as $card ) : ?>
										<div class="swiper-slide iec_advantage_card_wrapper">
											<?php get_template_part( 'template-parts/t-vsat-portfolio/advantage-card', null, array( 'card' => $card ) ); ?>
										</div>
									<?php endforeach; ?>
								</div>
								<div class="iec_swiper_arrow_warpper">
									<div class="swiper-button-prev iec_advantage_prev"></div>
									<div class="swiper-button-next iec_advantage_next"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $show_freq && ( $freq_title || $freq_bands ) ) : ?>
			<section class="iec_frequency_section" id="iec_frequency_section" aria-labelledby="iec-vsat-freq-title">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="iec_section_heading">
								<?php if ( $freq_eyebrow ) : ?>
									<span class="iec_home_eyebrow iec-eyebrow"><?= $freq_eyebrow; ?></span>
								<?php endif; ?>
								<?php if ( $freq_title ) : ?>
									<h2 id="iec-vsat-freq-title" class="iec-section-heading js-vsat-section-title"><?= $freq_title; ?></h2>
								<?php endif; ?>
								<?php if ( $freq_description ) : ?>
									<p><?= $freq_description; ?></p>
								<?php endif; ?>
							</div>

							<div class="swiper iec_band_slider iec_band_grid iec_band_grid_desktop">
								<div class="swiper-wrapper">
									<?php foreach ( $freq_bands as $band ) : ?>
										<div class="swiper-slide">
											<?php get_template_part( 'template-parts/t-vsat-portfolio/band-card', null, array( 'band' => $band ) ); ?>
										</div>
									<?php endforeach; ?>
								</div>
								<div class="iec_swiper_arrow_warpper">
									<div class="swiper-button-prev iec_band_prev"></div>
									<div class="swiper-button-next iec_band_next"></div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php if ( $show_service && ( $service_title || $service_cards ) ) : ?>
			<section class="iec_service_models_section" id="iec_service_models_section" aria-labelledby="iec-vsat-service-title">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="iec_section_heading">
								<?php if ( $service_eyebrow ) : ?>
									<span class="iec_home_eyebrow iec-eyebrow"><?= $service_eyebrow; ?></span>
								<?php endif; ?>
								<?php if ( $service_title ) : ?>
									<h2 id="iec-vsat-service-title" class="iec-section-heading js-vsat-section-title"><?= $service_title; ?></h2>
								<?php endif; ?>
								<?php if ( $service_description ) : ?>
									<p class="iec_section_description"><?= $service_description; ?></p>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="row iec_service_grid">
						<?php foreach ( $service_cards as $card ) : ?>
							<?php
							$image    = is_array( $card['image'] ?? null ) ? $card['image'] : array();
							$best_for = $card['best_for'] ?? '';
							?>
							<div class="col-md-6 iec_service_card_wrapper">
								<article class="iec_service_card">
									<div class="bd_model_img_wrapper">
										<?php if ( ! empty( $image['url'] ) ) : ?>
											<img src="<?= $image['url']; ?>" alt="<?= $image['alt'] ?? ( $card['title'] ?? '' ); ?>">
										<?php endif; ?>
									</div>
									<div class="iec_service_body">
										<div class="iec_service_header">
											<h3 class="iec_service_title"><?= $card['title'] ?? ''; ?></h3>
											<?php if ( ! empty( $card['description'] ) ) : ?>
												<p><?= $card['description']; ?></p>
											<?php endif; ?>
										</div>
										<?php if ( $best_for ) : ?>
											<div class="iec_service_footer">
												<p><strong><?= __( 'Best for:', 'bbtheme' ); ?></strong> <?= $best_for; ?></p>
											</div>
										<?php endif; ?>
									</div>
								</article>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<?php iec_module( 'recommended-solutions' ); ?>

		<?php
		if ( $show_faq ) {
			iec_module(
				'faq',
				array(
					'heading'       => get_field( 'faq_title' ),
					'eyebrow'       => get_field( 'faq_eyebrow' ),
					'faq'           => get_field( 'faq_items' ) ?: array(),
					'section_id'    => 'faq',
					'heading_class' => 'js-vsat-section-title',
				)
			);
		}
		?>

	</main>

	<div class="iec-modal-overlay iec-popup" id="iecEnquiryModal">
		<div class="iec-modal-content">
			<button class="iec-modal-close" id="iecEnquiryModalClose" aria-label="<?= __( 'Close modal', 'bbtheme' ); ?>">
				<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
					<path d="M18 6L6 18M6 6L18 18" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>
			<?php
			get_template_part(
				'template-parts/modules/popup',
				null,
				array(
					'form_type'          => 'Department-enquiry',
					'success_popup_html' => $success_popup_html,
				)
			);
			?>
		</div>
	</div>

	<?php
endwhile;

get_footer();
