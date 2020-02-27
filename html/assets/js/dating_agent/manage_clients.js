$(document).ready(function () {
    $("form#client-management-form a").click(function(e) {
        var action_url = $(this).parent().attr('action');
        var pending_client =  $(this).parent().parent().parent().parent();
        var client_status = $(this).data("client-status");
        $.post(action_url, {
            sender_id: $(this).data("sender-id"),
            status: client_status
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

            pending_client.remove();
            if($("#latest-friend-requests .content").children().length === 0 ){
                $("#latest-friend-requests .content").append("<p>No New Friend Requests!</p>");
            }

            $("div#notification-container h4").html(heading);
            $("div#notification-container p").html(data.message);
            $("div#notification-container").showNotification();

        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occurred while trying to send your friend request. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });

        e.preventDefault();
    });
});