define([
    'jquery',
    'jquery/validate',
    'mage/validation'
], function($) {
    'use strict';

    /**
     * Toggle message class 'active' for CSS animations
     */
    var defaultShowErrors = $.validator.prototype.defaultShowErrors;
    $.extend($.validator.prototype, {
        defaultShowErrors: function() {
            defaultShowErrors.call(this);
            this.addWrapper(this.toShow).addClass('active');
        },
        hideErrors: function() {
            this.addWrapper(this.toHide).removeClass('active');
        }
    });

    return $.mage.validation;
});
