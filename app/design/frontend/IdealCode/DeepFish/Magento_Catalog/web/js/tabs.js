define([
    'jquery',
    'jquery/ui',
], function($) {
    'use strict';

    return function(config, element) {
        $(element).tabs();

        $(window).on('hashchange', function() {
            var hash = window.location.hash, $target = $(element).find(hash);

            if($target.length > 0) {
                $(element).tabs('option', 'active', $target.closest('.ui-tabs-panel').index() - 1);
            }

            if(hash) {
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 200);
            }
        }).trigger('hashchange');

        $('a.js-move').on('click', function() {
            $(window).trigger('hashchange');
        });
    };
});
