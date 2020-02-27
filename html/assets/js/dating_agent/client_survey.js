$(document).ready(function () {
    $('div.client_detail a.client_read_more').click(function(e){
        e.preventDefault();

        if($(this).text() == "Read More >") {
            $("div#about-me-full-content p.full_text").show();
            $("div#about-me-full-content p.partial_text").hide();
            $(this).text('< Read Less');
        } else {
            $("div#about-me-full-content p.full_text").hide();
            $("div#about-me-full-content p.partial_text").show();
            $(this).text('Read More >');
        }

    });

    $("a#btn-refer-me").showReferMeDialog();

    $("form#refer-form").submit(function(e) {
        e.preventDefault();
        $.post(this.action, $(this).serialize(), function(data) {
            if(data.status) {
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');

                $("div#notification-container h4").html("Refer Me");
                $("div#notification-container p").html(data.message);
                $("div#notification-container").showNotification();
                $.clearDialogForm();
                $.closeDialogWindow();
            }else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');

                $("div#notification-container h4").html("Refer Me");
                $("div#notification-container p").html(data.message);

                $("div#notification-container").showNotification();
            }
        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occured while trying to refer a friend. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });
        e.preventDefault();
    });
});

$.fn.showReferMeDialog = function() {
    $(this).click(function(e) {
        e.preventDefault();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        })
        $(".overlay, .close-dialog").closeDialog();

        var dialog_id = "#refer-popup-container";

        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    });
};