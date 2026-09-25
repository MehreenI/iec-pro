<?php
/**
 * About management members.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$profile_sections = $args['profile_sections'] ?? array();

if ( empty( $profile_sections ) ) {
	return;
}

?>

<!-- Management members. -->
<section class="iec_background_image_section iec_defualt_position iec-about-management-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php foreach ( $profile_sections as $section ) : ?>
					<?php
					$section_title = $section['profile_section_title'] ?? '';
					$profiles      = $section['profiles'] ?? array();
					?>

					<?php if ( ! empty( $profiles ) ) : ?>
						<div class="iec_management_member_section_warpper">

							<?php if ( $section_title ) : ?>
								<h2 class="iec_management_member_category_heading"><?php echo $section_title; ?></h2>
							<?php endif; ?>

							<div class="iec_management_member_grid">

								<?php foreach ( $profiles as $profile ) : ?>
									<?php
									$name         = $profile['name'] ?? '';
									$position     = $profile['position'] ?? '';
									$company      = $profile['company'] ?? '';
									$bio          = $profile['bio'] ?? '';
									$linkedin     = $profile['linkedin_url'] ?? '';
									$image        = $profile['image'] ?? array();
									$image_id     = $image['ID'] ?? 0;
									$image_url    = $image['url'] ?? '';
									$has_bio      = ! empty( $bio );
									$has_linkedin = ! empty( $linkedin );
									$is_link_card = $has_linkedin && ! $has_bio;
									$is_bio_card  = $has_bio && ! $has_linkedin;
									?>

									<?php if ( $name || $image_id || $image_url ) : ?>
										<?php if ( $is_link_card ) : ?>
											<a href="<?php echo $linkedin; ?>" class="iec_management_member_box" target="_blank" rel="noopener noreferrer">
										<?php elseif ( $is_bio_card ) : ?>
											<article
												class="iec_management_member_box iec_management_member_box--bio"
												data-member-name="<?php echo $name; ?>"
												data-member-role="<?php echo $position; ?>"
												data-member-company="<?php echo $company; ?>"
												data-member-image="<?php echo $image_url; ?>"
												tabindex="0"
												role="button"
											>
										<?php else : ?>
											<article
												class="iec_management_member_box<?php echo $has_bio ? '' : ' iec_management_member_box--static'; ?>"
												<?php if ( $has_bio ) : ?>
													data-member-name="<?php echo $name; ?>"
													data-member-role="<?php echo $position; ?>"
													data-member-company="<?php echo $company; ?>"
													data-member-image="<?php echo $image_url; ?>"
												<?php endif; ?>
											>
										<?php endif; ?>

											<div class="iec_management_member_image">

												<?php if ( $image_id ) : ?>
													<?php echo wp_get_attachment_image( $image_id, 'medium', false, array( 'alt' => $name, 'loading' => 'lazy', 'decoding' => 'async' ) ); ?>
												<?php elseif ( $image_url ) : ?>
													<img src="<?php echo $image_url; ?>" alt="<?php echo $name; ?>" class="iec_management_member_image_tag" loading="lazy" decoding="async">
												<?php endif; ?>

											</div>
											<div class="iec_management_member_content">

												<?php if ( $name ) : ?>
													<h3 class="iec_management_member_name"><?php echo $name; ?></h3>
												<?php endif; ?>

												<?php if ( $position ) : ?>
													<p class="iec_management_member_role"><?php echo $position; ?></p>
												<?php endif; ?>

												<?php if ( $company || $has_linkedin || $has_bio ) : ?>
													<div class="iec_management_member_details">

														<?php if ( $company ) : ?>
															<div class="iec_management_member_item"><?php echo $company; ?></div>
														<?php endif; ?>

														<?php if ( $has_linkedin || $has_bio ) : ?>
															<div class="iec_management_member_links">

																<?php if ( $has_linkedin && ! $is_link_card ) : ?>
																	<a href="<?php echo $linkedin; ?>" class="linkedin" target="_blank" rel="noopener noreferrer" aria-label="<?php echo $name; ?> LinkedIn"></a>
																<?php elseif ( $has_linkedin ) : ?>
																	<span class="linkedin" aria-hidden="true"></span>
																<?php endif; ?>

																<?php if ( $has_bio && ! $is_bio_card ) : ?>
																	<button type="button" class="popup iec-member-bio-trigger" aria-label="<?php echo $name; ?> bio"></button>
																<?php elseif ( $has_bio ) : ?>
																	<span class="popup" aria-hidden="true"></span>
																<?php endif; ?>

															</div>
														<?php endif; ?>

													</div>
												<?php endif; ?>

											</div>

											<?php if ( $has_bio ) : ?>
												<template class="iec-member-bio-source"><?php echo $bio; ?></template>
											<?php endif; ?>

										<?php if ( $is_link_card ) : ?>
											</a>
										<?php else : ?>
											</article>
										<?php endif; ?>
									<?php endif; ?>

								<?php endforeach; ?>

							</div>
						</div>
					<?php endif; ?>

				<?php endforeach; ?>

			</div>
		</div>
	</div>

	<dialog id="member-popup" class="bio-popup" aria-labelledby="member-popup-name">
		<button type="button" class="close" aria-label="Close"></button>
		<div class="inner-wrapper">
			<div class="header">
				<div class="img-wrapper">
					<div class="img" aria-hidden="true"></div>
				</div>
				<div class="details">
					<div id="member-popup-name" class="name"></div>
					<p class="position"></p>
					<p class="company"></p>
				</div>
			</div>
			<div class="bio-wrapper">
				<div class="bio"></div>
			</div>
		</div>
	</dialog>
</section>
