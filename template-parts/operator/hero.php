<?php
/**
 * Operator — hero and the stats bar under it.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$banner = is_array($args['fields']['banner'] ?? null) ? $args['fields']['banner'] : [];
$defaults = iec_operator_defaults()['banner'];
$banner_image = iec_resolve_media_to_url($banner['image'] ?? null) ?: $defaults['image_default'];
$banner_mobile_image = iec_resolve_media_to_url($banner['mobile_image'] ?? null);
$title = iec_filled($banner['overlay_title'] ?? '', $defaults['overlay_title']);
$lead = iec_filled($banner['sub_heading'] ?? '', $defaults['sub_heading']);
$eyebrow = iec_filled($banner['eyebrow'] ?? '', $defaults['eyebrow']);
$primary = iec_link_parts($banner['primary_button'] ?? null, $defaults['primary_button']);
$secondary = iec_link_parts($banner['secondary_button'] ?? null, $defaults['secondary_button']);
$stats = iec_rows_or_defaults($banner['stats'] ?? [], $defaults['stats']);
$boxes = iec_rows_or_defaults($banner['boxes'] ?? [], $defaults['boxes']);
$stats_style = in_array($banner['stats_style'] ?? '', ['compact', 'strip', 'cards'], true) ? $banner['stats_style'] : $defaults['stats_style'];
?>

<section class="iec_hero_banner iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center<?= $banner_mobile_image ? ' has-mobile-image' : ''; ?>" style="--bgImage: url(<?= $banner_image; ?>);<?= $banner_mobile_image ? ' --bgImageMobile: url(' . $banner_mobile_image . ');' : ''; ?>" aria-label="<?= __('Starlink hero', 'iec'); ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="iec_content_box text-md-center">
					<span class="iec-eyebrow text-md-center" data-fade="up"><?= $eyebrow; ?></span>

					<h1 class="iec-primary-heading text-white" data-split="word" data-fade="up" data-delay="100"><?= $title; ?></h1>

					<div class="iec_hero_desc wysiwyg-content" data-fade="up" data-delay="200"><?= $lead; ?></div>

					<nav class="navigation-buttons" data-fade="up" data-delay="300">
						<a href="<?= $primary['url']; ?>" class="btn secondary-btn"<?= $primary['target']; ?>><?= $primary['title']; ?></a>
						<a href="<?= $secondary['url']; ?>" class="btn outline-btn"<?= $secondary['target']; ?>><?= $secondary['title']; ?></a>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>

<?php if ($stats || $boxes): ?>
	<section class="iec-statistics" aria-label="<?= __('Starlink at a glance', 'iec'); ?>">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="iec_starlink_hero_below_grid" data-fade="up" data-delay="150" data-stagger=".iec_starlink_hero_below_box">
						<?php foreach ($boxes as $box): ?>
							<div class="iec_starlink_hero_below_box">
                                <?php if(get_field('icon') ): ?>
								<span class="iec_starlink_hero_below_box_icon" aria-hidden="true">
									<?= get_field('icon') ?>
								</span>
                                <?php endif; ?>

								<h2><?= $box['title'] ?? ''; ?></h2>

								<div class="wysiwyg-content">
									<p class="card_iec_text"><?= $box['text'] ?? ''; ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
                </div>
			</div>
		</div>
	</section>
<?php endif; ?>
