<?php
/**
 * Template Name: Offices Landing Page
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$fields  = get_fields() ?: array();
	$heading = ! empty( $fields['ro_section_heading'] ) ? $fields['ro_section_heading'] : __( 'Our Regional Offices', 'bbtheme' );
	$offices = iec_offices_get_items( $fields['ro_offices'] ?? array() );
	$map_src = get_stylesheet_directory_uri() . '/assets/img/offices-map.png';
	?>
	<div id="main">
		<section class="iec_regional_offices_section iec_defualt_position">
			<div class="container">
				<div class="row">

				
					<div class="col-lg-5 iec_regional_offices_left_warpper">
						<div class="iec_regional_offices_main_content">
							<h1 data-aos="fade-right" data-aos-duration="800"><?php echo wp_kses_post( $heading ); ?></h1>

							<ul>
								<?php foreach ( $offices as $index => $item ) : ?>
									<li data-aos="fade-up" data-aos-delay="<?php echo esc_attr( 100 + ( $index * 50 ) ); ?>">
										<a href="<?php echo esc_url( $item['permalink'] ); ?>"
											class="iec_regional_offices_button"
											data-target="<?php echo esc_attr( $item['card_class'] ); ?>">
											<?php echo wp_kses_post( $item['title'] ); ?>
										</a>
									</li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>

					
					<div class="col-lg-7 iec_regional_offices_right_warpper">
						<div class="iec_regional_offices_map_image_warpper" data-aos="fade-left" data-aos-duration="1000">
							<div class="iec_svg_map">
								<img class="iec_regional_offices_image"
									src="<?php echo esc_url( $map_src ); ?>"
									alt=""
									width="<?php echo esc_attr( IEC_OFFICES_MAP_DESKTOP_W ); ?>"
									height="<?php echo esc_attr( IEC_OFFICES_MAP_DESKTOP_H ); ?>">

								<?php foreach ( $offices as $item ) : ?>
									<a<?php echo iec_offices_pointer_attributes( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Escaped per attribute in helper. ?>>
										<span class="iec_map_pin" aria-hidden="true"></span>
										<span class="iec_hover_tooltip"><span><?php echo wp_kses_post( $item['pin_label'] ); ?></span></span>
									</a>
								<?php endforeach; ?>

								<div class="iec_map_card" id="mapTooltip"></div>
							</div>
						</div>
					</div>

				</div>
			</div>
		</section>
	</div>
	<?php
endwhile;

get_footer();