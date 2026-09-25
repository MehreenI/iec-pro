<?php
/**
 * Default page template.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

get_header();

$fields  = function_exists( 'get_fields' ) ? get_fields() : array();
$fields  = is_array( $fields ) ? $fields : array();
$caption = isset( $fields['caption'] ) ? (string) $fields['caption'] : get_the_title();
$content = isset( $fields['content'] ) ? (string) $fields['content'] : '';
?>
<main>
	<section class="iec_default_hero_section">
		<div class="container">
			<h1><?php echo $caption; ?></h1>
		</div>
	</section>
	<section class="iec_default_content_section">
		<div id="main" class="container">
			<div class="iec_main_content_warpper">
				<?php echo wp_kses_post( $content ); ?>
			</div>
		</div>
	</section>
</main>
<?php
get_footer();
