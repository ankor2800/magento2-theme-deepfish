define([
    'ko',
    'jquery',
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function(ko, $, Component, customerData) {
    'use strict';

    return Component.extend({
        miniCart: $('.minicart'),
        cart: customerData.get('cart'),
        errorMessage: ko.observable(''),

        /**
         * @override
         */
        initialize: function() {
            this._super();
            this._setQuantityFormActions();
        },

        /**
         * Remove price label, if there is only one price value
         */
        updatePrices: function() {
            this.miniCart.find('.prices').each(function() {
                if($(this).find('> span').length <= 1) {
                    $(this).find('> span').removeAttr('data-label');
                }
            });
        },

        /**
         * @private
         */
        _setQuantityFormActions: function() {
            var self = this;

            // Show submit link only if form is valid
            this.miniCart.on('keyup', '.qty input', function() {
                var $form = $(this).closest('form');
                if($form.valid() && ($(this).val() != $(this).data('value'))) {
                    $form.find('.submit').addClass('active');
                } else {
                    $form.find('.submit').removeClass('active');
                }
            });

            this.miniCart.on('click', '.qty .submit', function() {
                $(this).closest('form').submit();
                return false;
            });

            // Ajax request if form is valid
            this.miniCart.on('submit', '.qty', function() {
                if($(this).valid()) {
                    $.post($(this).attr('action'), $(this).serialize(), function(response) {
                        self.errorMessage(response.error_message || '');
                    }, 'json');
                }
                return false;
            });

            // Reset error messages and return input values
            this.miniCart.on('dropdowndialogclose', function() {
                self.errorMessage('').miniCart.find('.qty input').each(function() {
                    $(this).val($(this).data('value')).valid();
                });
            });
        }
    });
});
