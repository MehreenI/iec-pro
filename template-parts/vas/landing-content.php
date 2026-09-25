<?php
/**
 * VAS landing main section wrapper.
 *
 * @package iec
 *
 * @var array $args { banner: array, fields: array }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$banner = $args['banner'] ?? array();
$fields = $args['fields'] ?? array();
$sections = $fields['section'] ?? array();

?>
<section class="iec_background_image_section iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center iec_main_contact_section iec_value_added_services_content" data-vas-landing-content>
	<div class="container">
		<?php get_template_part( 'template-parts/vas/landing-intro', null, array( 'banner' => $banner ) ); ?>
		<?php
		get_template_part(
			'template-parts/vas/landing-grid',
			null,
			array( 'sections' => $sections,'spacing'=>'mb-10' )
		);
		?>
	</div>
</section>
