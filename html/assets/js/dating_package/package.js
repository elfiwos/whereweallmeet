$(document).ready(function () {
    //$("#featured-dating-package #top > p").alternateScroll({'vertical-bar-class': 'styled-blue-v-bar', 'hide-bars': false });

    //$("#featured-dating-package #top #dating-package").alternateScroll({'vertical-bar-class': 'styled-blue-v-bar', 'hide-bars': false });

    $("form#date-idea-invitation-form").submit(function(e){
        if($("form#date-idea-invitation-form select").val() == "" || $("form#date-idea-invitation-form textarea").val().trim()=="") {
            $("div#notification-container").removeClass('alert-success');
            $("div#notification-container").addClass('alert-error');

            $("div#notification-container h4").html("Sending Date Idea Failed");
            $("div#notification-container p").html("Date Idea and Friend should be selected!");
            $("div#notification-container").showNotification();
            return false;
        }
    });


    $("div.btn-holder a.more-events").click(function(e){
        e.preventDefault();
        var count=  $(this).data("count");
        var rows = Math.ceil(count/10);
        var current_rows = $("div#event-list-container").height()/2570;
        if(rows == Math.ceil(current_rows)) {
            $("div#event-list-container").height(2570);
            return;
        }

        var previous_height = $("div#event-list-container").height();
        var remaining = count - (current_rows * 10)
        var new_height = previous_height + (remaining>10 ? 257*10 : remaining*257) ;
        $("div#event-list-container").height(new_height);
    });
});
