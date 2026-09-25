<?php
/**
 * About hero banner.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields       = $args['fields'] ?? array();
$banner       = $fields['banner'] ?? array();
$banner_image = $banner['image']['url'] ?? '';
$overlay      = $banner['overlay_title'] ?? '';

if ( ! $banner_image && ! $overlay ) {
	return;
}

?>

<!-- Hero. -->
<section class="iec_hero_banner iec_hero_content_banner iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center"<?php echo $banner_image ? ' style="--bgImage: url(\'' . $banner_image . '\');"' : ''; ?>>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_hero_content_box">

					<?php if ( $overlay ) : ?>
						<h1 class="iec_main_heading"><?php echo $overlay; ?></h1>
					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
</section>
