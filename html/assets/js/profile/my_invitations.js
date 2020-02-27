$(document).ready(function () {
    $("div.invitation-listings a.event-invite").click(function(e) {
        var $button = $(this);
        var action_url = $(this).data('action');
        var invitation_id =  $(this).data('my-invitation-id');
        var status = $(this).data("status");
        $.post(action_url, {
            invitation_id: invitation_id,
            status: status
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
            if(status == "rejected") {
                $button.parent().parent().parent().remove();
            }
            if(status == "accepted") {
                $button.parent().siblings("p.invitation-sub-text.pull-left").remove();
                $button.parent().remove();
            }

            if($(".invitation-listings").children().length === 0 ){
                $("invitation-listings").append("<p>No event invitations added yet!</p>");
            }

            $("div#notification-container h4").html(heading);
            $("div#notification-container p").html(data.message);
            $("div#notification-container").showNotification();

        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occurred while trying to manage your event invite request. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });

        e.preventDefault();
    });
});
