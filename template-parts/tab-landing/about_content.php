<?php

if ( ! defined( 'ABSPATH' ) || ! isset( $iec_tab_landing ) ) {
	return;
}

$about = $iec_tab_landing->field( 'about_content', [] );

if ( ! is_array( $about ) || empty( $about ) ) {
	return;
}

$heading      = (string) ( $about['heading']     ?? '' );
$intro        = (string) ( $about['intro']        ?? '' );
$disc_text    = (string) ( $about['disclaimer']   ?? '' );
$role_heading = (string) ( $about['role_heading'] ?? '' );
$role_content = (string) ( $about['role_content'] ?? '' );
$features     = $about['features'] ?? [];
?>
<section class="iec_tab_about">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php if ( $heading !== '' ) : ?>
					<h2 class="iec_tab_section_heading"><?= $heading; ?></h2>
				<?php endif; ?>

				<?php if ( $intro !== '' ) : ?>
					<div class="iec_tab_body_text"><?= wp_kses_post( $intro ); ?></div>
				<?php endif; ?>

				<?php if ( $disc_text !== '' ) : ?>
				<div class="iec_tab_disclaimer" role="note">
					<svg class="iec_tab_disclaimer_icon" xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60" fill="none" aria-hidden="true">
						<path d="M30 55.6136C43.9874 55.6136 55.6135 44.0121 55.6135 30C55.6135 16.0125 43.9617 4.38641 29.9742 4.38641C15.9632 4.38641 4.38745 16.0125 4.38745 30C4.38745 44.0121 15.9878 55.6136 30 55.6136ZM29.9764 33.7671C28.6446 33.7671 27.9171 32.9882 27.8657 31.6564L27.5142 19.2536C27.4639 17.8714 28.5182 16.8932 29.9496 16.8932C31.3564 16.8932 32.4353 17.8971 32.386 19.2782L32.0335 31.6586C31.9832 33.0139 31.2299 33.7682 29.9753 33.7682M29.9753 43.0093C28.5182 43.0093 27.1617 41.8543 27.1617 40.2964C27.1617 38.7386 28.4935 37.5857 29.9753 37.5857C31.4314 37.5857 32.7867 38.715 32.7867 40.2964C32.7867 41.8789 31.4057 43.0093 29.9753 43.0093Z" fill="white"/>
					</svg>
					<span class="iec_tab_disclaimer_label"><?= 'Important Note:'; ?></span>
					<p class="iec_tab_disclaimer_text"><?= wp_kses_post( $disc_text ); ?></p>
				</div>
				<?php endif; ?>

				<?php if ( $role_heading !== '' ) : ?>
					<h3 class="iec_tab_section_heading iec_tab_role_heading"><?= $role_heading; ?></h3>
				<?php endif; ?>

				<?php if ( $role_content !== '' ) : ?>
					<div class="iec_tab_body_text"><?= wp_kses_post( $role_content ); ?></div>
				<?php endif; ?>

				<?php if ( ! empty( $features ) ) : ?>
				<ul class="iec_tab_features" role="list">
					<?php foreach ( $features as $feature ) :
						if ( ! is_array( $feature ) ) {
							continue;
						}
						$label = (string) ( $feature['label'] ?? '' );
						if ( $label === '' ) {
							continue;
						}
					?>
					<li class="iec_tab_feature_item">
						<svg class="iec_tab_feature_icon" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" fill="none" aria-hidden="true">
							<path d="M26.3 7.89829C26.4269 8.02492 26.5277 8.17535 26.5964 8.34097C26.6651 8.50658 26.7005 8.68413 26.7005 8.86343C26.7005 9.04274 26.6651 9.22029 26.5964 9.3859C26.5277 9.55152 26.4269 9.70195 26.3 9.82857L14.0312 22.0973C13.9046 22.2243 13.7542 22.325 13.5886 22.3937C13.423 22.4624 13.2454 22.4978 13.0661 22.4978C12.8868 22.4978 12.7092 22.4624 12.5436 22.3937C12.378 22.325 12.2276 22.2243 12.101 22.0973L6.64819 16.6445C6.39222 16.3886 6.24841 16.0414 6.24841 15.6794C6.24841 15.3174 6.39222 14.9702 6.64819 14.7143C6.90416 14.4583 7.25133 14.3145 7.61333 14.3145C7.97533 14.3145 8.3225 14.4583 8.57847 14.7143L13.0661 19.2046L24.3697 7.89829C24.4963 7.77134 24.6468 7.67062 24.8124 7.6019C24.978 7.53318 25.1555 7.4978 25.3348 7.4978C25.5141 7.4978 25.6917 7.53318 25.8573 7.6019C26.0229 7.67062 26.1734 7.77134 26.3 7.89829Z" fill="#727DA3"/>
						</svg>
						<span class="iec_tab_feature_label"><?= $label; ?></span>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
