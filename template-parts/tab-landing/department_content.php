<?php

if ( ! defined( 'ABSPATH' ) || ! isset( $iec_tab_landing ) ) {
	return;
}

$dept_data = $iec_tab_landing->field( 'department_content', [] );

if ( ! is_array( $dept_data ) || empty( $dept_data ) ) {
	return;
}
$form_heading = $args['form_heading'] ?? ( $form_heading ?? '' );
$form_type    = $args['form_type'] ?? ( $form_type ?? 'office-enquiry' );
$form_option  = get_config( 'form_options' ) ?: array();
$nonce        = wp_create_nonce( 'enquiry_form_nonce' );
$captcha_key  = iec_recaptcha_site_key();
$page_url     = ( empty( $_SERVER['HTTPS'] ) ? 'http' : 'https' ) . '://' . sanitize_text_field( wp_unslash( $_SERVER['HTTP_HOST'] ?? '' ) ) . esc_url_raw( wp_unslash( $_SERVER['REQUEST_URI'] ?? '/' ) );
$submit_label = $form_option['button'] ?? __( 'Send', 'bbtheme' );

$countries = array();
if ( class_exists( '\BlueBeetle\Press\Common' ) ) {
    $countries = \BlueBeetle\Press\Common::get_instance()->get_countries();
    $countries = array_map( 'unserialize', array_unique( array_map( 'serialize', $countries ) ) );
}

if ( ! isset( $hear_source ) || ! is_array( $hear_source ) || $hear_source === [] ) {
    $hear_source = get_config( 'form_hear_source' );
}

if ( ! is_array( $hear_source ) ) {
    $hear_source = [];
}

$country_placeholder  = ! empty( $form_option['country_field'] ) ? $form_option['country_field'] : __( 'Country...', 'bbtheme' );
$interest_placeholder = ! empty( $form_option['interest_field'] ) ? $form_option['interest_field'] : __( 'Interest...', 'bbtheme' );
$hear_placeholder     = ! empty( $form_option['hear_field'] ) ? $form_option['hear_field'] : __( 'How did you hear about us?', 'bbtheme' );

$heading      = (string) ( $dept_data['heading']      ?? '' );
$intro        = (string) ( $dept_data['intro']         ?? '' );
$contact_link = $dept_data['contact_link'] ?? [];
$departments  = $dept_data['departments'] ?? [];
?>
<section class="iec_tab_department">

	<div class="container">

		<div class="row iec_tab_dept_header">
			<div class="col-md-9">
				<?php if ( $heading !== '' ) : ?>
					<h2 class="iec_tab_section_heading"><?= $heading; ?></h2>
				<?php endif; ?>

				<?php if ( $intro !== '' ) : ?>
					<p class="iec_tab_dept_intro"><?= wp_kses_post( $intro ); ?></p>
				<?php endif; ?>
			</div>

			<?php if ( ! empty( $contact_link['url'] ) ) : ?>
			<div class="col-md-3 iec_tab_dept_cta_col">
				<a
					id="iecEnquiryModalTrigger"
					href="<?= esc_url( $contact_link['url'] ); ?>"
					class="iec_tab_dept_contact_btn"
					<?= ! empty( $contact_link['target'] ) && '_self' !== $contact_link['target'] ? 'target="' . esc_attr( $contact_link['target'] ) . '" rel="noopener noreferrer"' : ''; ?>
				><?= $contact_link['title'] ?? __( 'Contact Us', 'bbtheme' ); ?></a>
			</div>
			<?php endif; ?>
		</div>

		<div class="row iec_tab_dept_cards">
			<div class="col-md-12">
				<?php foreach ( $departments as $dept_index => $dept ) :
					if ( ! is_array( $dept ) ) {
						continue;
					}
					$title    = (string) ( $dept['title']   ?? '' );
					$content  = (string) ( $dept['content'] ?? '' );
					$features = $dept['features'] ?? [];
					$image    = $iec_tab_landing->image_url( $dept['image'] ?? null );
				?>
				<div class="iec_tab_dept_card<?= $dept_index % 2 === 0 ? ' iec_tab_dept_card--highlighted' : ''; ?>">
					<div class="iec_tab_dept_card_layout">
						<div class="iec_tab_dept_card_text">
							<?php if ( $title !== '' ) : ?>
								<h3 class="iec_tab_dept_card_title"><?= $title; ?></h3>
							<?php endif; ?>

							<?php if ( $content !== '' ) : ?>
								<div class="iec_tab_dept_card_body"><?= wp_kses_post( $content ); ?></div>
							<?php endif; ?>

							<?php if ( ! empty( $features ) ) : ?>
							<ul class="iec_tab_dept_features">
								<?php foreach ( $features as $feature ) :
									if ( ! is_array( $feature ) ) {
										continue;
									}
									$label = (string) ( $feature['label'] ?? '' );
									if ( $label === '' ) {
										continue;
									}
								?>
								<li>
									<svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none">
										<path d="M26.3 7.89829C26.4269 8.02492 26.5277 8.17535 26.5964 8.34097C26.6651 8.50658 26.7005 8.68413 26.7005 8.86343C26.7005 9.04274 26.6651 9.22029 26.5964 9.3859C26.5277 9.55152 26.4269 9.70195 26.3 9.82857L14.0312 22.0973C13.9046 22.2243 13.7542 22.325 13.5886 22.3937C13.423 22.4624 13.2454 22.4978 13.0661 22.4978C12.8868 22.4978 12.7092 22.4624 12.5436 22.3937C12.378 22.325 12.2276 22.2243 12.101 22.0973L6.64819 16.6445C6.39222 16.3886 6.24841 16.0414 6.24841 15.6794C6.24841 15.3174 6.39222 14.9702 6.64819 14.7143C6.90416 14.4583 7.25133 14.3145 7.61333 14.3145C7.97533 14.3145 8.3225 14.4583 8.57847 14.7143L13.0661 19.2046L24.3697 7.89829C24.4963 7.77134 24.6468 7.67062 24.8124 7.6019C24.978 7.53318 25.1555 7.4978 25.3348 7.4978C25.5141 7.4978 25.6917 7.53318 25.8573 7.6019C26.0229 7.67062 26.1734 7.77134 26.3 7.89829Z" fill="#727DA3"/>
									</svg><?= $label; ?></li>
								<?php endforeach; ?>
							</ul>
							<?php endif; ?>
						</div>
						<?php if ( $image !== '' ) : ?>
						<div class="iec_tab_dept_card_media">
							<img
								src="<?= esc_url( $image ); ?>"
								alt="<?= esc_attr( $title ); ?>"
								class="iec_tab_dept_card_img"
								loading="lazy"
								width="340"
								height="280"
							>
						</div>
						<?php endif; ?>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</div>
</section>
