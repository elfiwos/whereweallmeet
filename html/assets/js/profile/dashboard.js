$(document).ready(function () {

    $('#post-section').show();
    $('#upload-section').hide();
    $("#compose-popup-container").hide();
    $('#list-friends-popup').hide();
     
      $("#show-send-message a, a.notification-send-message").click(function(e){
            e.preventDefault();
           $("#compose-popup-container").show();
    });

    $("div.btn-holder a.more-events").click(function(e){
        e.preventDefault();
        var count=  $(this).data("count");
        var rows = Math.ceil(count/3);
        var current_rows = $(".latest-events div#event-list-container").height()/281;
        if(rows == current_rows) {
            $(".latest-events div#event-list-container").height(281);
            return;
        }

        var previous_height = $(".latest-events div#event-list-container").height();
        var new_height = previous_height + 281;
        $(".latest-events div#event-list-container").height(new_height);
    });
    $("div.btn-holder a.more-date-ideas").click(function(e){
        e.preventDefault();
        var count=  $(this).data("count");
        var rows = Math.ceil(count/3);
        var current_rows = $(".latest-events div#date-idea-list-container").height()/281;
        if(rows == current_rows) {
            $(".latest-events div#date-idea-list-container").height(281);
            return;
        }

        var previous_height = $(".latest-events div#date-idea-list-container").height();
        var new_height = previous_height + 281;
        $(".latest-events div#date-idea-list-container").height(new_height);
    });


    $(".write-post a").click(function(e){
        e.preventDefault();

         $('#list-friends-popup').show();

    });


    $('#show-upload a').click(function(e){
        e.preventDefault();
        $(this).addClass('option active');

        $('#show-send-message a').removeClass('option active');
        $('#show-send-message a').addClass('option');
        $('#show-post a').removeClass('option active');
        $('#show-post a').addClass('option ');

        $('#post-section').hide();
        $('#send-message-section').hide();
        $('#upload-section').show();

    });

    
    $('#show-post a').click(function(e){
        e.preventDefault();
        $(this).addClass('option active');

        $('#show-upload a').removeClass('option active');
        $('#show-upload a').addClass('option');
        $('#show-send-message a').removeClass('option active');
        $('#show-send-message a').addClass('option ');

        $('#post-section').show();
        $('#upload-section').hide();
        $('#send-message-section').hide();

    });


    $("#friendship-form a").click(function(e) {
        var action_url = $(this).parent().attr('action');
        var pending_friend =  $(this).parent().parent();
        var friendship_status = $(this).data("friendship-status");
        $.post(action_url, {
            sender_id: $(this).data("sender-id"),
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

    var item_width = 113;
    var element_count = $(".match-slider .slider-content .content").children().length;
    $(".match-slider .slider-content .content").width(item_width*element_count);

    $(".match-slider img#left-scroller, .match-slider img#right-scroller").click(function(e){
        e.preventDefault();
        var direction = $(this).data("direction");

        var inner_container =$(".match-slider .slider-content .content");
        var container_width = $(".match-slider .slider-content").width();
        //var item_width = 113;
        var inner_width = inner_container.width();
        var max_left = Math.abs(container_width - inner_width);
        var current_left = inner_container.data('left');
        var new_left = 0;
        if(direction === "left"){
            new_left = current_left - item_width;
            if(new_left >= -max_left){
                inner_container.data('left', new_left);
                inner_container.animate({
                    left: new_left
                }, 'slow');
            }
        } else {
            new_left = current_left + item_width;
            if(new_left <= 0){
                inner_container.data('left', new_left);
                inner_container.animate({
                    left: new_left
                }, 'slow');
            }
        }
    });

    $("#post-section .activity a.delete-notification").click(function(e) {
        e.preventDefault();

        var action_url = $(this).data("action");
        var $notification_container =  $(this).parent();
        var notification_id = $(this).data("notification-id");

        $.post(action_url, {
            notification_id: notification_id
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

            $notification_container.remove();
            $("#separator-" + notification_id).remove();
            if($("#post-section .user-status .content").children("div.activity").length === 0 ){
                $("#post-section .user-status .content").append("<p>You have no notification.</p>");
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


    $photo_inner = $("#refer_friend-invitation-dialog #profile-pictures-container #photos-inner");
    $photo_inner.width($photo_inner.children().length * 400);
    $("#refer_friend-invitation-dialog #profile-pictures-container #left-arrow a, #refer_friend-invitation-dialog #profile-pictures-container #right-arrow a" ).click(function(e){
        e.preventDefault();

        var direction = $(this).data("direction");

        var inner_container = $("#refer_friend-invitation-dialog #photos-inner");
        var conatiner_width = $("#refer_friend-invitation-dialog #picture-container").width();
        var item_width = 400;
        var inner_width = inner_container.width();
        var max_left = Math.abs(conatiner_width-inner_width);
        var current_left = inner_container.data("left");
        var new_left = 0;
        if(direction == "left") {
            new_left = current_left-item_width;
            if(new_left >= -max_left) {
                inner_container.data("left", new_left);
                inner_container.animate({
                    left: new_left
                }, 'slow');
            }
        } else {
            new_left = current_left+item_width;
            if(new_left <= 0) {
                inner_container.data("left", new_left);
                inner_container.animate({
                    left: new_left
                }, 'slow');
            }
        }
    });

    $suggested_matches_photo_inner = $("#suggested-matches-dialog #profile-pictures-container #photos-inner");
    $suggested_matches_photo_inner.width($suggested_matches_photo_inner.children().length * 400);
    $("#suggested-matches-dialog #profile-pictures-container #left-arrow a, #suggested-matches-dialog #profile-pictures-container #right-arrow a").click(function(e){
            e.preventDefault();

            var direction = $(this).data("direction");

            var inner_container = $("#suggested-matches-dialog #photos-inner");
            var conatiner_width = $("#suggested-matches-dialog #picture-container").width();
            var item_width = 400;
            var inner_width = inner_container.width();
            var max_left = Math.abs(conatiner_width-inner_width);
            var current_left = inner_container.data("left");
            var new_left = 0;
            if(direction == "left") {
                new_left = current_left-item_width;
                if(new_left >= -max_left) {
                    inner_container.data("left", new_left);
                    inner_container.animate({
                        left: new_left
                    }, 'slow');
                    var item_order_number = (Math.abs(new_left) + item_width)/item_width;
                    $(".profile-description").removeClass('active');
                    $("#profile-description-"+item_order_number).addClass("active");
                }
            } else {
                new_left = current_left+item_width;
                if(new_left <= 0) {
                    inner_container.data("left", new_left);
                    inner_container.animate({
                        left: new_left
                    }, 'slow');
                    var item_order_number = (Math.abs(new_left) + item_width)/item_width;
                    $(".profile-description").removeClass('active');
                    $("#profile-description-"+item_order_number).addClass("active");
                }
            }
        });

    if($.cookie("wwam_popupClosed") == null) {
        if($('#refer_friend-invitation-dialog').length > 0) {
            $('#refer_friend-invitation-dialog').showReferFriendInvitationPopup();
            $('#refer_friend-invitation-dialog a.refer_friend-invitation-reply').replyReferFriendInvitation();
            $("#close-refer-friend").closeReferFriendDialog();
        } else {
            //show suggested matches if any
            if($('#suggested-matches-dialog #photos-inner').children().length > 0) {
                $('#suggested-matches-dialog').showSuggestedMatches();
                $('#suggested-matches-dialog a.suggested-matches-reply').replySuggestedMatchRequest();
                $("#close-suggested-matches").closeSuggestedMatchesDialog();
            }
        }
    }
});
$.fn.closeReferFriendDialog = function(){
    $(this).click(function(e){
        e.preventDefault();
        $("body").append($(".overlay div.dialog"));
        $("div.dialog").hide();
        $(".overlay").detach();

        //set cookie value that the popup is closed, the cookie value will remain till the browser is closed
        //$.cookie("wwam_popupClosed", "true");
        $.cookie("wwam_popupClosed", true, {path: '/'});

        //show suggested matches if any
        if($('#suggested-matches-dialog #photos-inner').children().length > 0) {
            $('#suggested-matches-dialog').showSuggestedMatches();
            $('#suggested-matches-dialog a.suggested-matches-reply').replySuggestedMatchRequest();
        }
    });
};
$.fn.closeSuggestedMatchesDialog = function(){
    $(this).click(function(e){
        e.preventDefault();
        $("body").append($(".overlay div.dialog"));
        $("div.dialog").hide();
        $(".overlay").detach();

        //set cookie value that the popup is closed, the cookie value will remain till the browser is closed
        //$.cookie("wwam_popupClosed", "true");
        $.cookie("wwam_popupClosed", true, {path: '/'});
    });
};
$.fn.replySuggestedMatchRequest = function(){
    $(this).click(function(e){
        var member_id = $("#suggested-matches-dialog .profile-description.active").data("profile-id");
        $.post($(this).attr('href'), {'member_id': member_id}, function(data) {
            var heading = data.status ? "Success" : "Error";
            if(data.status) {
                $("div#notification-container").removeClass('alert-error');
                $("div#notification-container").addClass('alert-success');
            }
            else {
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
            }

            $("div#notification-container h4").html(heading);
            $("div#notification-container p").html(data.message);
            $("div#notification-container").showNotification();
        }, 'json').error(function() {
                $("div#notification-container h4").html("Error!");
                $("div#notification-container p").html("Error occurred. Please try again.");
                $("div#notification-container").removeClass('alert-success');
                $("div#notification-container").addClass('alert-error');
                $("div#notification-container").showNotification();
            });
        e.preventDefault();
    })
};
$.fn.replyReferFriendInvitation = function(){
    $('a.refer_friend-invitation-reply').click(function(e){
        $.post($(this).attr('href'), null, function(data) {
            if(data.accepted){
                window.location.replace(data.url);
            }
            else if(data.rejected){
                $("body").append($(".overlay div.dialog"));
                $("div.dialog").hide();
                $(".overlay").detach();
            }
        }, 'json');
        e.preventDefault();
    })
};
$.fn.showSuggestedMatches = function() {
    if($(this).length > 0) {
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay, .close-dialog").closeDialog();
        var dialog_id = "#suggested-matches-dialog";
        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    }
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