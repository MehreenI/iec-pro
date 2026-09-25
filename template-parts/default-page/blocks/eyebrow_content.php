<?php

if (!defined('ABSPATH')) {
    exit();
}

$eyebrow = get_sub_field('eyebrow');
$heading = get_sub_field('heading');
$content = get_sub_field('content');

if (!$eyebrow && !$heading && !$content) {
    return;
}
?>

<div class="iec_default_block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php if ($eyebrow): ?>
                    <span class="iec-eyebrow" data-fade="up"><?= $eyebrow; ?></span>
                <?php endif; ?>

                <?php if ($heading): ?>
                    <h2 class="iec-section-heading" data-split="word" data-fade="up"><?= $heading; ?></h2>
                <?php endif; ?>

                <?php if ($content): ?>
                    <div class="wysiwyg-content" data-fade="up" data-delay="150"><?= $content; ?></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
