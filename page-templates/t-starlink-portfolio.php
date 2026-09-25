<?php
/**
 * Template Name: Starlink Portfolio
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$fields   = get_fields() ?: array();
	$hero     = is_array( $fields['hero'] ?? null ) ? $fields['hero'] : array();
	$news     = is_array( $fields['news'] ?? null ) ? $fields['news'] : array();
	$maritime = is_array( $fields['starlink_maritime'] ?? null ) ? $fields['starlink_maritime'] : array();
	$land     = is_array( $fields['starlink_land'] ?? null ) ? $fields['starlink_land'] : array();
	$faq      = is_array( $fields['faq'] ?? null ) ? $fields['faq'] : array();

	$heading     = ( $hero['heading'] ?? '' ) ?: get_the_title();
	$sub_heading = $hero['sub_heading'] ?? '';
	$desktop_bg  = iec_resolve_media_to_url( $hero['background_image'] ?? '' );
	$mobile_bg   = iec_resolve_media_to_url( $hero['mobile_background_image'] ?? '' );

	$hero_style = '';
	if ( $desktop_bg ) {
		$hero_style = '--desktopImage: url(\'' . $desktop_bg . '\');';
		if ( $mobile_bg ) {
			$hero_style .= ' --mobileImage: url(\'' . $mobile_bg . '\');';
		}
	}

	$hero_buttons = array(
		array(
			'href'  => '#maritime',
			'label' => $hero['button_1'] ?? '',
			'icon'  => 'maritime',
		),
		array(
			'href'  => '#land',
			'label' => $hero['button_2'] ?? '',
			'icon'  => 'land',
		),
	);

	$insights_query = null;
	if ( ! empty( $fields['show_regional_insights'] ) ) {
		$insights_query = new WP_Query(
			array(
				'post_type'      => 'news',
				'post_status'    => 'publish',
				'orderby'        => 'date',
				'order'          => 'DESC',
				'posts_per_page' => 3,
				'meta_query'     => array(
					array(
						'key'     => 'starlink_news',
						'value'   => 'starlink',
						'compare' => 'LIKE',
					),
				),
				'tax_query'      => array(
					array(
						'taxonomy' => 'news_type',
						'field'    => 'slug',
						'terms'    => 'insights',
					),
				),
			)
		);
	}

	$sliders = array();

	if ( ! empty( $fields['show_maritime_portfolio'] ) ) {
		$maritime_link = is_array( $maritime['button_link'] ?? null ) ? $maritime['button_link'] : array();
		$sliders[]     = array(
			'heading'      => $maritime['heading'] ?? '',
			'content'      => $maritime['content'] ?? '',
			'button_url'   => iec_resolve_wpml_url( $maritime_link ),
			'button_title' => $maritime_link['title'] ?? __( 'Learn More', 'bbtheme' ),
			'slider'       => $maritime['portfolio'] ?? array(),
			'id'           => 'maritime',
		);
	}

	if ( ! empty( $fields['show_land_portfolio'] ) ) {
		$land_link = is_array( $land['button_link'] ?? null ) ? $land['button_link'] : array();
		$sliders[] = array(
			'heading'      => $land['heading'] ?? '',
			'content'      => $land['content'] ?? '',
			'button_url'   => iec_resolve_wpml_url( $land_link ),
			'button_title' => $land_link['title'] ?? __( 'Learn More', 'bbtheme' ),
			'slider'       => $land['portfolio'] ?? array(),
			'id'           => 'land',
		);
	}
	?>

	<main id="main" class="t-starlink-portfolio">

		<section
			class="iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center iec_starlink_portfolio_hero"
			<?php if ( $hero_style ) : ?>style="<?= $hero_style; ?>"<?php endif; ?>
			aria-labelledby="iec-starlink-page-title"
		>
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="iec_starlink_portfolio_hero_content">
							<h1 id="iec-starlink-page-title" class="iec-anim-split-words" data-iec-anim-on-load="true"><?= $heading; ?></h1>
							<?php if ( $sub_heading ) : ?>
								<p class="iec_starlink_portfolio_hero_subheading"><?= $sub_heading; ?></p>
							<?php endif; ?>
							<?php
							get_template_part(
								'template-parts/starlink-portfolio/hero-buttons',
								null,
								array(
									'buttons'  => $hero_buttons,
									'instance' => 'hero',
								)
							);
							?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="iec_starlink_portfolio_hero_below_button">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<?php
						get_template_part(
							'template-parts/starlink-portfolio/hero-buttons',
							null,
							array(
								'buttons'  => $hero_buttons,
								'instance' => 'below',
							)
						);
						?>
					</div>
				</div>
			</div>
		</section>

		<?php
		if ( $insights_query instanceof WP_Query ) {
			get_template_part(
				'template-parts/modules/featured-news',
				null,
				array(
					'heading' => $news['heading'] ?? '',
					'query'   => $insights_query,
				)
			);
		}

		foreach ( $sliders as $slider ) {
			get_template_part( 'template-parts/modules/vertical-market-slider', null, $slider );
		}

		if ( ! empty( $fields['show_plans'] ) ) {
			get_template_part(
				'template-parts/starlink-portfolio/plans',
				null,
				array(
					'service_plans' => $fields['service_plans'] ?? array(),
				)
			);
		}

		if ( ! empty( $fields['show_faq'] ) ) {
			iec_module(
				'faq',
				array(
					'heading' => $faq['heading'] ?? '',
					'faq'     => $faq['fqas'] ?? array(),
				)
			);
		}
		?>

	</main>

	<?php
endwhile;

get_footer();
