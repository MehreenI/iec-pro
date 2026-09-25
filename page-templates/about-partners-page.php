<?php
/**
 * Template Name: About Partners Page
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

while ( have_posts() ) :
	the_post();

	$fields       = get_fields() ?: array();
	$banner       = $fields['banner'] ?? array();
	$banner_image = $banner['image']['url'] ?? '';
	$mobile_image = $banner['mobile_image']['url'] ?? '';
	$overlay      = $banner['overlay_title'] ?? '';
	$sub_heading  = $banner['sub_heading'] ?? '';
	?>

	<main id="main" class="iec-about-partners-main">

		<!-- Hero. -->
		<?php if ( $banner_image || $overlay || $sub_heading ) : ?>
			<section class="iec_hero_banner iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center"<?php echo $banner_image ? ' style="--bgImage: url(\'' . $banner_image . '\'); --mobileImage: url(\'' . $mobile_image . '\');"' : ''; ?>>
				<div class="container">
					<div class="row">
						<div class="col-md-5">
							<div class="iec_hero_content_box">

								<?php if ( $overlay ) : ?>
									<h1 class="iec-primary-heading"><?php echo $overlay; ?></h1>
								<?php elseif ( ! $sub_heading ) : ?>
									<h1 class="sr-only"><?php echo get_the_title(); ?></h1>
								<?php endif; ?>

								<?php if ( $sub_heading ) : ?>
									<?php if ( $overlay ) : ?>
										<h2 class="iec-sub-heading"><?php echo $sub_heading; ?></h2>
									<?php else : ?>
										<h1 class="iec-sub-heading"><?php echo $sub_heading; ?></h1>
									<?php endif; ?>
								<?php endif; ?>

								<div class="btn">
									<a class="gray_btn" href="#contact">Speak to an expert</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		<?php endif; ?>

		<section class="iec-spacer">
			<div class="container">
				<div class="row">
					<div class="col-md-12" style="height: 2.78301177649rem"></div>
				</div>
			</div>
		</section>

		<?php get_template_part( 'template-parts/about/tabs', null, array( 'fields' => $fields ) ); ?>

		<?php get_template_part( 'template-parts/about/about-partner-accordion', null, array( 'partners' => $fields['partners'] ?? array() ) ); ?>

	</main>

	<?php
endwhile;

get_footer();
