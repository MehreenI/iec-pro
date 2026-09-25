<?php
/**
 * About job vacancies list.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields   = $args['fields'] ?? array();
$generic  = class_exists( '\BlueBeetle\Press\Generic' ) ? \BlueBeetle\Press\Generic::get_instance() : null;
$offices  = $generic ? $generic->get_offices() : array();
$jobs     = $generic ? $generic->get_jobs() : array();
$has_jobs = ! empty( $jobs );

$selected_job_id    = $_GET['job_id'] ?? 0;
$post_full_name     = $_POST['full_name'] ?? '';
$post_email         = $_POST['email'] ?? '';
$form_errors        = class_exists( '\BlueBeetle\Press\Form' ) ? \BlueBeetle\Press\Form::get_instance()->get_errors() : array();
$success_popup      = get_config( 'job_success_popup_content' );
$success_popup_html = is_string( $success_popup ) ? $success_popup : '';
$banner_description = $fields['banner']['description'] ?? '';
?>

<!-- Job vacancies. -->
<section class="iec_background_image_section iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center iec_vacancies_widget iec-job-vacancies<?php echo $has_jobs ? '' : ' no-results'; ?>">
	<div class="container">
		<div class="row">
			<div class="col-md-9">

				<?php if ( $banner_description ) : ?>
					<div class="iec_inner_main_content_box"><?php echo $banner_description; ?></div>
				<?php endif; ?>

				<?php if ( ! empty( $form_errors ) && is_array( $form_errors ) ) : ?>
					<div class="iec-job-form-errors" role="alert">

						<?php foreach ( $form_errors as $error ) : ?>
							<?php if ( is_string( $error ) ) : ?>
								<p><?php echo $error; ?></p>
							<?php endif; ?>
						<?php endforeach; ?>

					</div>
				<?php endif; ?>

			</div>
			<div class="col-md-3">
				<div class="iec_filters">
					<label class="sr-only" for="job-location-filter">Filter by location</label>
					<select name="location" id="job-location-filter" class="iec-job-location-filter">
						<option value="all" selected>All locations</option>

						<?php foreach ( $offices as $office ) : ?>
							<option value="<?php echo $office->post_name; ?>"><?php echo get_field( 'caption', $office->ID ) ?: get_the_title( $office->ID ); ?></option>
						<?php endforeach; ?>

					</select>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">

				<?php if ( $has_jobs ) : ?>
					<div class="items iec-job-items">

						<?php foreach ( $jobs as $job ) : ?>
							<?php
							get_template_part(
								'template-parts/about/job-item',
								null,
								array(
									'job'            => $job,
									'is_expanded'    => ( (int) $selected_job_id === (int) $job->ID ),
									'post_full_name' => $post_full_name,
									'post_email'     => $post_email,
								)
							);
							?>
						<?php endforeach; ?>

					</div>
				<?php else : ?>
					<div class="iec_no_results_note">
						<p class="iec-no-results-heading">While we do not have any vacancies at the moment, please visit us soon.</p>
						<p>New opportunities are updated on this page as they become available.</p>
					</div>
				<?php endif; ?>

				<?php if ( $success_popup_html ) : ?>
					<div id="success-popup" class="message-popup lity-hide d-none"><?php echo $success_popup_html; ?></div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
