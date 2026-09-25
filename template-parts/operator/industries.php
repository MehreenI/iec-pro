<?php
/**
 * Operator — solutions for every industry (flip cards).
 *
 * Args: fields (ACF group `solutions`: eyebrow, heading, content,
 *       cards[front_title, front_text, back_title, back_text, bullets[text], link]).
 * Empty fields fall back to iec_operator_defaults().
 *
 * @package iec
 */

if (!defined('ABSPATH')) {
    exit();
}

$section = is_array($args['fields']['solutions'] ?? null) ? $args['fields']['solutions'] : [];
$defaults = iec_operator_defaults()['solutions'];
$eyebrow = iec_filled($section['eyebrow'] ?? '', $defaults['eyebrow']);
$heading = iec_filled($section['heading'] ?? '', $defaults['heading']);
$content = iec_filled($section['content'] ?? '', $defaults['content']);
$cards = iec_rows_or_defaults($section['cards'] ?? [], $defaults['cards']);
$arrow = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none"><path d="M8.49219 3.41666C8.51931 3.41691 8.54751 3.42327 8.5752 3.43619C8.60296 3.44917 8.63095 3.46927 8.65625 3.49771L8.66211 3.50357L11.6621 6.76236C11.7006 6.8041 11.7315 6.86254 11.7441 6.9313C11.7567 7.00001 11.7494 7.07095 11.7256 7.13345V7.13443C11.7101 7.17539 11.6882 7.21038 11.6631 7.23795L8.66309 10.4958L8.65723 10.5026C8.63196 10.531 8.6039 10.5511 8.57617 10.5641C8.54854 10.577 8.52024 10.5834 8.49316 10.5836C8.46606 10.5839 8.4378 10.5783 8.41016 10.5661C8.3825 10.5538 8.3546 10.5341 8.3291 10.5065C8.30342 10.4786 8.28041 10.4429 8.26465 10.401C8.24888 10.3592 8.24083 10.3126 8.24121 10.2653C8.24163 10.2183 8.25039 10.1727 8.2666 10.1315C8.28294 10.0902 8.30614 10.0552 8.33203 10.028L8.33789 10.0211L10.0576 8.15396L10.8301 7.31509H2.5C2.44774 7.31508 2.3885 7.29274 2.33789 7.23795C2.28597 7.18156 2.25006 7.09668 2.25 7.00064C2.25 6.9045 2.28593 6.81977 2.33789 6.76334C2.38855 6.70835 2.44765 6.6862 2.5 6.68619H10.8301L10.0576 5.84732L8.33691 3.97818L8.33105 3.97232L8.29492 3.92545C8.28406 3.90831 8.27471 3.8893 8.2666 3.8688C8.25023 3.82742 8.24061 3.78135 8.24023 3.73404C8.23989 3.68684 8.24892 3.64104 8.26465 3.59927C8.2804 3.55745 8.30244 3.5217 8.32812 3.4938C8.35361 3.46617 8.3815 3.44657 8.40918 3.43423C8.43682 3.42195 8.46509 3.41641 8.49219 3.41666Z" fill="#727DA3" stroke="#727DA3"></path></svg>';
?>

<section class="iec_defualt_position p-3" id="solutions" aria-labelledby="solutions-heading">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="iec_content_box text-md-center">
                    <span class="iec-eyebrow text-md-center"><?= $eyebrow; ?></span>
                    <h2 id="solutions-heading" class="iec-section-heading text-md-center mb-1" data-split="word" data-fade="up"><?= $heading; ?></h2>
                    <div class="wysiwyg-content mb-2" data-fade="up" data-delay="100"><?= $content; ?></div>
                </div>
            </div>
        </div>
        <?php if ($cards): ?>
            <div class="row iec_flip_grid">
                <?php foreach ($cards as $index => $item): ?>
                    <?php
                    $number = sprintf('%02d', $index + 1);
                    $link = iec_link_parts($item['link'] ?? null, $defaults['link_default']);
                    $bullets = array_filter(iec_flex_rows($item['bullets'] ?? null), function ($bullet) {
                        return !empty($bullet['text']);
                    });
                    ?>
                    <div class="col-md-3">
                        <div class="iec_flip_card">
                            <div class="iec_flip_card_inner">
                                <div class="iec_flip_card_face iec_flip_card_front">
                                    <span class="iec_flip_card_num" aria-hidden="true"><?= $number; ?></span>
                                    <!-- <span class="iec_flip_card_icon" aria-hidden="true">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="12" cy="12" r="9"></circle><path d="M8 12h8M12 8v8" stroke-linecap="round"></path></svg>
                                    </span> -->
                                    <h3 class="iec-heading"><?= $item['front_title'] ?? ''; ?></h3>
                                    <div class="wysiwyg-content mb-2" data-fade="up" data-delay="100">
                                        <p class="card_iec_text"><?= $item['front_text'] ?? ''; ?></p>
                                    </div>
                                    <span class="iec_flip_card_hint"><?= __('Hover to explore', 'iec'); ?> <?= $arrow; ?></span>
                                </div>

                                <div class="iec_flip_card_face iec_flip_card_back">
                                    <span><?= $number; ?> / <?= __('Solution', 'iec'); ?></span>
                                    <h3 class="iec-heading"><?= $item['back_title'] ?? ''; ?></h3>
                                    <div class="wysiwyg-content mb-2" data-fade="up" data-delay="100">
                                        <p class="card_iec_text"><?= $item['back_text'] ?? ''; ?></p>
                                    </div>
                                    <?php if ($bullets): ?>
                                        <ul class="iec_flip_card_list">
                                            <?php foreach ($bullets as $bullet): ?>
                                                <li class="card_iec_text"><?= $bullet['text']; ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php endif; ?>
                                    <?php if ($link['url']): ?>
                                        <a href="<?= $link['url']; ?>" class="iec_flip_card_link"<?= $link['target']; ?>><?= $link['title']; ?> <?= $arrow; ?></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
