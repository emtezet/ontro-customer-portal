'use strict';

// Include jquery
import $ from 'jquery';

// Include Bootstrap
import 'bootstrap';

//Include Google Fon Awesome
//import '@fortawesome/fontawesome-free/css/all.min.css';

import '../scss/layout.scss';

// FOSJsRoutingBundle functionality
const routes = require('../../fos_js_routes.json');
import Routing from '../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router';
Routing.setRoutingData(routes);
window.Routing = Routing;

window.showErrorModal = function(errorsMessagesArray, reload = false){
    $("#info-modal-body").empty();
    errorsMessagesArray.forEach(function(element){
        $("#info-modal-body").append('<div class="alert alert-danger" role="alert">'+element+'</div>');
    });
    $('#info-modal').modal('show');

    if(reload === true) {
        $('#info-modal').on('hidden.bs.modal', function (e) {
            window.location.reload();
        })
    }
};

window.showSuccessModal = function(successMessage,reload = false){
    $("#info-modal-body").empty().append('<div class="alert alert-success" role="alert">'+successMessage+'</div>');
    $('#info-modal').modal('show');

    if(reload === true) {
        $('#info-modal').on('hidden.bs.modal', function (e) {
            window.location.reload();
        })
    }
};

//Confirm Modal
window.showConfirmModal = function(confirmMessage,yesCallbackFunction,params){
    $("#confirm-modal-body").empty().append('<div class="alert alert-warning" role="alert">'+confirmMessage+'</div>');
    $("#confirm-modal-yes-btn").unbind( "click" ).click(function(){
        yesCallbackFunction.apply(this,params);
    });

    $('#confirm-modal').modal('show');
};

window.actionAjaxEditUser = function(button) {
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
                window.location.replace(Routing.generate('homepage'));
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
                window.location.replace(Routing.generate('homepage'));
            }

        }
    });
};








