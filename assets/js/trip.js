'use strict';

window.actionAjaxTripAdd = function(button) {
    var $form = $(button).parents('form');

    $.ajax({
        type: $form.attr('method'),
        url: $form.attr('action'),
        data: $form.serialize(),
        statusCode: {
            201: function(data, textStatus, jqXHR){
                showSuccessModal(data['successMessage'],true);
            },
            400: function(data, textStatus, jqXHR) {
                var errorData = JSON.parse(data.responseText);
                showErrorModal(errorData['errors']);
            },
            403: function(){
                //window.location.replace(Routing.generate('trip_page_add'));
            }
        },
        beforeSend: function () {
            //$(button).append('<i class="btn-spinner fas fa-spinner fa-spin"></i>');
        },
        complete: function(){
            //$(button).children('.btn-spinner').remove();
        },
        error: function(data, textStatus, jqXHR) {
            if(data.status !== 400) {
                //window.location.replace(Routing.generate('trip_page_add'));
            }

        }
    });
};

window.actionAjaxTripRemove = function(id, button){
    $.ajax({
        type: 'POST',
        url: Routing.generate('trip_action_ajax_remove'),
        data: {trip_id: id},
        statusCode: {
            201: function(data, textStatus, jqXHR){
                showSuccessModal(data['successMessage'],true);
            },
            400: function(data, textStatus, jqXHR) {
                var errorData = JSON.parse(data.responseText);
                showErrorModal(errorData['errors']);
            },
            403: function(){
                //window.location.replace(Routing.generate('passenger_page_add'));
            }
        },
        beforeSend: function () {
            //$(button).append('<i class="btn-spinner fas fa-spinner fa-spin"></i>');
        },
        complete: function(){
            //$(button).children('.btn-spinner').remove();
        },
        error: function(data, textStatus, jqXHR) {
            if(data.status !== 400) {
                //window.location.replace(Routing.generate('passenger_page_add'));
            }

        }
    });
};