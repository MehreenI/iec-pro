<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function iec_solution_expand_svg(): string {
	return '<svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none" aria-hidden="true"><rect x="0.5" y="0.5" width="21" height="21" rx="10.5" stroke="#727DA3"/><path d="M16.569 10.1425C16.4554 10.1425 16.3465 10.0973 16.2661 10.0169C16.1858 9.9365 16.1407 9.82745 16.1407 9.71373V6.46377L12.585 10.0224C12.5042 10.1005 12.396 10.1438 12.2837 10.1428C12.1714 10.1418 12.0639 10.0967 11.9845 10.0172C11.9051 9.93772 11.86 9.83018 11.8591 9.71777C11.8581 9.60535 11.9013 9.49704 11.9793 9.41618L15.5349 5.85751H12.2877C12.1741 5.85751 12.0652 5.81234 11.9848 5.73193C11.9045 5.65152 11.8593 5.54247 11.8593 5.42876C11.8593 5.31504 11.9045 5.20599 11.9848 5.12558C12.0652 5.04517 12.1741 5 12.2877 5H16.5716C16.6852 5 16.7942 5.04517 16.8745 5.12558C16.9549 5.20599 17 5.31504 17 5.42876V9.71631C17 9.83002 16.9549 9.93908 16.8745 10.0195C16.7942 10.0999 16.6852 10.1451 16.5716 10.1451L16.569 10.1425ZM5.43096 11.8575C5.54457 11.8575 5.65354 11.9027 5.73387 11.9831C5.81421 12.0635 5.85935 12.1726 5.85935 12.2863V15.5362L9.41496 11.9776C9.49576 11.8995 9.60397 11.8562 9.71629 11.8572C9.82862 11.8582 9.93606 11.9033 10.0155 11.9828C10.0949 12.0623 10.14 12.1698 10.1409 12.2822C10.1419 12.3947 10.0987 12.503 10.0207 12.5838L6.46509 16.1425H9.71227C9.82588 16.1425 9.93484 16.1877 10.0152 16.2681C10.0955 16.3485 10.1407 16.4575 10.1407 16.5712C10.1407 16.685 10.0955 16.794 10.0152 16.8744C9.93484 16.9548 9.82588 17 9.71227 17H5.42839C5.31477 17 5.20581 16.9548 5.12547 16.8744C5.04513 16.794 5 16.685 5 16.5712V12.2837C5 12.17 5.04513 12.0609 5.12547 11.9805C5.20581 11.9001 5.31477 11.8549 5.42839 11.8549L5.43096 11.8575Z" fill="#727DA3"/></svg>';
}

function iec_solution_download_svg(): string {
	return '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M6.66667 9.64584C6.55556 9.64584 6.45139 9.62861 6.35417 9.59417C6.25694 9.55973 6.16667 9.50056 6.08333 9.41667L3.08333 6.41667C2.91667 6.25 2.83667 6.05556 2.84333 5.83334C2.85 5.61111 2.93 5.41667 3.08333 5.25C3.25 5.08334 3.44806 4.99667 3.6775 4.99C3.90694 4.98334 4.10472 5.06306 4.27083 5.22917L5.83333 6.79167V0.833336C5.83333 0.597225 5.91333 0.399447 6.07333 0.240003C6.23333 0.0805585 6.43111 0.000558429 6.66667 2.87356e-06C6.90222 -0.000552682 7.10028 0.0794474 7.26083 0.240003C7.42139 0.400559 7.50111 0.598336 7.5 0.833336V6.79167L9.0625 5.22917C9.22917 5.0625 9.42722 4.9825 9.65667 4.98917C9.88611 4.99584 10.0839 5.08278 10.25 5.25C10.4028 5.41667 10.4828 5.61111 10.49 5.83334C10.4972 6.05556 10.4172 6.25 10.25 6.41667L7.25 9.41667C7.16667 9.5 7.07639 9.55917 6.97917 9.59417C6.88194 9.62917 6.77778 9.64639 6.66667 9.64584ZM1.66667 13.3333C1.20833 13.3333 0.816111 13.1703 0.49 12.8442C0.163889 12.5181 0.000555556 12.1256 0 11.6667V10C0 9.76389 0.0800001 9.56611 0.24 9.40667C0.4 9.24723 0.597778 9.16723 0.833333 9.16667C1.06889 9.16611 1.26694 9.24611 1.4275 9.40667C1.58806 9.56723 1.66778 9.765 1.66667 10V11.6667H11.6667V10C11.6667 9.76389 11.7467 9.56611 11.9067 9.40667C12.0667 9.24723 12.2644 9.16723 12.5 9.16667C12.7356 9.16611 12.9336 9.24611 13.0942 9.40667C13.2547 9.56723 13.3344 9.765 13.3333 10V11.6667C13.3333 12.125 13.1703 12.5175 12.8442 12.8442C12.5181 13.1708 12.1256 13.3339 11.6667 13.3333H1.66667Z" fill="white"/></svg>';
}

function iec_solution_check_circle_svg(): string {
	return '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 64 64" fill="none" aria-hidden="true"><path d="M28 42.828L18 32.826L20.826 30L28 37.172L43.17 22L46 24.83L28 42.828Z" fill="#727DA3"/><path d="M32 4C26.4621 4 21.0486 5.64217 16.444 8.71885C11.8395 11.7955 8.25064 16.1685 6.13139 21.2849C4.01213 26.4012 3.45764 32.0311 4.53802 37.4625C5.61841 42.894 8.28515 47.8831 12.201 51.799C16.1169 55.7149 21.106 58.3816 26.5375 59.462C31.969 60.5424 37.5988 59.9879 42.7151 57.8686C47.8315 55.7494 52.2045 52.1605 55.2812 47.556C58.3578 42.9514 60 37.5379 60 32C60 24.5739 57.05 17.452 51.799 12.201C46.548 6.94999 39.4261 4 32 4ZM32 56C27.2533 56 22.6131 54.5924 18.6663 51.9553C14.7195 49.3181 11.6434 45.5698 9.8269 41.1844C8.0104 36.799 7.53512 31.9734 8.46117 27.3178C9.38721 22.6623 11.673 18.3859 15.0294 15.0294C18.3859 11.673 22.6623 9.3872 27.3178 8.46115C31.9734 7.53511 36.799 8.01039 41.1844 9.82689C45.5698 11.6434 49.3181 14.7195 51.9553 18.6663C54.5924 22.6131 56 27.2532 56 32C56 38.3652 53.4714 44.4697 48.9706 48.9706C44.4697 53.4714 38.3652 56 32 56Z" fill="#727DA3"/></svg>';
}

function iec_solution_industry_items( array $fields ): array {
	$raw = $fields['industries'] ?? ( $fields['industries_section'] ?? array() );

	if ( ! is_array( $raw ) || $raw === array() ) {
		return array();
	}

	if ( isset( $raw['list'] ) && is_array( $raw['list'] ) ) {
		$raw = $raw['list'];
	}

	$items = array();

	foreach ( $raw as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$title = $row['title'] ?? ( $row['text'] ?? '' );
		if ( '' === $title ) {
			continue;
		}

		$items[] = $row;
	}

	return $items;
}

function iec_solution_single_context( array $fields ): array {
	$hero      = is_array( $fields['hero_section'] ?? null ) ? $fields['hero_section'] : array();
	$overview  = is_array( $fields['overview'] ?? null ) ? $fields['overview'] : array();
	$use_cases = is_array( $fields['use_cases'] ?? null ) ? $fields['use_cases'] : array();
	$specs     = is_array( $fields['specifications_section'] ?? null ) ? $fields['specifications_section'] : array();
	$materials = is_array( $fields['product_materials'] ?? null ) ? $fields['product_materials'] : array();
	$faqs      = is_array( $fields['faqs'] ?? null ) ? $fields['faqs'] : array();
	$features  = is_array( $fields['features'] ?? null ) ? $fields['features'] : array();

	$filter       = iec_product_normalize_application_filter( $fields['ps_filter_application'] ?? array() );
	$overview_images = is_array( $overview['images'] ?? null ) ? $overview['images'] : array();
	$use_cases_list  = is_array( $use_cases['list'] ?? null ) ? $use_cases['list'] : array();
	$features_list   = is_array( $features['features'] ?? null ) ? $features['features'] : array();
	$faq_list        = is_array( $faqs['list'] ?? null ) ? $faqs['list'] : array();
	$valid_materials = iec_product_valid_materials( $materials );
	$industry_items  = iec_solution_industry_items( $fields );
	$show_industries = ! empty( $fields['show_industries'] ) && $industry_items !== array();

	$attachment     = $hero['attachment'] ?? false;
	$attachment_url = is_array( $attachment ) ? ( $attachment['url'] ?? '' ) : '';

	return array(
		'filter'           => $filter,
		'hero'             => $hero,
		'heading'          => $hero['heading'] ?? get_the_title(),
		'sub_heading'      => $hero['sub_heading'] ?? '',
		'quote_btn_label'  => $hero['quote_button_label'] ?? __( 'Request Quote', 'bbtheme' ),
		'download_label'   => $hero['download_button'] ?? __( 'Downloads', 'bbtheme' ),
		'bg_desktop'       => iec_resolve_media_to_url( $hero['background_image'] ?? '' ),
		'bg_mobile'        => iec_resolve_media_to_url( $hero['background_image_mobile'] ?? '' ),
		'attachment_url'   => $attachment_url,
		'overview'         => $overview,
		'overview_images'  => $overview_images,
		'use_cases'        => $use_cases,
		'use_cases_list'   => $use_cases_list,
		'specs'            => $specs,
		'features_list'    => $features_list,
		'materials'        => $materials,
		'valid_materials'  => $valid_materials,
		'faqs'             => $faqs,
		'faq_list'         => $faq_list,
		'industry_items'   => $industry_items,
		'has_overview'     => ! empty( $overview['contant'] ) || $overview_images !== array(),
		'has_use_cases'    => $use_cases_list !== array(),
		'has_markets'      => ( in_array( 'maritime', $filter, true ) || in_array( 'land', $filter, true ) ) && ! $show_industries,
		'has_industries'   => $show_industries,
		'has_specs'        => ! empty( $specs['specification_content'] ),
		'has_features'     => $features_list !== array(),
		'has_materials'    => $valid_materials !== array(),
		'has_faqs'         => $faq_list !== array(),
	);
}
