<?php
/**
 * Template Name: Solution and Product Listing Page
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
	$banner_image = iec_resolve_media_to_url( $fields['image'] ?? '' );
	$mobile_image = iec_resolve_media_to_url( $fields['mobile_image'] ?? '' );
	$heading      = ( $fields['heading'] ?? '' ) ?: get_the_title();
	$sub_heading  = $fields['sub_heading'] ?? '';
	$link         = is_array( $fields['link'] ?? null ) ? $fields['link'] : array();
	$link_url     = iec_resolve_wpml_url( $link );
	$link_title   = $link['title'] ?? __( 'Learn More', 'bbtheme' );
	$link_target  = $link['target'] ?? '_self';
	$link_rel     = ( '_blank' === $link_target ) ? 'noopener noreferrer' : '';
	$show_text    = ! empty( $fields['show_text'] );
	$content      = $fields['content'] ?? '';
	$sp_landing   = iec_sp_landing_page_context( get_the_ID() );
	$main_class   = ! empty( $sp_landing['is_inner_products'] ) ? 'inner-products' : '';

	$hero_style = '';
	if ( $banner_image ) {
		$hero_style = '--bgImage: url(\'' . $banner_image . '\');';
		if ( $mobile_image ) {
			$hero_style .= ' --mobileImage: url(\'' . $mobile_image . '\');';
		}
	}

	$filter_groups = array();

	if ( empty( $sp_landing['hide_application_filter'] ) ) {
		$filter_groups[] = array(
			'slug'    => 'application',
			'label'   => __( 'Application', 'bbtheme' ),
			'wrapper' => 'first',
			'row'     => 'toggle-fields-row single-column cf',
		);
	}

	$filter_groups[] = array(
		'slug'    => 'setup',
		'label'   => __( 'Set up', 'bbtheme' ),
		'wrapper' => 'first',
		'row'     => 'toggle-fields-row single-column cf',
	);
	$filter_groups[] = array(
		'slug'    => 'operator',
		'label'   => __( 'Operator', 'bbtheme' ),
		'wrapper' => 'second',
		'row'     => 'toggle-fields-row cf',
	);
	$filter_groups[] = array(
		'slug'    => 'market',
		'label'   => __( 'Market', 'bbtheme' ),
		'wrapper' => 'third',
		'row'     => 'toggle-fields-row cf',
	);
	?>

	<main id="main"<?= $main_class ? ' class="' . $main_class . '"' : ''; ?>>

		<section
			class="iec_hero_banner iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center"
			<?php if ( $hero_style ) : ?>style="<?= $hero_style; ?>"<?php endif; ?>
			aria-labelledby="iec-page-title"
		>
			<div class="iec_hero_strips" aria-hidden="true">
				<span></span><span></span><span></span><span></span><span></span><span></span>
			</div>

			<div class="container">
				<div class="row">
					<div class="col-md-5">
						<div class="iec_hero_content_box">
							<h1 id="iec-page-title" class="iec-primary-heading js-split-reveal"><?= $heading; ?></h1>
							<?php if ( $sub_heading ) : ?>
								<p class="iec-sub-heading js-split-reveal"><?= $sub_heading; ?></p>
							<?php endif; ?>
							<?php if ( $link_url ) : ?>
								<p class="btn js-fade-up">
									<a class="gray_btn linkto" href="<?= $link_url; ?>" target="<?= $link_target; ?>"<?= $link_rel ? ' rel="' . $link_rel . '"' : ''; ?>><?= $link_title; ?></a>
								</p>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</section>

		<section class="iec_product_post_filter_forms filters-form" aria-label="<?= __( 'Filter products', 'bbtheme' ); ?>">
			<form method="get" action="" id="filters-form" data-sp-landing-filters>
				<input type="hidden" name="start-at" value="<?= $sp_landing['per_page']; ?>">
				<input type="hidden" name="type" value="<?= $sp_landing['post_type']; ?>">
				<input type="hidden" name="category" value="<?= $sp_landing['product_category'] ?? ''; ?>">

				<div class="container">
					<div class="filters-grid">
						<?php foreach ( $filter_groups as $group ) : ?>
							<div class="iec_filters_group_warpper <?= $group['wrapper']; ?>">
								<div class="filters-group">
									<p class="filters-group-title"><?= $group['label']; ?></p>
									<div class="toggle-fields-wrapper">
										<div class="<?= $group['row']; ?>">
											<?php print_ps_filter( $group['slug'] ); ?>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>
			</form>
		</section>

		<?php get_template_part( 'template-parts/sp-landing/products', 'section', $sp_landing ); ?>

		<?php if ( $show_text && $content ) : ?>
			<article class="intro">
				<div class="container">
					<div class="wyswig-content">
						<?= $content; ?>
					</div>
				</div>
			</article>
		<?php endif; ?>

	</main>

	<?php
endwhile;

get_footer();
