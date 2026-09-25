<?php
/**
 * About page heading.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$fields        = $args['fields'] ?? array();
$overlay       = $fields['banner']['overlay_title'] ?? '';
$content_title = $fields['content_title'] ?? '';

if ( ! $overlay && ! $content_title ) {
	?>
	<!-- Fallback page title. -->
	<h1 class="sr-only"><?php echo get_the_title(); ?></h1>
	<?php
	return;
}

if ( ! $content_title ) {
	return;
}

?>

<!-- Page heading. -->
<section class="iec_heading_section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php if ( $overlay ) : ?>
					<h2 id="about-page-title" class="iec-about-main-heading"><?php echo $content_title; ?></h2>
				<?php else : ?>
					<h1 id="about-page-title" class="iec-about-main-heading"><?php echo $content_title; ?></h1>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
