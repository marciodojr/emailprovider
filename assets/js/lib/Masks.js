var Inputmask = require('inputmask');

function Masks() {

}


Masks.prototype.init = function() {
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

    Inputmask({
        mask: ["9", "99", "999"],
        keepStatic: true,
        skipOptionalPartCharacter: ""
    }).mask($(".mask-bank-code"));

    Inputmask({
        mask: ["9", "99", "999", "9999", "99999"],
        keepStatic: true,
        skipOptionalPartCharacter: ""
    }).mask($(".mask-bank-agency"));

    Inputmask({
        mask: ["9", "99", "999", "9999", "99999", "999999", "9999999"],
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
}

Masks.prototype.initVerificationCode = function(){
  Inputmask({
    mask: ["999-999"],
    keepStatic: true,
    skipOptionalPartCharacter: ""
  }).mask($(".mask-verification-code"));
}


module.exports = Masks;
