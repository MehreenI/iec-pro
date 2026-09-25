<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$desktop_image = $args['desktop_image'] ?? '';
$mobile_image  = $args['mobile_image'] ?? $desktop_image;
$color         = $args['desktop_class'] ?? 'text_white';
$heading       = $args['heading'] ?? '';
$subheading    = $args['subheading'] ?? '';
$items         = $args['items'] ?? array();
$link          = $args['link'] ?? array();
$reverse       = ! empty( $args['reverse'] );
$top_space     = $args['top_space'] ?? '';
$bottom_space  = $args['bottom_space'] ?? '';

if ( ! $desktop_image ) {
	return;
}

$classes     = 'iec_exlore_section' . ( $reverse ? ' ice_right_content_section' : '' );
$content_col = $reverse ? 'col-md-6 col-lg-5' : 'col-md-6 col-lg-4';
$spacer_col  = $reverse ? 'col-md-6 col-lg-7' : 'col-md-6 col-lg-8';

$style = '--desktopImage: url(\'' . esc_url( $desktop_image ) . '\'); --mobileImage: url(\'' . esc_url( $mobile_image ) . '\');';
if ( $top_space && '0px' !== $top_space ) {
	$style .= ' padding-top: ' . esc_attr( $top_space ) . ';';
}
if ( $bottom_space && '0px' !== $bottom_space ) {
	$style .= ' padding-bottom: ' . esc_attr( $bottom_space ) . ';';
}

$link_url    = '';
$link_title  = __( 'Learn More', 'bbtheme' );
$link_target = '_self';

if ( is_array( $link ) && ! empty( $link['url'] ) ) {
	$link_url    = function_exists( 'iec_resolve_wpml_url' ) ? iec_resolve_wpml_url( $link ) : $link['url'];
	$link_title  = $link['title'] ?? $link_title;
	$link_target = $link['target'] ?? '_self';
} elseif ( is_string( $link ) && '' !== trim( $link ) ) {
	$link_url = trim( $link );
}

$heading_id = $heading && function_exists( 'wp_unique_id' ) ? wp_unique_id( 'iec-explore-heading-' ) : '';

$icon = function_exists( 'iec_office_check_icon_svg' ) ? iec_office_check_icon_svg() : '';
?>

<!-- Explore. -->
<section class="<?php echo esc_attr( $classes ); ?>" style="<?php echo esc_attr( $style ); ?>"<?php echo $heading_id ? ' aria-labelledby="' . esc_attr( $heading_id ) . '"' : ''; ?>>
	<div class="container">
		<div class="row">

			<?php if ( $reverse ) : ?>
				<div class="<?php echo esc_attr( $spacer_col ); ?>"></div>
			<?php endif; ?>

			<div class="<?php echo esc_attr( $content_col ); ?>">

				<?php if ( $heading ) : ?>
					<h2<?php echo $heading_id ? ' id="' . esc_attr( $heading_id ) . '"' : ''; ?> class="iec_section_heading <?php echo esc_attr( $color ); ?>"><?php echo $heading; ?></h2>
				<?php endif; ?>

				<?php if ( $subheading ) : ?>
					<h3 class="iec_sec_sub_heading <?php echo esc_attr( $color ); ?>"><?php echo $subheading; ?></h3>
				<?php endif; ?>

				<?php if ( $items ) : ?>
					<ul class="iec_icon_list">
						<?php foreach ( $items as $item ) :
							if ( ! is_array( $item ) ) {
								continue;
							}
							$text = $item['text'] ?? $item['point'] ?? $item['item'] ?? '';
							if ( ! $text ) {
								continue;
							}
							?>
							<li class="<?php echo esc_attr( $color ); ?>">
								<?php echo $icon; ?>
								<?php echo $text; ?>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>

				<?php if ( $link_url ) : ?>
					<a href="<?php echo esc_url( $link_url ); ?>" class="gray_btn"<?php echo ( $link_target && '_self' !== $link_target ) ? ' target="' . esc_attr( $link_target ) . '" rel="noopener noreferrer"' : ''; ?>>
						<?php echo $link_title; ?>
					</a>
				<?php endif; ?>

			</div>

			<?php if ( ! $reverse ) : ?>
				<div class="<?php echo esc_attr( $spacer_col ); ?>"></div>
			<?php endif; ?>

		</div>
	</div>
</section>
