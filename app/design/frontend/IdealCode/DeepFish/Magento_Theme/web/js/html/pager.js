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
                page_var_name: '${ $.parentName }:provider.pager.page_var_name'
            },
            links: {
                params: '${ $.parentName }:params'
            }
        },

        /**
         * @param cur_page
         */
        setCurPage: function(cur_page) {
            this.params = Object.assign(
                this.params,
                {[this.page_var_name]: cur_page}
            );
        }
    });
});
