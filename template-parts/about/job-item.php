<?php
/**
 * About job vacancy card.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$job            = $args['job'] ?? null;
$is_expanded    = ! empty( $args['is_expanded'] );
$post_full_name = $args['post_full_name'] ?? '';
$post_email     = $args['post_email'] ?? '';

if ( ! $job || empty( $job->ID ) ) {
	return;
}

$job_id         = (int) $job->ID;
$job_fields     = get_fields( $job_id ) ?: array();
$office         = $job_fields['office'] ?? null;
$office_slug    = ( is_object( $office ) && ! empty( $office->post_name ) ) ? $office->post_name : '';
$office_caption = '';

if ( is_object( $office ) && ! empty( $office->ID ) ) {
	$office_caption = get_field( 'caption', $office->ID ) ?: get_the_title( $office->ID );
}

$caption    = $job_fields['caption'] ?? get_the_title( $job_id );
$content    = $job_fields['content'] ?? '';
$item_class = trim( 'item iec-job-item ' . $office_slug . ( $is_expanded ? ' expand' : '' ) );
?>

<article class="<?php echo $item_class; ?>" data-office="<?php echo $office_slug; ?>" id="job-<?php echo $job_id; ?>">
	<button type="button" class="close iec-job-item__close" aria-label="Close"></button>

	<div class="columns cf iec-job-item__columns">
		<div class="form iec-job-item__form">
			<form action="<?php echo get_ajax_url( 'job', 'save' ); ?>" method="post" id="jform-<?php echo $job_id; ?>" class="iec-job-apply-form" enctype="multipart/form-data" novalidate>
				<div class="error" role="alert"></div>
				<div class="overlay" hidden>
					<div class="loader" aria-hidden="true"></div>
				</div>
				<div class="form-fields">
					<p class="iec-form-heading">Apply Now</p>

					<div class="form-field">
						<label class="sr-only" for="job-full-name-<?php echo $job_id; ?>">Full Name</label>
						<input type="text" id="job-full-name-<?php echo $job_id; ?>" name="full_name" placeholder="Full Name" value="<?php echo $post_full_name; ?>" required autocomplete="name">
					</div>

					<div class="form-field">
						<label class="sr-only" for="job-email-<?php echo $job_id; ?>">Email</label>
						<input type="email" id="job-email-<?php echo $job_id; ?>" name="email" placeholder="Email" value="<?php echo $post_email; ?>" required autocomplete="email" inputmode="email">
					</div>

					<div class="file-upload form-field">
						<input type="file" name="file" id="file-<?php echo $job_id; ?>" required accept=".pdf,application/pdf" data-invalid="No file chosen">
						<label for="file-<?php echo $job_id; ?>" data-default-label="Upload Resume">Upload Resume</label>
					</div>

					<input type="hidden" name="job_id" value="<?php echo $job_id; ?>">
					<button type="submit" class="iec-job-submit">Send</button>
				</div>
			</form>
		</div>

		<div class="details iec-job-item__details">
			<h2 class="iec-job-item__title">
				<button type="button" class="header cf iec-job-item__header">
					<span><?php echo $caption; ?></span>

					<?php if ( $office_caption ) : ?>
						<span class="location iec-job-item__location"><?php echo $office_caption; ?></span>
					<?php endif; ?>

				</button>
			</h2>

			<?php if ( $content ) : ?>
				<div class="description iec-job-item__description">
					<div class="text-content-widget"><?php echo $content; ?></div>
				</div>
			<?php endif; ?>

		</div>
	</div>
</article>
