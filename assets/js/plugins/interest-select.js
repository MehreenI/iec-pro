(function ($) {
    'use strict';

    $.fn.interestSelect = function () {
        const placeholder = $('#interest-label').text();

        return this.each(function () {
            $(this).select2({
                placeholder           : placeholder,
                multiple              : true,
                maximumSelectionLength: 5,
                allowClear            : true,
                width                 : '100%',
                dropdownParent        : $(this).parent(),
            });
        });
    };

})(jQuery);
