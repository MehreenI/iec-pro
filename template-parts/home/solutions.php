<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$section   = $args['section'] ?? array();
$heading   = $section['heading'] ?? '';
$link      = $section['link'] ?? array();
$solutions = $section['solutions'] ?? array();

if ( empty( $solutions ) ) {
	return;
}

$link_url    = ! empty( $link['url'] ) && function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( $link ) : ( $link['url'] ?? '' );
$link_title  = $link['title'] ?? '';
$link_target = $link['target'] ?? '';
$arrow       = '<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M8.49219 3.41663C8.51931 3.41688 8.54751 3.42324 8.5752 3.43616C8.60296 3.44914 8.63095 3.46924 8.65625 3.49768L8.66211 3.50354L11.6621 6.76233C11.7006 6.80407 11.7315 6.86251 11.7441 6.93127C11.7567 6.99998 11.7494 7.07092 11.7256 7.13342V7.1344C11.7101 7.17536 11.6882 7.21035 11.6631 7.23792L8.66309 10.4957L8.65723 10.5026C8.63196 10.531 8.6039 10.5511 8.57617 10.5641C8.54854 10.577 8.52024 10.5833 8.49316 10.5836C8.46606 10.5839 8.4378 10.5783 8.41016 10.566C8.3825 10.5538 8.3546 10.534 8.3291 10.5065C8.30342 10.4786 8.28041 10.4428 8.26465 10.401C8.24888 10.3591 8.24083 10.3126 8.24121 10.2653C8.24163 10.2183 8.25039 10.1726 8.2666 10.1315C8.28294 10.0902 8.30614 10.0551 8.33203 10.028L8.33789 10.0211L10.0576 8.15393L10.8301 7.31506H2.5C2.44774 7.31505 2.3885 7.29271 2.33789 7.23792C2.28597 7.18153 2.25006 7.09665 2.25 7.00061C2.25 6.90447 2.28593 6.81974 2.33789 6.76331C2.38855 6.70832 2.44765 6.68617 2.5 6.68616H10.8301L10.0576 5.84729L8.33691 3.97815L8.33105 3.97229L8.29492 3.92542C8.28406 3.90828 8.27471 3.88927 8.2666 3.86877C8.25023 3.82739 8.24061 3.78131 8.24023 3.73401C8.23989 3.68681 8.24892 3.64101 8.26465 3.59924C8.2804 3.55742 8.30244 3.52167 8.32812 3.49377C8.35361 3.46614 8.3815 3.44654 8.40918 3.4342C8.43682 3.42192 8.46509 3.41638 8.49219 3.41663Z" fill="#727DA3" stroke="#727DA3"/></svg>';

$render_card = static function ( $solution, $aos_delay = null ) use ( $arrow ) {
	$post_id = is_object( $solution ) ? (int) $solution->ID : (int) $solution;

	if ( $post_id < 1 ) {
		return;
	}

	$lang = apply_filters( 'wpml_current_language', null );

	if ( $lang && has_filter( 'wpml_object_id' ) ) {
		$translated_id = (int) apply_filters( 'wpml_object_id', $post_id, get_post_type( $post_id ), true, $lang );

		if ( $translated_id ) {
			$post_id = $translated_id;
		}
	}

	$permalink = get_permalink( $post_id );

	if ( ! $permalink ) {
		return;
	}

	$title       = get_the_title( $post_id );
	$caption     = '';
	$image_field = function_exists( 'get_field' ) ? get_field( 'landing_image', $post_id ) : null;
	$image_id    = 0;

	if ( is_array( $image_field ) ) {
		$image_id = (int) ( $image_field['ID'] ?? 0 );

		if ( $image_id < 1 && ! empty( $image_field['url'] ) ) {
			$image_id = (int) attachment_url_to_postid( $image_field['url'] );
		}

	} elseif ( is_numeric( $image_field ) ) {
		$image_id = (int) $image_field;

	} elseif ( is_string( $image_field ) && $image_field ) {
		$image_id = (int) attachment_url_to_postid( $image_field );
	}

	if ( function_exists( 'get_field' ) ) {
		$overview = get_field( 'overview', $post_id );
		$caption  = is_array( $overview ) ? trim( wp_strip_all_tags( $overview['contant'] ?? '' ) ) : '';
		$caption  = $caption ? $caption : (string) get_field( 'caption', $post_id );
		$caption  = $caption ? wp_trim_words( $caption, 15, '...' ) : '';
	}

	?>
	<a
		href="<?= esc_url( $permalink ); ?>"
		class="iec_home_solution_post_box"
		<?= null !== $aos_delay ? 'data-aos="fade-up"' : ''; ?>
		<?= $aos_delay ? 'data-aos-delay="' . esc_attr( $aos_delay ) . '"' : ''; ?>
	>
		<div class="iec_home_solution_post_image">

			<?php if ( $image_id ) : ?>

				<?= wp_get_attachment_image( $image_id, 'medium_large', false, array( 'class' => 'iec_img_style', 'alt' => $title ) ); ?>

			<?php endif; ?>

		</div>
		<div class="iec_home_solution_post_content">
			<h3 class="iec_home_solution_post_title"><?= esc_html( $title ); ?></h3>

			<?php if ( $caption ) : ?>

				<div class="iec_home_solution_post_para">
					<p><?= esc_html( $caption ); ?></p>
				</div>

			<?php endif; ?>
			<span>
				<?= __( 'Explore solution', 'bbtheme' ); ?>
				<?= $arrow; ?>
			</span>
		</div>
	</a>
	<?php
};
?>

<section class="iec_defualt_position iec_section_home_solutios">
	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<?php if ( $heading ) : ?>

					<h2 class="iec_section_heading" data-aos="fade-up"><?= esc_html( $heading ); ?></h2>

				<?php endif; ?>

			</div>
			<div class="col-md-4">

				<?php if ( $link_url && $link_title ) : ?>

					<a
						href="<?= esc_url( $link_url ); ?>"
						class="iec_button iec_blue_gradient"
						data-aos="fade-up"
						data-aos-delay="100"
						<?= $link_target ? 'target="' . esc_attr( $link_target ) . '"' : ''; ?>
					><?= esc_html( $link_title ); ?></a>

				<?php endif; ?>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="iec_home_solution_swiper_warpper">
					<div class="swiper iec_home_solution_swiper">
						<div class="swiper-wrapper">
							<?php foreach ( $solutions as $i => $solution ) : ?>
								<div class="swiper-slide">
									<?php $render_card( $solution, (int) $i * 100 ); ?>
								</div>
							<?php endforeach; ?>
						</div>
					</div>
					<div class="swiper-pagination iec_home_solution_swiper_pagination"></div>
					<div class="iec_swiper_arrow_warpper">
						<div class="swiper-button-next iec_home_solution_swiper_next"></div>
						<div class="swiper-button-prev iec_home_solution_swiper_prev"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
