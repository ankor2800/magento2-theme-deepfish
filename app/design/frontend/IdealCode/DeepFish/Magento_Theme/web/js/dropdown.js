define([
    'jquery'
], function($) {
    'use strict';

    $.widget('deepfish.dropdown', {

        /**
         * Init widget
         * @private
         */
        _create: function() {
            var self = this,
                events = {};

            events['click .close'] = function() {
                self.element.dropdownDialog('close');
                return false;
            };

            this._on(this.element, events);
        }
    });

    return $.deepfish.dropdown;
});
