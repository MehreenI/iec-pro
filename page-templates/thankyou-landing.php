<?php
/**
 * Template Name: Thank You Landing Page
 *
 * @package iec
 */

get_header();

while ( have_posts() ) :
	the_post();
	?>

	<div id="main" class="ice_thankyou_page_warpper">
		<?php get_template_part( 'template-parts/thankyou/decorations' ); ?>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
	</div>

	<?php
endwhile;

get_footer();
