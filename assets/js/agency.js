global.jQuery = $ = require('jquery');
require('bootstrap-sass');
require('bootstrap-validator');
Query = require("jquery-easing");
Inputmask = require('inputmask');

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
    })

    Inputmask({
        mask: ["(99) 9999-9999", "(99) 99999-9999"],
        keepStatic: true,
        skipOptionalPartCharacter: ""
    }).mask($(".mask-phone"));

    Inputmask({
        mask: ["9999 9999 9999 999", "9999 9999 9999 9999"],
        keepStatic: true,
        skipOptionalPartCharacter: ""
    }).mask($(".mask-creditcard"));

    Inputmask({
        mask: ["999", "9999"],
        keepStatic: true,
        skipOptionalPartCharacter: ""
    }).mask($(".mask-cvv"));

    Inputmask({
        mask: ["99/99"],
        keepStatic: true
    }).mask($(".mask-cc-expiration"));

    Inputmask({
        mask: ["999.999.999-99"],
        keepStatic: true
    }).mask($(".mask-cpf"));

    Inputmask({
        mask: ["999.999.999-99", "99.999.999/9999-99"],
        keepStatic: true,
        skipOptionalPartCharacter: ""
    }).mask($(".mask-cpf-cnpj"));

    Inputmask({
        mask: ["9", "99", "999"],
        keepStatic: true,
        skipOptionalPartCharacter: ""
    }).mask($(".mask-bank-code"));

    Inputmask({
        mask: ["99999-999"],
        keepStatic: true
    }).mask($(".mask-zip"));

    Inputmask({
        mask: ["99/99/9999"],
        keepStatic: true
    }).mask($(".mask-date"));

    Inputmask('decimal',{
        radixPoint: ",",
        groupSeparator: ".",
        digits: 2,
        digitsOptional: false,
        autoGroup: true,
        placeholder: '0',
        prefix: 'R$ '
    }).mask($(".mask-money"));

    Inputmask('decimal',{
        radixPoint: ",",
        groupSeparator: ".",
        digits: 2,
        digitsOptional: false,
        autoGroup: true,
        placeholder: '0,00'
    }).mask($(".mask-money-no-currency"));

    $(".intec-form-validator").validator({
        feedback: {
            success: 'icon-check',
            error: 'icon-cross'
        }
    })

})(jQuery);
