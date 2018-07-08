define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function(Component, customerData) {
    'use strict';

    return Component.extend({
        cart: customerData.get('cart'),

        /**
         * Check product in cart
         *
         * @param id
         * @returns {boolean}
         */
        productInCart: function(id) {
            for(var index in this.cart().items) {
                if(this.cart().items[index].product_id == id) {
                    return this.cart().items[index];
                }
            }

            return false;
        }
    });
});
