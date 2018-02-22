
function AjaxForm() {

}


AjaxForm.prototype.init = function(form) {
    var $forms = $(form);
    if(!$forms.length) {
        return;
    }

    $alert = $("#ajaxFormAlert");
    $alert.find('#alert-close').one(function(){
        $alert.hide();
    });

    $forms.submit(function(){
        $f = $(this);
        var action = $(this).attr('action');
        var method = $(this).attr('method');
        var noSuccessAlert = !$(this).attr('data-no-default-success');
        var showErrorAlert = !$(this).attr('data-no-default-error');
        var data;

        $alert
            .removeClass('alert-info')
            .removeClass('alert-danger')
            .removeClass('alert-success')
            .hide();

        var ajaxConfig = {
            url: action,
            method: method,
            success: function (response) {
                if(!noSuccessAlert) {
                    $alert
                        .addClass('alert-success')
                        .find('#alertFeedbackText')
                        .html(response.message || 'Operação executada com sucesso!');
                    $alert.show();
                }
                $f.trigger('ajaxForm:submitSuccess', response);
            },
            error: function (jqXHR) {
                res = jqXHR.responseJSON;
                $alert
                    .addClass('alert-danger')
                    .find('#alertFeedbackText')
                    .html(res.errorMessage || 'Oops! Ocorreu um erro inesperado =(');
                $alert.show();
                $f.trigger('ajaxForm:submitError', jqXHR);
            },
            dataType: 'json'
        };

        if ($(this).attr('enctype') === 'multipart/form-data') {
            ajaxConfig.contentType = false;
            ajaxConfig.processData = false;
            data = new FormData(this);
        } else {
            data = $(this).serialize();
        }

        ajaxConfig.data = data;
        $.ajax(ajaxConfig);

        return false;
    });
}

module.exports = AjaxForm;
