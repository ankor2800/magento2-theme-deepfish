define([
    'uiComponent'
], function(Component) {
    'use strict';

    return Component.extend({
        defaults: {
            tracks: {
                params: true
            },
            imports: {
                toolbar: '${ $.parentName }:provider.toolbar'
            },
            links: {
                params: '${ $.parentName }:params'
            }
        },

        /**
         * @param cur_order
         */
        setCurOrder: function(cur_order) {
            this.params = Object.assign(
                this.params,
                {[this.toolbar.order_var_name]: cur_order}
            );
        },

        /**
         * @param cur_direction
         */
        setCurDirection: function(cur_direction) {
            this.params = Object.assign(
                this.params,
                {[this.toolbar.direction_var_name]: cur_direction}
            );
        }
    });
});
