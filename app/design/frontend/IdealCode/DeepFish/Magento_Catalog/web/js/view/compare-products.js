define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function(Component, customerData) {
    'use strict';

    return Component.extend({
        compareProducts: customerData.get('compare-products'),

        /**
         * Check product in compare products
         *
         * @param id
         * @returns {boolean}
         */
        productInCompare: function(id) {
            var items = this.compareProducts().items;

            for(var index in items) {
                if(items[index].id == id) {
                    return items[index];
                }
            }

            return false;
        }
    });
});
