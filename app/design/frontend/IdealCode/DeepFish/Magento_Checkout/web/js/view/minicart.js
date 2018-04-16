define([
    'jquery',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function($, Component, customerData) {
    'use strict';

    return Component.extend({

        /**
         * @override
         */
        initialize: function() {
            this._super();
            this.cart = customerData.get('cart');
        },

        /**
         * Remove price label, if there is only one price value
         */
        updatePrices: function() {
            $('.minicart .prices').each(function() {
                if($(this).find('> span').length <= 1) {
                    $(this).find('> span').removeAttr('data-label');
                }
            });
        }
    });
});
