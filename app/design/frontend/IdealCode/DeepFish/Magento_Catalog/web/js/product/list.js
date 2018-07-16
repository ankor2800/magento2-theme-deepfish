define([
    'uiComponent'
], function(Component) {
    'use strict';

    return Component.extend({
        /** @inheritdoc */
        initObservable: function() {
            this._super().observe(['data']);

            return this;
        }
    });
});
