<?php
/**
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields       = $args['fields'] ?? array();
$banner       = $fields['banner'] ?? array();
$banner_image = $banner['image']['url'] ?? '';
$overlay      = $banner['overlay_title'] ?? '';
$content_title = $fields['content_title'] ?? '';

if ( ! $banner_image && ! $overlay && ! $content_title ) {
	return;
}
?>

<?php if ( $banner_image || $overlay ) : ?>
	<section
		class="iec_hero_banner iec_hero_content_banner iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center"
		<?php if ( $banner_image ) : ?>
			style="--bgImage: url('<?= esc_url( $banner_image ); ?>');"
		<?php endif; ?>
		aria-label="<?php esc_attr_e( 'Page hero', 'bbtheme' ); ?>"
	>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="iec_hero_content_box">
						<?php if ( $overlay ) : ?>
							<h1 class="iec_main_heading"><?= $overlay; ?></h1>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>

<?php if ( $content_title ) : ?>
	<?php $content_heading_tag = $overlay ? 'h2' : 'h1'; ?>
	<section class="iec_heading_section">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<<?= $content_heading_tag; ?> class="iec-about-main-heading"><?= $content_title; ?></<?= $content_heading_tag; ?>>
				</div>
			</div>
		</div>
	</section>
<?php endif; ?>
