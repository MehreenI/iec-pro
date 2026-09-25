<?php
/**
 * Flexible: product card grid.
 *
 * @package iec
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$block = $args['block'] ?? array();
$cards = $block['card'] ?? array();

if ( empty( $cards ) ) {
	return;
}

$bg_color = ! empty( $block['background_color'] ) ? $block['background_color'] : '#F1F2F7';
$heading  = $block['heading'] ?? '';

$card_items = array();

foreach ( $cards as $card ) {
	if ( ! is_array( $card ) ) {
		continue;
	}
	$title = $card['title'] ?? '';
	$body  = $card['body'] ?? '';
	$tag   = '';
	if ( ! empty( $card['tag'] ) ) {
		$tag = trim( (string) $card['tag'] );
	} elseif ( ! empty( $card['category'] ) ) {
		$tag = trim( (string) $card['category'] );
	} elseif ( ! empty( $card['label'] ) ) {
		$tag = trim( (string) $card['label'] );
	}
	$product_id = 0;
	$selected   = $card['select_product'] ?? null;
	if ( $selected instanceof WP_Post ) {
		$product_id = (int) $selected->ID;
	} elseif ( is_array( $selected ) ) {
		$first = reset( $selected );
		if ( $first instanceof WP_Post ) {
			$product_id = (int) $first->ID;
		} elseif ( is_numeric( $first ) ) {
			$product_id = (int) $first;
		} elseif ( is_array( $first ) && ! empty( $first['ID'] ) ) {
			$product_id = (int) $first['ID'];
		} elseif ( ! empty( $selected['ID'] ) ) {
			$product_id = (int) $selected['ID'];
		}
	} elseif ( is_numeric( $selected ) ) {
		$product_id = (int) $selected;
	}

	if ( $product_id > 0 && function_exists( 'iec_wpml_translate_post_id' ) ) {
		$product_id = iec_wpml_translate_post_id( $product_id );
	}
	$image = '';
	if ( $product_id > 0 && function_exists( 'iec_solution_card_image_url' ) ) {
		$image = iec_solution_card_image_url( $product_id );
	}

	if ( '' === $image && function_exists( 'iec_resolve_media_to_url' ) ) {
		$image = iec_resolve_media_to_url( $card['product_image'] ?? null );
	}
	$features_raw = array();
	if ( ! empty( $card['key_features'] ) && is_array( $card['key_features'] ) ) {
		$features_raw = $card['key_features'];
	} elseif ( ! empty( $card['features'] ) && is_array( $card['features'] ) ) {
		$features_raw = $card['features'];
	}

	if ( $product_id > 0 ) {
		$product_title = get_the_title( $product_id );
		if ( '' !== trim( (string) $product_title ) ) {
			$title = trim( wp_strip_all_tags( $product_title ) );
		}
	}
	$features = array();
	foreach ( $features_raw as $feature_row ) {
		if ( is_string( $feature_row ) ) {
			$text = trim( $feature_row );
		} elseif ( is_array( $feature_row ) ) {
			$text = '';
			foreach ( array( 'feature', 'point', 'text', 'label' ) as $key ) {
				if ( ! empty( $feature_row[ $key ] ) ) {
					$text = trim( (string) $feature_row[ $key ] );
					break;
				}
			}
		} else {
			continue;
		}

		if ( $text !== '' ) {
			$features[] = $text;
		}
	}
	$link       = $card['link'] ?? null;
	$link_url   = '';
	$link_title = __( 'Learn More', 'bbtheme' );
	$link_target = '_self';
	if ( is_array( $link ) ) {
		$link_url    = $link['url'] ?? '';
		$link_title  = $link['title'] ?? $link_title;
		$link_target = $link['target'] ?? '_self';
	} elseif ( is_string( $link ) && '' !== trim( $link ) ) {
		$link_url = trim( $link );
	}

	if ( '' === $link_url && $product_id > 0 ) {
		$permalink = function_exists( 'iec_wpml_permalink' ) ? iec_wpml_permalink( $product_id ) : get_permalink( $product_id );
		$link_url  = $permalink ? (string) $permalink : '';
	}

	if ( $title === '' && $body === '' && $image === '' && empty( $features ) ) {
		continue;
	}
	$tag_slug = sanitize_title( $tag );
	$tag_mod  = '';
	if ( false !== strpos( $tag_slug, 'iridium' ) ) {
		$tag_mod = 'is-iridium';
	} elseif ( false !== strpos( $tag_slug, 'inmarsat' ) ) {
		$tag_mod = 'is-inmarsat';
	}
	$card_items[] = array(
		'title'       => $title,
		'body'        => $body,
		'tag'         => $tag,
		'tag_mod'     => $tag_mod,
		'image'       => $image,
		'features'    => $features,
		'link_url'    => $link_url,
		'link_title'  => $link_title,
		'link_target' => $link_target,
	);
}

if ( empty( $card_items ) ) {
	return;
}

$card_count = count( $card_items );
$col_class  = ( 0 === $card_count % 3 ) ? 'col-md-4' : 'col-md-6';
$section_id = 'iec-insights-product-cards-' . wp_unique_id();
?>
<section class="iec_single_news_main_section iec_single_news_boxes_section iec_single_news_product_cards_section iec_defualt_position" id="<?= esc_attr( $section_id ); ?>" >
	<div class="container">
		<?php if ( $heading !== '' ) : ?>
			<div class="row">
				<div class="col-md-12">
					<div class="iec_heading_section">
						<h2><?= $heading; ?></h2>
					</div>
				</div>
			</div>
		<?php endif; ?>

		<div class="row">
			<?php foreach ( $card_items as $card_item ) : ?>
				<div class="<?= esc_attr( $col_class ); ?> iec_single_news_product_box_warpper">
					<article class="iec_single_news_product_box">
						<?php if ( $card_item['image'] !== '' ) : ?>
							<div class="iec_single_news_product_image">
								<img src="<?= esc_url( $card_item['image'] ); ?>" alt="<?= esc_attr( $card_item['title'] ); ?>" loading="lazy" decoding="async">
							</div>
						<?php endif; ?>
						<div class="iec_single_news_product_box_body">
							<?php if ( $card_item['tag'] !== '' ) : ?>
								<span class="iec_single_news_product_tag <?= esc_attr( $card_item['tag_mod'] ); ?>"><?= $card_item['tag']; ?></span>
							<?php endif; ?>

							<?php if ( $card_item['title'] !== '' ) : ?>
								<h3 class="iec_single_news_product_title"><?= $card_item['title']; ?></h3>
							<?php endif; ?>

							<?php if ( $card_item['body'] !== '' ) : ?>
								<div class="iec_single_news_product_desc">
									<?php if ( strpos( $card_item['body'], '<' ) !== false ) : ?>
										<?= wp_kses_post( $card_item['body'] ); ?>
									<?php else : ?>
										<p><?= $card_item['body']; ?></p>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $card_item['features'] ) ) : ?>
								<div class="iec_single_news_product_features">
									<h4 class="iec_single_news_product_features_heading">Key Features</h4>
									<ul class="iec_single_news_product_features_list">
										<?php foreach ( $card_item['features'] as $feature ) : ?>
											<li><?= $feature; ?></li>
										<?php endforeach; ?>
									</ul>
								</div>
							<?php endif; ?>

							<?php if ( $card_item['link_url'] !== '' ) : ?>
								<a class="iec_single_news_product_cta" href="<?= esc_url( $card_item['link_url'] ); ?>" target="<?= esc_attr( $card_item['link_target'] ); ?>"<?= '_blank' === $card_item['link_target'] ? ' rel="noopener noreferrer"' : ''; ?>>
									<?= $card_item['link_title']; ?>
									<svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path d="M8.49219 3.41663C8.51931 3.41688 8.54751 3.42324 8.5752 3.43616C8.60296 3.44914 8.63095 3.46924 8.65625 3.49768L8.66211 3.50354L11.6621 6.76233C11.7006 6.80407 11.7315 6.86251 11.7441 6.93127C11.7567 6.99998 11.7494 7.07092 11.7256 7.13342V7.1344C11.7101 7.17536 11.6882 7.21035 11.6631 7.23792L8.66309 10.4957L8.65723 10.5026C8.63196 10.531 8.6039 10.5511 8.57617 10.5641C8.54854 10.577 8.52024 10.5833 8.49316 10.5836C8.46606 10.5839 8.4378 10.5783 8.41016 10.566C8.3825 10.5538 8.3546 10.534 8.3291 10.5065C8.30342 10.4786 8.28041 10.4428 8.26465 10.401C8.24888 10.3591 8.24083 10.3126 8.24121 10.2653C8.24163 10.2183 8.25039 10.1726 8.2666 10.1315C8.28294 10.0902 8.30614 10.0551 8.33203 10.028L8.33789 10.0211L10.0576 8.15393L10.8301 7.31506H2.5C2.44774 7.31505 2.3885 7.29271 2.33789 7.23792C2.28597 7.18153 2.25006 7.09665 2.25 7.00061C2.25 6.90447 2.28593 6.81974 2.33789 6.76331C2.38855 6.70832 2.44765 6.68617 2.5 6.68616H10.8301L10.0576 5.84729L8.33691 3.97815L8.33105 3.97229L8.29492 3.92542C8.28406 3.90828 8.27471 3.88927 8.2666 3.86877C8.25023 3.82739 8.24061 3.78131 8.24023 3.73401C8.23989 3.68681 8.24892 3.64101 8.26465 3.59924C8.2804 3.55742 8.30244 3.52167 8.32812 3.49377C8.35361 3.46614 8.3815 3.44654 8.40918 3.4342C8.43682 3.42192 8.46509 3.41638 8.49219 3.41663Z" fill="currentColor" stroke="currentColor"/></svg>
								</a>
							<?php endif; ?>
						</div>
					</article>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
