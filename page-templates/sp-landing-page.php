<?php

/**
 * Template Name: Solution and Product Landing Page
 */
$post_id    = (int) get_queried_object_id();
$acf_fields = ( $post_id && function_exists( 'get_fields' ) ) ? get_fields( $post_id ) : array();

if ( ! is_array( $acf_fields ) ) {
    $acf_fields = array();
}
$banner       = isset( $acf_fields['banner'] ) && is_array( $acf_fields['banner'] ) ? $acf_fields['banner'] : array();
$banner_image = isset( $banner['image'] ) && is_array( $banner['image'] ) ? $banner['image'] : array();
$lcp_url      = ! empty( $banner_image['url'] ) ? (string) $banner_image['url'] : '';

if ( $lcp_url !== '' ) {
    add_action(
        'wp_head',
        static function () use ( $lcp_url ) {
            printf(
                '<link rel="preload" as="image" href="%s" fetchpriority="high" />' . "\n",
                esc_url( $lcp_url )
            );
        },
        1
    );
}

get_header();
?>

<?php while (have_posts()) : the_post(); ?>

    <?php $fields = get_fields();
    ?>

    <div id="main">

        <?php
        get_template_part(
            'template-parts/market-detail/hero',
            null,
            array( 'banner' => $banner )
        );
        ?>
        <div class="iec_background_image_section iec_defualt_position iec_bg_repeat iec_bg_cover iec_bg_position_center iec_product_listing_section solutions-products-listing-widget">
            <section class="iec_product_post_filter_forms filters-form">
                <form action="" id="filters-form">
                    <input type="hidden" name="start-at" value="0">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="iec_product_post_filter_form_content">
                                    <?php if (!empty($fields['banner']['caption'])) : ?>
                                        <h1><?= $fields['banner']['caption']; ?></h1>
                                    <?php endif; ?>
                                    <h3><?php _e('We will find a tailored solution for you', 'bbtheme'); ?></h3>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="iec_search_field search-field">
                                    <a href="#" class="close"></a>
                                    <input type="text" name="keyword" id="keyword" placeholder="Search products...">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="iec_filters_group_warpper first">
                                    <div class="filters-group first">
                                        <h6><?php _e('Application', 'bbtheme'); ?></h6>
                                        <div class="toggle-fields-wrapper">
                                            <div class="toggle-fields-row cf">
                                                <?php print_ps_filter('application'); ?>
                                            </div>
                                        </div>
                                        <!-- <h6><?php _e('By Specifications', 'bbtheme'); ?></h6> -->
                                    </div>

                                    <div class="filters-group first">
                                        <h6><?php _e('Set up', 'bbtheme'); ?></h6>
                                        <div class="toggle-fields-wrapper">
                                            <div class="toggle-fields-row cf">
                                                <?php print_ps_filter('setup'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="filters-group first">
                                        <h6><?php _e('Service', 'bbtheme'); ?></h6>
                                        <div class="toggle-fields-wrapper">
                                            <div class="toggle-fields-row cf">
                                                <?php print_ps_filter('service'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="filters-group first">
                                        <h6><?php _e('Type', 'bbtheme'); ?></h6>
                                        <div class="toggle-fields-wrapper">
                                            <div class="toggle-fields-row cf">
                                                <?php print_ps_filter('type'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="iec_filters_group_warpper second">
                                    <div class="filters-group second">
                                        <h6><?php _e('Operator', 'bbtheme'); ?></h6>
                                        <div class="toggle-fields-wrapper">
                                            <div class="toggle-fields-row cf">
                                                <?php print_ps_filter('operator'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="filters-group second">
                                        <h6><?php _e('Market', 'bbtheme'); ?></h6>
                                        <div class="toggle-fields-wrapper">
                                            <div class="toggle-fields-row cf">
                                                <?php print_ps_filter('market'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="iec_filters_group_warpper third">
                                    <div class="filters-group third">
                                        <h6><?php _e('Speed', 'bbtheme'); ?></h6>
                                        <div class="toggle-fields-wrapper">
                                            <div class="toggle-fields-row cf">
                                                <?php print_ps_filter('speed'); ?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="filters-group third">
                                        <h6><?php _e('Coverage', 'bbtheme'); ?></h6>
                                        <div class="toggle-fields-wrapper">
                                            <div class="toggle-fields-row cf">
                                                <?php print_ps_filter('region'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </section>

            <div class="listing iec_products_posts_sec" id="items-listing">
                <div class="container">
                    <div class="row iec_product_posts_margin">

                    </div>

					<div class="loading-overlay">
                        <div class="loader"></div>
                    </div>

					<div class="row">
                        <div class="col-md-12">
                            <div class="load-more">
                                <div class="loader"></div>
                                <a href="#" class="iec_button iec_blue_gradient mx-auto ms-md-auto me-md-0"><?php _e('Load More', 'bbtheme'); ?></a>
                            </div>
                            <div class="no-results"><?php _e('No results found.', 'bbtheme'); ?></div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>

<?php endwhile; ?>
<script>
    jQuery(function ($) {
        var adminUrl = <?= wp_json_encode(get_ajax_url('psfilter', 'search')); ?>;
        var noResultsText = <?= wp_json_encode(__('No results found.', 'bbtheme')); ?>;
        var requestErrorText = <?= wp_json_encode(__('Error: Could not load results', 'bbtheme')); ?>;
        var urlParams = new URLSearchParams(window.location.search);
        var initialKeyword = urlParams.get('keyword') || '';

        function getOperatorSlugFromPath() {
            var path = (window.location.pathname || '').replace(/\/+$/, '');
            var segments = path.split('/').filter(function (s) {
                return s.length > 0;
            });
            var ix = -1;
            for (var i = 0; i < segments.length; i++) {
                if (String(segments[i]).toLowerCase() === 'product-solution') {
                    ix = i;
                    break;
                }
            }
            if (ix === -1 || ix + 1 >= segments.length) {
                return '';
            }
            try {
                return decodeURIComponent(String(segments[ix + 1]).replace(/\+/g, ' '));
            } catch (e) {
                return segments[ix + 1];
            }
        }

        var initialOperator = getOperatorSlugFromPath()
            || urlParams.get('operator')
            || urlParams.get('Operator')
            || '';
        var debounceDelay = 500;
        var searchTimeout = null;
        var activeRequest = null;
        var lastRequestToken = 0;

        var $form = $('#filters-form');
        var $keywordInput = $('#keyword');
        var $resultsContainer = $('.iec_product_posts_margin');
        var $loadingOverlay = $('.loading-overlay');
        var $loadMore = $('.load-more');
        var $loadMoreLoader = $loadMore.find('.loader');
        var $noResults = $('.no-results');

        function normalizeFilterValue(value) {
            return String(value || '')
                .toLowerCase()
                .trim()
                .replace(/&/g, 'and')
                .replace(/[^a-z0-9\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        function preselectOperatorFromUrl() {
            if (!initialOperator) {
                return;
            }

            var normalizedOperator = normalizeFilterValue(initialOperator);
            var $operatorToggles = $('input[name="ps_filter[operator][]"]');

            if (!$operatorToggles.length) {
                return;
            }

            var $targetToggle = $operatorToggles.filter(function () {
                var value = $(this).val();
                var dataKey = $(this).data('key');
                var normVal = normalizeFilterValue(value);
                var normKey = normalizeFilterValue(dataKey);
                return value === initialOperator
                    || dataKey === initialOperator
                    || normVal === normalizedOperator
                    || normKey === normalizedOperator;
            }).first();

            if ($targetToggle.length) {
                $targetToggle.prop('checked', true);
            }
        }

        function buildRequestData(startAt) {
            var data = {
                keyword: $.trim($keywordInput.val()),
                'start-at': startAt
            };

            $.each($form.serializeArray(), function (_, field) {
                if (field.name.indexOf('ps_filter') === -1) {
                    return;
                }

                if (!data[field.name]) {
                    data[field.name] = [];
                }

                data[field.name].push(field.value);
            });

            return data;
        }

        function createItemHTML(item) {
            var catsHTML = '';

            if (item.cats && item.cats.length) {
                catsHTML = '<div class="cats">' + item.cats.map(function (cat) {
                    return '<div class="' + cat.cat + '"><div>' + cat.label + '</div></div>';
                }).join('') + '</div>';
            }

            return (
                '<div class="col-md-6 col-lg-4 iec_product_post_box_warpper">' +
                    '<a href="' + item.href + '" class="iec_product_post_box">' +
                        '<div class="iec_product_box_image" style="background-image: url(\'' + item.thumb + '\');">' +
                            catsHTML +
                        '</div>' +
                        '<h3 class="iec_product_post_title">' + item.title + '</h3>' +
                    '</a>' +
                '</div>'
            );
        }

        function showNoResults(message) {
            $noResults.text(message || noResultsText).show();
        }

        function toggleLoader(show, isAppend) {
            if (isAppend) {
                $loadMoreLoader.toggle(show);
                return;
            }

            $loadingOverlay.toggle(show);
        }

        function handleResponse(response, append) {
            var items = response && Array.isArray(response.items) ? response.items : [];

            if (!items.length) {
                if (!append) {
                    $resultsContainer.empty();
                    showNoResults();
                }
                $loadMore.hide();
                return;
            }

            var html = items.map(createItemHTML).join('');

            if (append) {
                $resultsContainer.append(html);
            } else {
                $resultsContainer.html(html);
            }

            $loadMore.toggle(response.hasMore === true);
            $noResults.hide();
        }

        function fetchFilteredResults(startAt, append) {
            var offset = typeof startAt === 'number' ? startAt : 0;
            var shouldAppend = append === true;
            var requestToken = ++lastRequestToken;

            if (activeRequest && activeRequest.readyState !== 4) {
                activeRequest.abort();
            }

            activeRequest = $.ajax({
                url: adminUrl,
                type: 'POST',
                dataType: 'json',
                data: buildRequestData(offset),
                beforeSend: function () {
                    toggleLoader(true, shouldAppend);
                }
            })
                .done(function (response) {
                    if (requestToken !== lastRequestToken) {
                        return;
                    }
                    handleResponse(response, shouldAppend);
                })
                .fail(function (xhr, status, error) {
                    if (status === 'abort' || requestToken !== lastRequestToken) {
                        return;
                    }
                    console.error('AJAX Error:', error);
                    if (!shouldAppend) {
                        showNoResults(requestErrorText);
                    }
                })
                .always(function () {
                    if (requestToken === lastRequestToken) {
                        toggleLoader(false, shouldAppend);
                    }
                });
        }

        function resetAndFetch() {
            fetchFilteredResults(0, false);
        }

        function handleKeywordInput() {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(resetAndFetch, debounceDelay);
        }

        preselectOperatorFromUrl();
        if (initialKeyword) {
            $keywordInput.val(initialKeyword);
        }
        fetchFilteredResults(0, false);

        $keywordInput.on('input', handleKeywordInput);

        $form.on('change', '.toggle-fields-row input[type="checkbox"]', resetAndFetch);

        $loadMore.on('click', 'a', function (event) {
            event.preventDefault();
            fetchFilteredResults($('.iec_product_post_box_warpper').length, true);
        });

        $('.search-field').on('click', '.close', function (event) {
            event.preventDefault();
            $keywordInput.val('');
            resetAndFetch();
        });

        $('.filters-group').on('click', function () {
            $(this).toggleClass('expand');
        });
    });
</script>

<?php get_footer(); ?>
