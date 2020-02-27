$(document).ready(function () {

    $("div.message-del a").click(function(e) {
        e.preventDefault();

        var action_url = $(this).data("action");
        var $message_container =  $("div#" + $(this).data("message-container"));
        var message_id = $(this).data("message-id");
        var message_section = $(this).data("message-section");
        var $this = $(this);

        $.post(action_url, {
            message_id: message_id,
            message_section: message_section
        }, function(data) {
            var heading = data.status ? "Success" : "Error";
            if(data.status) {
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }

            if(message_section == "inbox-detail") {
                window.location.replace($this.data("inbox-url"));
            } else {
                $message_container.remove();
                if($("div.message-detail-wrapper").children().length === 0 ){
                    $("div.message-detail-wrapper").append("<p>No Messages!</p>");
                }
            }

            $("div#notification-container h4").html(heading);
            $("div#notification-container p").html(data.message);
            $("div#notification-container").showNotification();

        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occurred while trying to delete record. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });
    });

    $(".sent-message-read-more").showDialog();
    $("#compose-popup-container").hide();


    $("#messages_header a").click(function(e){
            e.preventDefault();
           $("#compose-popup-container").show();
    });
    
});

$.fn.showDialog = function() {
    $(this).click(function(e) {
        e.preventDefault();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        })
        $(".overlay, .close-dialog").closeDialog();
        var dialog_id = "#" + $(this).data("dialog");
        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    });
};

$.closeDialogWindow = function(){
    $("body").append($(".overlay div.dialog"));
    $("div.dialog").hide();
    $(".overlay").detach();
};
function check(e) {
var target = (e && e.target) || (event && event.srcElement);
var obj = document.getElementById('compose-popup-container');
var obj2 = document.getElementById('btn');
checkParent(target) ? obj.style.display = 'none' : null;
target == obj2 ? obj.style.display = 'block' : null;
}

function checkParent(t) {
while (t.parentNode) {
if (t == document.getElementById('compose-popup-container')) {
return false
} else if (t == document.getElementById('close')) {
return true
}
t = t.parentNode
}
return true
}