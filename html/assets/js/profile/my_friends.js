$(document).ready(function () {
    $("div.btn-holder a.more-friends").click(function(e){
        e.preventDefault();
        var count=  $(this).data("count");
        var rows = Math.ceil(count/20);
        var current_rows = $("div#friend-list-container").height()/900;
        if(rows == current_rows) {
            $("div#friend-list-container").height(900);
            return;
        }

        var previous_height = $("div#friend-list-container").height();
        var new_height = previous_height + 900;
        $("div#friend-list-container").height(new_height);
    });

    $('#outgoing a').click(function(e){
         e.preventDefault();

        $('#incoming-request').hide();
        $('#incoming a').removeClass('option active');
        $(this).addClass('option active');

        $('#outgoing-request').show();
    });

    $('#incoming a').click(function(e){
         e.preventDefault();

        $('#outgoing-request').hide();
        $('#outgoing a').removeClass('option active');
        $(this).addClass('option active');

        $('#incoming-request').show();
    });

	 $("form#find-friend-form").submit(function(e) {
	        $('button#find-a-friend').html('<i class="fa fa-cog fa-spin"></i>');
	        $.post(this.action, $(this).serialize(), function(data) {
	            var heading = data.status ? "The person is on the system!" : "The person is not on the system!";
	            if(data.status) {
	                $("div#notification-container").removeClass('alert-error');
	                $("div#notification-container").addClass('alert-success');
	            }
	            else {
	                $("div#notification-container").removeClass('alert-success');
	                $("div#notification-container").addClass('alert-error');
	            }
	            $("div#notification-container h4").html(heading);
	            $("div#notification-container").showNotification();
	            $('button#find-a-friend').html('Find a Friend Now!');
	        }, 'json');
	        e.preventDefault();
	    });
	
	$("form#refer-friend-form").submit(function(e) {
        $('button#refer-a-friend').html('<i class="fa fa-cog fa-spin"></i>');
        $.post(this.action, $(this).serialize(), function(data) {
            var heading = data.status ? "You\'ve successfully notified your friend.!" : "Sending failed. Please try again later!";
            if(data.status) {
                $('input#email').val('');
                $('textarea#message').val('');
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }
            $("div#notification-container h4").html(heading);
            $("div#notification-container").showNotification();
            $('button#refer-a-friend').html('Refer a Friend Now!');
        }, 'json');
        e.preventDefault();
    });

    $("#friendship-form a, div.pull-right.message-del a").click(function(e) {
        var action_url = $(this).data("action");
        var pending_friend =  $("div#" + $(this).data("request-container"));
        var friendship_status = $(this).data("friendship-status");
        $.post(action_url, {
            sender_id: $(this).data("sender-id"),
            receiver_id: $(this).data("receiver-id"),
            status: friendship_status
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
            pending_friend.remove();

            if($("div.message-wrapper.inbox-wrapper").children().length === 0 ){
                $("div.message-wrapper.inbox-wrapper").append("<p>No new friend requests!</p>");
            }
            if($("div.message-wrapper.sent-wrapper").children().length === 0 ){
                $("div.message-wrapper.sent-wrapper").append("<p>No new friend requests!</p>");
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

    $("#manage-friendship-form a").click(function(e) {
        var action_url = $(this).parent().attr('action');
        var friend =  $(this).parent().parent().parent();
        var form = $(this).parent();
        var friendship_status = $(this).data("friendship-status");
        var $button = $(this);
        $.post(action_url, {
            friend_id: $(this).data("friend-id"),
            status: friendship_status
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

            friend.remove();
            if($("#my-friends .content").children().length === 0 ){
                $("#my-friends .content").append("<p>No friends added yet!</p>");
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

    $('a.btn-friend-management').click(function(e){
        e.preventDefault();

        $("div.friends-thumb div.popup-friend-management").hide();
        $popup_window = $("#" + $(this).data('popup-id'));
        $popup_window.css({
            top: $(this).top,
            left: $(this).left
        });
        $popup_window.show();
    });

});
