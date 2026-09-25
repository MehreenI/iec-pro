<?php
/**
 * Template Name: Starlink Operator
 */

get_header();

while ( have_posts() ) :
	the_post();

	$fields = get_fields() ?: array();
	?>

	<main id="main" class="iec-starlink-operator-main" data-iec-anim-progress="true">
		<?php
		$parts = array(
			'hero',
			'overview',
			'how-it-works',
			'leo-compare',
			'coverage',
			'industries',
			'products',
			'maritime',
			'land',
			'availability',
			'plans',
			'buying-guide',
			'managed',
			'faq',
		);

		foreach ( $parts as $part ) {
			get_template_part(
				'template-parts/starlink-operator/' . $part,
				null,
				array( 'fields' => $fields )
			);
		}
		?>
	</main>

	<?php
endwhile;

get_footer();
