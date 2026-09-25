<?php
/**
 * Starlink landing — product specs swiper + collapsible hardware details.
 *
 * @package iec
 */

if (! defined('ABSPATH')) {
    exit;
}

$fields = $args['fields'] ?? [];

if (empty($fields['general_specs_title']) && empty($fields['spec_title_main']) && empty($fields['spec_image'])) {
    return;
}
?>
<section class="iec_defualt_position iec_starlink_product_with_collapse_section">
    <div class="iec_starlink_product_sec">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="iec_section_heading iec-section-heading"><?= $fields['general_specs_title']; ?></h2>
                    <div class="iec_starlink_product_swiper_warpper">
                        <div class="swiper product_swiper">
                            <div class="swiper-wrapper">
                                <?php if (! empty($fields['spec_image'])): ?>
                                    <div class="swiper-slide">
                                        <div class="iec_starlink_product_box">
                                            <h3 class="iec_starlink_product_title"><?= $fields['spec_title_main']; ?></h3>
                                            <img src="<?= $fields['spec_image']; ?>" alt="img">
                                            <button id="ant-1" class="iec_starlink_product_button"><?php esc_attr_e('explore', 'bbtheme'); ?></button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (! empty($fields['spec_image_two'])): ?>
                                    <div class="swiper-slide">
                                        <div class="iec_starlink_product_box">
                                            <h3 class="iec_starlink_product_title"><?= $fields['spec_title_main_two']; ?></h3>
                                            <img src="<?= $fields['spec_image_two']; ?>" alt="img">
                                            <button id="ant-2" class="iec_starlink_product_button"><?php esc_attr_e('explore', 'bbtheme'); ?></button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (! empty($fields['spec_image_four'])): ?>
                                    <div class="swiper-slide">
                                        <div class="iec_starlink_product_box">
                                            <h3 class="iec_starlink_product_title"><?= $fields['spec_title_main_four']; ?></h3>
                                            <img src="<?= $fields['spec_image_four']; ?>" alt="img">
                                            <button id="ant-3" class="iec_starlink_product_button"><?php esc_attr_e('explore', 'bbtheme'); ?></button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (! empty($fields['spec_image_three'])): ?>
                                    <div class="swiper-slide">
                                        <div class="iec_starlink_product_box">
                                            <h3 class="iec_starlink_product_title"><?= $fields['spec_title_main_three']; ?></h3>
                                            <img src="<?= $fields['spec_image_three']; ?>" alt="img">
                                            <button id="ant-4" class="iec_starlink_product_button"><?php esc_attr_e('explore', 'bbtheme'); ?></button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (! empty($fields['spec_image_five'])): ?>
                                    <div class="swiper-slide">
                                        <div class="iec_starlink_product_box">
                                            <h3 class="iec_starlink_product_title"><?= $fields['spec_title_main_five']; ?></h3>
                                            <img src="<?= $fields['spec_image_five']; ?>" alt="img">
                                            <button id="ant-5" class="iec_starlink_product_button"><?php esc_attr_e('explore', 'bbtheme'); ?></button>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <?php if (! empty($fields['spec_image_five_copy'])): ?>
                                    <div class="swiper-slide">
                                        <div class="iec_starlink_product_box">
                                            <h3 class="iec_starlink_product_title"><?= $fields['spec_title_main_six']; ?></h3>
                                            <img src="<?= $fields['spec_image_five_copy']; ?>" alt="img">
                                            <button id="ant-6" class="iec_starlink_product_button"><?php esc_attr_e('explore', 'bbtheme'); ?></button>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="swiper-button-next iec_starlink_product_swiper_next">
                            <svg width="24" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M0 0.5L15.2337 0.5L30.7269 15.522L15.3634 31.5L0 31.5L15.3634 16L0 0.5Z" fill="#727DA4" fill-opacity="0.5"/>
                            </svg>
                        </div>
                        <div class="swiper-button-prev iec_starlink_product_swiper_prev">
                            <svg width="24" height="32" viewBox="0 0 31 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M30.7269 31.5L15.4932 31.5L-2.50143e-06 16.478L15.3634 0.499999L30.7269 0.5L15.3634 16L30.7269 31.5Z" fill="#727DA4" fill-opacity="0.5"/>
                            </svg>
                        </div>
                        <div class="swiper-pagination iec_starlink_product_swiper_pagination"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="iec_starlink_product_collapse_sec">
        <div class="container iec_starlink_product_collapse_container">
            <div class="row">
                <div class="col-md-12">
                    <div class="iec_starlink_product_collapse_warpper ant-item-1">
                        <div class="iec_starlink_product_collapse_item_warpper">
                            <svg class="close-popup d-none" width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 21.32L21 3.32001" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 3.32001L21 21.32" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="iec_starlink_product_collapse_item">
                                <div class="iec_starlink_product_collapse_item_image">
                                    <div class="ant-1 ant">
                                        <?= $fields['params'][0]['parameter']; ?>
                                        <svg width="217" height="92" viewBox="0 0 217 92" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M216 91L164 1H0" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-2 ant">
                                        <?= $fields['params'][1]['parameter']; ?>
                                        <svg width="330" height="88" viewBox="0 0 330 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 87.5L47.9384 1H330" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-3 ant">
                                        <?= $fields['params'][2]['parameter']; ?>
                                        <svg width="286" height="88" viewBox="0 0 286 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 87.5L47.9384 1H286" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-4 ant">
                                        <svg width="356" height="101" viewBox="0 0 356 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M63 1L1 100H356" stroke="#F3F2F4"/>
                                        </svg>
                                        <p><?= $fields['params'][3]['parameter']; ?></p>
                                    </div>
                                    <img class="img-1" src="<?= $fields['spec_image']; ?>" alt="<?php esc_attr_e( 'Product hardware', 'bbtheme' ); ?>">
                                </div>
                                <div class="iec_starlink_product_collapse_item_content">
                                    <div class="iec_starlink_product_collapse_item_content_top">
                                        <svg width="29" height="19" viewBox="0 0 29 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.7916 16.6248L14.6666 9.49982L21.7916 2.37482" stroke="#1B204C" stroke-width="2.27163"/>
                                            <path d="M9.125 16.625L2 9.5L9.125 2.375" stroke="#1B204C" stroke-width="2.27163"/>
                                        </svg>
                                        <?php esc_attr_e('View Other Hardware Options', 'bbtheme'); ?>
                                    </div>
                                    <div class="iec_starlink_product_collapse_item_content_bottom">
                                        <h4><?= $fields['spec_title']; ?></h4>
                                        <div class="desc">
                                            <?= $fields['spec_description']; ?>
                                        </div>
                                        <a href="<?= $fields['spec_more_url']; ?>" class="iec_starlink_product_button"><?php esc_attr_e('VIEW PRODUCT PAGE', 'bbtheme'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="iec_starlink_product_collapse_warpper ant-item-2">
                        <div class="iec_starlink_product_collapse_item_warpper">
                            <svg class="close-popup d-none" width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 21.32L21 3.32001" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 3.32001L21 21.32" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="iec_starlink_product_collapse_item">
                                <div class="iec_starlink_product_collapse_item_image">
                                    <div class="ant-5 ant">
                                        <?= $fields['params_second'][0]['parameter']; ?>
                                        <svg width="230" height="77" viewBox="0 0 230 77" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M229.5 76L198.5 1H0.5" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-6 ant">
                                        <?= $fields['params_second'][1]['parameter']; ?>
                                        <svg width="330" height="88" viewBox="0 0 330 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 87.5L47.9384 1H330" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-7 ant">
                                        <?= $fields['params_second'][2]['parameter']; ?>
                                        <svg width="315" height="70" viewBox="0 0 315 70" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 69L48.4384 1H315" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-8 ant">
                                        <svg width="359" height="47" viewBox="0 0 359 47" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M358.5 1L309 46.5H0" stroke="#F3F2F4"/>
                                        </svg>
                                        <p><?= $fields['params_second'][3]['parameter']; ?></p>
                                    </div>
                                    <img class="img-2" src="<?= $fields['spec_image_two']; ?>" alt="<?php esc_attr_e( 'Product hardware', 'bbtheme' ); ?>">
                                </div>
                                <div class="iec_starlink_product_collapse_item_content">
                                    <div class="iec_starlink_product_collapse_item_content_top">
                                        <svg width="29" height="19" viewBox="0 0 29 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.7916 16.6248L14.6666 9.49982L21.7916 2.37482" stroke="#1B204C" stroke-width="2.27163"/>
                                            <path d="M9.125 16.625L2 9.5L9.125 2.375" stroke="#1B204C" stroke-width="2.27163"/>
                                        </svg>
                                        <?php esc_attr_e('View Other Hardware Options', 'bbtheme'); ?>
                                    </div>
                                    <div class="iec_starlink_product_collapse_item_content_bottom">
                                        <h4><?= $fields['spec_title_two']; ?></h4>
                                        <div class="desc">
                                            <?= $fields['spec_description_two']; ?>
                                        </div>
                                        <a href="<?= $fields['more_url_two']; ?>" class="iec_starlink_product_button"><?php esc_attr_e('VIEW PRODUCT PAGE', 'bbtheme'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="iec_starlink_product_collapse_warpper ant-item-3">
                        <div class="iec_starlink_product_collapse_item_warpper">
                            <svg class="close-popup d-none" width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 21.32L21 3.32001" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 3.32001L21 21.32" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="iec_starlink_product_collapse_item">
                                <div class="iec_starlink_product_collapse_item_image">
                                    <div class="ant-9 ant">
                                        <?= $fields['params_four'][0]['parameter']; ?>
                                        <svg width="217" height="92" viewBox="0 0 217 92" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M216 91L164 1H0" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-10 ant">
                                        <?= $fields['params_four'][1]['parameter']; ?>
                                        <svg width="300" height="106" viewBox="0 0 300 106" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 105L28 1H300" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-11 ant">
                                        <p><?= $fields['params_four'][2]['parameter']; ?> </p>
                                        <svg width="319" height="28" viewBox="0 0 319 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 27L17 1H319" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-12 ant">
                                        <svg width="482" height="122" viewBox="0 0 482 122" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M66 1L1 121H482" stroke="#F3F2F4"/>
                                        </svg>
                                        <p><?= $fields['params_four'][3]['parameter']; ?></p>
                                    </div>
                                    <img class="img-3" src="<?= $fields['spec_image_four']; ?>" alt="<?php esc_attr_e( 'Product hardware', 'bbtheme' ); ?>">
                                </div>
                                <div class="iec_starlink_product_collapse_item_content">
                                    <div class="iec_starlink_product_collapse_item_content_top">
                                        <svg width="29" height="19" viewBox="0 0 29 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.7916 16.6248L14.6666 9.49982L21.7916 2.37482" stroke="#1B204C" stroke-width="2.27163"/>
                                            <path d="M9.125 16.625L2 9.5L9.125 2.375" stroke="#1B204C" stroke-width="2.27163"/>
                                        </svg>
                                        <?php esc_attr_e('View Other Hardware Options', 'bbtheme'); ?>
                                    </div>
                                    <div class="iec_starlink_product_collapse_item_content_bottom">
                                        <h4><?= $fields['spec_title_four']; ?></h4>
                                        <div class="desc">
                                            <?= $fields['spec_description_four']; ?>
                                        </div>
                                        <a href="<?= $fields['more_url_four']; ?>" class="iec_starlink_product_button"><?php esc_attr_e('VIEW PRODUCT PAGE', 'bbtheme'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="iec_starlink_product_collapse_warpper ant-item-4">
                        <div class="iec_starlink_product_collapse_item_warpper">
                            <svg class="close-popup d-none" width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M3 21.32L21 3.32001" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M3 3.32001L21 21.32" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            <div class="iec_starlink_product_collapse_item">
                                <div class="iec_starlink_product_collapse_item_image">
                                    <div class="ant-13 ant">
                                        <?= $fields['params_third'][0]['parameter']; ?>
                                        <svg width="217" height="92" viewBox="0 0 217 92" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M216 91L164 1H0" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-14 ant">
                                        <?= $fields['params_third'][1]['parameter']; ?>
                                        <svg width="304" height="94" viewBox="0 0 304 94" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 93L47.9384 1H304" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-15 ant">
                                        <?= $fields['params_third'][2]['parameter']; ?>
                                        <svg width="91" height="52" viewBox="0 0 91 52" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 51L33.9384 1H91" stroke="#F3F2F4"/>
                                        </svg>
                                    </div>
                                    <div class="ant-16 ant">
                                        <svg width="417" height="187" viewBox="0 0 417 187" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M104 1L1 186H417" stroke="#F3F2F4"/>
                                        </svg>
                                        <p><?= $fields['params_third'][3]['parameter']; ?></p>
                                    </div>
                                    <img class="img-4" src="<?= $fields['spec_image_three']; ?>" alt="<?php esc_attr_e( 'Product hardware', 'bbtheme' ); ?>">
                                </div>
                                <div class="iec_starlink_product_collapse_item_content">
                                    <div class="iec_starlink_product_collapse_item_content_top">
                                        <svg width="29" height="19" viewBox="0 0 29 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M21.7916 16.6248L14.6666 9.49982L21.7916 2.37482" stroke="#1B204C" stroke-width="2.27163"/>
                                            <path d="M9.125 16.625L2 9.5L9.125 2.375" stroke="#1B204C" stroke-width="2.27163"/>
                                        </svg>
                                        <?php esc_attr_e('View Other Hardware Options', 'bbtheme'); ?>
                                    </div>
                                    <div class="iec_starlink_product_collapse_item_content_bottom">
                                        <h4><?= $fields['spec_title_three']; ?></h4>
                                        <div class="desc">
                                            <?= $fields['spec_description_three']; ?>
                                        </div>
                                        <a href="<?= $fields['more_url_three']; ?>" class="iec_starlink_product_button"><?php esc_attr_e('VIEW PRODUCT PAGE', 'bbtheme'); ?></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if (isset($fields['spec_title_five']) && ! empty($fields['spec_title_five'])): ?>
                        <div class="iec_starlink_product_collapse_warpper ant-item-5">
                            <div class="iec_starlink_product_collapse_item_warpper">
                                <svg class="close-popup d-none" width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 21.32L21 3.32001" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 3.32001L21 21.32" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="iec_starlink_product_collapse_item">
                                    <div class="iec_starlink_product_collapse_item_image">
                                        <div class="ant-17 ant">
                                            <?= $fields['params_five'][0]['parameter']; ?>
                                            <svg width="217" height="92" viewBox="0 0 217 92" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M216 91L164 1H0" stroke="#F3F2F4"/>
                                            </svg>
                                        </div>
                                        <div class="ant-18 ant">
                                            <?= $fields['params_five'][1]['parameter']; ?>
                                            <svg width="330" height="88" viewBox="0 0 330 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 87.5L47.9384 1H330" stroke="#F3F2F4"/>
                                            </svg>
                                        </div>
                                        <div class="ant-19 ant">
                                            <p><?= $fields['params_five'][2]['parameter']; ?></p>
                                            <svg width="312" height="59" viewBox="0 0 312 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 1L73.9384 58H312" stroke="#F3F2F4"/>
                                            </svg>
                                        </div>
                                        <div class="ant-20 ant">
                                            <svg width="356" height="104" viewBox="0 0 356 104" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M58 1L1 103H356" stroke="#F3F2F4"/>
                                            </svg>
                                            <p><?= $fields['params_five'][3]['parameter']; ?></p>
                                        </div>
                                        <img class="img-4" src="<?= $fields['spec_image_five']; ?>" alt="<?php esc_attr_e( 'Product hardware', 'bbtheme' ); ?>">
                                    </div>
                                    <div class="iec_starlink_product_collapse_item_content">
                                        <div class="iec_starlink_product_collapse_item_content_top">
                                            <svg width="29" height="19" viewBox="0 0 29 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21.7916 16.6248L14.6666 9.49982L21.7916 2.37482" stroke="#1B204C" stroke-width="2.27163"/>
                                                <path d="M9.125 16.625L2 9.5L9.125 2.375" stroke="#1B204C" stroke-width="2.27163"/>
                                            </svg>
                                            <?php esc_attr_e('View Other Hardware Options', 'bbtheme'); ?>
                                        </div>
                                        <div class="iec_starlink_product_collapse_item_content_bottom">
                                            <h4><?= $fields['spec_title_five']; ?></h4>
                                            <div class="desc">
                                                <?= $fields['spec_description_five']; ?>
                                            </div>
                                            <a href="<?= $fields['more_url_five']; ?>" class="iec_starlink_product_button"><?php esc_attr_e('VIEW PRODUCT PAGE', 'bbtheme'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ( ! empty( $fields['spec_title_six'] ) ) : ?>
                        <div class="iec_starlink_product_collapse_warpper ant-item-6">
                            <div class="iec_starlink_product_collapse_item_warpper">
                                <svg class="close-popup d-none" width="20px" height="20px" viewBox="-0.5 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M3 21.32L21 3.32001" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M3 3.32001L21 21.32" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                <div class="iec_starlink_product_collapse_item">
                                    <div class="iec_starlink_product_collapse_item_image">
                                        <div class="ant-21 ant">
                                            <?= $fields['params_six'][0]['parameter'] ?? ''; ?>
                                            <svg width="217" height="92" viewBox="0 0 217 92" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M216 91L164 1H0" stroke="#F3F2F4"/>
                                            </svg>
                                        </div>
                                        <div class="ant-22 ant">
                                            <?= $fields['params_six'][1]['parameter'] ?? ''; ?>
                                            <svg width="330" height="88" viewBox="0 0 330 88" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 87.5L47.9384 1H330" stroke="#F3F2F4"/>
                                            </svg>
                                        </div>
                                        <div class="ant-23 ant">
                                            <p><?= $fields['params_six'][2]['parameter'] ?? ''; ?></p>
                                            <svg width="312" height="59" viewBox="0 0 312 59" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 1L73.9384 58H312" stroke="#F3F2F4"/>
                                            </svg>
                                        </div>
                                        <div class="ant-24 ant">
                                            <svg width="356" height="104" viewBox="0 0 356 104" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M58 1L1 103H356" stroke="#F3F2F4"/>
                                            </svg>
                                            <p><?= $fields['params_six'][3]['parameter'] ?? ''; ?></p>
                                        </div>
                                        <img class="img-4" src="<?= $fields['spec_image_five_copy']; ?>" alt="<?php esc_attr_e( 'Product hardware', 'bbtheme' ); ?>">
                                    </div>
                                    <div class="iec_starlink_product_collapse_item_content">
                                        <div class="iec_starlink_product_collapse_item_content_top">
                                            <svg width="29" height="19" viewBox="0 0 29 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M21.7916 16.6248L14.6666 9.49982L21.7916 2.37482" stroke="#1B204C" stroke-width="2.27163"/>
                                                <path d="M9.125 16.625L2 9.5L9.125 2.375" stroke="#1B204C" stroke-width="2.27163"/>
                                            </svg>
                                            <?php esc_attr_e('View Other Hardware Options', 'bbtheme'); ?>
                                        </div>
                                        <div class="iec_starlink_product_collapse_item_content_bottom">
                                            <h4><?= $fields['spec_title_six']; ?></h4>
                                            <div class="desc">
                                                <?= $fields['spec_description_six']; ?>
                                            </div>
                                            <a href="<?= $fields['more_url_six']; ?>" class="iec_starlink_product_button"><?php esc_attr_e('VIEW PRODUCT PAGE', 'bbtheme'); ?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
