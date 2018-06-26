define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function(Component, customerData) {
    'use strict';

    return Component.extend({
        /** @inheritdoc */
        initialize: function() {
            this._super();

            this.recentlyProducts = customerData.get(this.dataSection);
            this.productDataStorage = customerData.get('product_data_storage');
        }
    });
});
