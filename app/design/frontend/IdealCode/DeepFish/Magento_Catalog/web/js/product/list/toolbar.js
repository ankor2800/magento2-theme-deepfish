define([
    'uiComponent',
    'mage/translate'
], function(Component, $t) {
    'use strict';

    return Component.extend({
        defaults: {
            tracks: {
                params: true
            },
            imports: {
                data: '${ $.parentName }:data'
            },
            links: {
                params: '${ $.parentName }:params'
            }
        },

        /**
         * @param cur_mode
         */
        setCurMode: function(cur_mode) {
            this.params = Object.assign(
                this.params,
                {[this.data.toolbar.mode_var_name]: cur_mode}
            );
        },

        /**
         * @param cur_order
         */
        setCurOrder: function(cur_order) {
            this.params = Object.assign(
                this.params,
                {[this.data.toolbar.order_var_name]: cur_order}
            );
        },

        /**
         * @param cur_direction
         */
        setCurDirection: function(cur_direction) {
            this.params = Object.assign(
                this.params,
                {[this.data.toolbar.direction_var_name]: cur_direction}
            );
        },

        /**
         * @param cur_limit
         */
        setCurLimit: function(cur_limit) {
            this.params = Object.assign(
                this.params,
                {[this.data.toolbar.limit_var_name]: cur_limit}
            );
        },

        /**
         * Get amount label
         */
        getAmount: function() {
            var label = '%1-%2 of %3', toolbar = this.data.toolbar;

            if((toolbar.total_num == toolbar.last_num) && (toolbar.first_num == 1)) {
                label = toolbar.total_num > 1 ? '%3 Items' : '%3 Item';
            }

            return $t(label)
                .replace('%1', this.data.toolbar.first_num)
                .replace('%2', this.data.toolbar.last_num)
                .replace('%3', this.data.toolbar.total_num);
        }
    });
});
