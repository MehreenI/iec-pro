<?php
/**
 * Product grid and load-more controls for t-solution-product.
 *
 * Args: products, has_more, per_page, current_page.
 *
 * @package iec
 */

$products           = $args['products'] ?? array();
$has_more           = ! empty( $args['has_more'] );
$per_page           = $args['per_page'] ?? iec_sp_landing_per_page();
$current_page       = $args['current_page'] ?? 1;
$page_id            = $args['page_id'] ?? 0;
$post_type          = $args['post_type'] ?? 'product';
$hide_card_category = ! empty( $args['hide_card_category'] );
$search             = $args['search'] ?? '';
$is_solution        = 'solution' === $post_type;
$listing_heading    = $is_solution ? __( 'Explore All Solutions', 'bbtheme' ) : __( 'Explore All Products', 'bbtheme' );
?>
<section
        class="iec-product-solution-section"
        aria-labelledby="iec-listing-heading"
        data-sp-landing-grid
        data-page="<?= esc_attr( (string) $current_page ); ?>"
        data-per-page="<?= esc_attr( (string) $per_page ); ?>"
        data-page-id="<?= esc_attr( (string) $page_id ); ?>"
        data-post-type="<?= esc_attr( $post_type ); ?>"
>
    <div class="container">
        <div class="iec-listing-toolbar">
            <h2 id="iec-listing-heading" class="iec-primary-heading"><?= $listing_heading; ?></h2>
            <div class="iec_search_field search-field" role="search">
                <span class="search-icon" aria-hidden="true">
                    <svg width="13" height="15" viewBox="0 0 13 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M5.6721 10.7605C8.48226 10.7605 10.7603 8.48238 10.7603 5.67222C10.7603 2.86207 8.48226 0.583984 5.6721 0.583984C2.86194 0.583984 0.583862 2.86207 0.583862 5.67222C0.583862 8.48238 2.86194 10.7605 5.6721 10.7605Z" stroke="#1B204C" stroke-width="1.16837" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M12.2952 13.6184L8.54456 9.8678" stroke="#1B204C" stroke-width="1.16837" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <button type="button" class="close" aria-label="<?= __( 'Clear search', 'bbtheme' ); ?>"></button>
                <label for="keyword" class="screen-reader-text"><?= __( 'Search products', 'bbtheme' ); ?></label>
                <input
                    type="text"
                    name="keyword"
                    id="keyword"
                    value="<?= esc_attr( $search ); ?>"
                    placeholder="<?= __( 'Search products...', 'bbtheme' ); ?>"
                    autocomplete="off"
                >
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="iec-grid-wrap"<?= empty( $products ) ? ' hidden' : ''; ?>>
                    <div class="iec-grid-loader" data-sp-landing-grid-loader hidden aria-hidden="true">
                        <div class="iec-sp-landing-spinner"></div>
                    </div>
                    <div class="iec-grid" data-sp-landing-products role="list">
                        <?php
                        foreach ( $products as $product_post ) {
                            get_template_part(
                                'template-parts/sp-landing/product',
                                'card',
                                array(
                                    'post'               => $product_post,
                                    'hide_card_category' => $hide_card_category,
                                    'search'             => $search,
                                )
                            );
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="btn" data-sp-landing-actions>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="load-more"<?= ! $has_more ? ' hidden' : ''; ?>>
                    <div class="load-more__spinner iec-sp-landing-spinner" aria-hidden="true"></div>
                    <button type="button" class="iec_button iec_blue_gradient mx-auto ms-md-auto me-md-0" data-sp-landing-load-more aria-busy="false">
                        <span class="load-more__label"><?= __( 'View More', 'bbtheme' ); ?></span>
                    </button>
                </div>
                <div
                        class="iec-no-results"
                        data-sp-landing-no-results
                        role="status"
                        aria-live="polite"
                    <?= ! empty( $products ) ? ' hidden' : ''; ?>
                >
                    <div class="iec-nr-icon" aria-hidden="true">
                        <span class="disc"></span>
                        <span class="pulse"></span>
                        <span class="blip"></span>
                        <span class="iec-nr-glass">
							<svg viewBox="0 0 44 44" fill="none" xmlns="http://www.w3.org/2000/svg">
								<circle cx="18" cy="18" r="12" stroke="#1b204c" stroke-width="2.5"></circle>
								<circle cx="18" cy="18" r="12" fill="rgba(27,32,76,.05)"></circle>
								<line x1="27" y1="27" x2="38" y2="38" stroke="#1b204c" stroke-width="3" stroke-linecap="round"></line>
							</svg>
						</span>
                    </div>

                    <h3><?= __( 'No results found', 'bbtheme' ); ?></h3>
                    <p><?= __( 'No products match these filters. Try removing a few or reset to see everything.', 'bbtheme' ); ?></p>

                    <button type="button" class="iec-nr-reset" data-sp-landing-reset-filters>
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"></path><path d="M3 3v5h5"></path></svg>
                        <?= __( 'Reset filters', 'bbtheme' ); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>
