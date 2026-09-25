<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$band = is_array( $args['band'] ?? null ) ? $args['band'] : array();
$link = $band['link'] ?? array();
$href = function_exists( 'iec_resolve_wpml_url' )
	? ( iec_resolve_wpml_url( $link ) ?: '#' )
	: ( ( is_array( $link ) && ! empty( $link['url'] ) ) ? $link['url'] : '#' );
$text   = ( is_array( $link ) && ! empty( $link['title'] ) ) ? $link['title'] : __( 'Discuss Requirements', 'bbtheme' );
$target = ( is_array( $link ) && ! empty( $link['target'] ) ) ? $link['target'] : '';
$features = is_array( $band['features'] ?? null ) ? $band['features'] : array();
?>
	<article class="iec_band_card">
		<div class="iec_band_header">
			<h3 class="iec_band_title"><?= $band['title'] ?? ''; ?></h3>
			<?php if ( ! empty( $band['subtitle'] ) ) : ?>
				<span class="iec_band_subtitle"><?= $band['subtitle']; ?></span>
			<?php endif; ?>
		</div>
		<?php if ( ! empty( $band['description'] ) ) : ?>
			<p><?= $band['description']; ?></p>
		<?php endif; ?>
		<?php if ( $features ) : ?>
			<ul class="iec_band_features">
				<?php foreach ( $features as $feature ) : ?>
					<li><?= $feature; ?></li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
		<a href="<?= $href; ?>"<?= $target ? ' target="' . $target . '"' : ''; ?> class="iec_band_link"><?= $text; ?></a>
	</article>
