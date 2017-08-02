
'use strict';


/*

 Busca por formulários com a classe "intec-ajax-form"
 Gerencia o envio e resposta
 O envio é feito com base nos atributos action e method
 A resposta é adicionada em um alert padrão na página


*/


function AjaxForm($) {
    this.$ = $;
}


AjaxForm.prototype.init = function() {
    console.log($);
}


module.exports = AjaxForm;
