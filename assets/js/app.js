global.jQuery = $ = require('jquery');
require('bootstrap-sass');
require("jquery-easing");
AjaxForm = require('./lib/AjaxForm');
FormValidator = require('./lib/FormValidator');
ZipFinder = require('./lib/ZipFinder');
global.FormFiller = require('./lib/FormFiller');
global.PrettyAlerts = require('./lib/PrettyAlerts');

var cf = require("./lib/CurrencyFormatter");
global.Vue = require("vue/dist/vue.common");
Vue.filter('moneyFormatter', function (value) {
    if (!value)
        return '';
    return cf.floatToCurrency(value);
});

VueTheMask = require('vue-the-mask');
Vue.use(VueTheMask);

(function($){
    "use strict"; // Start of use strict

    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - 50)
        }, 1250, 'easeInOutExpo');
        event.preventDefault();
    });

    // Highlight the top nav as scrolling occurs
    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 51
    });

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function(){
        $('.navbar-toggle:visible').click();
    });

    // Offset for Main Navigation
    $('#mainNav').affix({
        offset: {
            top: 100
        }
    });

    $("#ajaxFormAlert").on('click', '.close', function(){
        $(this).closest("#ajaxFormAlert").hide();
    });

    PrettyAlerts.init();
    AjaxForm.init('.intec-ajax-form');
    FormValidator.init('.intec-form-validator');

})(jQuery);
