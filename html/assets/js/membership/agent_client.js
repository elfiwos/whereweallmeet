$(document).ready(function(){

    $("#upgrade-form").submit(function(e){
        if(!$.fn.form_validate()){
            e.preventDefault();
        }
    });

});

$.fn.form_validate = function(){
    var response = true;

    $("#upgrade-form .required").each(function(){
        if(!$(this).val()){
            $(this).siblings('span.error').show().css({
                display: "block"
            });
            response = false;
        } else {
            $(this).siblings('span.error').hide();
        }
    });

    if($("#agree-to-terms:checked").length == 0){
        $("p.agreement span.error").show().css({
            display: "block"
        });
        response = false;
    } else {
        $("p.agreement span.error").hide();
    }

    $("#upgrade-form input.email").each(function(){
        var pattern = /[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/igm;
        var email = $(this).val();
        if(!email.match(pattern)){
            $(this).siblings('span.email').show().css({
                display: "block"
            });
            response = false;
        } else {
            $(this).siblings('span.error').hide();
        }
    });

    return response;
};