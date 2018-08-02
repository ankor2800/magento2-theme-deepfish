define([
    'jquery',
    'uiComponent',
    'mage/cookies'
], function($, Component) {
    'use strict';

    return Component.extend({
        defaults: {
            listens: {
                params: 'onParamsChange'
            }
        },

        /** @inheritdoc */
        initObservable: function() {
            this._super().observe({
                data: this.data,
                isLoading: false
            });

            return this;
        },

        /**
         * Handles changes of 'params' object.
         */
        onParamsChange: function() {
            var self = this, data = this.params;
            $.extend(data, {
                'form_key': $.mage.cookies.get('form_key')
            });

            this.isLoading(true);
            $.post(location.pathname, data, function(response) {
                self.data(response).isLoading(false);
            }, 'json');
        }
    });
});
