<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section = $args['section'] ?? array();

if ( empty( $section ) ) {
	return;
}

$heading = $section['heading'] ?? '';
$content = $section['content'] ?? '';
$map     = $section['map_image'] ?? null;
$map_id  = is_array( $map ) && ! empty( $map['ID'] ) ? (int) $map['ID'] : ( is_numeric( $map ) ? (int) $map : 0 );
$map_url = function_exists( 'iec_resolve_media_to_url' ) ? iec_resolve_media_to_url( $map ) : ( is_array( $map ) ? ( $map['url'] ?? '' ) : '' );

if ( $map_id < 1 && $map_url ) {
	$map_id = (int) attachment_url_to_postid( $map_url );
}
$button  = $section['button'] ?? ( $section['link'] ?? array() );
$button_title  = $button['title'] ?? '';
$button_url    = ! empty( $button['url'] ) && function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( $button ) : ( $button['url'] ?? '' );
$button_target = $button['target'] ?? '';
$lang          = apply_filters( 'wpml_current_language', null );
$page_id       = 247;

if ( $lang && has_filter( 'wpml_object_id' ) ) {

	$translated_page = (int) apply_filters( 'wpml_object_id', $page_id, 'page', true, $lang );

	if ( $translated_page ) {
		$page_id = $translated_page;
	}

}

$regional_url = get_permalink( $page_id );

if ( ! $regional_url ) {
	$office_page  = get_page_by_path( 'office' );
	$regional_url = $office_page instanceof WP_Post ? get_permalink( $office_page ) : home_url( '/office/' );
}

$flag_media = static function ( $flag ) {
	$id  = 0;
	$url = '';

	if ( is_array( $flag ) ) {
		$id  = (int) ( $flag['ID'] ?? 0 );
		$url = (string) ( $flag['url'] ?? '' );

	} elseif ( is_numeric( $flag ) ) {
		$id = (int) $flag;

	} elseif ( is_string( $flag ) ) {
		$url = trim( $flag );
	}

	if ( $id < 1 && $url ) {
		$id = (int) attachment_url_to_postid( $url );
	}

	if ( $id > 0 && '' === $url ) {
		$url = (string) wp_get_attachment_image_url( $id, 'thumbnail' );
	}

	return array(
		'id'  => $id,
		'url' => $url,
	);
};

$rows    = function_exists( 'get_fields' ) ? ( get_fields( $page_id )['ro_offices'] ?? array() ) : array();
$offices = array();

foreach ( $rows as $row ) {
	$post = $row['office'] ?? null;

	if ( ! $post instanceof WP_Post ) {
		continue;
	}

	$id = (int) $post->ID;

	if ( $lang && has_filter( 'wpml_object_id' ) ) {

		$translated_id = (int) apply_filters( 'wpml_object_id', $id, 'office', true, $lang );

		if ( $translated_id ) {
			$id = $translated_id;
		}

	}

	$title = get_the_title( $id );

	if ( ! $title ) {
		continue;
	}

	$flag      = $flag_media( $row['flag_image'] ?? null );
	$detail    = $row['address_detail'][0] ?? array();
	$offices[] = array(
		'key'     => sanitize_title( $title ),
		'label'   => $title,
		'title'   => 'IEC TELECOM ' . strtoupper( $title ),
		'flag'    => $flag['url'],
		'flag_id' => $flag['id'],
		'address' => trim( (string) ( $detail['address'] ?? '' ) ),
		'phone'   => trim( (string) ( $detail['phone_number'] ?? '' ) ),
		'email'   => trim( (string) ( $detail['email'] ?? '' ) ),
		'link'    => get_permalink( $id ) ?: '',
	);
}

if ( empty( $offices ) ) {
	return;
}


$first = $offices[0];
$ring  = '/wp-content/uploads/2026/08/ring-';
$pins  = array(
	1  => array( 'europe' ),
	2  => array( 'norway' ),
	3  => array( 'sweden' ),
	4  => array( 'turkey' ),
	5  => array( 'uae' ),
	6  => array( 'kazakhstan', 'kazakhistan' ),
	7  => array( 'tunisia' ),
	8  => array( 'malaysia' ),
	9  => array( 'indonesia' ),
	10 => array( 'singapore', 'sangapore' ),
);
$index_by_key = array();

foreach ( $offices as $index => $office ) {
	$index_by_key[ $office['key'] ] = $index;
}

$markers = array();
foreach ( $pins as $slot => $keys ) {
	foreach ( $keys as $key ) {

		if ( ! isset( $index_by_key[ $key ] ) ) {
			continue;
		}

		$markers[] = array(
			'slot'  => $slot,
			'index' => $index_by_key[ $key ],
			'label' => $offices[ $index_by_key[ $key ] ]['label'],
		);
		break;
	}
}
?>

<section class="iec_defualt_position iec_section_home_global">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="iec_home_global_warpper">
					<div class="iec_home_global_content">
						<?php if ( $heading ) : ?>

							<h2 class="iec_section_heading" data-aos="fade-up"><?= $heading; ?></h2>

						<?php endif; ?>

						<?php if ( $content ) : ?>

							<div class="wysiwyg-content" data-aos="fade-up" data-aos-delay="80"><?= $content; ?></div>

						<?php endif; ?>
						<div class="iec_home_global_office_list">
							<?php foreach ( $offices as $index => $office ) : ?>
								<button
									class="iec_home_global_office_item<?= 0 === $index ? ' is-active' : ''; ?>"
									type="button"
									data-aos="fade-up"
									data-aos-delay="<?= 100 + ( $index * 60 ); ?>"
									data-office-index="<?= $index; ?>"
									data-office="<?= esc_attr( $office['key'] ); ?>"
									data-title="<?= esc_attr( $office['title'] ); ?>"
									data-office-flag="<?= esc_url( $office['flag'] ); ?>"
									data-address="<?= esc_attr( $office['address'] ); ?>"
									data-phone="<?= esc_attr( $office['phone'] ); ?>"
									data-email="<?= esc_attr( $office['email'] ); ?>"
									data-link="<?= esc_url( $office['link'] ); ?>"
								>
									<img
										class="iec_home_global_office_ring"
										data-active-src="<?= esc_url( $ring . 'active.svg' ); ?>"
										data-inactive-src="<?= esc_url( $ring . 'inactive.svg' ); ?>"
										src="<?= esc_url( $ring . ( 0 === $index ? 'active' : 'inactive' ) . '.svg' ); ?>"
										width="24"
										height="24"
										alt=""
									>
									<?= esc_html( $office['label'] ); ?>
								</button>
							<?php endforeach; ?>
						</div>
						<div class="iec_home_global_btns" data-aos="fade-up" data-aos-delay="200">
							<?php if ( $button_title ) : ?>

								<?php if ( $button_url ) : ?>

									<a class="iec_button iec_blue_gradient iec_home_global_btn" href="<?= esc_url( $button_url ); ?>"<?= $button_target ? ' target="' . esc_attr( $button_target ) . '"' : ''; ?>><?= $button_title; ?></a>

								<?php else : ?>

									<button type="button" class="iec_button iec_blue_gradient iec_home_global_btn" data-iec-popup-open="#iecEnquiryModal" aria-haspopup="dialog"><?= $button_title; ?></button>

								<?php endif; ?>

							<?php endif; ?>

							<?php if ( $regional_url ) : ?>

								<a class="iec_button iec_home_global_btn iec_home_global_btn--secondary" href="<?= esc_url( $regional_url ); ?>"><?= __( 'Regional Offices', 'bbtheme' ); ?></a>

							<?php endif; ?>
						</div>
					</div>
					<div class="iec_home_global_map_wrap" data-aos="fade-left" data-aos-delay="150">
						<?php if ( $map_id ) : ?>

							<?= wp_get_attachment_image( $map_id, 'large', false, array( 'class' => 'iec_home_global_map', 'alt' => $heading ) ); ?>

						<?php endif; ?>
						<?php foreach ( $markers as $i => $marker ) : ?>
							<button
								type="button"
								class="iec_home_global_map_marker iec_home_global_map_marker_<?= (int) $marker['slot']; ?><?= 0 === $i ? ' is-active' : ''; ?>"
								data-office-index="<?= (int) $marker['index']; ?>"
								aria-label="<?= esc_attr( $marker['label'] ); ?>"
							>
								<img
									src="<?= esc_url( $ring . ( 0 === $i ? 'active' : 'inactive' ) . '.svg' ); ?>"
									data-active-src="<?= esc_url( $ring . 'active.svg' ); ?>"
									data-inactive-src="<?= esc_url( $ring . 'inactive.svg' ); ?>"
									width="24"
									height="24"
									alt=""
								>
							</button>
						<?php endforeach; ?>
						<div class="iec_home_global_office_popup" aria-live="polite">
							<div class="iec_home_global_office_head">
								<?php if ( $first['flag_id'] ) : ?>

									<?= wp_get_attachment_image( (int) $first['flag_id'], 'thumbnail', false, array( 'class' => 'iec_home_global_office_flag', 'alt' => $first['title'] ) ); ?>

								<?php endif; ?>
								<?php if ( $first['link'] ) : ?>

									<a href="<?= esc_url( $first['link'] ); ?>"><strong><?= esc_html( $first['title'] ); ?></strong><span>›</span></a>

								<?php else : ?>

									<strong><?= esc_html( $first['title'] ); ?></strong><span>›</span>

								<?php endif; ?>
							</div>
							<p<?= $first['address'] ? '' : ' hidden'; ?>><?= $first['address']; ?></p>
							<div class="iec_home_global_office_popup_meta">
								<?php if ( $first['phone'] ) : ?>

									<a href="tel:<?= esc_attr( preg_replace( '/[^\d+]/', '', $first['phone'] ) ); ?>"><?= esc_html( $first['phone'] ); ?></a>

								<?php endif; ?>

								<?php if ( $first['phone'] && $first['email'] ) : ?>

									<b></b>

								<?php endif; ?>

								<?php if ( $first['email'] ) : ?>

									<a href="mailto:<?= esc_attr( $first['email'] ); ?>"><?= esc_html( $first['email'] ); ?></a>

								<?php endif; ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
