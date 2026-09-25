<?php
/**
 * Operator — live availability by region and the specialist note.
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$defaults = iec_operator_defaults()['availability'];

$live = function_exists('iec_starlink_live_availability') ? iec_starlink_live_availability() : [];
$continents = is_array($live['continents'] ?? null) ? $live['continents'] : [];

// "All" tab: har region ki chips merge karke, duplicates hata kar, A–Z sort.
if ($continents) {
    $all_chips = [];

    foreach ($continents as $continent) {
        foreach ($continent['chips'] ?? [] as $chip) {
            $name = strtolower(trim(wp_strip_all_tags($chip[1])));

            if ($name !== '' && !isset($all_chips[$name])) {
                $all_chips[$name] = $chip;
            }
        }
    }

    ksort($all_chips, SORT_NATURAL);

    $continents = [
            'all' => [
                'label' => __('All', 'iec'),
                'chips' => array_values($all_chips),
            ],
        ] + $continents;
}

$first_key = array_key_first($continents);

$eyebrow = iec_filled(get_sub_field('eyebrow'), $defaults['eyebrow']);
$heading = iec_filled(get_sub_field('heading'), $defaults['heading']);
$content = iec_filled(get_sub_field('content'), $defaults['content']);
$status_heading = iec_filled(get_sub_field('status_heading'), $defaults['status_heading']);
$note_heading = iec_filled(get_sub_field('note_heading'), $defaults['note_heading']);
$note_content = iec_filled(get_sub_field('note_content'), $defaults['note_content']);
$note_buttons = [
    iec_link_parts(get_sub_field('note_primary_button'), $defaults['note_primary_button']),
    iec_link_parts(get_sub_field('note_secondary_button'), $defaults['note_secondary_button']),
];
?>
<section class="iec_defualt_position p-3" id="availability" aria-labelledby="availability-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_content_box text-md-center">
                    <span class="iec-eyebrow text-md-center"><?= $eyebrow; ?></span>
                    <h2 id="availability-heading" class="iec-section-heading text-md-center mb-1" data-split="word" data-fade="up"><?= $heading; ?></h2>
                    <div class="wysiwyg-content"><?= $content; ?></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="iec_content_box text-md-center">
                    <h3 class="iec-heading text-md-center highlight"><?= $status_heading; ?></h3>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="iec-avail-key" role="list">
                    <span class="iec-avail-key-item" role="listitem"><i class="iec-avail-dot iec-avail-dot--live" aria-hidden="true"></i><?= __('Available — licensed and live', 'iec'); ?></span>
                    <span class="iec-avail-key-item" role="listitem"><i class="iec-avail-dot iec-avail-dot--pend" aria-hidden="true"></i><?= __('Pending — in the regulatory process', 'iec'); ?></span>
                    <span class="iec-avail-key-item" role="listitem"><i class="iec-avail-dot iec-avail-dot--no" aria-hidden="true"></i><?= __('Restricted — service not permitted', 'iec'); ?></span>
                </div>
            </div>
        </div>

        <?php if ($continents): ?>
            <div class="iec-avail-card">
                <div class="row">
                    <div class="col-md-12">
                        <div class="iec_avail_tab_search">
                            <form role="search">
                                <input type="search" name="tab_search" placeholder="<?= __('Search country', 'iec'); ?>" autocomplete="off" value="" aria-label="<?= __('Search country', 'iec'); ?>">
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row iec-avail-tabs" data-iec-tabs>
                    <div class="col-md-4">
                        <div class="iec-avail-tabnav" role="tablist" aria-orientation="vertical" aria-label="<?= __('Regions', 'iec'); ?>">
                            <?php foreach ($continents as $key => $continent): ?>
                                <button
                                        type="button"
                                        class="iec-avail-tab<?= $key === $first_key ? ' is-active' : ''; ?>"
                                        role="tab"
                                        id="iec-tab-<?= $key; ?>"
                                        aria-selected="<?= $key === $first_key ? 'true' : 'false'; ?>"
                                        aria-controls="panel-<?= $key; ?>"
                                        tabindex="<?= $key === $first_key ? '0' : '-1'; ?>"
                                        data-iec-tab="<?= $key; ?>"
                                >
                                    <span class="iec-avail-tab-label"><?= $continent['label']; ?></span>
                                    <span class="iec-avail-tab-count"><?= count($continent['chips'] ?? []); ?></span>
                                </button>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <div class="iec-avail-board">

                            <?php foreach ($continents as $key => $continent): ?>
                                <div
                                        class="iec-avail-panel<?= $key === $first_key ? ' is-active' : ''; ?>"
                                        role="tabpanel"
                                        id="panel-<?= $key; ?>"
                                        aria-labelledby="iec-tab-<?= $key; ?>"
                                    <?= $key === $first_key ? '' : ' hidden'; ?>
                                >
                                    <div class="iec-avail-panel-head">
                                        <h3 class="iec-avail-panel-title"><?= $continent['label']; ?></h3>
                                        <span class="iec-avail-panel-meta"><?= count($continent['chips'] ?? []); ?> <?= __('countries', 'iec'); ?></span>
                                    </div>

                                    <?php if (empty($continent['chips'])): ?>
                                        <p class="iec-avail-empty"><?= __('No countries reported for this region yet.', 'iec'); ?></p>
                                    <?php else: ?>
                                        <div class="iec-avail-chips">
                                            <?php foreach ($continent['chips'] as $chip): ?>
                                                <span class="iec-avail-chip">
                                            <i class="iec-avail-dot iec-avail-dot--<?= $chip[0]; ?>" aria-hidden="true"></i>
                                            <?= $chip[1]; ?>
                                        </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>

                                </div>
                            <?php endforeach; ?>

                            <p class="iec-avail-empty iec-avail-noresult" hidden><?= __('No countries match your search.', 'iec'); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-12">
                    <div class="wysiwyg-content">
                        <p class="iec-avail-empty"><?= __('Availability data could not be loaded. Please try again shortly.', 'iec'); ?></p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-12">
                <div class="iec_availability_note">
                    <h3 class="iec-secondary-heading"><?= $note_heading; ?></h3>

                    <div class="wysiwyg-content"><?= $note_content; ?></div>

                    <nav class="navigation-buttons">
                        <?php foreach ($note_buttons as $button): ?>
                            <?php if ($button['url']): ?>
                                <a class="btn secondary-btn" href="<?= $button['url']; ?>"<?= $button['target']; ?>><?= $button['title']; ?></a>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</section>
