define([
    'jquery',
    'uiComponent'
], function($, Component) {
    'use strict';

    return Component.extend({
        /** @inheritdoc */
        initObservable: function() {
            this._super().observe({
                items: [],
                isLoading: false
            });

            return this;
        },

        /**
         * Get products for autocomplete
         * @param {string} value
         * @returns {boolean}
         */
        ajaxLoad: function(value) {
            var self = this;

            if ($('[name='+this.helper.name+']').closest('form').valid() === false)
            {
                this.items([]);
                return true;
            }

            if ($.trim(value).length >= 3) {
                this.isLoading(true);
                $.get(this.ajax, {[this.helper.name] : $.trim(value)}, function (data) {
                    self.items(data).isLoading(false);
                });
            }

            return true;
        },

        /**
         * Data reset after close dropdown
         * @param form
         */
        resetSearch: function (form) {
            this.items([]);
            $(form).find('[name='+this.helper.name+']').val(this.helper.value);
            $(form).validate().resetForm();
        }
    });
});
