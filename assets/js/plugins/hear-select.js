(function ($) {
    'use strict';

    $.fn.hearSelect = function () {
        const placeholder = $('#hear-source-label').text();

        return this.each(function () {
            $(this).select2({
                placeholder   : placeholder,
                allowClear    : true,
                width         : '100%',
                dropdownParent: $(this).parent(),
            });
        });
    };

})(jQuery);
