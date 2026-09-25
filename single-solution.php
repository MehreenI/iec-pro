<?php
get_header();

global $wp;
$current_page_link = home_url( $wp->request );
?>
<style>
    @media (max-width: 991px) {
        .iec_single_products_links_list.full-width-mb li:last-child {width: 100% !important;}
        .iec_single_products_links_list.full-width-mb li:last-child a {border-right: none !important;}
        .iec_single_products_links_list.full-width-mb li:nth-last-child(2) a {border-bottom: 1px solid rgba(255, 255, 255, 0.40) !important;}
    }
</style>

<?php while ( have_posts() ) : the_post(); ?>
    <?php
    // Field extraction
    $fields = get_fields() ?: [];

    $iec_ps_page      = get_config( 'iec_ps_page' );
    $iec_ps_page_link = $iec_ps_page
        ? ( function_exists( 'iec_wpml_permalink' ) ? iec_wpml_permalink( (int) $iec_ps_page ) : get_permalink( $iec_ps_page ) )
        : '';
    $iec_enquire_page = get_config( 'iec_enquire_page' );

    // Field groups
    $hero      = $fields['hero_section']           ?? [];
    $overview  = $fields['overview']               ?? [];
    $use_cases = $fields['use_cases']              ?? [];
    $specs     = $fields['specifications_section'] ?? [];
    $materials = $fields['product_materials']      ?? [];
    $faqs      = $fields['faqs']                   ?? [];
    $features  = $fields['features']               ?? [];

    // show_industries controls whether Markets is shown or hidden in favour of Industries content
    $show_industries = $fields['show_industries'] ?? false;

    // Filters (ps_filter_application drives pills + markets)
    $filter = $fields['ps_filter_application'] ?? array();
    if ( ! is_array( $filter ) ) {
        $filter = ! empty( $filter ) ? array( $filter ) : array();
    }

    // Normalise to lowercase so ACF-stored 'Maritime' / 'Land' still match
    $filter = array_values(
        array_filter(
            array_map( 'strtolower', $filter ),
            function ( $v ) {
                return in_array( $v, array( 'maritime', 'land' ), true );
            }
        )
    );

    $operator = $fields['ps_filter_operator'] ?? array();
    if ( ! is_array( $operator ) ) {
        $operator = ! empty( $operator ) ? array( $operator ) : array();
    }

    // True only when at least one supported market type is present, and industries view isn't active
    $has_maritime = in_array( 'maritime', $filter, true );
    $has_land     = in_array( 'land', $filter, true );
    $has_markets  = ( $has_maritime || $has_land ) && ! $show_industries;

    // Alias used for hero pills and label
    $applications = $filter;

    // Hero fields
    $bg_desktop      = $hero['background_image']['url']        ?? '';
    $bg_mobile       = $hero['background_image_mobile']['url'] ?? '';
    $heading         = $hero['heading']                        ?? get_the_title();
    $sub_heading     = $hero['sub_heading']                    ?? '';
    $quote_btn_label = $hero['quote_button_label']             ?? 'Request Quote';
    $download_label  = $hero['download_button']                ?? 'Downloads';
    $attachment      = $hero['attachment']                     ?? false;
    $attachment_url  = is_array( $attachment ) ? ( $attachment['url'] ?? '' ) : '';

    // Application pill
    $pill_colors = [
        'maritime' => '#92C0E9',
        'land'     => '#DDC9A3',
    ];
    $primary_app  = strtolower( $applications[0] ?? '' );
    $pill_color   = $pill_colors[ $primary_app ] ?? '#DDC9A3';
    $market_label = ucfirst( $primary_app );

    // Repeater lists
    $overview_images = $overview['images']                ?? [];
    $use_cases_list  = $use_cases['list']                 ?? [];
    $mat_list        = $materials['product_material_list']?? [];
    $faq_list        = $faqs['list']                      ?? [];
    $features_list   = $features['features']              ?? [];

    // Helper: format filesize
    function iec_format_filesize( $bytes ) {
        if ( ! $bytes ) return '';
        $mb = $bytes / 1048576;
        return number_format( $mb, 1, ',', '' ) . ' Mb';
    }

    // Expand icon SVG (reused in overview grid)
    $expand_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
    <rect x="0.5" y="0.5" width="21" height="21" rx="10.5" stroke="#727DA3"/>
    <path d="M16.569 10.1425C16.4554 10.1425 16.3465 10.0973 16.2661 10.0169C16.1858 9.9365 16.1407 9.82745 16.1407 9.71373V6.46377L12.585 10.0224C12.5042 10.1005 12.396 10.1438 12.2837 10.1428C12.1714 10.1418 12.0639 10.0967 11.9845 10.0172C11.9051 9.93772 11.86 9.83018 11.8591 9.71777C11.8581 9.60535 11.9013 9.49704 11.9793 9.41618L15.5349 5.85751H12.2877C12.1741 5.85751 12.0652 5.81234 11.9848 5.73193C11.9045 5.65152 11.8593 5.54247 11.8593 5.42876C11.8593 5.31504 11.9045 5.20599 11.9848 5.12558C12.0652 5.04517 12.1741 5 12.2877 5H16.5716C16.6852 5 16.7942 5.04517 16.8745 5.12558C16.9549 5.20599 17 5.31504 17 5.42876V9.71631C17 9.83002 16.9549 9.93908 16.8745 10.0195C16.7942 10.0999 16.6852 10.1451 16.5716 10.1451L16.569 10.1425ZM5.43096 11.8575C5.54457 11.8575 5.65354 11.9027 5.73387 11.9831C5.81421 12.0635 5.85935 12.1726 5.85935 12.2863V15.5362L9.41496 11.9776C9.49576 11.8995 9.60397 11.8562 9.71629 11.8572C9.82862 11.8582 9.93606 11.9033 10.0155 11.9828C10.0949 12.0623 10.14 12.1698 10.1409 12.2822C10.1419 12.3947 10.0987 12.503 10.0207 12.5838L6.46509 16.1425H9.71227C9.82588 16.1425 9.93484 16.1877 10.0152 16.2681C10.0955 16.3485 10.1407 16.4575 10.1407 16.5712C10.1407 16.685 10.0955 16.794 10.0152 16.8744C9.93484 16.9548 9.82588 17 9.71227 17H5.42839C5.31477 17 5.20581 16.9548 5.12547 16.8744C5.04513 16.794 5 16.685 5 16.5712V12.2837C5 12.17 5.04513 12.0609 5.12547 11.9805C5.20581 11.9001 5.31477 11.8549 5.42839 11.8549L5.43096 11.8575Z" fill="#727DA3"/>
</svg>';

    // Download button icon SVG
    $download_svg = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
    <path d="M6.66667 9.64584C6.55556 9.64584 6.45139 9.62861 6.35417 9.59417C6.25694 9.55973 6.16667 9.50056 6.08333 9.41667L3.08333 6.41667C2.91667 6.25 2.83667 6.05556 2.84333 5.83334C2.85 5.61111 2.93 5.41667 3.08333 5.25C3.25 5.08334 3.44806 4.99667 3.6775 4.99C3.90694 4.98334 4.10472 5.06306 4.27083 5.22917L5.83333 6.79167V0.833336C5.83333 0.597225 5.91333 0.399447 6.07333 0.240003C6.23333 0.0805585 6.43111 0.000558429 6.66667 2.87356e-06C6.90222 -0.000552682 7.10028 0.0794474 7.26083 0.240003C7.42139 0.400559 7.50111 0.598336 7.5 0.833336V6.79167L9.0625 5.22917C9.22917 5.0625 9.42722 4.9825 9.65667 4.98917C9.88611 4.99584 10.0839 5.08278 10.25 5.25C10.4028 5.41667 10.4828 5.61111 10.49 5.83334C10.4972 6.05556 10.4172 6.25 10.25 6.41667L7.25 9.41667C7.16667 9.5 7.07639 9.55917 6.97917 9.59417C6.88194 9.62917 6.77778 9.64639 6.66667 9.64584ZM1.66667 13.3333C1.20833 13.3333 0.816111 13.1703 0.49 12.8442C0.163889 12.5181 0.000555556 12.1256 0 11.6667V10C0 9.76389 0.0800001 9.56611 0.24 9.40667C0.4 9.24723 0.597778 9.16723 0.833333 9.16667C1.06889 9.16611 1.26694 9.24611 1.4275 9.40667C1.58806 9.56723 1.66778 9.765 1.66667 10V11.6667H11.6667V10C11.6667 9.76389 11.7467 9.56611 11.9067 9.40667C12.0667 9.24723 12.2644 9.16723 12.5 9.16667C12.7356 9.16611 12.9336 9.24611 13.0942 9.40667C13.2547 9.56723 13.3344 9.765 13.3333 10V11.6667C13.3333 12.125 13.1703 12.5175 12.8442 12.8442C12.5181 13.1708 12.1256 13.3339 11.6667 13.3333H1.66667Z" fill="white"/>
</svg>';

    // File download circle SVG (product materials)
    $dl_circle_svg = '<svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
    <path d="M20 38.75C30.3553 38.75 38.75 30.3553 38.75 20C38.75 9.64466 30.3553 1.25 20 1.25C9.64466 1.25 1.25 9.64466 1.25 20C1.25 30.3553 9.64466 38.75 20 38.75Z" fill="#727DA3" class="at_circle"/>
    <path d="M20 23.575C19.8667 23.575 19.7417 23.5543 19.625 23.513C19.5083 23.4717 19.4 23.4007 19.3 23.3L15.7 19.7C15.5 19.5 15.404 19.2667 15.412 19C15.42 18.7333 15.516 18.5 15.7 18.3C15.9 18.1 16.1377 17.996 16.413 17.988C16.6883 17.98 16.9257 18.0757 17.125 18.275L19 20.15V13C19 12.7167 19.096 12.4793 19.288 12.288C19.48 12.0967 19.7173 12.0007 20 12C20.2827 11.9993 20.5203 12.0953 20.713 12.288C20.9057 12.4807 21.0013 12.718 21 13V20.15L22.875 18.275C23.075 18.075 23.3127 17.979 23.588 17.987C23.8633 17.995 24.1007 18.0993 24.3 18.3C24.4833 18.5 24.5793 18.7333 24.588 19C24.5967 19.2667 24.5007 19.5 24.3 19.7L20.7 23.3C20.6 23.4 20.4917 23.471 20.375 23.513C20.2583 23.555 20.1333 23.5757 20 23.575ZM14 28C13.45 28 12.9793 27.8043 12.588 27.413C12.1967 27.0217 12.0007 26.5507 12 26V24C12 23.7167 12.096 23.4793 12.288 23.288C12.48 23.0967 12.7173 23.0007 13 23C13.2827 22.9993 13.5203 23.0953 13.713 23.288C13.9057 23.4807 14.0013 23.718 14 24V26H26V24C26 23.7167 26.096 23.4793 26.288 23.288C26.48 23.0967 26.7173 23.0007 27 23C27.2827 22.9993 27.5203 23.0953 27.713 23.288C27.9057 23.4807 28.0013 23.718 28 24V26C28 26.55 27.8043 27.021 27.413 27.413C27.0217 27.805 26.5507 28.0007 26 28H14Z" fill="white"/>
</svg>';
    ?>

    <div id="main">

        <!-- Hero -->
        <section class="iec_defualt_position iec_single_solution_hero"
                 style="--bg_desktop: url(<?= $bg_desktop ?>); --bg_mobile: url(<?= $bg_mobile ?>);">

            <div class="iec_single_solution_tagline">
                <span>Solution</span>
            </div>

            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="iec_single_solution_hero_content">

                            <?php if ( ! empty( $applications ) ) : ?>
                                <ul class="iec_single_solution_slide_pills">
                                    <?php foreach ( $applications as $app ) : ?>
                                        <li style="--bg: <?= $pill_colors[ strtolower( $app ) ] ?? '#DDC9A3' ?>">
                                            <?= ucfirst( $app ) ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <h1 class="iec_single_solution_name"><?= $heading ?></h1>

                            <?php if ( $sub_heading ) : ?>
                                <h2 class="iec_single_solution_sub_head"><?= $sub_heading ?></h2>
                            <?php endif; ?>

                            <ul class="iec_single_solution_slide_buttons">
                                <li>
                                    <a href="#contact" class="gray_btn"><?= $quote_btn_label ?></a>
                                </li>
                                <?php if ( $attachment_url ) : ?>
                                    <li>
                                        <a href="<?= $attachment_url ?>"
                                           download
                                           class="download at_btn iec_outline_button_with_icon"
                                           target="_blank"
                                           rel="noopener noreferrer">
                                            <?= $download_label ?>
                                            <?= $download_svg ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Sticky nav links -->
        <section class="iec_single_products_links_section iec_with_half_bg">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php
                        $nav_count = 2;
                        if ( ! empty( $use_cases_list ) ) { $nav_count++; }
                        if ( $has_markets ) { $nav_count++; }
                        if ( ! empty( $specs['specification_content'] ) ) { $nav_count++; }
                        if ( ! empty( $mat_list ) ) { $nav_count++; }
                        if ( ! empty( $faq_list ) ) { $nav_count++; }
                        if ( ! empty( $features_list ) ) { $nav_count++; }

                        // Odd number of items (3, 5, 7…) — flag the list so the last item can go full width on mobile.
                        $nav_odd_class = ( 1 === $nav_count % 2 ) ? ' full-width-mb' : '';
                        ?>
                        <ul class="iec_single_products_links_list<?= $nav_odd_class ?>">
                            <li><a href="#overview">Overview</a></li>
                            <?php if ( ! empty( $use_cases_list ) ) : ?><li><a href="#use-cases">Use Cases</a></li><?php endif; ?>
                            <?php if ( $has_markets ) : ?><li><a href="#markets">Markets</a></li><?php endif; ?>
                            <?php if ( ! empty( $specs['specification_content'] ) ) : ?><li><a href="#specifications">Specifications</a></li><?php endif; ?>
                            <?php if ( ! empty( $features_list ) ) : ?><li><a href="#features">Features</a></li><?php endif; ?>
                            <?php if ( ! empty( $mat_list ) ) : ?><li><a href="#product-materials">Product Materials</a></li><?php endif; ?>
                            <?php if ( ! empty( $faq_list ) ) : ?><li><a href="#faqs">FAQs</a></li><?php endif; ?>
                            <li><a href="#contact">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>


        <!-- Overview -->
        <section id="overview" class="iec_single_solution_overview">

            <?php if ( ! empty( $overview['contant'] ) ) : ?>
                <div class="iec_single_solution_overview_content_warpper">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="iec_single_product_wyswig">
                                    <?= wp_kses_post( $overview['contant'] ) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ( ! empty( $overview_images ) ) : ?>
                <div class="iec_single_solution_image_modal">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">

                                <!-- Desktop grid -->
                                <div class="iec_single_solution_product_image_grid">
                                    <?php foreach ( $overview_images as $img_item ) :
                                        $img_obj = $img_item['image'] ?? [];
                                        $img_url = $img_obj['url']   ?? '';
                                        $title   = $img_item['title']       ?? '';
                                        $desc    = $img_item['description'] ?? '';
                                        ?>
                                        <a href="#"
                                           class="iec_single_solution_product_image_post"
                                           data-img="<?= $img_url ?>"
                                           aria-label="<?= $title ?>">

                                            <div class="iec_single_solution_image_warpper">
                                                <img src="<?= $img_url ?>"
                                                     class="iec_single_solution_product_image"
                                                     alt="<?= $title ?>">
                                                <div class="iec_modal_image_icon"><?= $expand_svg ?></div>
                                            </div>

                                            <div class="iec_single_product_image_content">
                                                <h3><?= $title ?></h3>
                                                <p><?= $desc ?></p>
                                            </div>
                                        </a>
                                    <?php endforeach; ?>
                                </div>

                                <!-- Mobile swiper -->
                                <div class="iec_single_solution_mobile_swiper_warpper">
                                    <div class="swiper image-modal-swiper">
                                        <div class="swiper-wrapper">
                                            <?php foreach ( $overview_images as $img_item ) :
                                                $img_obj = $img_item['image'] ?? [];
                                                $img_url = $img_obj['url']   ?? '';
                                                $title   = $img_item['title']       ?? '';
                                                $desc    = $img_item['description'] ?? '';
                                                ?>
                                                <div class="swiper-slide">
                                                    <a href="#"
                                                       class="iec_single_solution_product_image_post"
                                                       data-img="<?= $img_url ?>"
                                                       aria-label="<?= $title ?>">
                                                        <div class="iec_single_solution_image_warpper">
                                                            <img src="<?= $img_url ?>"
                                                                 class="iec_single_solution_product_image"
                                                                 alt="<?= $title ?>">
                                                            <div class="iec_modal_image_icon"><?= $expand_svg ?></div>
                                                        </div>
                                                        <div class="iec_single_product_image_content">
                                                            <h3><?= $title ?></h3>
                                                            <p><?= $desc ?></p>
                                                        </div>
                                                    </a>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                    <div class="iec_swiper_arrow_warpper">
                                        <div class="swiper-button-prev image_modal_swiper_prev">
                                            <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M7.88999 1.58002L6.70332 0.400024L0.109985 7.00002L6.70999 13.6L7.88999 12.42L2.46999 7.00002L7.88999 1.58002Z" fill="#727DA3"/>
                                            </svg>
                                        </div>
                                        <div class="swiper-button-next image_modal_swiper_next">
                                            <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                                <path d="M0.110015 12.42L1.29668 13.6L7.89002 6.99998L1.29002 0.399975L0.110015 1.57997L5.53002 6.99998L0.110015 12.42Z" fill="#727DA3"/>
                                            </svg>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        </section>

        <!-- Image modal overlay -->
        <div class="iec_image_modal_overlay" id="iecModalOverlay" role="dialog" aria-modal="true" aria-label="Image preview">
            <div class="iec_image_modal_box">
                <button class="iec_modal_close" id="iecModalClose" aria-label="Close modal">
                    <svg xmlns="http://www.w3.org/2000/svg" width="41" height="41" viewBox="0 0 41 41" fill="none">
                        <rect x="0.916946" y="0.916946" width="38.5117" height="38.5117" rx="19.2559" stroke="#727DA3" stroke-width="1.83389"/>
                        <path d="M13.041 27.3055L27.3066 13.04M27.3066 27.3055L13.041 13.04" stroke="#727DA3" stroke-width="2.5216" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <img id="iecModalImg" src="" alt="">
            </div>
        </div>


        <!-- Use cases -->
        <?php if ( ! empty( $use_cases_list ) ) : ?>
            <section id="use-cases" class="iec_single_solution_use_cases">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">

                            <h2><?= $use_cases['heading'] ?? 'Use Cases' ?></h2>

                            <?php
                            // Shared card renderer avoids copy-paste for desktop + mobile
                            $use_case_card = function( $case ) {
                                $icon  = $case['icon']        ?? false;
                                $title = $case['title']       ?? '';
                                $desc  = $case['description'] ?? '';
                                ?>
                                <div class="iec_single_solution_use_cases_box">
                                    <div class="iec_single_solution_use_cases_box_icon">
                                        <?php if ( ! empty( $icon ) && is_array( $icon ) ) : ?>
                                            <img src="<?= $icon['url'] ?? '' ?>" alt="<?= $title ?>">
                                        <?php else : ?>
                                            <!-- Default check-circle icon -->
                                            <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none">
                                                <path d="M28 42.828L18 32.826L20.826 30L28 37.172L43.17 22L46 24.83L28 42.828Z" fill="#727DA3"/>
                                                <path d="M32 4C26.4621 4 21.0486 5.64217 16.444 8.71885C11.8395 11.7955 8.25064 16.1685 6.13139 21.2849C4.01213 26.4012 3.45764 32.0311 4.53802 37.4625C5.61841 42.894 8.28515 47.8831 12.201 51.799C16.1169 55.7149 21.106 58.3816 26.5375 59.462C31.969 60.5424 37.5988 59.9879 42.7151 57.8686C47.8315 55.7494 52.2045 52.1605 55.2812 47.556C58.3578 42.9514 60 37.5379 60 32C60 24.5739 57.05 17.452 51.799 12.201C46.548 6.94999 39.4261 4 32 4ZM32 56C27.2533 56 22.6131 54.5924 18.6663 51.9553C14.7195 49.3181 11.6434 45.5698 9.8269 41.1844C8.0104 36.799 7.53512 31.9734 8.46117 27.3178C9.38721 22.6623 11.673 18.3859 15.0294 15.0294C18.3859 11.673 22.6623 9.3872 27.3178 8.46115C31.9734 7.53511 36.799 8.01039 41.1844 9.82689C45.5698 11.6434 49.3181 14.7195 51.9553 18.6663C54.5924 22.6131 56 27.2532 56 32C56 38.3652 53.4714 44.4697 48.9706 48.9706C44.4697 53.4714 38.3652 56 32 56Z" fill="#727DA3"/>
                                            </svg>
                                        <?php endif; ?>
                                    </div>
                                    <h3><?= $title ?></h3>
                                    <div><?= wp_kses_post( $desc ) ?></div>
                                </div>
                            <?php }; ?>

                            <!-- Desktop grid -->
                            <div class="iec_single_solution_use_cases_box_grid">
                                <?php foreach ( $use_cases_list as $case ) : $use_case_card( $case ); endforeach; ?>
                            </div>

                            <!-- Mobile swiper -->
                            <div class="iec_single_solution_mobile_swiper_warpper">
                                <div class="swiper use_cases_swiper">
                                    <div class="swiper-wrapper">
                                        <?php foreach ( $use_cases_list as $case ) : ?>
                                            <div class="swiper-slide">
                                                <?php $use_case_card( $case ); ?>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                                <div class="iec_swiper_arrow_warpper">
                                    <div class="swiper-button-prev use_cases_swiper_prev">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M7.88999 1.58002L6.70332 0.400024L0.109985 7.00002L6.70999 13.6L7.88999 12.42L2.46999 7.00002L7.88999 1.58002Z" fill="#727DA3"/>
                                        </svg>
                                    </div>
                                    <div class="swiper-button-next use_cases_swiper_next">
                                        <svg width="8" height="14" viewBox="0 0 8 14" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                            <path d="M0.110015 12.42L1.29668 13.6L7.89002 6.99998L1.29002 0.399975L0.110015 1.57997L5.53002 6.99998L0.110015 12.42Z" fill="#727DA3"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <!--
            Markets: rendered via template-parts/product/markets.php.
            That partial reads get_field('market-maritime','option') and
            get_field('market-land','option') from ACF Options, and only
            outputs a wrapper when the relevant filter key is present in
            $filter (ps_filter_application). Hidden entirely when
            show_industries is checked (Industries content replaces it).
        -->
        <?php if ( $has_markets ) :
            get_template_part(
                'template-parts/product/markets',
                null,
                array( 'filter' => $filter )
            );
        endif; ?>


        <!-- Specifications -->
        <?php if ( ! empty( $specs ) && ! empty( $specs['specification_content'] ) ) : ?>
            <section id="specifications" class="iec_defualt_position iec_specification_section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="iec_single_product_section_title"><?= $specs['heading'] ?? 'Specifications' ?></h2>
                            <div class="at_specifications_wrapper">
                                <?= $specs['specification_content'] ?? '' ?>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

        <!-- Features -->
        <?php if ( ! empty( $features_list ) ) : ?>
            <section class="iec_defualt_position iec_specification_section" id="features">
                <div class="container">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="iec_single_product_section_title">Features</h2>
                            <div class="at_feature_wrapper">
                                <div class="row">
                                    <?php foreach ( $features_list as $feature ) : ?>
                                        <div class="col-md-6">
                                            <div class="iec_single_product_feature_item">
                                                <div class="iec_single_product_feature_icon_wrapper">
                                                    <?= $feature['icon_svg'] ?>
                                                </div>
                                                <div class="feature-content">
                                                    <h3 class="iec_single_product_feature_heading"><?= $feature['title'] ?></h3>
                                                    <p><?= $feature['body'] ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <!-- Product materials -->
        <?php if ( ! empty( $mat_list ) ) : ?>
            <section id="product-materials" class="iec_product_materials_section">
                <div class="container">
                    <div class="row">
                        <div class="col-12">

                            <h2 class="iec_single_product_section_title"><?= $materials['heading'] ?? 'Product Materials' ?></h2>

                            <!-- Desktop table -->
                            <div class="iec_responsive_table">
                                <table class="table iec_table">
                                    <thead>
                                    <tr>
                                        <th>Language</th>
                                        <th>Type</th>
                                        <th>Last Updated</th>
                                        <th>Size</th>
                                        <th class="iec_table_buttons_warpper">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ( $mat_list as $item ) :
                                        $lang        = strtoupper( $item['language'] ?? '' );
                                        $type        = $item['type']  ?? '';
                                        $file        = $item['file']  ?? [];
                                        $file_url    = $file['url']   ?? '';
                                        $file_date   = ! empty( $file['modified'] )
                                            ? date_i18n( 'd M Y', strtotime( $file['modified'] ) )
                                            : '';
                                        $file_size   = iec_format_filesize( $file['filesize'] ?? 0 );
                                        ?>
                                        <tr>
                                            <td><?= $lang ?></td>
                                            <td><?= $type ?></td>
                                            <td><?= $file_date ?></td>
                                            <td><?= $file_size ?></td>
                                            <td class="iec_table_buttons_warpper">
                                                <ul class="iec_table_button">
                                                    <?php if ( $file_url ) : ?>
                                                        <li>
                                                            <a href="<?= $file_url ?>"
                                                               target="_blank"
                                                               rel="noopener noreferrer"
                                                               class="iec_outline_table_button"
                                                               aria-label="Download <?= $type ?>">
                                                                Download Brochure
                                                            </a>
                                                        </li>
                                                    <?php endif; ?>
                                                </ul>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Mobile cards -->
                            <div class="iec_mobile_product_materials">
                                <?php foreach ( $mat_list as $item ) :
                                    $lang        = strtoupper( $item['language'] ?? '' );
                                    $type        = $item['type']  ?? '';
                                    $link        = $item['link']  ?? [];
                                    $file        = $item['file']  ?? [];
                                    $file_url    = $file['url']   ?? '';
                                    $link_url    = function_exists( 'iec_resolve_wpml_url' )
                                        ? iec_resolve_wpml_url( $link )
                                        : ( $link['url'] ?? '' );
                                    $link_title  = $link['title'] ?? 'View';
                                    $link_target = $link['target']?? '_blank';
                                    $file_date   = ! empty( $file['modified'] )
                                        ? date_i18n( 'd M Y', strtotime( $file['modified'] ) )
                                        : '';
                                    $file_size   = iec_format_filesize( $file['filesize'] ?? 0 );
                                    ?>
                                    <div class="iec_product_materials_box_warpper">
                                        <div class="iec_product_materials_box_content">
                                            <ul>
                                                <li><span>Type</span><?= $type ?></li>
                                                <li><span>Language</span><?= $lang ?></li>
                                                <li><span>Last Updated</span><?= $file_date ?></li>
                                                <li><span>Size</span><?= $file_size ?></li>
                                                <li>
                                                    <span>Action</span>
                                                    <ul class="iec_table_button">
                                                        <?php if ( $link_url ) : ?>
                                                            <li>
                                                                <a href="<?= $link_url ?>"
                                                                   class="iec_outline_table_button"
                                                                   target="<?= $link_target ?>"
                                                                   rel="noopener noreferrer">
                                                                    <?= $link_title ?>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                        <?php if ( $file_url ) : ?>
                                                            <li>
                                                                <a href="<?= $file_url ?>" target="_blank" rel="noopener noreferrer">
                                                                    <?= $dl_circle_svg ?>
                                                                </a>
                                                            </li>
                                                        <?php endif; ?>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>


        <!-- FAQs -->
        <?php if ( ! empty( $faq_list ) ) : ?>
            <section id="faqs" class="iec_defualt_position iec_single_solution_acordions_section">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="iec_single_solution_acordions_sec_warpper">

                                <h2 class="iec_single_product_section_title"><?= $faqs['heading'] ?? 'Frequently Asked Questions' ?></h2>

                                <div class="iec_single_solution_acordion_row">
                                    <?php foreach ( $faq_list as $faq ) : ?>
                                        <div class="iec_single_solution_acordion_item">
                                            <div class="iec_single_solution_acordion_header">
                                                <?= $faq['question'] ?? '' ?>
                                                <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M16.6248 6.83301L9.49976 13.958L2.37476 6.83301" stroke="#1B204C" stroke-width="2.27163"/>
                                                </svg>
                                            </div>
                                            <div class="iec_single_solution_acordion_body" style="display:none;">
                                                <?= wp_kses_post( $faq['answer'] ?? '' ) ?>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        <?php endif; ?>

    </div><!-- /#main -->


<?php endwhile; ?>

<?php get_footer(); ?>
