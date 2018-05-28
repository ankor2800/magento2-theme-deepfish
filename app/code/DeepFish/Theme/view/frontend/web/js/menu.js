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
                my: 'left top+30',
                at: 'left bottom'
            }
        },

        /**
         * @private
         */
        _create: function() {
            this.element.find('.divider:last').remove();
            this._setupMoreMenu();
            this._bind();
        },

        /**
         * @private
         */
        _bind: function() {
            var self = this, top = 30;

            this.element.find('li').each(function() {
                var $submenu = $(this).find('> .submenu, > ul');

                if($submenu.length > 0) {
                    $(this).hover(
                        function() {
                            $submenu
                                .addClass('open')
                                .position($.extend({of: this}, self.options.position))
                                .stop()
                                .animate({
                                    opacity: 1,
                                    top: $submenu.position().top > 0 ? '-='+top : '+='+top
                                }, 300);
                        },
                        function() {
                            $submenu
                                .stop()
                                .animate({
                                    opacity: 0,
                                    top: $submenu.position().top > 0 ? '+=' + top : '-=' + top
                                }, 300, function() {
                                    $(this).removeClass('open');
                                });
                        }
                    );
                }
            });
        },

        /**
         * @private
         */
        _setupMoreMenu: function() {
            var $moreContent = this.element.children(':not(.divider)').clone();
            $moreContent.find('> .submenu > ul').unwrap();

            this.moreMenu = $('<li class="parent">')
                .append('<a href="#">' + this.options.moreText + '</a>')
                .append('<div class="submenu"><ul></ul></div>')
                .find('ul')
                .append($moreContent)
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
