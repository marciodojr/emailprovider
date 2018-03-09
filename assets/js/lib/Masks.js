var Inputmask = require('inputmask');

function Masks() {
}


Masks.init = function() {
    Inputmask({
      mask: ["999-999"],
      keepStatic: true,
      skipOptionalPartCharacter: ""
    }).mask($(".mask-verification-code"));

    Inputmask({
        mask: ["(99) 9999-9999", "(99) 99999-9999"],
        //keepStatic: true,
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

    // Inputmask({
    //     mask: ["9", "99", "999"],
    //     keepStatic: true,
    //     skipOptionalPartCharacter: ""
    // }).mask($(".mask-bank-code"));

    Inputmask({
        mask: ["9999"],
        keepStatic: true,
        skipOptionalPartCharacter: ""
    }).mask($(".mask-bank-agency"));

    Inputmask({
        mask: ["99", "999", "9999", "99999", "999999", "9999999", "99999999", "999999999", "9999999999", "99999999999", "99999999999", "99999999999" ],
        keepStatic: true,
        skipOptionalPartCharacter: ""
    }).mask($(".mask-bank-account"));

    Inputmask({
        mask: ["99999-999"],
        keepStatic: true
    }).mask($(".mask-zip"));

    Inputmask({
        mask: ["99/99/9999"],
        keepStatic: true
    }).mask($(".mask-date"));

    Inputmask({
        mask: ["99-99-9999"],
        keepStatic: true
    }).mask($(".mask-date-trace"));

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

    Inputmask('decimal',{
        radixPoint: ",",
        groupSeparator: ".",
        digits: 0,
        digitsOptional: false,
        autoGroup: true,
        placeholder: '0'
    }).mask($(".mask-money-no-currency-no-cent"));

    $(".mask-at-most").on("change", "input[type=checkbox]", function(){
        var $anchor = $(this);
        var name = $anchor.attr('name');
        var $atMost = $(this).closest('.mask-at-most');
        var number = $atMost.attr('data-mask-at-most');
        var isOk = $atMost.find("input[name=\""+name+"\"]").filter(":checked").length <= number;

        console.log('asdasd ', $atMost.find("input[name=\""+name+"\"]").filter(":checked").length, number);

        if(!isOk) {
            if($anchor.is(":checked")) {
                $anchor.prop("checked", false);
                $anchor.trigger("change");
            }
        }
    });

    Inputmask({
        mask: ["999-999"],
        keepStatic: true,
        skipOptionalPartCharacter: ""
    }).mask($(".mask-verification-code"));
}

module.exports = Masks;
