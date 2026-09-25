<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$slides = get_field( 'offshore_hero_slides' );
$slide  = is_array( $slides ) ? ( $slides[0] ?? array() ) : array();

if ( ! is_array( $slide ) ) {
	$slide = array();
}

$media_id = static function ( $image ) {
	$id  = 0;
	$url = '';

	if ( is_array( $image ) ) {
		$id  = (int) ( $image['ID'] ?? 0 );
		$url = (string) ( $image['url'] ?? '' );

	} elseif ( is_numeric( $image ) ) {
		$id = (int) $image;

	} elseif ( is_string( $image ) ) {
		$url = trim( $image );
	}

	if ( $id < 1 && '' === $url && function_exists( 'iec_resolve_media_to_url' ) ) {
		$url = (string) iec_resolve_media_to_url( $image );
	}

	if ( $id < 1 && $url ) {
		$id = (int) attachment_url_to_postid( $url );
	}

	return $id;
};

$desktop_id = $media_id( $slide['desktop_image'] ?? null );
$mobile_id  = $media_id( $slide['mobile_image'] ?? null );

if ( $mobile_id < 1 ) {
	$mobile_id = $desktop_id;
}

$split_hero = $desktop_id > 0 && $mobile_id > 0 && $mobile_id !== $desktop_id;
$title      = $slide['title'] ?? '';

if ( '' === $title ) {
	$title = get_the_title();
}

$subtitle = $slide['subtitle'] ?? '';
$card     = is_array( $slide['info_card'] ?? null ) ? $slide['info_card'] : array();
$cta_card = is_array( $card['cta'] ?? null ) ? $card['cta'] : array();
$icon_id  = $media_id( $card['icon_image'] ?? null );
$cta          = is_array( $slide['hero_cta_buttons'] ?? null ) ? $slide['hero_cta_buttons'] : array();
$brochure     = is_array( $slide['boucher'] ?? null ) ? $slide['boucher'] : array();
$cta_url      = $cta['url'] ?? '';
$cta_label    = ! empty( $cta['cta_label'] ) ? $cta['cta_label'] : 'Enquire Today';
$brochure_url = $brochure['url'] ?? '';
$has_ctas     = $cta_url || $brochure_url;
?>

<section class="iec_banner_section iec_home_page_banner_section iec-offshore-hero iec-anim-hero-curtain" aria-label="Main Hero Banner">

	<?php if ( $desktop_id > 0 ) : ?>

		<div class="iec-offshore-hero__media" aria-hidden="true">

			<?= wp_get_attachment_image( $desktop_id, 'full', false, array( 'class' => $split_hero ? 'iec-offshore-hero__img iec-offshore-hero__img--desktop' : 'iec-offshore-hero__img', 'alt' => '', 'loading' => 'eager', 'fetchpriority' => 'high', 'decoding' => 'async' ) ); ?>

			<?php if ( $split_hero ) : ?>

				<?= wp_get_attachment_image( $mobile_id, 'full', false, array( 'class' => 'iec-offshore-hero__img iec-offshore-hero__img--mobile', 'alt' => '', 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>

			<?php endif; ?>

		</div>

	<?php endif; ?>

	<div class="iec_single_office_banner_box">
		<div class="container">
			<div class="row">
				<div class="col-md-7">
					<div class="banner_content text_white iec-anim-hero-content">
						<h1 class="text_white iec-anim-split-words" data-iec-anim-on-load="true"><?= $title; ?></h1>

						<?php if ( '' !== $subtitle ) : ?>

							<div class="sub_head text_white iec-anim-split-words" data-iec-anim-on-load="true" data-iec-anim-delay="0.15"><?= $subtitle; ?></div>

						<?php endif; ?>

						<?php if ( $has_ctas ) : ?>

							<div class="hero__buttons d-flex align-items-center iec-anim-stagger-group" data-iec-anim-on-load="true" data-iec-anim-target="a" data-iec-anim-preset="iec-anim-fade-up" data-iec-anim-stagger="0.12" data-iec-anim-delay="0.35">

								<?php if ( $cta_url ) : ?>

									<a href="<?= $cta_url; ?>" class="btn btn-outline iec-btn-outline iec-anim-magnetic">
										<svg xmlns="http://www.w3.org/2000/svg" width="18" height="15" viewBox="0 0 18 15" fill="none">
											<path d="M5.518 0H11.982C12.795 0 13.451 2.19792e-07 13.982 0.0430002C14.528 0.0880002 15.008 0.183 15.452 0.409C16.1581 0.768372 16.7322 1.34214 17.092 2.048C17.318 2.492 17.412 2.972 17.457 3.518C17.5 4.049 17.5 4.705 17.5 5.518V8.982C17.5 9.795 17.5 10.451 17.457 10.982C17.412 11.528 17.317 12.008 17.091 12.452C16.7316 13.1581 16.1579 13.7322 15.452 14.092C15.008 14.318 14.528 14.412 13.982 14.457C13.451 14.5 12.795 14.5 11.982 14.5H5.518C4.705 14.5 4.049 14.5 3.518 14.457C2.972 14.412 2.492 14.317 2.048 14.091C1.34192 13.7316 0.767803 13.1579 0.408 12.452C0.182 12.008 0.088 11.528 0.043 10.982C-1.86265e-08 10.451 0 9.795 0 8.982V5.518C0 4.705 -1.86265e-08 4.049 0.043 3.518C0.088 2.972 0.183 2.492 0.409 2.048C0.768372 1.34192 1.34214 0.767803 2.048 0.408C2.492 0.182 2.972 0.0880002 3.518 0.0430002C4.049 2.19792e-07 4.705 0 5.518 0ZM3.64 1.538C3.186 1.575 2.925 1.645 2.728 1.745C2.428 1.898 2.168 2.115 1.965 2.378L7.145 6.867C7.525 7.197 7.778 7.416 7.988 7.571C8.19 7.721 8.306 7.776 8.397 7.803C8.627 7.87 8.871 7.87 9.101 7.803C9.191 7.776 9.308 7.721 9.51 7.571C9.72 7.416 9.973 7.196 10.354 6.867L15.533 2.378C15.3292 2.11301 15.0689 1.89677 14.771 1.745C14.573 1.645 14.312 1.575 13.858 1.538C13.396 1.501 12.801 1.5 11.949 1.5H5.55C4.698 1.5 4.103 1.5 3.64 1.538ZM1.5 5.55V8.95C1.5 9.803 1.5 10.397 1.538 10.86C1.575 11.313 1.645 11.574 1.745 11.772C1.79167 11.8633 1.84467 11.9513 1.904 12.036L4.72 9.22C4.86217 9.08752 5.05022 9.0154 5.24452 9.01882C5.43882 9.02225 5.62421 9.10097 5.76162 9.23838C5.89903 9.37579 5.97775 9.56118 5.98118 9.75548C5.9846 9.94978 5.91248 10.1378 5.78 10.28L3.163 12.898C3.293 12.9247 3.45233 12.946 3.641 12.962C4.103 12.999 4.698 13 5.55 13H11.95C12.802 13 13.397 13 13.86 12.962C14.0205 12.9503 14.1801 12.9289 14.338 12.898L11.72 10.28C11.6463 10.2113 11.5872 10.1285 11.5462 10.0365C11.5052 9.94454 11.4832 9.84523 11.4814 9.74452C11.4796 9.64382 11.4982 9.54379 11.5359 9.4504C11.5736 9.35701 11.6297 9.27218 11.701 9.20096C11.7722 9.12974 11.857 9.0736 11.9504 9.03588C12.0438 8.99816 12.1438 8.97963 12.2445 8.98141C12.3452 8.98318 12.4445 9.00523 12.5365 9.04622C12.6285 9.08721 12.7113 9.14631 12.78 9.22L15.596 12.036C15.6547 11.9513 15.7077 11.863 15.755 11.771C15.855 11.574 15.925 11.313 15.962 10.859C15.999 10.397 16 9.803 16 8.95V5.55C16 4.89 16 4.384 15.982 3.975L11.316 8.019C10.962 8.325 10.666 8.583 10.404 8.776C10.13 8.979 9.852 9.146 9.524 9.242C9.01833 9.39042 8.48067 9.39042 7.975 9.242C7.648 9.146 7.37 8.979 7.095 8.776C6.78297 8.53431 6.47945 8.28182 6.185 8.019L1.517 3.975C1.499 4.385 1.5 4.89 1.5 5.55Z" fill="#1B204C"/>
										</svg>
										<?= $cta_label; ?>
									</a>

								<?php endif; ?>

								<?php if ( $brochure_url ) : ?>

									<a href="<?= $brochure_url; ?>" class="gray_btn iec-anim-magnetic" download>
										<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
											<path d="M6.66667 9.64584C6.55556 9.64584 6.45139 9.62861 6.35417 9.59417C6.25694 9.55973 6.16667 9.50056 6.08333 9.41667L3.08333 6.41667C2.91667 6.25 2.83667 6.05556 2.84333 5.83334C2.85 5.61111 2.93 5.41667 3.08333 5.25C3.25 5.08334 3.44806 4.99667 3.6775 4.99C3.90694 4.98334 4.10472 5.06306 4.27083 5.22917L5.83333 6.79167V0.833336C5.83333 0.597225 5.91333 0.399447 6.07333 0.240003C6.23333 0.0805585 6.43111 0.000558429 6.66667 2.87356e-06C6.90222 -0.000552682 7.10028 0.0794474 7.26083 0.240003C7.42139 0.400559 7.50111 0.598336 7.5 0.833336V6.79167L9.0625 5.22917C9.22917 5.0625 9.42722 4.9825 9.65667 4.98917C9.88611 4.99584 10.0839 5.08278 10.25 5.25C10.4028 5.41667 10.4828 5.61111 10.49 5.83334C10.4972 6.05556 10.4172 6.25 10.25 6.41667L7.25 9.41667C7.16667 9.5 7.07639 9.55917 6.97917 9.59417C6.88194 9.62917 6.77778 9.64639 6.66667 9.64584ZM1.66667 13.3333C1.20833 13.3333 0.816111 13.1703 0.49 12.8442C0.163889 12.5181 0.000555556 12.1256 0 11.6667V10C0 9.76389 0.0800001 9.56611 0.24 9.40667C0.4 9.24723 0.597778 9.16723 0.833333 9.16667C1.06889 9.16611 1.26694 9.24611 1.4275 9.40667C1.58806 9.56723 1.66778 9.765 1.66667 10V11.6667H11.6667V10C11.6667 9.76389 11.7467 9.56611 11.9067 9.40667C12.0667 9.24723 12.2644 9.16723 12.5 9.16667C12.7356 9.16611 12.9336 9.24611 13.0942 9.40667C13.2547 9.56723 13.3344 9.765 13.3333 10V11.6667C13.3333 12.125 13.1703 12.5175 12.8442 12.8442C12.5181 13.1708 12.1256 13.3339 11.6667 13.3333H1.66667Z" fill="white"/>
										</svg>
										Download Brochure
									</a>

								<?php endif; ?>

							</div>

						<?php endif; ?>

						<?php if ( ! empty( $card['enabled'] ) && ! empty( $card['headline'] ) ) : ?>

							<div class="hero-info-card iec-anim-init iec-anim-scale-in iec-anim-hover-glow" data-iec-anim-on-load="true" data-iec-anim-delay="0.55">
								<div class="card-icon<?= $icon_id > 0 ? '' : ' default-icon'; ?>" aria-hidden="true">

									<?php if ( $icon_id > 0 ) : ?>

										<?= wp_get_attachment_image( $icon_id, 'thumbnail', false, array( 'alt' => '' ) ); ?>

									<?php endif; ?>

								</div>
								<div class="hero-card-content">

									<?php if ( ! empty( $card['eyebrow'] ) ) : ?>

										<p class="card-eyebrow"><?= $card['eyebrow']; ?></p>

									<?php endif; ?>

									<?php if ( ! empty( $card['headline'] ) ) : ?>

										<p class="card-headline"><?= $card['headline']; ?></p>

									<?php endif; ?>

									<?php if ( ! empty( $cta_card['url'] ) ) : ?>

										<a href="<?= $cta_card['url']; ?>" class="gray_btn" target="<?= $cta_card['target'] ?? '_self'; ?>">
											<?= ! empty( $cta_card['title'] ) ? $cta_card['title'] : 'Learn More'; ?>
										</a>

									<?php endif; ?>

								</div>
							</div>

						<?php endif; ?>

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
