<?php
/**
 * @package iec
 */

get_header();
?>

<main id="main">
	<section class="error-404 not-found" aria-labelledby="error-title">
		<div class="container">
			<h1 id="error-title"><?php _e( "Oops! That page can't be found.", 'bbtheme' ); ?></h1>
			<p><?php _e( 'It looks like nothing was found at this location.', 'bbtheme' ); ?></p>
		</div>
	</section>
</main>

<?php
get_footer();
