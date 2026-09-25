<?php

if (!defined('ABSPATH')) {
    exit();
}

$fields = iec_page_fields();
?>

<section class="iec_default_hero_section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1 class="iec-primary-heading" data-split="word" data-fade="up"><?= ($fields['caption'] ?? '') ?: get_the_title(); ?></h1>
            </div>
        </div>
    </div>
</section>
