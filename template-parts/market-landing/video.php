<?php
/**
 * Market Landing — video band.
 *
 * Args: section (ACF group `video`: show_section, video_file, poster_image, heading, sub_heading).
 * Empty fields fall back to iec_market_landing_defaults().
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$section = is_array($args['section'] ?? null) ? $args['section'] : [];

if (iec_section_hidden($section)) {
    return;
}

$defaults = iec_market_landing_defaults()['video'];
$video = iec_filled($section['video_file'] ?? '', $defaults['video_file_default']);
$poster = iec_resolve_media_to_url($section['poster_image'] ?? null);
?>

<section class="iec-industries-video iec_defualt_position">
    <div class="iec-industries-video__media">
        <video class="iec-industries-video__video" autoplay muted loop playsinline preload="metadata"<?= $poster ? ' poster="' . $poster . '"' : ''; ?>>
            <source src="<?= $video; ?>" type="video/mp4">
        </video>
        <div class="iec-industries-video__overlay"></div>
    </div>
    <div class="container">
        <div class="row mx-auto">
            <div class="col-md-12 text-md-center">
                <div class="iec-content d-flex align-items-center justify-content-center">
                    <h2 class="iec-section-heading mb-1 text-white"><?= iec_filled($section['heading'] ?? '', $defaults['heading']); ?></h2>
                    <h3 class="iec-sub-heading text-white text-center"><?= iec_filled($section['sub_heading'] ?? '', $defaults['sub_heading']); ?></h3>
                </div>
            </div>
        </div>
    </div>
</section>
