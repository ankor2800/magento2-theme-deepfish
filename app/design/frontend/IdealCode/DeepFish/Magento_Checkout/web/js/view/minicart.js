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
        }
    });
});
