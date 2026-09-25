<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

$header_logo       = get_config( 'header_logo' );
$header_logo_white = get_config( 'header_logo_white' );

$has_other_languages = false;
if ( function_exists( 'apply_filters' ) ) {
    $languages = apply_filters(
        'wpml_active_languages',
        null,
        array(
            'skip_missing' => 1,
            'orderby'      => 'code',
        )
    );

    if ( ! empty( $languages ) ) {
        foreach ( $languages as $l ) {
            if ( 0 === (int) $l['missing'] && empty( $l['active'] ) ) {
                $has_other_languages = true;
                break;
            }
        }
    }
}

$is_office        = is_singular( 'office' );
$is_tunisian_page = $is_office ? get_field( 'is_tunisian_page' ) : null;
?>

<header>
    <?php if ( function_exists( 'iec_mega_menu_is_enabled' ) && iec_mega_menu_is_enabled() ) : ?>
        <?php iec_mega_menu_render( 'utility' ); ?>
    <?php endif; ?>

    <div id="header-v2" class="iec_main_header <?php echo is_front_page() ? 'homepage is_static' : ''; ?>">
        <div class="container">
            <div class="main_header_row">

                <div class="logo_search_block">
                    <?php if ( ! empty( $header_logo_white ) || ! empty( $header_logo ) ) : ?>
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo">
                            <?php
                            $logo_white_url = is_array( $header_logo_white ) ? (string) ( $header_logo_white['url'] ?? '' ) : '';
                            $logo_dark_url  = is_array( $header_logo ) ? (string) ( $header_logo['url'] ?? '' ) : '';
                            $logo_white_alt = is_array( $header_logo_white ) ? (string) ( $header_logo_white['alt'] ?? '' ) : '';
                            $logo_dark_alt  = is_array( $header_logo ) ? (string) ( $header_logo['alt'] ?? '' ) : '';
                            ?>
                            <?php if ( $logo_white_url ) : ?>
                                <img class="logo_light" src="<?php echo esc_url( $logo_white_url ); ?>" alt="<?php echo esc_attr( $logo_white_alt ); ?>">
                            <?php endif; ?>
                            <?php if ( $logo_dark_url ) : ?>
                                <img class="logo_dark" src="<?php echo esc_url( $logo_dark_url ); ?>" alt="<?php echo esc_attr( $logo_dark_alt ); ?>">
                            <?php endif; ?>
                        </a>
                    <?php endif; ?>
                </div>

                <div class="iec_main_menu_warpper">
                    <?php if ( function_exists( 'iec_mega_menu_is_enabled' ) && iec_mega_menu_is_enabled() ) : ?>
                        <?php

                        $iec_tree  = IEC_Mega_Menu_Storage::get_tree();
                        $items     = isset( $iec_tree['primary_menu'] ) ? $iec_tree['primary_menu'] : array();
                        $iec_override = get_template_directory() . '/inc/mega-menu/primary-v2.php';
                        if ( file_exists( $iec_override ) ) {
                            include $iec_override;
                        } else {
                            iec_mega_menu_render( 'primary' );
                        }
                        ?>
                    <?php endif; ?>
                </div>
                <div class="iec_mobile_menu_warpper">
                    <div class="iec_header_top_bar_right">
                        <div class="search">
                            <div class="search-form">
                                <form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get" role="search">
                                    <label class="screen-reader-text" for="iec-header-search-mobile">Search</label>
                                    <input id="iec-header-search-mobile" type="text" name="s" placeholder="Search" value="<?php echo esc_attr( get_search_query() ); ?>">
                                </form>
                            </div>
                            <div class="search-icon" role="button" tabindex="0" aria-label="Open search">
                                <svg width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                    <path d="M5.6721 10.7605C8.48226 10.7605 10.7603 8.48238 10.7603 5.67222C10.7603 2.86207 8.48226 0.583984 5.6721 0.583984C2.86194 0.583984 0.583862 2.86207 0.583862 5.67222C0.583862 8.48238 2.86194 10.7605 5.6721 10.7605Z" stroke="#1B204C" stroke-width="1.16837" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M12.2952 13.6184L8.54456 9.8678" stroke="#1B204C" stroke-width="1.16837" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                        <?php if ( $has_other_languages && defined( 'ICL_LANGUAGE_CODE' ) ) : ?>
                            <div class="lang-container">
                                <div class="lang">
                                    <span class="current-lang">
                                        <?php
                                        $mobile_lang_code = 'zh-hans' === ICL_LANGUAGE_CODE ? 'zh' : ICL_LANGUAGE_CODE;
                                        echo strtoupper( $mobile_lang_code );
                                        ?>
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="8" viewBox="0 0 12 8" fill="none">
                                        <path d="M10.711 0.892588L5.80179 6.24809L0.892578 0.892588" stroke="white" stroke-width="1.78517" stroke-linecap="round"></path>
                                    </svg>
                                </div>
                                <?php iec_language_selector_flags(); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <button class="iec_mobile_menu_btn" aria-label="Toggle Menu">
                        <span></span>
                        <span></span>
                        <span></span>
                    </button>
                </div>
            </div>

        </div>
    </div>
</header>

<?php if ( function_exists( 'iec_mega_menu_is_enabled' ) && iec_mega_menu_is_enabled() ) : ?>
    <?php
    $iec_tree = IEC_Mega_Menu_Storage::get_tree();
    $items    = isset( $iec_tree['primary_menu'] ) ? $iec_tree['primary_menu'] : array();
    $cta      = isset( $iec_tree['cta'] ) ? $iec_tree['cta'] : array();
    $iec_override = get_template_directory() . '/inc/mega-menu/mobile.php';
    if ( file_exists( $iec_override ) ) {
        include $iec_override;
    } else {
        iec_mega_menu_render( 'mobile' );
    }
    ?>
<?php else : ?>
    <div class="iec_mobile_navigation">
        <div class="iec_mobile_menu">
            <!-- Solutions -->
            <div class="iec_mobile_dropdown">
                <button class="iec_mobile_toggle">
                    <span>Solutions</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 7L10 13L4.5 7" stroke="#1B204C" stroke-width="1.78517" stroke-linecap="round"/>
                    </svg>
                </button>

                <div class="iec_mobile_submenu">
                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M4.41772 16C4.41772 10.2311 8.63995 5.44889 14.1599 4.56889" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16 27.5822C10.2311 27.5822 5.44885 23.36 4.56885 17.84" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M27.5821 16C27.5821 21.7689 23.3598 26.5511 17.8398 27.4311" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16 7.28889V2.22222" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M7.28883 16H2.22217" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16 24.7111V29.7778" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M24.7109 16H29.7776" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16 4.44444C21.76 4.44444 26.5333 8.65778 27.4133 14.1689" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16.3822 21.84L21.1022 19.1467C21.2622 19.0578 21.36 18.88 21.36 18.6933V13.1822C21.36 12.9956 21.2622 12.8267 21.1022 12.7289L16.3822 10.0356C16.1422 9.90222 15.8489 9.90222 15.6089 10.0356L10.8889 12.7289C10.7289 12.8178 10.6311 12.9956 10.6311 13.1822V18.6933C10.6311 18.88 10.7289 19.0489 10.8889 19.1467L15.6089 21.84C15.8489 21.9733 16.1422 21.9733 16.3822 21.84Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M19.7155 13.8311L16 15.9467L12.2844 13.8311" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16 15.9467V20.2489" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <span>Products & Equipment</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">All Satellite Products
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Maritime Terminals
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Land Terminals
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Starlink Portfolio
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">VSAT Portfolio
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg width="36" height="36" viewBox="0 0 36 36" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="36" height="36" rx="8" fill="#DBDFEE"/>
                                    <path d="M7.30655 31.1644L12.1599 24.3111M14.9954 26.3556V31.1644M21.4221 31.1644H4.68433M11.0932 11.4667L8.95988 13.68C8.07099 16.9244 9.21766 20.9422 12.2221 23.9467C15.2265 26.9511 19.2443 28.0978 22.4888 27.2089L24.711 25.0844M18.471 15.3778C15.1199 12.3111 11.9554 10.5956 11.0843 11.4667C10.1065 12.4444 12.3643 16.2756 16.1243 20.0356C19.8843 23.7956 23.7243 26.0533 24.6932 25.0756C25.5732 24.1956 23.8221 20.9867 20.711 17.6089M20.0888 20.9333L21.3777 14.7911L15.2354 16.08M30.2132 14.64C29.1554 10.08 25.8843 6.81778 21.3332 5.76M24.6665 15.4667C23.991 13.3244 22.6577 11.9822 20.5065 11.3067M27.4488 15.0578C26.5777 11.7067 24.2843 9.40445 20.9243 8.53334" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span>Connectivity Solutions</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Hybrid Connectivity
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Portable Connectivity
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Tracking, PTT & IoT
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Media & Field Connectivity
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Crew Welfare Connectivity
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="#" class="iec_mobile_btn">View All Solutions</a>
                </div>
            </div>

            <!-- Industries -->
            <div class="iec_mobile_dropdown">
                <button class="iec_mobile_toggle">
                    <span>Industries</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 7L10 13L4.5 7" stroke="#1B204C" stroke-width="1.78517" stroke-linecap="round"/>
                    </svg>
                </button>

                <div class="iec_mobile_submenu">
                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M18.1955 18.48L28.8532 21.7689L22.4266 23.76L15.9999 25.7422L9.57325 23.76L3.1377 21.7689L13.8044 18.48" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M22.4266 23.76L28.8621 25.7422L15.9999 29.7156L3.1377 25.7422L9.57325 23.76" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M22.2667 9.53778C22.2667 12.9956 16.0001 21.7689 16.0001 21.7689C16.0001 21.7689 9.7334 12.9956 9.7334 9.53778C9.7334 6.08 12.5334 3.27111 16.0001 3.27111C19.4667 3.27111 22.2667 6.07111 22.2667 9.53778Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M15.9999 12.7467C17.7721 12.7467 19.2088 11.31 19.2088 9.53778C19.2088 7.76556 17.7721 6.32889 15.9999 6.32889C14.2277 6.32889 12.791 7.76556 12.791 9.53778C12.791 11.31 14.2277 12.7467 15.9999 12.7467Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <span>Land Industries</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Government
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Enterprise
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Energy
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Mining
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">NGOs
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg width="24" height="29" viewBox="0 0 24 29" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.1344 27.7533C10.45 26.0378 8.79663 25.4244 7.13441 24.82C5.23219 24.1178 3.32996 23.4156 2.51219 21.22L2.44996 21.2733C2.33441 21.38 2.23663 21.5222 2.20107 21.6556C2.13885 21.9133 1.88107 22.0822 1.61441 22.02C1.4633 21.9844 1.33885 21.8778 1.27663 21.7444C0.87663 20.8556 0.654408 19.8067 0.55663 18.7933C0.441075 17.5222 0.512186 16.2956 0.681075 15.46C0.734408 15.1933 0.992186 15.0244 1.25885 15.0778C1.39219 15.1044 1.49885 15.1756 1.56996 15.2822C2.44996 16.4733 3.63219 17.2556 4.91219 18.1089C5.32996 18.3844 5.75663 18.6689 6.20107 18.98C6.4233 19.1311 6.46774 19.4422 6.31663 19.6556C6.20107 19.8156 6.01441 19.8867 5.83663 19.86C5.64107 19.8422 5.36552 19.8956 5.09885 19.9756L4.99219 20.0111C5.64107 20.5978 6.22774 21.0067 6.75219 21.2111C7.20552 21.3889 7.59663 21.4067 7.92552 21.2644C8.27219 21.1044 8.5833 20.7489 8.84107 20.18C9.28552 19.2111 9.56996 17.6911 9.66774 15.5489V15.1311C9.65885 14.5178 9.64996 13.9133 9.64108 13.3267C9.64108 12.9089 9.64108 12.5 9.64108 12.1089H6.07663C5.80996 12.1089 5.58774 11.8867 5.58774 11.62V10.0644C5.58774 9.79778 5.80996 9.57556 6.07663 9.57556H9.66774V7.53111C9.1433 7.22 8.69885 6.79333 8.37885 6.28667C8.00552 5.7 7.80107 5.00667 7.80107 4.27778C7.80107 3.23778 8.22774 2.29556 8.9033 1.61111C9.58774 0.926667 10.53 0.5 11.57 0.5C12.61 0.5 13.5522 0.926667 14.2366 1.60222C14.9211 2.28667 15.3389 3.22889 15.3389 4.26889C15.3389 4.99778 15.1255 5.68222 14.7611 6.27778C14.4411 6.78444 14.0055 7.21111 13.4722 7.52222V9.56667H17.0633C17.33 9.56667 17.5522 9.78889 17.5522 10.0556V11.6111C17.5522 11.8778 17.33 12.1 17.0633 12.1H13.4989C13.4989 12.4911 13.4989 12.9 13.4989 13.3178C13.4989 13.9133 13.49 14.5356 13.4722 15.1578V15.5578C13.57 17.6911 13.8544 19.2111 14.2989 20.18C14.5655 20.7489 14.8677 21.1044 15.2144 21.2644C15.5433 21.4156 15.9344 21.3889 16.3877 21.2111C16.9122 21.0067 17.5077 20.5978 18.1477 20.0111L18.0411 19.9756C17.7744 19.8867 17.4811 19.8333 17.2855 19.86C17.0189 19.8956 16.7789 19.7 16.7433 19.4333C16.7166 19.2467 16.8055 19.0778 16.9477 18.98C17.3922 18.66 17.8189 18.3844 18.2366 18.1089C19.5255 17.2556 20.7077 16.4644 21.5877 15.2733C21.7477 15.06 22.05 15.0067 22.2722 15.1667C22.3789 15.2378 22.4411 15.3533 22.4589 15.4689C22.6277 16.3044 22.6989 17.5311 22.5833 18.8022C22.4855 19.8244 22.2722 20.8644 21.8633 21.7533C21.7566 22.0022 21.4633 22.1089 21.2144 21.9933C21.0633 21.9311 20.9655 21.7978 20.9389 21.6467C20.9033 21.5133 20.8144 21.38 20.69 21.2733L20.6366 21.22C19.8189 23.4156 17.9166 24.1178 16.0144 24.82C14.3611 25.4333 12.6989 26.0467 12.0144 27.7533C11.9166 28.0022 11.6322 28.1267 11.3833 28.0289C11.25 27.9756 11.1611 27.8778 11.1077 27.7533H11.1344Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <span>Maritime Industries</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Commercial Shipping
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Fishing
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Offshore
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Superyachts
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="#" class="iec_mobile_btn">View All Industries</a>
                </div>
            </div>

            <!-- Services -->
            <div class="iec_mobile_dropdown">
                <button class="iec_mobile_toggle">
                    <span>Services</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 7L10 13L4.5 7" stroke="#1B204C" stroke-width="1.78517" stroke-linecap="round"/>
                    </svg>
                </button>

                <div class="iec_mobile_submenu">
                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M16.249 22.3911C19.7787 22.3911 22.6401 19.5297 22.6401 16C22.6401 12.4703 19.7787 9.60889 16.249 9.60889C12.7193 9.60889 9.85791 12.4703 9.85791 16C9.85791 19.5297 12.7193 22.3911 16.249 22.3911Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M22.3114 14.1333C18.4447 13.04 14.0625 13.04 10.1958 14.1333" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M22.3114 17.8667C18.4447 18.96 14.0625 18.96 10.1958 17.8667" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14.3026 9.92889C13.1648 13.7956 13.1648 18.1956 14.3026 22.0622" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M18.1958 9.92889C19.3336 13.7956 19.3336 18.1956 18.1958 22.0622" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M28.2132 18.2489C29.4553 18.2489 30.4621 17.242 30.4621 16C30.4621 14.758 29.4553 13.7511 28.2132 13.7511C26.9712 13.7511 25.9644 14.758 25.9644 16C25.9644 17.242 26.9712 18.2489 28.2132 18.2489Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M4.28453 18.2489C5.52656 18.2489 6.53342 17.242 6.53342 16C6.53342 14.758 5.52656 13.7511 4.28453 13.7511C3.04251 13.7511 2.03564 14.758 2.03564 16C2.03564 17.242 3.04251 18.2489 4.28453 18.2489Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M22.2313 7.88444C23.4733 7.88444 24.4802 6.87758 24.4802 5.63555C24.4802 4.39353 23.4733 3.38667 22.2313 3.38667C20.9893 3.38667 19.9824 4.39353 19.9824 5.63555C19.9824 6.87758 20.9893 7.88444 22.2313 7.88444Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M10.2665 28.6133C11.5085 28.6133 12.5154 27.6065 12.5154 26.3644C12.5154 25.1224 11.5085 24.1156 10.2665 24.1156C9.02444 24.1156 8.01758 25.1224 8.01758 26.3644C8.01758 27.6065 9.02444 28.6133 10.2665 28.6133Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M11.629 7.43268C12.6173 6.68037 12.8085 5.26936 12.0562 4.2811C11.3039 3.29283 9.8929 3.10156 8.90464 3.85387C7.91638 4.60617 7.7251 6.01719 8.47741 7.00545C9.22972 7.99371 10.6407 8.18499 11.629 7.43268Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M22.2313 28.6133C23.4733 28.6133 24.4802 27.6065 24.4802 26.3644C24.4802 25.1224 23.4733 24.1156 22.2313 24.1156C20.9893 24.1156 19.9824 25.1224 19.9824 26.3644C19.9824 27.6065 20.9893 28.6133 22.2313 28.6133Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M25.9645 16H23.9556" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M6.54199 16H8.55088" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M21.111 7.59111L20.0977 9.33333" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M11.3955 24.4089L12.4 22.6667" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M11.3955 7.59111L12.4 9.33333" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M21.111 24.4089L20.0977 22.6667" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <span>Network Management & Security</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Network Monitoring
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Bandwidth Management
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Cyber Security
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Cloud Connectivity
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M15.9911 28.4444C15.92 28.4444 15.8489 28.4267 15.7867 28.4C15.3778 28.2133 5.8667 23.7244 5.8667 16.6844V7.84C5.8667 7.69778 5.92892 7.56445 6.03559 7.46667C6.14225 7.36889 6.28448 7.33334 6.4267 7.35111C6.43559 7.35111 8.95114 7.71556 11.5645 6.70222C14.16 5.69778 15.6 3.80445 15.6178 3.78667C15.7067 3.66222 15.8578 3.55556 16.0089 3.55556C16.16 3.55556 16.3111 3.66222 16.4 3.78667C16.4178 3.80445 17.8489 5.68 20.4267 6.68445C23.0311 7.69778 25.5467 7.34222 25.5556 7.34222C25.6978 7.32445 25.84 7.36889 25.9556 7.45778C26.0623 7.54667 26.1334 7.68889 26.1334 7.83111V16.6756C26.1334 23.7156 16.6134 28.2044 16.2134 28.3911C16.1511 28.4178 16.0711 28.4356 16 28.4356L15.9911 28.4444ZM6.86225 8.37334V16.6844C6.86225 22.5511 14.6311 26.7111 16 27.4044C17.3778 26.7111 25.1378 22.5511 25.1378 16.6844V8.37334C24.1511 8.43556 22.1778 8.43556 20.0711 7.61778C18.0089 6.81778 16.6311 5.54667 16.0089 4.87111C15.3778 5.54667 13.9911 6.81778 11.9289 7.61778C9.82226 8.43556 7.79559 8.43556 6.86225 8.37334Z" fill="#1B204C"></path>
                                    <path d="M15.9912 24.96C15.9201 24.96 15.849 24.9422 15.7868 24.9156C15.5023 24.7822 8.81787 21.6 8.81787 16.5778V10.3822C8.81787 10.24 8.88009 10.1067 8.98676 10.0089C9.09343 9.91111 9.23565 9.87555 9.37787 9.89333C9.37787 9.89333 11.0756 10.1422 12.8534 9.44889C14.6223 8.76444 15.5734 7.50222 15.5823 7.48444C15.6712 7.36 15.8223 7.28889 15.9734 7.28889C16.1245 7.28889 16.2756 7.36 16.3645 7.48444C16.3645 7.49333 17.3423 8.76444 19.1023 9.44889C20.8801 10.1422 22.5779 9.89333 22.5868 9.89333C22.729 9.87555 22.8712 9.91111 22.9868 10.0089C23.0934 10.1067 23.1645 10.24 23.1645 10.3822V16.5778C23.1645 21.5911 16.4801 24.7822 16.1956 24.9156C16.1334 24.9422 16.0534 24.96 15.9823 24.96H15.9912ZM9.80454 10.9156V16.5778C9.80454 20.5244 14.8979 23.3511 16.0001 23.92C17.1023 23.3511 22.1956 20.5156 22.1956 16.5778V10.9156C21.4579 10.9422 20.1601 10.9067 18.7734 10.3644C17.4223 9.84 16.489 9.03111 16.0001 8.52444C15.5112 9.03111 14.5868 9.84 13.2356 10.3644C11.849 10.9067 10.5068 10.9422 9.82232 10.9156H9.80454Z" fill="#1B204C"></path>
                                    <path d="M15.12 18.8356C14.9956 18.8356 14.88 18.7911 14.7822 18.7022L12.3822 16.48C12.1867 16.2933 12.1689 15.9822 12.3556 15.7867C12.5422 15.5911 12.8534 15.5733 13.0489 15.76L15.0845 17.6444L18.8889 13.5289C19.0756 13.3333 19.3867 13.3156 19.5822 13.5022C19.7778 13.6889 19.7956 14 19.6089 14.1956L15.4756 18.6667C15.3867 18.7644 15.2622 18.8178 15.1378 18.8267C15.1378 18.8267 15.1289 18.8267 15.12 18.8267V18.8356Z" fill="#1B204C"></path>
                                </svg>
                            </div>
                            <span>Digital & User Services</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Installation
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Commissioning
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Maintenance
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Technical Support
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M16.9954 25.6178H14.1687C13.3881 25.6178 12.7554 26.2506 12.7554 27.0311C12.7554 27.8117 13.3881 28.4444 14.1687 28.4444H16.9954C17.7759 28.4444 18.4087 27.8117 18.4087 27.0311C18.4087 26.2506 17.7759 25.6178 16.9954 25.6178Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M24.6398 13.1733V11.4222C24.6398 7.07556 20.5864 3.55556 15.5909 3.55556C10.5953 3.55556 6.54199 7.07556 6.54199 11.4222V13.1733" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M18.4175 26.9245C21.4486 26.0622 23.7686 23.84 24.4441 21.0933" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M27.3775 13.6978L26.0975 12.9244C25.573 12.6044 24.8975 12.6933 24.4619 13.1289C24.213 13.3778 24.0708 13.7244 24.0708 14.0711V20.16C24.0708 20.5156 24.213 20.8533 24.4619 21.1022C24.8975 21.5378 25.573 21.6178 26.0975 21.3067L27.3775 20.5333C27.7775 20.2933 28.0264 19.8578 28.0264 19.3867V14.8356C28.0264 14.3644 27.7775 13.9289 27.3775 13.6889V13.6978Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M4.35543 13.6978L5.63543 12.9244C6.15988 12.6044 6.83543 12.6933 7.27099 13.1289C7.51988 13.3778 7.6621 13.7244 7.6621 14.0711V20.16C7.6621 20.5156 7.51988 20.8533 7.27099 21.1022C6.83543 21.5378 6.15988 21.6178 5.63543 21.3067L4.35543 20.5333C3.95543 20.2933 3.70654 19.8578 3.70654 19.3867V14.8356C3.70654 14.3644 3.95543 13.9289 4.35543 13.6889V13.6978Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M21.2443 16.9778V15.3422L19.831 15.1378C19.7332 14.7644 19.591 14.4089 19.3954 14.08L20.2488 12.9333L19.0932 11.7778L17.9465 12.6311C17.6177 12.4356 17.271 12.2933 16.8888 12.1956L16.6843 10.7822H15.0488L14.8443 12.1956C14.471 12.2933 14.1154 12.4356 13.7865 12.6311L12.6399 11.7778L11.4843 12.9333L12.3377 14.08C12.1421 14.4089 11.9999 14.7556 11.9021 15.1378L10.4888 15.3422V16.9778L11.9021 17.1822C11.9999 17.5556 12.1421 17.9111 12.3377 18.24L11.4843 19.3867L12.6399 20.5422L13.7865 19.6889C14.1154 19.8844 14.4621 20.0267 14.8443 20.1244L15.0488 21.5378H16.6843L16.8888 20.1244C17.2621 20.0267 17.6177 19.8844 17.9465 19.6889L19.0932 20.5422L20.2488 19.3867L19.3954 18.24C19.591 17.9111 19.7332 17.5644 19.831 17.1822L21.2443 16.9778Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M15.8664 17.6978C16.7157 17.6978 17.4042 17.0093 17.4042 16.16C17.4042 15.3107 16.7157 14.6222 15.8664 14.6222C15.0171 14.6222 14.3286 15.3107 14.3286 16.16C14.3286 17.0093 15.0171 17.6978 15.8664 17.6978Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <span>Insights &amp; Thought Leadership</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">OneAssist – Remote Maintenance
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">OneMonitor – Remote Surveillance
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Traksat – PTT, IoT &amp; Tracking
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Global 24/7 Technical Support
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Logistics, Training &amp; Maintenance
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="#" class="iec_mobile_btn">View All Services</a>
                </div>
            </div>

            <!-- Resources -->
            <div class="iec_mobile_dropdown">
                <button class="iec_mobile_toggle">
                    <span>Resources</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 7L10 13L4.5 7" stroke="#1B204C" stroke-width="1.78517" stroke-linecap="round"/>
                    </svg>
                </button>
                <div class="iec_mobile_submenu">
                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M11.8665 23.0578C11.6887 21.5911 11.1109 20.4444 10.062 19.12C8.7287 17.44 7.82203 15.3689 8.04425 13.0044C8.39092 9.28 11.3687 6.24 15.0931 5.83111C19.9198 5.29778 24.0087 9.05778 24.0087 13.7778C24.0087 15.8222 23.1643 17.6178 21.982 19.0933C20.8976 20.4444 20.3198 21.5733 20.142 23.0578" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M18.9689 24.6489C18.24 24.7644 17.1822 24.8889 16 24.8889C14.8178 24.8889 13.76 24.7644 13.0311 24.6489C12.4889 24.56 12 24.9778 12 25.5289V26.3911C12 26.8178 12.3022 27.1911 12.7289 27.2622C12.7644 27.2622 12.8089 27.2711 12.8444 27.28C12.6133 27.4489 12.4533 27.7422 12.4533 28.08V28.5067C12.4533 28.9778 12.7556 29.3778 13.1822 29.4578C13.8667 29.6 14.9333 29.7778 16.0089 29.7778C17.0844 29.7778 18.1511 29.6 18.8356 29.4578C19.2533 29.3689 19.5644 28.9689 19.5644 28.5067V28.08C19.5644 27.7422 19.4044 27.4489 19.1733 27.28C19.2089 27.28 19.2533 27.2711 19.2889 27.2622C19.7067 27.1911 20.0178 26.8178 20.0178 26.3911V25.5289C20.0178 24.9778 19.5289 24.56 18.9867 24.6489H18.9689Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M13.7778 27.4133C13.3689 27.36 13.0133 27.3067 12.7289 27.2533C12.3111 27.1822 12 26.8089 12 26.3822V25.52C12 24.9689 12.4889 24.5511 13.0311 24.64C13.76 24.7556 14.8178 24.88 16 24.88C17.1822 24.88 18.24 24.7556 18.9689 24.64C19.5111 24.5511 20 24.9689 20 25.52V26.3822C20 26.8089 19.6978 27.1822 19.2711 27.2533C18.9867 27.3067 18.6311 27.36 18.2222 27.4133" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16 3.55555V2.22222" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M8.93343 6.26667L7.99121 5.32445" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M5.77767 13.3333H4.44434" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M23.0669 6.26667L24.0091 5.32445" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M26.2222 13.3333H27.5555" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M15.9999 14.6667C13.9643 15.8933 12.6754 14.8711 12.471 14.6933M12.471 14.6933L12.4443 14.6667M12.471 14.6933C13.7421 15.9822 14.1954 16.8178 14.2221 22.96" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16 14.6667C18.0356 15.8933 19.3244 14.8711 19.5289 14.6933M19.5289 14.6933L19.5556 14.6667M19.5289 14.6933C18.2489 15.9911 17.8044 16.8356 17.7778 23.0489" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <span>Insights & Thought Leadership</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Case Studies
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Whitepapers
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Brochures
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Downloads
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6.85303 6.48888V25.1467" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M17.822 12.7111H11.9731V18.56H17.822V12.7111Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M24.4087 7.59111H11.9731V9.78667H24.4087V7.59111Z" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M20.7554 12.7111H24.4087" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M20.7554 15.6356H24.4087" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M20.7554 18.56H24.4087" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.9731 21.4844H24.4087" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M11.9731 24.4089H24.4087" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M6.85317 27.3422H25.1376C26.3465 27.3422 27.3332 26.3556 27.3332 25.1467V4.65778H9.04873V25.0489C9.04873 26.2489 8.12428 27.2978 6.92428 27.3333C5.67984 27.3689 4.6665 26.3733 4.6665 25.1378V7.95555" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                            <span>Latest News</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Company News
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Events
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Press Releases
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M7.06689 16V17.6267H9.50245" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M12.3467 16V17.6267H14.7822" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M17.627 16V17.6267H20.0625" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M22.8979 16V17.6267H25.3335" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M7.06689 22.0889V23.7156H9.50245" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M12.3467 22.0889V23.7156H14.7822" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M17.627 22.0889V23.7156H20.0625" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M22.8979 22.0889V23.7156H25.3335" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16.8087 6.66666H12.7554" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M27.36 6.88C27.8489 7.16444 28.1778 7.68889 28.1778 8.28444V26.1422C28.1778 27.04 27.4489 27.7689 26.5512 27.7689H5.44893C4.55115 27.7689 3.82227 27.04 3.82227 26.1422V8.28444C3.82227 7.38666 4.55115 6.65778 5.44893 6.65778H9.51115" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M24.1153 6.66666H20.062" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M5.44873 12.3467H26.551" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M8.69322 9.10222C10.0354 9.10222 11.1288 8.00889 11.1288 6.66667C11.1288 6.04444 10.8977 5.47555 10.5065 5.04C10.0621 4.54222 9.41322 4.23111 8.69322 4.23111C7.97322 4.23111 7.32433 4.54222 6.87988 5.04" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M15.9999 9.10222C17.3421 9.10222 18.4354 8.00889 18.4354 6.66667C18.4354 6.04444 18.2043 5.47555 17.8132 5.04C17.3687 4.54222 16.7199 4.23111 15.9999 4.23111C15.2799 4.23111 14.631 4.54222 14.1865 5.04" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M23.3065 9.10222C24.6487 9.10222 25.7421 8.00889 25.7421 6.66667C25.7421 6.04444 25.5109 5.47555 25.1198 5.04C24.6754 4.54222 24.0265 4.23111 23.3065 4.23111C22.5865 4.23111 21.9376 4.54222 21.4932 5.04" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <span>News & Updates</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Company News
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Events
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Press Releases
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="#" class="iec_mobile_btn">View All Resources</a>
                </div>
            </div>

            <!-- Company -->
            <div class="iec_mobile_dropdown">
                <button class="iec_mobile_toggle">
                    <span>Company</span>
                    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M15.5 7L10 13L4.5 7" stroke="#1B204C" stroke-width="1.78517" stroke-linecap="round"/>
                    </svg>
                </button>
                <div class="iec_mobile_submenu">
                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M12.5244 10.4267V6.84444H23.3777V14.6756" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M5.94629 28.6578L6.06184 14.8889L13.2174 12.4356V26.8444" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M26.1511 28.6756V17.1467L20.5244 16.5689V28.6756" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M19.582 9.34222V14.8" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M23.3418 18.9689V28.6756" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M9.58203 15.9644V28.6756" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M16.1777 9.34222V28.6756" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M14.0889 6.84445V3.77778H21.8133V5.02222" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                    <path d="M2.98633 28.6578H29.013" stroke="#1B204C" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                            </div>
                            <span>About IEC Telecom</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Who We Are
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Leadership
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Global Offices
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Partners
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                                    <path d="M16 28.2222C9.38667 28.2222 4 22.8356 4 16.2222C4 9.60889 9.38667 4.22222 16 4.22222C22.6133 4.22222 28 9.60889 28 16.2222C28 22.8356 22.6133 28.2222 16 28.2222ZM16 5.07555C9.84889 5.07555 4.85333 10.08 4.85333 16.2222C4.85333 22.3644 9.85778 27.3689 16 27.3689C22.1422 27.3689 27.1467 22.3644 27.1467 16.2222C27.1467 10.08 22.1422 5.07555 16 5.07555Z" fill="#1B204C"></path>
                                    <path d="M16.0002 10.7911C12.7113 10.7911 9.55574 10.2933 6.85352 9.36L7.12907 8.56C9.7424 9.46666 12.8091 9.93778 16.0002 9.93778C19.1913 9.93778 22.258 9.45778 24.8713 8.56L25.1469 9.36C22.4446 10.2933 19.2802 10.7911 16.0002 10.7911Z" fill="#1B204C"></path>
                                    <path d="M24.8713 23.8844C22.258 22.9778 19.1913 22.5067 16.0002 22.5067C12.8091 22.5067 9.7424 22.9867 7.12907 23.8844L6.85352 23.0844C9.55574 22.1511 12.7113 21.6533 16.0002 21.6533C19.2891 21.6533 22.4446 22.1511 25.1469 23.0844L24.8713 23.8844Z" fill="#1B204C"></path>
                                    <path d="M15.9996 28.2222C12.4618 28.2222 9.68848 22.9511 9.68848 16.2222C9.68848 9.49333 12.4618 4.22222 15.9996 4.22222C19.5374 4.22222 22.3107 9.49333 22.3107 16.2222C22.3107 22.9511 19.5374 28.2222 15.9996 28.2222ZM15.9996 5.07555C13.0396 5.07555 10.5329 10.1778 10.5329 16.2222C10.5329 22.2667 13.0307 27.3689 15.9996 27.3689C18.9685 27.3689 21.4663 22.2667 21.4663 16.2222C21.4663 10.1778 18.9685 5.07555 15.9996 5.07555Z" fill="#1B204C"></path>
                                    <path d="M16.4266 4.64889H15.5732V27.7956H16.4266V4.64889Z" fill="#1B204C"></path>
                                    <path d="M27.5734 15.7956H4.42676V16.6489H27.5734V15.7956Z" fill="#1B204C"></path>
                                </svg>
                            </div>
                            <span>Careers</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Open Positions
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Graduate Program
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Life at IEC
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28" fill="none">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M13.9282 9.67C11.5726 9.67 9.67039 11.5811 9.67039 13.9278C9.67039 16.2744 11.5815 18.1856 13.9282 18.1856C16.2748 18.1856 18.1859 16.2744 18.1859 13.9278C18.1859 11.5811 16.2748 9.67 13.9282 9.67ZM13.9282 8.88778C16.7104 8.88778 18.9682 11.1456 18.9682 13.9278C18.9682 16.71 16.7104 18.9678 13.9282 18.9678C11.1459 18.9678 8.88817 16.71 8.88817 13.9278C8.88817 11.1456 11.1459 8.88778 13.9282 8.88778ZM21.1548 6.68334C21.3415 6.85222 21.5904 6.95889 21.8659 6.95889C22.4526 6.95889 22.9237 6.47889 22.9237 5.90111C22.9237 5.32334 22.4437 4.84334 21.8659 4.84334C21.2882 4.84334 20.8082 5.32334 20.8082 5.90111C20.8082 6.20334 20.9415 6.47889 21.1459 6.67445C21.1459 6.67445 21.1459 6.67445 21.1548 6.68334ZM20.9237 7.48334L18.3459 10.0611C18.1948 10.2122 17.9459 10.2122 17.7948 10.0611C17.6437 9.91 17.6437 9.66111 17.7948 9.51L20.3548 6.95C20.1504 6.65667 20.0259 6.29222 20.0259 5.90111C20.0259 4.88778 20.8526 4.06111 21.8659 4.06111C22.8793 4.06111 23.7059 4.88778 23.7059 5.90111C23.7059 6.91445 22.8793 7.74111 21.8659 7.74111C21.5193 7.74111 21.1993 7.64333 20.9237 7.48334ZM6.71039 6.67445C6.91484 6.47889 7.04817 6.20334 7.04817 5.90111C7.04817 5.31445 6.56817 4.84334 5.99039 4.84334C5.41261 4.84334 4.93261 5.32334 4.93261 5.90111C4.93261 6.47889 5.41261 6.95889 5.99039 6.95889C6.26595 6.95889 6.51483 6.85222 6.7015 6.68334C6.7015 6.68334 6.7015 6.68333 6.71039 6.67445ZM6.93261 7.48334C6.65706 7.65222 6.32817 7.74111 5.99039 7.74111C4.97706 7.74111 4.15039 6.91445 4.15039 5.90111C4.15039 4.88778 4.97706 4.06111 5.99039 4.06111C7.00372 4.06111 7.83039 4.88778 7.83039 5.90111C7.83039 6.29222 7.70595 6.64778 7.5015 6.95L10.0615 9.51C10.2126 9.66111 10.2126 9.91 10.0615 10.0611C9.91039 10.2122 9.6615 10.2122 9.51039 10.0611L6.93261 7.48334ZM6.7015 21.1722C6.51483 21.0033 6.26595 20.8967 5.99039 20.8967C5.40372 20.8967 4.93261 21.3767 4.93261 21.9544C4.93261 22.5322 5.41261 23.0122 5.99039 23.0122C6.56817 23.0122 7.04817 22.5322 7.04817 21.9544C7.04817 21.6522 6.91484 21.3767 6.71039 21.1811C6.71039 21.1811 6.71039 21.1811 6.7015 21.1722ZM7.5015 20.9056C7.70595 21.1989 7.83039 21.5633 7.83039 21.9544C7.83039 22.9678 7.00372 23.7944 5.99039 23.7944C4.97706 23.7944 4.15039 22.9678 4.15039 21.9544C4.15039 20.9411 4.97706 20.1144 5.99039 20.1144C6.33706 20.1144 6.65706 20.2122 6.93261 20.3722L9.51039 17.7944C9.6615 17.6433 9.91039 17.6433 10.0615 17.7944C10.2126 17.9456 10.2126 18.1944 10.0615 18.3456L7.5015 20.9056ZM21.1459 21.1811C20.9415 21.3767 20.8082 21.6522 20.8082 21.9544C20.8082 22.5411 21.2882 23.0122 21.8659 23.0122C22.4437 23.0122 22.9237 22.5322 22.9237 21.9544C22.9237 21.3767 22.4437 20.8967 21.8659 20.8967C21.5904 20.8967 21.3415 21.0033 21.1548 21.1722C21.1548 21.1722 21.1548 21.1722 21.1459 21.1811ZM20.3548 20.9056L17.7948 18.3456C17.6437 18.1944 17.6437 17.9456 17.7948 17.7944C17.9459 17.6433 18.1948 17.6433 18.3459 17.7944L20.9237 20.3722C21.1993 20.2033 21.5282 20.1144 21.8659 20.1144C22.8793 20.1144 23.7059 20.9411 23.7059 21.9544C23.7059 22.9678 22.8793 23.7944 21.8659 23.7944C20.8526 23.7944 20.0259 22.9678 20.0259 21.9544C20.0259 21.5633 20.1504 21.2078 20.3548 20.9056ZM13.9282 4.23C14.8348 4.23 15.5726 3.49222 15.5726 2.58556C15.5726 1.67889 14.8348 0.941113 13.9282 0.941113C13.0215 0.941113 12.2837 1.67889 12.2837 2.58556C12.2837 3.49222 13.0215 4.23 13.9282 4.23ZM13.5371 4.97667C12.3815 4.79 11.5015 3.78556 11.5015 2.57667C11.5015 1.23445 12.5859 0.150002 13.9282 0.150002C15.2704 0.150002 16.3548 1.23445 16.3548 2.57667C16.3548 3.78556 15.4748 4.79 14.3193 4.97667V8.07C14.3193 8.28333 14.1415 8.46111 13.9282 8.46111C13.7148 8.46111 13.5371 8.28333 13.5371 8.07V4.97667ZM4.23039 13.9278C4.23039 13.0211 3.49261 12.2833 2.58595 12.2833C1.67928 12.2833 0.941502 13.0211 0.941502 13.9278C0.941502 14.8344 1.67928 15.5722 2.58595 15.5722C3.49261 15.5722 4.23039 14.8344 4.23039 13.9278ZM4.97706 14.3189C4.79039 15.4744 3.78595 16.3544 2.57706 16.3544C1.23484 16.3544 0.150391 15.27 0.150391 13.9278C0.150391 12.5856 1.23484 11.5011 2.57706 11.5011C3.78595 11.5011 4.79039 12.3811 4.97706 13.5367H8.07039C8.28372 13.5367 8.4615 13.7144 8.4615 13.9278C8.4615 14.1411 8.28372 14.3189 8.07039 14.3189H4.97706ZM13.9282 23.6256C13.0215 23.6256 12.2837 24.3633 12.2837 25.27C12.2837 26.1767 13.0215 26.9144 13.9282 26.9144C14.8348 26.9144 15.5726 26.1767 15.5726 25.27C15.5726 24.3633 14.8348 23.6256 13.9282 23.6256ZM14.3193 22.8789C15.4748 23.0656 16.3548 24.07 16.3548 25.2789C16.3548 26.6211 15.2704 27.7056 13.9282 27.7056C12.5859 27.7056 11.5015 26.6211 11.5015 25.2789C11.5015 24.07 12.3815 23.0656 13.5371 22.8789V19.7856C13.5371 19.5722 13.7148 19.3944 13.9282 19.3944C14.1415 19.3944 14.3193 19.5722 14.3193 19.7856V22.8789ZM23.6259 13.9278C23.6259 14.8344 24.3637 15.5722 25.2704 15.5722C26.1771 15.5722 26.9148 14.8344 26.9148 13.9278C26.9148 13.0211 26.1771 12.2833 25.2704 12.2833C24.3637 12.2833 23.6259 13.0211 23.6259 13.9278ZM22.8793 14.3189H19.7859C19.5726 14.3189 19.3948 14.1411 19.3948 13.9278C19.3948 13.7144 19.5726 13.5367 19.7859 13.5367H22.8793C23.0659 12.3811 24.0704 11.5011 25.2793 11.5011C26.6215 11.5011 27.7059 12.5856 27.7059 13.9278C27.7059 15.27 26.6215 16.3544 25.2793 16.3544C24.0704 16.3544 23.0659 15.4744 22.8793 14.3189Z" fill="#1B204C" stroke="#1B204C" stroke-width="0.3"></path>
                                </svg>
                            </div>
                            <span>Our Partners & Network</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Open Positions
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Graduate Program
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Life at IEC
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>

                    <div class="iec_mobile_card">
                        <button class="iec_mobile_card_toggle">
                            <div class="iec_mega_menu_column_title_icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                                    <path d="M21.4696 11.35C21.2496 10.07 20.0896 9.65 19.0496 9.78C17.8396 9.94 16.6296 10.85 16.7596 12.2C16.7996 12.65 17.0096 13.03 17.3596 13.31C17.7496 13.62 18.3196 13.79 18.9096 13.79C19.0496 13.79 19.1896 13.79 19.3396 13.76C20.4096 13.61 21.5396 12.82 21.4796 11.46C21.4796 11.43 21.4796 11.4 21.4696 11.37C21.4696 11.37 21.4696 11.36 21.4696 11.35ZM20.5396 11.51C20.5396 12.27 19.9396 12.67 19.3596 12.79C18.9296 12.88 18.3096 12.85 17.9596 12.57C17.7896 12.43 17.7096 12.25 17.6996 12.02C17.6996 11.28 18.4596 10.77 19.2096 10.7C19.2596 10.7 19.3196 10.7 19.3696 10.7C19.8696 10.7 20.3896 10.91 20.5296 11.52L20.5396 11.51Z" fill="#1B204C"></path>
                                    <path d="M20.3895 21.82C20.3895 21.82 20.3296 21.78 20.2896 21.77C19.8196 21.58 19.4695 21.77 19.1295 21.93C19.1095 21.93 19.0995 21.95 19.0795 21.95C19.0795 21.92 19.0995 21.89 19.1095 21.86C19.1495 21.72 19.1895 21.59 19.2195 21.46L20.4095 16.41C20.4295 16.34 20.4395 16.27 20.4595 16.19C20.6195 15.57 20.8395 14.72 20.0595 14.3C19.3895 13.94 18.5695 14.25 17.9095 14.49C17.8095 14.53 17.7195 14.56 17.6395 14.59L17.3995 14.67C16.6495 14.93 15.8695 15.2 15.1695 15.57C14.8495 15.74 14.6195 16.02 14.5495 16.33C14.4795 16.61 14.5495 16.89 14.7095 17.14C15.0695 17.66 15.5895 17.65 16.0895 17.52C15.9295 18.19 15.7595 18.86 15.5995 19.51C15.4795 19.96 15.3695 20.41 15.2595 20.86C15.1895 21.13 15.1195 21.4 15.0495 21.68C14.9095 22.23 14.7595 22.8 14.6495 23.37C14.5295 24.03 14.7095 24.56 15.1695 24.85C15.5095 25.07 15.8896 25.16 16.2896 25.16C17.1596 25.16 18.1095 24.74 18.7995 24.43L18.8795 24.4C18.9795 24.36 19.0896 24.31 19.1996 24.27C19.7196 24.06 20.3595 23.79 20.6895 23.35C21.0395 22.88 20.9395 22.24 20.4595 21.86C20.4295 21.84 20.3996 21.82 20.3696 21.8L20.3895 21.82ZM19.9095 22.71C19.8795 22.94 19.1996 23.23 18.9496 23.34C18.8896 23.37 18.8395 23.39 18.7995 23.41C18.2395 23.67 17.7795 23.86 17.3395 24C16.9495 24.13 16.4195 24.3 15.9695 24.18C15.8195 24.14 15.7195 24.07 15.6595 23.97C15.5195 23.72 15.6395 23.29 15.7395 22.94C15.7695 22.85 15.7895 22.76 15.8095 22.68C15.9695 22.04 16.1296 21.41 16.2896 20.77C16.6096 19.52 16.9395 18.23 17.2095 16.96C17.2495 16.79 17.1895 16.6 17.0495 16.48C16.9695 16.4 16.8595 16.36 16.7495 16.36C16.6995 16.36 16.6596 16.36 16.6096 16.38C16.5796 16.39 16.5196 16.41 16.4496 16.44C15.7096 16.73 15.5595 16.69 15.5295 16.66C15.5195 16.64 15.5195 16.63 15.5295 16.62C15.5395 16.57 15.6195 16.47 15.7995 16.36C15.8595 16.32 15.9295 16.3 16.0095 16.27C16.0495 16.26 16.0895 16.24 16.1295 16.22C16.7095 15.97 17.3095 15.74 17.9295 15.53C17.9995 15.51 18.0896 15.47 18.1795 15.44C18.5696 15.29 19.2295 15.03 19.5095 15.22C19.6095 15.29 19.6495 15.42 19.6495 15.62C19.6495 15.8 19.5795 16.01 19.5195 16.21C19.4895 16.32 19.4595 16.42 19.4295 16.52L18.3795 20.97C18.3395 21.13 18.2895 21.3 18.2395 21.47C18.1295 21.86 18.0095 22.27 17.9895 22.65C17.9895 22.77 18.0395 22.9 18.1295 22.99C18.2195 23.08 18.3395 23.13 18.4595 23.13H18.4695C18.7095 23.13 18.9595 23 19.2095 22.89C19.4595 22.77 19.7095 22.65 19.8995 22.68C19.9195 22.71 19.9195 22.73 19.9095 22.74V22.71Z" fill="#1B204C"></path>
                                    <path d="M30.0802 17.46V17.44C30.0402 12.36 26.8302 7.8 22.0802 6.09C17.3402 4.39 11.8202 5.93 8.65019 9.84C5.44019 13.81 5.06019 19.39 7.70019 23.72C9.92019 27.35 13.8902 29.51 18.0602 29.51C18.8302 29.51 19.6202 29.44 20.3902 29.28C25.9602 28.18 30.0402 23.21 30.0802 17.46ZM29.1302 17.46C29.1002 22.15 26.1602 26.35 21.8102 27.91C17.4102 29.49 12.4402 28.14 9.44019 24.53C6.47019 20.95 6.09019 15.66 8.52019 11.67C10.5402 8.36 14.2802 6.35 18.1002 6.35C18.8102 6.35 19.5302 6.42 20.2302 6.56C25.3502 7.61 29.0902 12.19 29.1302 17.46Z" fill="#1B204C"></path>
                                    <path d="M31.5405 11.26C31.4705 11.11 31.3605 11.02 31.2105 11.01C31.0305 10.99 30.8605 11.08 30.7605 11.23C30.6505 11.38 30.6405 11.56 30.7105 11.72C32.9005 16.62 32.0705 22.42 28.6005 26.51C28.4805 26.65 28.4505 26.82 28.5105 26.99C28.5705 27.16 28.7205 27.29 28.8905 27.33C28.9205 27.33 28.9405 27.33 28.9705 27.33C29.0905 27.33 29.2005 27.27 29.2905 27.17C33.0205 22.77 33.9105 16.53 31.5505 11.26H31.5405Z" fill="#1B204C"></path>
                                    <path d="M15.05 31.07C10.74 30.11 7.1 27.14 5.3 23.15C3.4 18.93 3.78 13.86 6.3 9.94C7.68 7.79 9.66 6.04 12.03 4.89C12.26 4.78 12.34 4.53 12.23 4.3C12.12 4.08 11.85 3.92 11.57 4.06C7.12 6.21 3.95 10.57 3.28 15.41C2.62 20.21 4.33 25.04 7.86 28.33C9.79 30.13 12.2 31.4 14.81 31.98C14.85 31.98 14.89 31.99 14.92 31.99C15.05 31.99 15.17 31.94 15.26 31.84C15.38 31.71 15.43 31.51 15.38 31.34C15.33 31.19 15.21 31.09 15.05 31.05V31.07Z" fill="#1B204C"></path>
                                </svg>
                            </div>
                            <span>Company Information</span>
                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11.2955 4.65698L6.9999 9.34305L2.70435 4.65698" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                            </svg>
                        </button>
                        <ul class="iec_mobile_links">
                            <li>
                                <a href="#">Open Positions
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Graduate Program
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                            <li>
                                <a href="#">Life at IEC
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M4.65698 2.70454L9.34305 7.0001L4.65698 11.2957" stroke="#727DA3" stroke-width="1.56202" stroke-linecap="round"/>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <a href="#" class="iec_mobile_btn">Learn More</a>
                </div>
            </div>

            <a href="#" class="iec_button btn btn-primary">CONTACT US</a>
        </div>
    </div>
<?php endif; ?>

<?php if ( $is_office && $is_tunisian_page ) : ?>
    <div class="iec_alert_banner">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="iec_alert_banner_text_left">
                        <p>
                            <?php
                            printf(

                                __( 'Welcome to IEC Telecom %s', 'bbtheme' ),
                                 get_the_title()
                            );
                            ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-6 text_end blue-bg">
                    <div class="iec_alert_banner_text_right">
                        <p><?php _e( 'This office provides only IT solutions and does not offer satellite services.', 'bbtheme' ); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

