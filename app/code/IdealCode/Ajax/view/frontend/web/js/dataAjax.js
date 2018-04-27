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

                $.post($(this).data('ajax')['action'], data);
                return false;
            });
        }
    });

    return $.idealcode.dataAjax;
});
