define([
    'jquery',
    'mage/translate'
], function($) {
    'use strict';

    $.widget('deepfish.menu', {
        options: {
            container: '#menu',
            moreText: $.mage.__('more'),
            position: {
                my: 'left top',
                at: 'left bottom'
            }
        },

        /**
         * @private
         */
        _create: function() {
            var self = this;
            this._setupMoreMenu();

            this.element.find('li').hover(
                function() {
                    $(this)
                        .addClass('focus')
                        .find('> .submenu')
                        .position($.extend({of: this}, self.options.position));
                },
                function() {
                    $(this).removeClass('focus');
                }
            );
        },

        /**
         * @private
         */
        _setupMoreMenu: function() {
            this.element.find('.divider:last').remove();

            this.moreMenu = $('<li class="parent">')
                .append('<a href="#">' + this.options.moreText + '</a>')
                .append('<div class="submenu"><ul></ul></div>')
                .find('ul')
                .append(this.element.children().not('.divider').clone())
                .end()
                .appendTo(this.element);

            this.moreMenu.find('> a').on('click', function() {
                return false;
            });

            $(window).on('resize', $.proxy(this._responsive, this)).resize();
        },

        /**
         * @private
         */
        _responsive: function() {
            var $moreLinks = this.moreMenu.find('> .submenu > ul > li');

            // init value
            $moreLinks.hide();
            this.element.children('li').show();
            this.moreMenu.hide();

            // check overflow
            if($(this.options.container).outerWidth(true) < this.element.outerWidth(true)) {
                this.moreMenu.show();
                var containerSize = $(this.options.container).outerWidth(true) - this.moreMenu.outerWidth(true),
                    width = 0;

                $.each(this.element.children('li').not('.divider').not(this.moreMenu), function(index) {
                    width += $(this).outerWidth(true) + $(this).next('.divider').outerWidth(true);
                    if(width > containerSize) {
                        $(this).add($(this).next('.divider')).hide();
                        $moreLinks.eq(index).show();
                    }
                });
            }
        }
    });

    return $.deepfish.menu;
});
