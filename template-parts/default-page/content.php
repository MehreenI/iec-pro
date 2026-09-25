<?php

if (!defined('ABSPATH')) {
    exit();
}

$blocks = get_field('content_blocks');
$editor = trim(get_the_content());

if (!$blocks && '' === $editor) {
    return;
}
?>

<section class="iec_default_content_section">
    <?php if ($blocks): ?>
        <?php while (have_rows('content_blocks')):
            the_row();
            get_template_part('template-parts/default-page/blocks/' . get_row_layout());
        endwhile; ?>
    <?php else: ?>
        <div class="iec_default_block">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="wysiwyg-content" data-fade="up"><?php the_content(); ?></div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>
