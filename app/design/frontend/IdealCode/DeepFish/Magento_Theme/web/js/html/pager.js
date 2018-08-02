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
                data: '${ $.parentName }:data'
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
                {[this.data.pager.page_var_name]: cur_page}
            );
        }
    });
});
