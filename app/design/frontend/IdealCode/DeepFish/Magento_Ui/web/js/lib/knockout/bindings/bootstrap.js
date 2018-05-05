define(function (require) {
    'use strict';

    var renderer = require('../template/renderer');

    renderer.addAttribute('repeat', renderer.handlers.wrapAttribute);

    renderer.addAttribute('outerfasteach', {
        binding: 'fastForEach',
        handler: renderer.handlers.wrapAttribute
    });

    renderer
        .addNode('repeat')
        .addNode('fastForEach');

    return {
        i18n:           require('./i18n'),
        scope:          require('./scope'),
        mageInit:       require('./mage-init'),
        aferRender:     require('./after-render'),
        repeat:         require('knockoutjs/knockout-repeat'),
        fastForEach:    require('knockoutjs/knockout-fast-foreach')
    };
});
