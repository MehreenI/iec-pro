<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$heading    = get_sub_field( 'rt_heading' ) ?: '';
$content    = get_sub_field( 'rt_content' ) ?: '';
$text_align = get_sub_field( 'rt_text_align' ) ?: 'left';

if ( ! $content && ! $heading ) {
	return;
}
?>
<section class="iec-intro-section">
	<div class="container">
		<div class="row">
			<div class="col-md-12">

				<?php if ( $heading ) : ?>
					<h2 class="iec_section_heading"><?= $heading; ?></h2>
				<?php endif; ?>

				<?php if ( $content ) : ?>
					<div class="iec_main_content_warpper wysiwyg-content" style="text-align: <?= $text_align; ?>;">
						<?= $content; ?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
</section>
