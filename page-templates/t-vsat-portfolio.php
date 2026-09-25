<?php
/**
 * Template Name: VSAT Portfolio
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

get_header();

$hero_bg_desktop = get_field( 'hero_bg_desktop' );
$hero_bg_mobile  = get_field( 'hero_bg_mobile' );
$hero_bg_desktop = function_exists( 'iec_resolve_media_to_url' ) ? iec_resolve_media_to_url( $hero_bg_desktop ) : (string) $hero_bg_desktop;
$hero_bg_mobile  = function_exists( 'iec_resolve_media_to_url' ) ? iec_resolve_media_to_url( $hero_bg_mobile ) : (string) $hero_bg_mobile;
$hero_bg_mobile  = $hero_bg_mobile ? $hero_bg_mobile : $hero_bg_desktop;
$hero_style      = $hero_bg_desktop ? "--desktopImage: url('" . esc_url( $hero_bg_desktop ) . "'); --mobileImage: url('" . esc_url( $hero_bg_mobile ) . "');" : '';

?>
    <style>
        .t-vsat-portfolio .iec_partner_bar .iec_partner_label,
        .t-vsat-portfolio .iec_partner_logo,
        .t-vsat-portfolio .iec_section_eyebrow,
        .t-vsat-portfolio .iec_section_heading .iec_section_description,
        .t-vsat-portfolio .iec_section_heading > p,
        .t-vsat-portfolio .js-vsat-section-title .vsat-title-word,
        .t-vsat-portfolio .iec_advantage_grid .iec_advantage_card_wrapper,
        .t-vsat-portfolio .iec_band_grid_desktop .iec_band_card,
        .t-vsat-portfolio .iec_service_grid .iec_service_card_wrapper,
        .t-vsat-portfolio .recommended_solutions_section .col-md-3,
        .t-vsat-portfolio .recommended_solutions_section .col-md-5,
        .t-vsat-portfolio .recommended_solutions_section .recommeded_image,
        .t-vsat-portfolio .iec_faq_item {
            opacity: 0;
            visibility: hidden;
            will-change: opacity, transform;
        }

        .t-vsat-portfolio .iec_vsat_hero_reveal {
            position: relative;
            overflow: hidden;
            background-image: none !important;
        }

        .t-vsat-portfolio .iec_vsat_hero_bg {
            position: absolute;
            left: 0;
            right: 0;
            top: -15%;
            width: 100%;
            height: 130%;
            z-index: 1;
            background-image: var(--desktopImage);
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            will-change: transform;
            pointer-events: none;
        }

        .t-vsat-portfolio .iec_vsat_hero_reveal::before {
            z-index: 3;
        }

        .t-vsat-portfolio .iec_vsat_hero_reveal:not(.is-content-ready) .iec_vsat_hero_inner {
            visibility: hidden;
            pointer-events: none;
        }

        .t-vsat-portfolio .js-vsat-hero-heading .vsat-char {
            display: inline-block;
            opacity: 0;
            transform: translateY(30px);
            will-change: transform, opacity;
        }

        .t-vsat-portfolio .iec_vsat_hero_curtains {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            z-index: 8;
            pointer-events: none;
        }

        .t-vsat-portfolio .iec_vsat_hero_curtains span {
            flex: 1 1 0;
            background: #1b204c;
            transform: scaleY(1);
        }

        .t-vsat-portfolio .iec_vsat_hero_curtains span:nth-child(odd) {
            transform-origin: top;
        }

        .t-vsat-portfolio .iec_vsat_hero_curtains span:nth-child(even) {
            transform-origin: bottom;
        }

        .t-vsat-portfolio .iec_vsat_hero_reveal.is-revealed .iec_vsat_hero_curtains span {
            animation: iecVsatCurtainSlide 0.85s cubic-bezier(0.76, 0, 0.24, 1) forwards;
        }

        .t-vsat-portfolio .iec_vsat_hero_curtains span:nth-child(1) { animation-delay: 0s; }
        .t-vsat-portfolio .iec_vsat_hero_curtains span:nth-child(2) { animation-delay: 0.08s; }
        .t-vsat-portfolio .iec_vsat_hero_curtains span:nth-child(3) { animation-delay: 0.16s; }

        @keyframes iecVsatCurtainSlide {
            from { transform: scaleY(1); }
            to { transform: scaleY(0); }
        }

        .t-vsat-portfolio .iec_vsat_hero_inner {
            position: relative;
            z-index: 6;
        }

        @media (max-width: 767px) {
            .t-vsat-portfolio .iec_vsat_hero_bg {
                background-image: var(--mobileImage, var(--desktopImage));
                top: 0;
                height: 100%;
                will-change: auto;
                transform: none !important;
            }
        }

        .t-vsat-portfolio .js-vsat-split-reveal {
            overflow: hidden;
        }

        .t-vsat-portfolio .js-vsat-split-reveal .word-wrap {
            display: inline-block;
            overflow: hidden;
            vertical-align: top;
        }

        .t-vsat-portfolio .js-vsat-split-reveal .word {
            display: inline-block;
            transform: translateY(110%);
            opacity: 0;
            will-change: transform, opacity;
        }

        .t-vsat-portfolio .js-vsat-split-reveal.is-revealed .word {
            animation: iecVsatWordRise 0.7s cubic-bezier(0.22, 1, 0.36, 1) forwards;
        }

        @keyframes iecVsatWordRise {
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .t-vsat-portfolio .js-vsat-section-title .vsat-title-word {
            display: inline-block;
            will-change: transform, opacity;
        }

        .t-vsat-portfolio .js-vsat-fade-up {
            opacity: 0;
            transform: translateY(1rem);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }

        .t-vsat-portfolio .js-vsat-fade-up.is-revealed {
            opacity: 1;
            transform: translateY(0);
        }

        .t-vsat-portfolio .iec_vsat_stroke_btn {
            position: relative;
            overflow: visible;
        }

        .t-vsat-portfolio .iec_vsat_btn_stroke {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: visible;
            color: #fff;
        }

        .t-vsat-portfolio .iec_vsat_btn_stroke rect {
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            vector-effect: non-scaling-stroke;
            transition: stroke-dashoffset 0.6s ease;
        }

        .t-vsat-portfolio .iec_vsat_stroke_btn:hover .iec_vsat_btn_stroke rect,
        .t-vsat-portfolio .iec_vsat_stroke_btn:focus-visible .iec_vsat_btn_stroke rect {
            stroke-dashoffset: 0;
        }

        .t-vsat-portfolio .iec_band_link.iec_vsat_stroke_btn .iec_vsat_btn_stroke {
            color: #727da3;
        }

        .t-vsat-portfolio .iec_band_link.iec_vsat_stroke_btn:hover .iec_vsat_btn_stroke,
        .t-vsat-portfolio .iec_band_link.iec_vsat_stroke_btn:focus-visible .iec_vsat_btn_stroke {
            color: #1b204c;
        }

        .t-vsat-portfolio .learn_more_btn.iec_vsat_stroke_btn .iec_vsat_btn_stroke {
            color: #727da3;
        }

        .t-vsat-portfolio .learn_more_btn.iec_vsat_stroke_btn:hover .iec_vsat_btn_stroke,
        .t-vsat-portfolio .learn_more_btn.iec_vsat_stroke_btn:focus-visible .iec_vsat_btn_stroke {
            color: #fff;
        }

        .t-vsat-portfolio .iec_frequency_section {
            position: relative;
            overflow: visible;
        }

        .t-vsat-portfolio .iec_frequency_section .container {
            position: relative;
            z-index: 2;
        }

        .t-vsat-portfolio .iec_band_marquee {
            position: absolute;
            left: 0;
            right: 0;
            top: 62%;
            z-index: 0;
            display: flex;
            flex-direction: column;
            gap: 1.566024rem;
            pointer-events: none;
            overflow: hidden;
            transform: translateY(-50%);
        }

        .t-vsat-portfolio .iec_band_marquee_track {
            display: flex;
            align-items: center;
            width: max-content;
            min-width: 200%;
            gap: 3.132047rem;
            animation: iecVsatBandMarquee 32s linear infinite;
        }

        .t-vsat-portfolio .iec_band_marquee_track.is-reverse {
            animation-direction: reverse;
            animation-duration: 40s;
        }

        .t-vsat-portfolio .iec_band_marquee_track span {
            font-family: 'Myriad Pro', sans-serif;
            font-size: clamp(3rem, 8vw, 6.5rem);
            font-weight: 700;
            line-height: 1;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.06);
            white-space: nowrap;
        }

        .t-vsat-portfolio .iec_band_grid_desktop,
        .t-vsat-portfolio .iec_band_slider_mobile {
            position: relative;
            z-index: 1;
        }

        .t-vsat-portfolio .iec_service_card .bd_model_img_wrapper {
            overflow: hidden;
        }

        .t-vsat-portfolio .recommended_solution_image {
            overflow: hidden;
        }

        @keyframes iecVsatBandMarquee {
            from {
                transform: translateX(0);
            }
            to {
                transform: translateX(-50%);
            }
        }

        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_vsat_hero_curtains {
            display: none;
        }

        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_partner_bar .iec_partner_label,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_partner_logo,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_section_eyebrow,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_section_heading .iec_section_description,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_section_heading > p,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .js-vsat-section-title .vsat-title-word,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_advantage_grid .iec_advantage_card_wrapper,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_band_grid_desktop .iec_band_card,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_service_grid .iec_service_card_wrapper,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .recommended_solutions_section .col-md-3,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .recommended_solutions_section .col-md-5,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .recommended_solutions_section .recommeded_image,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_faq_item {
            opacity: 1 !important;
            visibility: visible !important;
            transform: none !important;
        }

        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_vsat_hero_reveal .iec_vsat_hero_inner,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .js-vsat-split-reveal .word,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .js-vsat-fade-up,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .iec_vsat_hero_button_list li,
        .t-vsat-portfolio.iec-vsat-gsap-fallback .js-vsat-hero-heading .vsat-char {
            opacity: 1 !important;
            transform: none !important;
        }

        @media (prefers-reduced-motion: reduce) {
            .t-vsat-portfolio .iec_vsat_btn_stroke rect {
                stroke-dashoffset: 0 !important;
                transition: none;
            }

            .t-vsat-portfolio .iec_band_marquee_track {
                animation: none !important;
            }

            .t-vsat-portfolio .iec_vsat_hero_curtains {
                display: none;
            }

            .t-vsat-portfolio .iec_vsat_hero_reveal .iec_vsat_hero_inner,
            .t-vsat-portfolio .js-vsat-split-reveal .word,
            .t-vsat-portfolio .js-vsat-fade-up,
            .t-vsat-portfolio .iec_vsat_hero_button_list li,
            .t-vsat-portfolio .js-vsat-hero-heading .vsat-char {
                opacity: 1 !important;
                transform: none !important;
                animation: none !important;
            }

            .t-vsat-portfolio .iec_partner_bar .iec_partner_label,
            .t-vsat-portfolio .iec_partner_logo,
            .t-vsat-portfolio .iec_section_eyebrow,
            .t-vsat-portfolio .iec_section_heading .iec_section_description,
            .t-vsat-portfolio .iec_section_heading > p,
            .t-vsat-portfolio .js-vsat-section-title .vsat-title-word,
            .t-vsat-portfolio .iec_advantage_grid .iec_advantage_card_wrapper,
            .t-vsat-portfolio .iec_band_grid_desktop .iec_band_card,
            .t-vsat-portfolio .iec_service_grid .iec_service_card_wrapper,
            .t-vsat-portfolio .recommended_solutions_section .col-md-3,
            .t-vsat-portfolio .recommended_solutions_section .col-md-5,
            .t-vsat-portfolio .recommended_solutions_section .recommeded_image,
            .t-vsat-portfolio .iec_faq_item {
                opacity: 1 !important;
                visibility: visible !important;
                transform: none !important;
            }
        }
    </style>

    <div id="main" class="t-vsat-portfolio">

        <section class="iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center iec_vsat_hero iec_vsat_hero_reveal">
            <div class="iec_vsat_hero_bg"<?= $hero_bg_desktop ? ' style="' . esc_attr( $hero_style ) . '"' : ''; ?> aria-hidden="true"></div>

            <div class="iec_vsat_hero_curtains" aria-hidden="true">
                <span></span><span></span><span></span>
            </div>

            <div class="container iec_vsat_hero_inner">
                <div class="row">
                    <div class="col-md-12">
                        <div class="iec_vsat_hero_content">
                            <h1 class="js-vsat-hero-heading"><?= get_field( 'hero_title' ); ?></h1>
                            <h4 class="js-vsat-split-reveal"><?= get_field( 'hero_subtitle' ); ?></h4>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container iec_vsat_hero_inner">
                <div class="iec_vsat_hero_button_wrap">
                    <ul class="iec_vsat_hero_button_list">

                        <?php if ( get_field( 'show_geo' ) ) : ?>
                            <li>
                                <a href="#iec_solution_section">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                                        <g clip-path="url(#clip0_2139_216)">
                                            <path d="M33.422 37.4807C33.4183 37.4807 33.4145 37.4807 33.4107 37.4807H13.8897C13.3894 37.4807 12.9835 37.0748 12.9835 36.5746C12.9835 36.0743 13.3894 35.6684 13.8897 35.6684H21.8741V30.9899C21.2319 31.2811 20.576 31.5306 19.9107 31.736C17.2549 32.5565 14.5818 32.6414 12.1797 31.9811C12.0343 31.941 11.9014 31.8655 11.7927 31.7613L8.76795 28.8597C8.75021 28.8431 8.73209 28.8261 8.71472 28.8087C8.70905 28.8031 8.70339 28.7974 8.69773 28.7917C7.79911 27.8716 7.98186 26.2164 9.24142 23.8717C10.2269 22.0374 11.838 19.8449 13.8066 17.6546L13.0624 14.1134C12.9994 13.814 13.0919 13.5029 13.3086 13.2862C13.5249 13.0698 13.8361 12.9769 14.1358 13.04L17.6767 13.7842C19.8855 11.7989 22.098 10.1765 23.9405 9.19406C26.2743 7.94998 27.9197 7.78045 28.8304 8.69114C28.8508 8.71153 28.8708 8.73268 28.8905 8.75382L31.7853 11.7676C31.8899 11.8763 31.9654 12.0096 32.0054 12.1553C32.6654 14.5574 32.5808 17.2306 31.76 19.8864C30.9777 22.418 29.5576 24.8133 27.6388 26.8446L33.8898 35.668H37.0448C37.5451 35.668 37.951 36.0739 37.951 36.5742C37.951 37.0745 37.5451 37.4803 37.0448 37.4803H33.4334C33.4296 37.4803 33.4258 37.4803 33.422 37.4803V37.4807ZM23.6861 35.6684H31.6686L26.3177 28.1155C25.4897 28.8386 24.6077 29.4819 23.6864 30.0366V35.668L23.6861 35.6684ZM12.8774 30.2907C17.1409 31.3603 22.2566 29.6737 25.9775 25.9539C29.6973 22.2334 31.3843 17.1173 30.3146 12.8538L29.1612 11.6528C28.9244 12.4159 28.5159 13.2907 27.9367 14.275C26.5809 16.5789 24.42 19.2619 21.8518 21.8301C19.284 24.3984 16.601 26.5592 14.2971 27.915C13.3135 28.4938 12.4391 28.902 11.6764 29.1391L12.8774 30.2911V30.2907ZM9.99958 27.5303C10.1087 27.6149 11.0443 27.7262 13.3781 26.353C15.5536 25.0727 18.1079 23.0116 20.5704 20.5487C23.0332 18.0858 25.0944 15.5315 26.3747 13.356C27.7404 11.0355 27.6381 10.0972 27.5539 9.97941L27.5467 9.97186C27.5086 9.95109 26.8886 9.67622 24.7927 10.7938C23.3512 11.5626 21.6494 12.7666 19.8968 14.2512L22.6338 14.8266C23.1235 14.9297 23.4372 15.41 23.3342 15.8997C23.2311 16.3894 22.7508 16.7031 22.2611 16.6001L15.1217 15.0992L15.5812 17.2865C15.7526 17.5085 15.8077 17.7939 15.7432 18.0571L16.6221 22.2391C16.7252 22.7288 16.4114 23.2094 15.9217 23.3121C15.432 23.4152 14.9514 23.1014 14.8487 22.6117L14.2737 19.8751C12.8038 21.61 11.6088 23.2947 10.8385 24.7291C9.68507 26.8763 9.97882 27.4971 9.99505 27.5254L10.0003 27.5303H9.99958ZM9.40038 15.766C9.31014 15.766 9.21802 15.7524 9.1274 15.7237C8.65015 15.5731 8.38548 15.0641 8.53575 14.5869C9.56198 11.3349 11.6397 9.2575 14.8876 8.23655C15.3648 8.08628 15.8738 8.35171 16.0237 8.82933C16.174 9.30658 15.9085 9.81554 15.4309 9.96544C12.7521 10.8078 11.1104 12.4495 10.2639 15.1325C10.1419 15.5191 9.78475 15.7664 9.4 15.7664L9.40038 15.766ZM5.55862 15.1936C5.48311 15.1936 5.40609 15.1842 5.32944 15.1642C4.84502 15.0381 4.55505 14.5431 4.68116 14.0587C5.32415 11.5909 6.4882 9.50103 8.14044 7.8469C9.79607 6.18938 11.8882 5.02307 14.3586 4.38083C14.843 4.25509 15.3376 4.54545 15.4637 5.02987C15.5895 5.51429 15.2991 6.0089 14.8147 6.13501C10.467 7.26507 7.56955 10.1633 6.43496 14.5159C6.32886 14.9237 5.96111 15.1936 5.55862 15.1936ZM1.72631 14.6216C1.65834 14.6216 1.58963 14.6141 1.52053 14.5978C1.03309 14.4846 0.729527 13.9979 0.842797 13.5104C1.22376 11.8688 1.80899 10.3185 2.58225 8.90258C3.34834 7.49916 4.3017 6.22336 5.41553 5.11029C6.5286 3.99759 7.8044 3.04537 9.20782 2.27966C10.6226 1.50791 12.171 0.923433 13.8104 0.542844C14.2978 0.429951 14.7849 0.733138 14.8982 1.22058C15.0114 1.70802 14.7079 2.19508 14.2204 2.30835C8.23068 3.69856 3.99851 7.93072 2.60868 13.9197C2.51165 14.3384 2.13899 14.6212 1.72668 14.6212L1.72631 14.6216Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2139_216">
                                                <rect width="38.5015" height="38.5015" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span><?= 'Why Geo'; ?></span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ( get_field( 'show_freq' ) ) : ?>
                            <li>
                                <a href="#iec_frequency_section">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                                        <path d="M4.26295 25.289C3.60972 25.289 3.08008 24.7594 3.08008 24.1062V13.8938C3.08008 13.2406 3.60972 12.711 4.26295 12.711C4.91618 12.711 5.44582 13.2406 5.44582 13.8938V24.1062C5.44582 24.7594 4.91618 25.289 4.26295 25.289Z" fill="white"/>
                                        <path d="M8.55311 29.6412C7.89988 29.6412 7.37024 29.1116 7.37024 28.4583V9.54167C7.37024 8.88843 7.89988 8.3588 8.55311 8.3588C9.20634 8.3588 9.73598 8.88843 9.73598 9.54167V28.4583C9.73598 29.1116 9.20634 29.6412 8.55311 29.6412Z" fill="white"/>
                                        <path d="M12.8438 37.4807C12.1905 37.4807 11.6609 36.9511 11.6609 36.2979V1.70213C11.6609 1.04889 12.1905 0.519257 12.8438 0.519257C13.497 0.519257 14.0266 1.04889 14.0266 1.70213V36.2979C14.0266 36.9511 13.497 37.4807 12.8438 37.4807Z" fill="white"/>
                                        <path d="M17.1336 30.3174C16.4803 30.3174 15.9507 29.7878 15.9507 29.1345V8.8654C15.9507 8.21216 16.4803 7.68253 17.1336 7.68253C17.7868 7.68253 18.3164 8.21216 18.3164 8.8654V29.1349C18.3164 29.7881 17.7868 30.3178 17.1336 30.3178V30.3174Z" fill="white"/>
                                        <path d="M21.4237 25.1283C20.7705 25.1283 20.2408 24.5987 20.2408 23.9455V14.0545C20.2408 13.4013 20.7705 12.8717 21.4237 12.8717C22.0769 12.8717 22.6066 13.4013 22.6066 14.0545V23.9455C22.6066 24.5987 22.0769 25.1283 21.4237 25.1283Z" fill="white"/>
                                        <path d="M25.7142 30.5617C25.061 30.5617 24.5314 30.032 24.5314 29.3788V8.6212C24.5314 7.96796 25.061 7.43832 25.7142 7.43832C26.3675 7.43832 26.8971 7.96796 26.8971 8.6212V29.3788C26.8971 30.032 26.3675 30.5617 25.7142 30.5617Z" fill="white"/>
                                        <path d="M30.0044 28.3826C29.3512 28.3826 28.8215 27.8529 28.8215 27.1997V10.8002C28.8215 10.147 29.3512 9.61734 30.0044 9.61734C30.6576 9.61734 31.1873 10.147 31.1873 10.8002V27.1997C31.1873 27.8529 30.6576 28.3826 30.0044 28.3826Z" fill="white"/>
                                        <path d="M34.2942 23.742C33.641 23.742 33.1113 23.2124 33.1113 22.5592V15.4404C33.1113 14.7872 33.641 14.2575 34.2942 14.2575C34.9474 14.2575 35.4771 14.7872 35.4771 15.4404V22.5592C35.4771 23.2124 34.9474 23.742 34.2942 23.742Z" fill="white"/>
                                    </svg>
                                    <span><?= 'Frequency Bands'; ?></span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ( get_field( 'show_service' ) ) : ?>
                            <li>
                                <a href="#iec_service_models_section">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="39" height="39" viewBox="0 0 39 39" fill="none">
                                        <path d="M22.9808 12.2611H15.7076C15.1474 12.2611 14.689 11.8027 14.689 11.2425V3.96594C14.689 3.40569 15.1474 2.9473 15.7076 2.9473H22.9808C23.541 2.9473 23.9994 3.40569 23.9994 3.96594V11.2391C23.9994 11.7994 23.541 12.2577 22.9808 12.2577V12.2611ZM16.2509 10.6992H22.4375V4.51262H16.2509V10.6992Z" fill="white"/>
                                        <path d="M22.9808 35.5101H15.7076C15.1474 35.5101 14.689 35.0517 14.689 34.4915V27.2183C14.689 26.6581 15.1474 26.1997 15.7076 26.1997H22.9808C23.541 26.1997 23.9994 26.6581 23.9994 27.2183V34.4915C23.9994 35.0517 23.541 35.5101 22.9808 35.5101ZM16.2509 33.9482H22.4375V27.7616H16.2509V33.9482Z" fill="white"/>
                                        <path d="M34.607 35.5101H27.3338C26.7736 35.5101 26.3152 35.0517 26.3152 34.4915V27.2183C26.3152 26.6581 26.7736 26.1997 27.3338 26.1997H34.607C35.1672 26.1997 35.6256 26.6581 35.6256 27.2183V34.4915C35.6256 35.0517 35.1672 35.5101 34.607 35.5101ZM27.8737 33.9482H34.0603V27.7616H27.8737V33.9482Z" fill="white"/>
                                        <path d="M11.3579 35.5101H4.08139C3.52114 35.5101 3.06274 35.0517 3.06274 34.4915V27.2183C3.06274 26.6581 3.52114 26.1997 4.08139 26.1997H11.3545C11.9148 26.1997 12.3732 26.6581 12.3732 27.2183V34.4915C12.3732 35.0517 11.9148 35.5101 11.3545 35.5101H11.3579ZM4.62467 33.9482H10.8113V27.7616H4.62467V33.9482Z" fill="white"/>
                                        <path d="M19.3442 27.7616C18.913 27.7616 18.5632 27.4118 18.5632 26.9806V11.4802C18.5632 11.0489 18.913 10.6992 19.3442 10.6992C19.7754 10.6992 20.1252 11.0489 20.1252 11.4802V26.9806C20.1252 27.4118 19.7754 27.7616 19.3442 27.7616Z" fill="white"/>
                                        <path d="M30.9703 27.7616C30.5391 27.7616 30.1894 27.4119 30.1894 26.9806V20.0131H8.49894V26.9806C8.49894 27.4119 8.1492 27.7616 7.71798 27.7616C7.28675 27.7616 6.93701 27.4119 6.93701 26.9806V19.7856C6.93701 19.0487 7.53462 18.4511 8.27144 18.4511H30.4135C31.1503 18.4511 31.7479 19.0487 31.7479 19.7856V26.9806C31.7479 27.4119 31.3982 27.7616 30.9669 27.7616H30.9703Z" fill="white"/>
                                    </svg>
                                    <span><?= 'Service Models'; ?></span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ( get_field( 'show_rec' ) ) : ?>
                            <li>
                                <a href="#recommended_solutions">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <g clip-path="url(#clip0_2139_206)">
                                            <path d="M38.4958 9.45855C38.4958 9.45509 38.4958 9.44816 38.4958 9.4447C38.4958 9.43085 38.4958 9.42045 38.4958 9.4066C38.4958 9.39967 38.4958 9.39621 38.4958 9.38929C38.4958 9.37543 38.4958 9.36158 38.4923 9.35119C38.4923 9.34772 38.4923 9.3408 38.4923 9.33733C38.4923 9.32348 38.4854 9.30616 38.4819 9.29231C38.4819 9.29231 38.4819 9.28885 38.4819 9.28538C38.4369 9.09143 38.3192 8.92172 38.1494 8.8109C38.1494 8.8109 38.1494 8.8109 38.146 8.8109C38.1425 8.8109 38.1391 8.80743 38.1321 8.80397C38.1183 8.79358 38.1044 8.78665 38.0871 8.77973C38.0836 8.77973 38.0802 8.77626 38.0733 8.7728C38.0629 8.76587 38.049 8.76241 38.0386 8.75548C38.0352 8.75548 38.0317 8.75548 38.0282 8.75202L19.6687 0.900477C19.4678 0.817355 19.2427 0.817355 19.0488 0.90394L1.24339 8.74855C1.24339 8.74855 1.23993 8.74855 1.23647 8.75202C1.22261 8.75894 1.21222 8.76241 1.19837 8.76933C1.19837 8.76933 1.19144 8.76933 1.18798 8.7728C1.17066 8.78319 1.15334 8.79358 1.13256 8.80397C1.13256 8.80397 1.13256 8.80397 1.1291 8.80397C0.955931 8.91826 0.838175 9.09143 0.79315 9.28538C0.789687 9.3027 0.786224 9.31655 0.78276 9.33387C0.78276 9.33387 0.78276 9.3408 0.78276 9.34426C0.78276 9.35811 0.779297 9.37197 0.779297 9.38929C0.779297 9.39275 0.779297 9.39621 0.779297 9.39967C0.779297 9.41353 0.779297 9.43085 0.779297 9.4447C0.779297 9.4447 0.779297 9.45163 0.779297 9.45509V29.5671C0.779297 29.8753 0.959394 30.1559 1.24339 30.2805L19.3189 38.3537H19.3224C19.3293 38.3572 19.3362 38.3607 19.3397 38.3641C19.3535 38.3711 19.3674 38.3745 19.3813 38.3815C19.3882 38.3815 19.3986 38.3884 19.4055 38.3884C19.4263 38.3953 19.4505 38.4022 19.4713 38.4057C19.4748 38.4057 19.4817 38.4057 19.4852 38.4057C19.5025 38.4092 19.5233 38.4126 19.5406 38.4161C19.5475 38.4161 19.5544 38.4161 19.5613 38.4161C19.5856 38.4161 19.6098 38.4196 19.6341 38.4196C19.6583 38.4196 19.6826 38.4196 19.7068 38.4161C19.7137 38.4161 19.7207 38.4161 19.7276 38.4161C19.7484 38.4161 19.7657 38.4092 19.7865 38.4057C19.7899 38.4057 19.7969 38.4057 19.8003 38.4057C19.8211 38.4022 19.8453 38.3953 19.8661 38.3884C19.8731 38.3884 19.88 38.3849 19.8904 38.3815C19.9042 38.378 19.9215 38.3711 19.9354 38.3641C19.9423 38.3641 19.9492 38.3607 19.9527 38.3572C19.9527 38.3572 19.9527 38.3572 19.9562 38.3572L38.0352 30.284C38.3157 30.1559 38.4958 29.8788 38.4958 29.5706V9.46548C38.4958 9.46548 38.4958 9.46548 38.4958 9.46202V9.45855ZM34.5821 10.0092L19.6341 16.6901L3.48768 9.47241L19.3709 2.47633L35.7632 9.48626L34.5856 10.0127L34.5821 10.0092ZM2.34129 10.6742L18.8548 18.0547V36.4419L2.34129 29.0684V10.6742ZM36.9303 29.0684L20.4168 36.4419V18.0547L36.9303 10.6742V29.0718V29.0684Z" fill="white"/>
                                        </g>
                                        <defs>
                                            <clipPath id="clip0_2139_206">
                                                <rect width="39.2716" height="39.2716" fill="white"/>
                                            </clipPath>
                                        </defs>
                                    </svg>
                                    <span><?= 'Solutions'; ?></span>
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ( get_field( 'show_faq' ) ) : ?>
                            <li>
                                <a href="#faq">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" viewBox="0 0 40 40" fill="none">
                                        <path d="M9.68319 3.48163L33.699 3.48163C35.3944 3.48163 36.7684 4.85564 36.7684 6.5502L36.7684 22.4312C36.7684 24.1261 35.394 25.4998 33.699 25.4998L32.837 25.4998L32.837 30.7821C32.837 31.3887 32.1539 31.7438 31.657 31.3957L23.2459 25.4998L9.6828 25.4998C7.98741 25.4998 6.61344 24.1258 6.61344 22.4312L6.61344 6.5502C6.61344 4.85525 7.9878 3.48163 9.6828 3.48163L9.68319 3.48163ZM8.11288 22.4308C8.11288 23.2976 8.81574 24.0007 9.68319 24.0007L23.3303 24.0007C23.5836 24.0007 23.8311 24.0789 24.0382 24.2241L31.3379 29.3411L31.3379 24.7502C31.3379 24.3364 31.6737 24.0007 32.0877 24.0007L33.6994 24.0007C34.5665 24.0007 35.2697 23.298 35.2697 22.4308L35.2697 6.5502C35.2697 5.68337 34.5669 4.9803 33.6994 4.9803L9.68319 4.9803C8.81613 4.9803 8.11288 5.68298 8.11288 6.5502L8.11288 22.4312L8.11288 22.4308Z" fill="white" stroke="white" stroke-width="0.770031"/>
                                        <path d="M3.88825 8.43068L3.88825 26.4829C3.88825 27.4164 4.63291 28.173 5.55176 28.173L7.0338 28.173C7.44307 28.173 7.77501 28.5102 7.77501 28.926L7.77501 33.5385L15.0255 28.3737C15.2089 28.243 15.4272 28.173 15.6511 28.173L22.703 28.173C23.1111 28.173 23.4422 28.5083 23.4442 28.9229C23.4457 29.3399 23.1138 29.6791 22.703 29.6791L15.7748 29.6791L7.45915 35.6027C6.96795 35.9524 6.29259 35.5957 6.29259 34.9862L6.29259 29.6791L5.55138 29.6791C3.81398 29.6791 2.40583 28.248 2.40583 26.4833L2.40584 8.43107C2.40584 8.02148 2.73279 7.6893 3.13594 7.6893L3.15815 7.6893C3.56129 7.6893 3.88825 8.02148 3.88825 8.43107L3.88825 8.43068Z" fill="white" stroke="white" stroke-width="0.770031"/>
                                    </svg>
                                    <span><?= 'FAQ'; ?></span>
                                </a>
                            </li>
                        <?php endif; ?>

                    </ul>
                </div>
            </div>
        </section>

        <?php if ( get_field( 'show_partners' ) && ( have_rows( 'partners' ) || get_field( 'partners_label' ) ) ) : ?>
            <section class="iec_solution_section" id="iec_solution_section">
                <div class="container">
                    <div class="row">
                        <div class="iec_partner_bar">
                            <span class="iec_partner_label"><?= get_field( 'partners_label' ); ?></span>
                            <div class="iec_partner_logos_wrapper">
                                <div class="iec_partner_logos">
                                    <?php
                                    while ( have_rows( 'partners' ) ) :
                                        the_row();
                                        $logo = get_sub_field( 'logo' );
                                        $link = get_sub_field( 'link' );
                                        if ( ! $logo ) {
                                            continue;
                                        }
                                        $href   = function_exists( 'iec_resolve_wpml_url' )
                                            ? ( iec_resolve_wpml_url( $link ) ?: '#' )
                                            : ( ( $link && ! empty( $link['url'] ) ) ? $link['url'] : '#' );
                                        $target = ( $link && ! empty( $link['target'] ) ) ? ' target="' . $link['target'] . '"' : '';
                                        ?>
                                        <a href="<?= $href; ?>"<?= $target; ?> class="iec_partner_logo">
                                            <img src="<?= $logo['url']; ?>" alt="<?= $logo['alt']; ?>">
                                        </a>
                                    <?php endwhile; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php
        $geo_cards = array();
        if ( have_rows( 'geo_cards' ) ) {
            while ( have_rows( 'geo_cards' ) ) {
                the_row();
                $geo_cards[] = array(
                    'title' => get_sub_field( 'title' ),
                    'icon'  => get_sub_field( 'icon' ),
                    'text'  => get_sub_field( 'text' ),
                );
            }
        }
        ?>
        <?php if ( get_field( 'show_geo' ) && ( get_field( 'geo_title' ) || $geo_cards ) ) : ?>
            <section class="iec_why_geo">
                <div class="container">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="iec_section_heading">
                                <span class="iec_section_eyebrow"><?= get_field( 'geo_eyebrow' ); ?></span>
                                <h2 class="iec_section_title js-vsat-section-title"><?= get_field( 'geo_title' ); ?></h2>
                                <p class="iec_section_description"><?= get_field( 'geo_description' ); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row iec_advantage_grid">
                        <?php foreach ( $geo_cards as $i => $card ) : ?>
                            <div class="col-md-3 iec_advantage_card_wrapper">
                                <article class="iec_advantage_card">
                                    <div class="iec_advantage_header">
                                        <h3 class="iec_advantage_title"><?= $card['title']; ?></h3>
                                        <div class="iec_advantage_icon">
                                            <?php if ( $card['icon'] ) : ?>
                                                <img src="<?= $card['icon']['url']; ?>" alt="<?= $card['icon']['alt']; ?>">
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <p class="iec_advantage_text"><?= $card['text']; ?></p>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div class="row iec_advantage_slider_mobile">
                        <div class="col-md-12">
                            <div class="swiper iec_advantage_slider">
                                <div class="swiper-wrapper">
                                    <?php foreach ( $geo_cards as $card ) : ?>
                                        <div class="swiper-slide">
                                            <article class="iec_advantage_card">
                                                <div class="iec_advantage_header">
                                                    <h3 class="iec_advantage_title"><?= $card['title']; ?></h3>
                                                    <div class="iec_advantage_icon">
                                                        <?php if ( $card['icon'] ) : ?>
                                                            <img src="<?= $card['icon']['url']; ?>" alt="<?= $card['icon']['alt']; ?>">
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                                <p class="iec_advantage_text"><?= $card['text']; ?></p>
                                            </article>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="iec_swiper_arrow_warpper">
                                    <div class="swiper-button-prev iec_advantage_prev"></div>
                                    <div class="swiper-button-next iec_advantage_next"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </section>
        <?php endif; ?>

        <?php
        $freq_bands = array();
        if ( have_rows( 'freq_bands' ) ) {
            while ( have_rows( 'freq_bands' ) ) {
                the_row();
                $features = array();
                if ( have_rows( 'features' ) ) {
                    while ( have_rows( 'features' ) ) {
                        the_row();
                        $features[] = get_sub_field( 'feature' );
                    }
                }
                $freq_bands[] = array(
                    'title'       => get_sub_field( 'title' ),
                    'subtitle'    => get_sub_field( 'subtitle' ),
                    'description' => get_sub_field( 'description' ),
                    'features'    => $features,
                    'link'        => get_sub_field( 'link' ),
                );
            }
        }
        ?>
        <?php if ( get_field( 'show_freq' ) && ( get_field( 'freq_title' ) || $freq_bands ) ) : ?>
            <section class="iec_frequency_section" id="iec_frequency_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="iec_section_heading">
                                <span class="iec_section_eyebrow"><?= get_field( 'freq_eyebrow' ); ?></span>
                                <h2 class="iec_section_title js-vsat-section-title"><?= get_field( 'freq_title' ); ?></h2>
                                <p><?= get_field( 'freq_description' ); ?></p>
                            </div>

                            <div class="iec_band_grid iec_band_grid_desktop">
                                <?php foreach ( $freq_bands as $i => $band ) : ?>
                                    <?php
                                    $link   = $band['link'];
                                    $href   = function_exists( 'iec_resolve_wpml_url' )
                                        ? ( iec_resolve_wpml_url( $link ) ?: '#' )
                                        : ( ( $link && ! empty( $link['url'] ) ) ? $link['url'] : '#' );
                                    $text   = ( $link && ! empty( $link['title'] ) ) ? $link['title'] : 'Discuss Requirements';
                                    $target = ( $link && ! empty( $link['target'] ) ) ? ' target="' . $link['target'] . '"' : '';
                                    ?>
                                    <article class="iec_band_card">
                                        <div class="iec_band_header">
                                            <h3 class="iec_band_title"><?= $band['title']; ?></h3>
                                            <span class="iec_band_subtitle"><?= $band['subtitle']; ?></span>
                                        </div>
                                        <p><?= $band['description']; ?></p>
                                        <?php if ( $band['features'] ) : ?>
                                            <ul class="iec_band_features">
                                                <?php foreach ( $band['features'] as $feature ) : ?>
                                                    <li><?= $feature; ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php endif; ?>
                                        <a href="<?= $href; ?>"<?= $target; ?> class="iec_band_link"><?= $text; ?></a>
                                    </article>
                                <?php endforeach; ?>
                            </div>

                            <div class="iec_band_slider_mobile">
                                <div class="swiper iec_band_slider">
                                    <div class="swiper-wrapper">
                                        <?php foreach ( $freq_bands as $band ) : ?>
                                            <?php
                                            $link   = $band['link'];
                                            $href   = function_exists( 'iec_resolve_wpml_url' )
                                                ? ( iec_resolve_wpml_url( $link ) ?: '#' )
                                                : ( ( $link && ! empty( $link['url'] ) ) ? $link['url'] : '#' );
                                            $text   = ( $link && ! empty( $link['title'] ) ) ? $link['title'] : 'Discuss Requirements';
                                            $target = ( $link && ! empty( $link['target'] ) ) ? ' target="' . $link['target'] . '"' : '';
                                            ?>
                                            <div class="swiper-slide">
                                                <article class="iec_band_card">
                                                    <div class="iec_band_header">
                                                        <h3 class="iec_band_title"><?= $band['title']; ?></h3>
                                                        <span class="iec_band_subtitle"><?= $band['subtitle']; ?></span>
                                                    </div>
                                                    <p><?= $band['description']; ?></p>
                                                    <?php if ( $band['features'] ) : ?>
                                                        <ul class="iec_band_features">
                                                            <?php foreach ( $band['features'] as $feature ) : ?>
                                                                <li><?= $feature; ?></li>
                                                            <?php endforeach; ?>
                                                        </ul>
                                                    <?php endif; ?>
                                                    <a href="<?= $href; ?>"<?= $target; ?> class="iec_band_link"><?= $text; ?></a>
                                                </article>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="iec_swiper_arrow_warpper">
                                        <div class="swiper-button-prev iec_band_prev"></div>
                                        <div class="swiper-button-next iec_band_next"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <?php if ( get_field( 'show_service' ) && ( get_field( 'service_title' ) || have_rows( 'service_cards' ) ) ) : ?>
            <section class="iec_service_models_section" id="iec_service_models_section">
                <div class="container">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="iec_section_heading">
                                <span class="iec_section_eyebrow"><?= get_field( 'service_eyebrow' ); ?></span>
                                <h2 class="iec_section_title js-vsat-section-title"><?= get_field( 'service_title' ); ?></h2>
                                <p class="iec_section_description"><?= get_field( 'service_description' ); ?></p>
                            </div>
                        </div>
                    </div>

                    <div class="row iec_service_grid">
                        <?php
                        $service_i = 0;
                        while ( have_rows( 'service_cards' ) ) :
                            the_row();
                            $image    = get_sub_field( 'image' );
                            $best_for = get_sub_field( 'best_for' );
                            ?>
                            <div class="col-md-6 iec_service_card_wrapper">
                                <article class="iec_service_card">
                                    <div class="bd_model_img_wrapper">
                                        <?php if ( $image ) : ?>
                                            <img src="<?= $image['url']; ?>" alt="<?= $image['alt']; ?>">
                                        <?php endif; ?>
                                    </div>
                                    <div class="iec_service_body">
                                        <div class="iec_service_header">
                                            <h3 class="iec_service_title"><?= get_sub_field( 'title' ); ?></h3>
                                            <p><?= get_sub_field( 'description' ); ?></p>
                                        </div>
                                        <?php if ( $best_for ) : ?>
                                            <div class="iec_service_footer">
                                                <p><strong>Best for:</strong> <?= $best_for; ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </article>
                            </div>
                            <?php
                            $service_i++;
                        endwhile;
                        ?>
                    </div>

                </div>
            </section>
        <?php endif; ?>

        <?php get_template_part( 'template-parts/t-vsat-portfolio/solutions' ); ?>

        <?php if ( get_field( 'show_faq' ) && ( get_field( 'faq_title' ) || have_rows( 'faq_items' ) ) ) : ?>
            <section class="iec_faq_section" id="faq">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="iec_section_heading">
                                <span class="iec_section_eyebrow"><?= get_field( 'faq_eyebrow' ); ?></span>
                                <h2 class="iec_section_title js-vsat-section-title"><?= get_field( 'faq_title' ); ?></h2>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="iec_faq_grid">
                                <?php while ( have_rows( 'faq_items' ) ) : the_row(); ?>
                                    <div class="iec_faq_item">
                                        <div class="iec_faq_header" aria-expanded="false">
                                            <h4 class="iec_faq_title"><?= get_sub_field( 'question' ); ?></h4>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="iec_faq_icon">
                                                <polyline points="6 9 12 15 18 9"></polyline>
                                            </svg>
                                        </div>
                                        <div class="iec_faq_answer">
                                            <div class="iec_faq_answer_inner">
                                                <p><?= get_sub_field( 'answer' ); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </div>

<?php
$success_popup_html = iec_enquiry_success_popup_html( 'iot-enquiry' );
?>
    <div class="iec-modal-overlay iec-popup" id="iecEnquiryModal">
        <div class="iec-modal-content">
            <button class="iec-modal-close" id="iecEnquiryModalClose" aria-label="Close modal">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M18 6L6 18M6 6L18 18" stroke="#333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <?php
            get_template_part(
                'template-parts/modules/popup',
                null,
                array(
                    'form_type'          => 'Department-enquiry',
                    'success_popup_html' => $success_popup_html,
                )
            );
            ?>
        </div>
    </div>
<?php
get_footer();
