$(document).ready(function () {
    $("p.more-less-button a").click(function(e){
        e.preventDefault();
        $(this).parent().parent().children("div.more-text").slideToggle();
        var moreAndLess = $(this).text() == 'Read More' ? 'Read Less' : 'Read More';
        $(this).text(moreAndLess);
    });
    $(".modal-container").click(function(e){
        e.stopPropagation();
    });
    $("#get-started-container #get-started-list div a").showDialog();
    $(".popup-button").showDialog();
    // $("#footer-section #footer-content p a").showDialog();

    // $("#step_five, #step_six, #step_seven, #step_eight").click(function(e){
    //     e.preventDefault();
    //         $(this).closeMyDialog();
    //         $(this).openMyDialog();
        
    // });
    $("#step_zero").click(function(e){
        e.preventDefault();
        $(this).openMyDialog();
    })

    $("#step_one").click(function(e){
        e.preventDefault();
        window.signupObject = {
            gender_id: document.getElementById('iam').value,
            seeking : document.getElementById('seeking').value,
            zip : document.getElementById('zipcode').value,
            day : document.getElementById('day').value,
            month : document.getElementById('month').value,
            year : document.getElementById('year').value,
            username : document.getElementById('username').value,
            password : document.getElementById('password').value,
            confirm_password : document.getElementById('confirm').value,
            first_name : document.getElementById('firstname').value,
            last_name : document.getElementById('lastname').value,
            email : document.getElementById('email').value
        };
    // console.log(signupObject);

            validateSignupForm();
            
    });

    $("#step_two").click(function(e){
        e.preventDefault();
        window.signupObject.career = document.getElementById('career').value;
        window.signupObject.education_id = document.getElementById('education').value;
        window.signupObject.ethnicity_id = document.getElementById('ethnicity').value;
        window.signupObject.match_ethnicity = document.getElementById('match_ethnicity').value;
        window.signupObject.faith_id = document.getElementById('faith').value;
        window.signupObject.faith_importance = document.getElementById('faith_importance').value;
        $(this).closeMyDialog();
        $(this).openMyDialog();
    });

    $("#step_three").click(function(e){
        e.preventDefault();
        window.signupObject.children_id = 
        document.getElementById('children').value;
        window.signupObject.feet = 
        document.getElementById('feet').value;
        window.signupObject.inches = 
        document.getElementById('inches').value;
        window.signupObject.politics_id = 
        document.getElementById('politics').value;
        window.signupObject.politics_importance = 
        document.getElementById('politics_importance').value;
        window.signupObject.exercise_id = 
        document.getElementById('exercise').value;
        window.signupObject.drink_id = 
        document.getElementById('drink').value;
        window.signupObject.body_type_id = 
        document.getElementById('body_type_id').value;
        window.signupObject.smoke_id = 
        document.getElementById('smoke').value;
        
        $(this).closeMyDialog();
        $(this).openMyDialog();
    });

    $("#step_four").click(function(e){
        e.preventDefault();
        window.signupObject.about_me = 
        document.getElementById('aboutme').value;
        $(this).closeMyDialog();
        $(this).openMyDialog();
    });

    $("#step_five").click(function(e){
        e.preventDefault();
        window.signupObject.places_visted = 
        document.getElementById('visited').value;
        $(this).closeMyDialog();
        $(this).openMyDialog();
    });

    $("#step_six").click(function(e){
        e.preventDefault();
        window.signupObject.like_doing = 
        document.getElementById('liketodo').value;
        $(this).closeMyDialog();
        $(this).openMyDialog();
    });


    $("#step_seven").click(function(e){
        e.preventDefault();
        window.signupObject.plan_for_future = 
        document.getElementById('futureplan').value;
        $(this).closeMyDialog();
        $(this).openMyDialog();
    });

    $("#step_eight").click(function(e){
        e.preventDefault();
        window.signupObject.ages_from = 
        document.getElementById('seeking_from').value;
        window.signupObject.ages_to = 
        document.getElementById('seeking_to').value;
        window.signupObject.seeking_education_id = 
        document.getElementById('seeking_education').value;
        window.signupObject.seeking_occupation_id = 
        document.getElementById('seeking_occupation').value;
        window.signupObject.seeking_ethnicity_id = 
        document.getElementById('seeking_ethnicity').value;
        window.signupObject.seeking_matching_ethnicity = 
        document.getElementById('seeking_matching_ethnicity').value;
        window.signupObject.seeking_religion_id = 
        document.getElementById('seeking_faith').value;
        window.signupObject.seeking_faith_importance = 
        document.getElementById('seeking_faith_importance').value;
        window.signupObject.seeking_children_id = 
        document.getElementById('seeking_children').value;
        window.signupObject.seeking_height =
        document.getElementById('seeking_height').value;
        window.signupObject.seeking_politics_id =
        document.getElementById('seeking_politics').value;
        window.signupObject.seeking_politics_importance = 
        document.getElementById('seeking_politics_importance').value;
        window.signupObject.seeking_exercise_id = 
        document.getElementById('seeking_exercise').value;
        window.signupObject.seeking_body_type_id = 
        document.getElementById('seeking_body_type_id').value;
        window.signupObject.seeking_drink_id = 
        document.getElementById('seeking_drink').value;
        window.signupObject.seeking_smoke_id = 
        document.getElementById('seeking_smoke').value;
        $(this).closeMyDialog();
        $(this).openMyDialog();
        document.getElementById('info1').value = window.signupObject.gender_id;
        document.getElementById('info2').value = window.signupObject.seeking;
        document.getElementById('info3').value = window.signupObject.zip;
        document.getElementById('info4').value = window.signupObject.day;
        document.getElementById('info5').value = window.signupObject.month;
        document.getElementById('info6').value = window.signupObject.year;
        document.getElementById('info7').value = window.signupObject.username;
        document.getElementById('info8').value = window.signupObject.password;
        document.getElementById('info9').value = window.signupObject.confirm_password;
        document.getElementById('info10').value = window.signupObject.first_name;
        document.getElementById('info11').value = window.signupObject.last_name;
        document.getElementById('info12').value = window.signupObject.email;
        document.getElementById('info13').value = window.signupObject.career;
        document.getElementById('info14').value = window.signupObject.education_id;
        document.getElementById('info15').value = window.signupObject.ethnicity_id;
        document.getElementById('info16').value = window.signupObject.match_ethnicity;
        document.getElementById('info17').value = window.signupObject.faith_id;
        document.getElementById('info18').value = window.signupObject.faith_importance;
        document.getElementById('info19').value = window.signupObject.children_id;
        document.getElementById('info20').value = window.signupObject.feet;
        document.getElementById('info21').value = window.signupObject.inches;
        document.getElementById('info22').value = window.signupObject.politics_id;
        document.getElementById('info23').value = window.signupObject.politics_importance;
        document.getElementById('info24').value = window.signupObject.exercise_id;
        document.getElementById('info25').value = window.signupObject.drink_id;
        document.getElementById('info26').value = window.signupObject.smoke_id;
        document.getElementById('info27').value = window.signupObject.about_me;
        document.getElementById('info28').value = window.signupObject.places_visted;
        document.getElementById('info29').value = window.signupObject.like_doing;
        document.getElementById('info30').value = window.signupObject.plan_for_future;
        document.getElementById('info31').value = window.signupObject.ages_from;
        document.getElementById('info32').value = window.signupObject.ages_to;
        document.getElementById('info33').value = window.signupObject.seeking_education_id;
        document.getElementById('info34').value = window.signupObject.seeking_ethnicity_id;
        document.getElementById('info35').value = window.signupObject.seeking_matching_ethnicity;
        document.getElementById('info36').value = window.signupObject.seeking_religion_id;
        document.getElementById('info37').value = window.signupObject.seeking_faith_importance;
        document.getElementById('info38').value = window.signupObject.seeking_children_id;
        document.getElementById('info39').value = window.signupObject.seeking_height;
        document.getElementById('info41').value = window.signupObject.seeking_politics_id;
        document.getElementById('info42').value = window.signupObject.seeking_politics_importance;
        document.getElementById('info43').value = window.signupObject.seeking_exercise_id;
        document.getElementById('info44').value = window.signupObject.seeking_drink_id;
        document.getElementById('info45').value = window.signupObject.seeking_smoke_id;
        document.getElementById('info46').value = window.signupObject.body_type_id;
        document.getElementById('info47').value = window.signupObject.seeking_body_type_id;
        document.getElementById('info48').value = window.signupObject.seeking_occupation_id;
     
 });

    $("#signup_form").submit(function(e){
        
        if(profile_uploaded){
            $(this).submit();
        } else {
            alert("Upload a profile picture");
            e.preventDefault();
        }
    });




    $("#step_nine1").click(function(e){
        //e.preventDefault();
         var image =  document.getElementById('imgInp').files[0]; 
           var url = $(this).data("url"); 
          //   window.signupObject.imagesize = image.size;
          //   window.signupObject.imagetype = image.type;    
          //   var reader = new FileReader();
          //   reader.onloadend = function () {
          //   window.signupObject.photo = reader.result;
          //   $.ajax({
          //  type: "POST",
          //   url: url,
          //   data: window.signupObject
          //  });
          //     } 
          // reader.readAsDataURL(image);
         
        // var form = document.getElementById('big-form');
        


        


        $.post(url, window.signupObject, function(data){
            if(data.result){
                var button = document.getElementById('step_nine');
                var redirect_url= button.getAttribute('data-redirect');
                console.log(data.result);
                //window.location.replace(redirect_url);
            } else {
                alert("Something went wrong. Please try again!");
                $(this).closeMyDialog();
            }
        }); 

        
    });
    
});





$.fn.showDialog = function() {
    $(this).click(function(e) {
        e.preventDefault();
        $("body").append("<div class='overlay'></div>");
        $(".overlay").height($('body').height());
        $(".overlay").css({
            'z-index': '3'
        });
        $(".overlay, button.close").closeDialog();
        var dialog_id = "#" + $(this).data("dialog");
        $(".overlay").append($(dialog_id));
        $(dialog_id).alignCenter();
        $(dialog_id).show();
    });
};
$.fn.alignCenter = function() {
    var top =  $(window).scrollTop() + ($(window).height()/2 - $(this).height()/2);
    var left = $(window).width() / 2 - $(this).width() / 2;
    top = top <= 0 ? 10 : top;
    left = left <= 0 ? 10 : left;
    $(this).css({
        top: top,
        left: left
    });
};
$.fn.closeDialog = function(){
    $(this).click(function(e){
        e.preventDefault();
        $("body").append($(".overlay div.modal-container"));
        $("div.modal-container").hide();
        $(".overlay").detach();
    });
};

$.fn.closeMyDialog = function() { 
    $("body").append($(".overlay div.modal-container"));
    $("div.modal-container").hide();
    $(".overlay").detach(); 
}

$.fn.openMyDialog = function() { 
    $("body").append("<div class='overlay'></div>");
    $(".overlay").height($('body').height());
    $(".overlay").css({
        'z-index': '3'
    });
    $(".overlay, button.close").closeDialog();
    var dialog_id = "#" + $(this).data("dialog");
    $(".overlay").append($(dialog_id));
    $(dialog_id).alignCenter();
    $(dialog_id).show(); 
}

function userExists() {
    var email = window.signupObject.email;
    var username = window.signupObject.username;
    
    var url = document.getElementById('email_exists').value;
    $.post(url,{email: email, username: username}, function(data){
        if(data.status){
            console.log(data);
            if(data.field == 'username'){
                var id = 'username';
                var msg = 'Username exists.';
            } else {
                var id = 'email';
                var msg = 'Email exists.';
            }
            showErrorMsg(id, msg);
            return;
        }
        $('#step_one').closeMyDialog();
        $('#step_one').openMyDialog();
    });
};

var showErrorMsg = function(id, msg){
    msg = typeof msg !== 'undefined' ? msg : "Enter a valid value.";
    document.getElementById(id).focus(); 
    alert(msg);
};

var validateSignupForm = function(){
    

    if(window.signupObject.gender_id == ""){
        showErrorMsg('iam');
        return false;

    }
    if(window.signupObject.seeking == ""){
        showErrorMsg('seeking');
        return false;
    }

    if(window.signupObject.zip == ""){
        showErrorMsg('zipcode');
        return false;
    }

    if(window.signupObject.day == ""){
        showErrorMsg('day');
        return false;
    }

    if(window.signupObject.month == ""){
        showErrorMsg('month');
        return false;
    }

    if(window.signupObject.year == ""){
        showErrorMsg('year');
        return false;
    }

    if(window.signupObject.first_name == ""){
        showErrorMsg('firstname');
        return false;
    }

    if(window.signupObject.last_name == ""){
        showErrorMsg('lastname');
        return false;
    }


    if(window.signupObject.email == ""){
        showErrorMsg('email');
        return false;
    }

    

    if(window.signupObject.username == ""){
        showErrorMsg('username');
        return false;
    }

    

    if(window.signupObject.password == ""){
        showErrorMsg('password');
        return false;
    }

    if(window.signupObject.confirm_password == ""){
        showErrorMsg('confirm');
        return false;
    }

    if(window.signupObject.password != window.signupObject.confirm_password){
        alert('Password don\'t match');
        $('#confirm').focus();
        return false;
    }

    userExists();

    return false;

    // if( ! validateUser()){
    //     return false;
    // }
}
