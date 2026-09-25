<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$field      = $args['field'] ?? array();
$news       = $field['news'] ?? array();
$about_us   = $field['about_us'] ?? array();
$contact_us = $field['contact_us'] ?? array();

$tabs = array(
	array(
		'id'    => 'about_us',
		'label' => $about_us['tab_name'] ?? __( 'About Us', 'bbtheme' ),
		'part'  => array( 'template-parts/office/about', null, array( 'about_us' => $about_us ) ),
	),
	array(
		'id'    => 'regional_news',
		'label' => $news['tab_name'] ?? __( 'Regional News', 'bbtheme' ),
		'part'  => array( 'template-parts/office/regional', 'news', array( 'field' => $field ) ),
	),
	array(
		'id'    => 'contact_us',
		'label' => $contact_us['tab_name'] ?? __( 'Contact Us', 'bbtheme' ),
		'part'  => array( 'template-parts/office/contact', null, array( 'contact_us' => $contact_us ) ),
	),
);
?>

<!-- Office tabs. -->
<section class="iec_single_office_tab_section" data-office-tabs aria-label="<?php esc_attr_e( 'Office information', 'bbtheme' ); ?>">
	<div class="iec_single_office_tabs_warpper">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="custom-tab-container">
						<div class="custom-tab-buttons" role="tablist">
							<?php foreach ( $tabs as $index => $tab ) : ?>
								<button
									type="button"
									id="iec-office-tab-<?php echo esc_attr( (string) $index ); ?>"
									class="custom-tab-btn<?php echo 0 === $index ? ' active' : ''; ?>"
									role="tab"
									aria-selected="<?php echo 0 === $index ? 'true' : 'false'; ?>"
									aria-controls="<?php echo esc_attr( $tab['id'] ); ?>"
									tabindex="<?php echo 0 === $index ? '0' : '-1'; ?>"
									data-tab="<?php echo esc_attr( (string) $index ); ?>"
								>
									<?php echo $tab['label']; ?>
								</button>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="iec_office_tabs_swiper_wrap">
		<div class="swiper iec_office_tabs_swiper">
			<div class="swiper-wrapper">
				<?php foreach ( $tabs as $index => $tab ) : ?>
					<div class="swiper-slide">
						<?php get_template_part( $tab['part'][0], $tab['part'][1], $tab['part'][2] ); ?>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
