/**
 * jQuery Unveil
 * A very lightweight jQuery plugin to lazy load images
 * http://luis-almeida.github.com/unveil
 *
 * Licensed under the MIT license.
 * Copyright 2013 Luís Almeida
 * https://github.com/luis-almeida
 */

define(['jquery'], function($) {
    /* Origin https://github.com/luis-almeida/unveil/blob/master/jquery.unveil.js */
    $.fn.rcblogunveil = function(threshold, callback) {

        var $w = $(window),
            th = threshold || 0,
            attrib = 'data-original',
            images = this,
            loaded;

        this.one("rcblogunveil", function() {
            var source = this.getAttribute(attrib);
            /*source = source || this.getAttribute("data-src");*/
            if (source) {
                /*this.setAttribute("src", source);*/
                var style = this.getAttribute('style') ? (this.getAttribute('style') + '; ') : '';
                style = style + 'background-image: url("' + source + '");'
                this.setAttribute('style', style);

                if (typeof callback === "function") callback.call(this);
            }
        });

        function rcblogunveil() {
            var inview = images.filter(function() {
                var $e = $(this);
                if ($e.is(":hidden")) return;

                var wt = $w.scrollTop(),
                    wb = wt + $w.height(),
                    et = $e.offset().top,
                    eb = et + $e.height();

                return eb >= wt - th && et <= wb + th;
            });

            loaded = inview.trigger("rcblogunveil");
            images = images.not(loaded);
        }

        $w.on("scroll.rcblogunveil resize.rcblogunveil lookup.rcblogunveil", rcblogunveil);

        rcblogunveil();

        return this;
    };
});
