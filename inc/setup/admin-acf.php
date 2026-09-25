<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class Custom_ACF {

    public function __construct() {
        add_action( 'admin_head', array( $this, 'accordion_style' ) );
        add_action( 'admin_footer', array( $this, 'acf_script' ) );
        add_action( 'acf/input/admin_footer', array( $this, 'dynamicTable' ) );
    }

    public function accordion_style()
    {
        ?>
        <style>
            .acf-label.acf-accordion-title:hover {
                background-color: #003b4d9e;
                color: white;
            }

            .acf-accordion.-open .acf-label.acf-accordion-title {
                background-color: #003B4D;
                color: white;
            }
            .acf-fc-layout-actions-wrap {
                background: #003B4D !important;
                color: white;
            }
            .acf-fc-layout-actions-wrap:hover{
                background: #003b4d9e !important;
            }

            span.acf-fc-layout-title {
                color: white
            }

            .acf-button.button.button-primary {
                background: #003B4D !important;
                border-color: #003B4D;
            }

            .acf-fc-layout-controls a , .acf-fc-layout-controls a span.acf-icon{
                color: white !important;
            }
            .acf-fc-layout-controls a span.acf-icon{
                background: white !important;
            }
            .acf-th{
                width: auto !important;
            }
        </style>
        <?php

    }

    public function acf_script()
    {
        ?>
        <script>
            jQuery(document).ready(function ($) {

                var $checkbox = $('#acf-field_696e3fd62f4d7');
                var $newGroup = $('#acf-group_694e9b0027427');
                var $oldGroup = $('#acf-group_5dba6849d4efe');
                var $maritime = $("#acf-field_ps_filter_application-maritime");
                var $land = $("#acf-field_ps_filter_application-land");
                var $accordion_maritime = $('.acf-field-69526ffd7aa6b');
                var $accordion_land = $(".acf-field-6952736b90744");
                var $starlink = $("#acf-field_ps_filter_operator-starlink");

                if (!$checkbox.length) return;

                function toggleACFGroups() {
                    if ($checkbox.is(':checked')) {
                        $newGroup.show();
                        $oldGroup.hide();
                    } else {
                        $newGroup.hide();
                        $oldGroup.show();
                    }

                    if ($maritime.is(':checked')) {
                        $accordion_maritime.show();
                    } else {
                        $accordion_maritime.hide();
                    }

                    if ($land.is(':checked')) {
                        $accordion_land.show();
                    } else {
                        $accordion_land.hide();
                    }

                    if ($starlink.is(':checked')) {
                        $("#coverage-map-img").hide();
                        $("#starlink-map").show();
                    } else {
                        $("#coverage-map-img").show();
                        $("#starlink-map").hide();
                    }
                }

                toggleACFGroups();

                $checkbox.on('change', toggleACFGroups);
                $maritime.on('change', toggleACFGroups);
                $land.on('change', toggleACFGroups);
                $starlink.on('change', toggleACFGroups);

            });
        </script>
        <?php

    }

    public function dynamicTable()
    {
        ?>
        <script type="text/javascript">
            (function ($) {

                if (typeof acf === 'undefined') return;

                acf.addAction('ready', function () {
                    initAllDynamicTables();
                });

                acf.addAction('append', function ($el) {
                    setTimeout(function () {
                        initAllDynamicTables();
                    }, 300);
                });

                function initAllDynamicTables() {
                    $('.layout[data-layout="dynamic_table_builder"]').each(function () {
                        initDynamicTable($(this));
                    });
                }

                function initDynamicTable($layout) {
                    if ($layout.data('table-init')) return;
                    $layout.data('table-init', true);

                    var $rowsField = $layout.find('[data-name="number_of_rows"] input');
                    var $colsField = $layout.find('[data-name="number_of_columns"] input');
                    var $repeater = $layout.find('[data-name="table"]');

                    if (!$rowsField.length || !$colsField.length || !$repeater.length) return;

                    $rowsField.on('change input', function () {
                        var rows = parseInt($(this).val()) || 0;
                        if (rows > 0) {
                            adjustRows($repeater, rows);
                        }
                    });

                    $colsField.on('change input', function () {
                        var cols = parseInt($(this).val()) || 0;
                        if (cols > 0 && cols <= 8) {
                            adjustColumns($repeater, cols);
                        }
                    });

                    setTimeout(function () {
                        var initialCols = parseInt($colsField.val()) || 0;
                        var initialRows = parseInt($rowsField.val()) || 0;

                        if (initialCols > 0) {
                            adjustColumns($repeater, initialCols);
                        }
                        if (initialRows > 0) {
                            adjustRows($repeater, initialRows);
                        }
                        highlightHeaderRow($repeater);
                    }, 500);
                }

                function adjustRows($repeater, targetRows) {
                    var $tbody = $repeater.find('tbody');
                    var $existingRows = $tbody.find('.acf-row:not(.acf-clone)');
                    var currentRows = $existingRows.length;

                    if (currentRows < targetRows) {
                        var $addButton = $repeater.find('.acf-actions .acf-repeater-add-row, .acf-actions [data-event="add-row"]');

                        for (var i = currentRows; i < targetRows; i++) {
                            $addButton.trigger('click');
                        }
                    }

                    if (currentRows > targetRows) {
                        $existingRows.slice(targetRows).each(function () {
                            $(this).find('[data-event="remove-row"]').trigger('click');
                        });
                    }

                    setTimeout(function () {
                        highlightHeaderRow($repeater);
                    }, 200);
                }

                function adjustColumns($repeater, targetCols) {

                    var columnFields = [
                        'column_1', 'column_2', 'column_3', 'column_4',
                        'column_5', 'column_6', 'column_7', 'column_8'
                    ];

                    $repeater.find('thead th').each(function () {
                        var $th = $(this);
                        var dataName = $th.data('name');

                        if (!dataName) return; // Skip handle columns

                        var colIndex = columnFields.indexOf(dataName);
                        if (colIndex !== -1) {
                            if (colIndex < targetCols) {
                                $th.show();
                            } else {
                                $th.hide();
                            }
                        }
                    });

                    $repeater.find('tbody tr').each(function () {
                        var $row = $(this);

                        columnFields.forEach(function (fieldName, index) {
                            var $cell = $row.find('[data-name="' + fieldName + '"]');
                            if (index < targetCols) {
                                $cell.show();
                            } else {
                                $cell.hide();
                            }
                        });
                    });
                }

                function highlightHeaderRow($repeater) {
                    var $rows = $repeater.find('tbody .acf-row:not(.acf-clone)');

                    $rows.removeClass('dtb-header-row');

                    $rows.first().addClass('dtb-header-row');
                }

            })(jQuery);

        </script>
        <?php

    }
}

new Custom_ACF();

add_action( 'admin_footer', function() {
    $screen = get_current_screen();
    if ( ! $screen || 'page' !== $screen->post_type ) {
        return;
    }
    ?>
    <script>
    jQuery(document).ready(function($) {
        var $newDesign = $('#acf-field_6a62107fa2b91');
        var $template  = $('#page_template');

        function toggleTemplate() {
            var newValue = $newDesign.is(':checked')
                ? 'page-templates/offshore-page.php'
                : 'page-templates/market-detail-page.php';

            if ($template.val() !== newValue) {
                $template.val(newValue);
                $template.trigger('change');
                var el = $template.get(0);
                if ( el ) {
                    el.dispatchEvent(new Event('change', { bubbles: true }));
                }
            }
        }

        $newDesign.on('change', toggleTemplate);
    });
    </script>
    <?php
} );
