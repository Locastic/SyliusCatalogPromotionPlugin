'use strict';
(function ($) {
    var url = "https://cdn.jsdelivr.net/npm/dual-listbox/dist/dual-listbox.min.js";
    $.getScript(url, function () {
        var dualListbox = new DualListbox('select');
    });

}(window.jQuery));