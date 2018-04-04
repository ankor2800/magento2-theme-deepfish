define([
    'jquery',
    'dropdownDialog'
], function($) {
    'use strict';

    $.widget('deepfish.dropdownDialogEx', {

        /**
         * Init widget
         * @private
         */
        _create: function() {
            var self = this;

            this.element.each(function() {
                $(this).dropdownDialog($.extend({
                    'appendTo': $(this).parent(),
                    'triggerTarget': $(this).parent().find('.action')
                }, self.options));
            });

            this.element.on('click', '.close', function() {
                self.element.dropdownDialog('close');
                return false;
            });
        }
    });

    return $.deepfish.dropdownDialogEx;
});
