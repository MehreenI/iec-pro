<?php

if (!defined('ABSPATH')) {
    exit();
}

$content = get_sub_field('content');

if (!$content) {
    return;
}
?>

<div class="iec_default_block">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="wysiwyg-content" data-fade="up"><?= $content; ?></div>
            </div>
        </div>
    </div>
</div>
