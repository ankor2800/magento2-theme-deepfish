define([
    'jquery',
    'mage/cookies'
], function($) {
    'use strict';

    $.widget('idealcode.dataAjax', {

        /**
         * Init widget
         * @private
         */
        _create: function() {
            this.element.on('click', 'a[data-ajax]', function() {
                var data = $(this).data('ajax')['data'];
                $.extend(data, {
                    'form_key': $.mage.cookies.get('form_key')
                });

                $(this).trigger('processStart');
                $.post($(this).data('ajax')['action'], data);

                return false;
            });

            // Remove loader
            $(document).on('customer-data-reload', function() {
                $(this).find('[data-role-preloader]').trigger('processStop');
            });
        }
    });

    return $.idealcode.dataAjax;
});
