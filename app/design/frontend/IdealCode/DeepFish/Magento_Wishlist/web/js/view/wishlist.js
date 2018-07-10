define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function(Component, customerData) {
    'use strict';

    return Component.extend({
        wishlist: customerData.get('wishlist'),

        /**
         * Check product in wishlist
         *
         * @param id
         * @returns {boolean}
         */
        productInWishlist: function(id) {
            var items = this.wishlist().items;

            for(var index in items) {
                if(items[index].product_id == id) {
                    return items[index];
                }
            }

            return false;
        }
    });
});
