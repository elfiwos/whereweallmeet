$(document).ready(function () {	

    $("[data-id='edit-photo']").hide();
    $("[data-id='edit-photo-crop']").hide();

    $("[data-id='edit-photo1']").hide();
    $("[data-id='edit-photo-crop1']").hide();

    $(".edit-popup-contianer").hide();

    $('.photo-edit-con a').click(function(e){
        e.preventDefault();
        $("[data-id='edit-photo']").show();
         $("[data-id='edit-photo-crop']").show();  
    });

    $('#photo-edit-con1 a').click(function(e){
        e.preventDefault();
        $("[data-id='edit-photo1']").show();
         $("[data-id='edit-photo-crop1']").show();  
    });

   // $("[data-id='edit-photo-crop']").click(function(){
           // $(".edit-popup-contianer").show();


   // });

    $("[data-id='edit-photo-crop'] a").click(function(){
            


    });

    $("#showmore-list").hide();

    $('#more a').click(function(e){
        e.preventDefault();
        $("#showmore-list").show();
    });

	$("#lets-talk").letsTalk();

    $("div#lets-talk-dialog a.confirm-lets-talk").click(function(e) {
        e.preventDefault();
        $.closeDialogWindow();
        $(this).data("username", $("#friends-list").val());
        var selected_topics = $("#something-to-chat input:checkbox:checked").map(function(){return $(this).data("text"); });
        selected_topics = selected_topics.toArray().toString();
        letsTalk($("#friends-list").val(), selected_topics)
    });

    $("#friends-list").change(function () {
        $("div#lets-talk-dialog a.yes-button").data("username", this.value);
    });

    $("#profile-header ul li").selectTab();

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

    $("#photo-container .left-scroller a, #photo-container .right-scroller a").click(function(e){
        e.preventDefault();
        var direction = $(this).data("direction");

        var inner_container =$("#photo-items");
        var container_width = $("#visible-photos").width();
        var item_width = 143;
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
});

$.fn.letsTalk = function() {
    $(this).click(function(e){
        e.preventDefault();

        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        })
        $(".overlay, .close-dialog").closeDialog();

        var dialog_id = "#" + $(this).data("dialog");
        var username = $(this).data("username");

        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    })
}

$.fn.selectTab = function () {
     $(this).click(function(e){
         e.preventDefault();

         $("#profile-header ul li").removeClass("active");
         $(this).addClass("active");

         $("#profile-detail > div").removeClass("active");
         $("#profile-detail #" + $(this).data('detail')).addClass("active");
     })
     
}

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

$.clearDialogForm = function(){
    $("div.dialog input[type=text], div.dialog textarea").val("");
};

$.closeDialogWindow = function(){
    $("body").append($(".overlay div.dialog"));
    $("div.dialog").hide();
    $(".overlay").detach();
};

function div_show1() {
document.getElementById('edit-popup-contianer').style.display = "block";
}


function check(e) {
var target = (e && e.target) || (event && event.srcElement);
var obj = document.getElementById('edit-popup-contianer');
var obj2 = document.getElementById('btn');
checkParent(target) ? obj.style.display = 'none' : null;
target == obj2 ? obj.style.display = 'block' : null;
}

function checkParent(t) {
while (t.parentNode) {
if (t == document.getElementById('edit-popup-contianer')) {
return false
} else if (t == document.getElementById('close')) {
return true
}
t = t.parentNode
}
return true
}


var TARGET_W = 300;
var TARGET_H = 300;

function show_popup(id) {
    // show the popup
    $('#'+id).show();
}

function show_popup1(id) {
    // show the popup
    $('#'+id).show();
}

// close_popup : close the popup
function close_popup(id) {
    // hide the popup
    $('#'+id).hide();
}

function close_popup1(id) {
    // hide the popup
    $('#'+id).hide();
}


function show_popup_crop(url, id) {
    // change the photo source
    $('#cropbox').attr('src', url);
    // destroy the Jcrop object to create a new one
    try {
        jcrop_api.destroy();
    } catch (e) {
        // object not defined
    }
    // Initialize the Jcrop using the TARGET_W and TARGET_H that initialized before
    $('#cropbox').Jcrop({
      aspectRatio: TARGET_W / TARGET_H,
      setSelect:   [ 100, 100, TARGET_W, TARGET_H ],
      onSelect: updateCoords
    },function(){
        jcrop_api = this;
    });

    // store the current uploaded photo url in a hidden input to use it later
    $('#photo_url').val(url);
    $('#photo_id').val(id);
    // hide and reset the upload popup
    $('#popup_upload').hide();
    $('#loading_progress').html('');
    $('#photo').val('');

    // show the crop popup
    $('#popup_crop').show();
}

function show_popup_crop1(url) {
    // change the photo source
    $('#cropbox1').attr('src', url);
    // destroy the Jcrop object to create a new one
    try {
        jcrop_api.destroy();
    } catch (e) {
        // object not defined
    }
    // Initialize the Jcrop using the TARGET_W and TARGET_H that initialized before
    $('#cropbox1').Jcrop({
      aspectRatio: TARGET_W / TARGET_H,
      setSelect:   [ 100, 100, TARGET_W, TARGET_H ],
      onSelect: updateCoords
    },function(){
        jcrop_api = this;
    });

    // store the current uploaded photo url in a hidden input to use it later
    $('#photo_url').val(url);
    // hide and reset the upload popup
    $('#popup_upload').hide();
    $('#loading_progress').html('');
    $('#photo').val('');

    // show the crop popup
    $('#popup_crop1').show();
}


function crop_photo() {
    var x_ = $('#x').val();
    var y_ = $('#y').val();
    var w_ = $('#w').val();
    var h_ = $('#h').val();
    var id = $('#photo_id').val();
    var photo_url_ = $('#pic_url_'+ id).attr('url');
    var file_n =  $('#pic_url_'+ id).attr('file');
    var path_n =  $('#pic_url_'+ id).attr('path');
    var original = $('#pic_url_'+ id).attr('origin');
    var id = $('#pic_url_'+ id).attr('image-id');

    console.log(path_n)
    console.log(file_n);
    console.log(photo_url_);

    // hide thecrop  popup
    $('#popup_crop').hide();

    // display the loading texte
    $('#photo_container').html('<img src="images/loader.gif"> Processing...');
    // crop photo with a php file using ajax call
    $.ajax({
        url: $('#popup_crop').attr("url"),
        type: 'POST',
        data: {x:x_, y:y_, w:w_, h:h_,id:id, photo_url:photo_url_, original:original, file_name:file_n, path:path_n, targ_w:TARGET_W, targ_h:TARGET_H},
        success:function(data){
            window.location.reload(true);
        }
    });
}

function crop_photo1() {
    var x_ = $('#x').val();
    var y_ = $('#y').val();
    var w_ = $('#w').val();
    var h_ = $('#h').val();
    //var id = $('#photo_id').val();
    var photo_url_ = $('#pic_url').attr('url');
    var file_n =  $('#pic_url').attr('file');
    var path_n =  $('#pic_url').attr('path');
    var original = $('#pic_url').attr('origin');
    //var id = $('#pic_url').attr('image-id');

    console.log(path_n)
    console.log(file_n);
    console.log(photo_url_);

    // hide thecrop  popup
    $('#popup_crop1').hide();

    // display the loading texte
    $('#photo_container').html('<img src="images/loader.gif"> Processing...');
    // crop photo with a php file using ajax call
    $.ajax({
        url: $('#popup_crop1').attr("url"),
        type: 'POST',
        data: {x:x_, y:y_, w:w_, h:h_, photo_url:photo_url_, original:original, file_name:file_n, path:path_n, targ_w:TARGET_W, targ_h:TARGET_H},
        success:function(data){
            window.location.reload(true);
        }
    });
}


function updateCoords(c) {
    $('#x').val(c.x);
    $('#y').val(c.y);
    $('#w').val(c.w);
    $('#h').val(c.h);
}