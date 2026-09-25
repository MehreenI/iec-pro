<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields  = $args['fields'] ?? array();
$content = $fields['content'] ?? $args['content'] ?? array();
$title   = $content['title'] ?? '';
$body    = $content['content'] ?? '';
$link    = $content['link'] ?? array();
$href    = $link['url'] ?? '';
$label   = $link['title'] ?? '';
$target  = $link['target'] ?? '';

if ( $href ) {
	$href = apply_filters( 'wpml_permalink', $href );
}

$success_popup_html    = '';
$success_popup_content = function_exists( 'get_config' ) ? get_config( 'enquiry_success_popup_content' ) : array();

if ( is_array( $success_popup_content ) ) {
	$key = array_search( 'iot-enquiry', array_column( $success_popup_content, 'form_type' ), true );
	if ( false !== $key && isset( $success_popup_content[ $key ]['content'] ) ) {
		$success_popup_html = $success_popup_content[ $key ]['content'];
	}
}

$countries = class_exists( '\BlueBeetle\Press\Common' )
	? \BlueBeetle\Press\Common::get_instance()->get_countries()
	: array();

if ( ! empty( $countries ) ) {
	$countries = array_map( 'unserialize', array_unique( array_map( 'serialize', $countries ) ) );
}

$form_interests = function_exists( 'get_config' ) ? ( get_config( 'enquiry_form_interest' ) ?: array() ) : array();
$hear_source    = function_exists( 'get_config' ) ? ( get_config( 'form_hear_source' ) ?: array() ) : array();
?>
<section class="iec_iot_enquriy_section iec_defualt_position">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">

				<?php if ( $title || $body || ( $href && $label ) ) : ?>
					<div class="iec_iot_enquriy_content_warpper">

						<?php if ( $title ) : ?>
							<h2 class="iec_section_heading iec-section-heading"><?= $title; ?></h2>
						<?php endif; ?>

						<?php if ( $body ) : ?>
							<div class="wysiwyg-content">
								<?= $body; ?>
							</div>
						<?php endif; ?>

						<?php if ( $href && $label ) : ?>
							<div class="iec_iot_enquriy_arrow_link">
								<a href="<?= $href; ?>"<?= $target ? ' target="' . $target . '" rel="noopener noreferrer"' : ''; ?>>
									<?= $label; ?>
								</a>
							</div>
						<?php endif; ?>

					</div>
				<?php endif; ?>

			</div>
			<div class="col-lg-4">
				<?php
				get_template_part(
					'template-parts/modules/sidebar',
					'enquiry-form',
					array(
						'form_type'          => 'iot-enquiry',
						'countries'          => $countries,
						'form_interests'     => $form_interests,
						'hear_source'        => $hear_source,
						'success_popup_html' => $success_popup_html,
					)
				);
				?>
			</div>
		</div>
	</div>
</section>
