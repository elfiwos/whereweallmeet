$(document).ready(function () {
    $('#upload-button-container a#banner-upload-button').click(function(e) {
        $('#upload-button-container input').click();
    });

    $("#banner-image").change(function(e){
        $("#upload-button-container span").html($(this).val());
    });
});
