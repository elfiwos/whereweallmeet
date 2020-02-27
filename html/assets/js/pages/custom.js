$(window).load(function(){
	$(".row .container").show();

    $("#our-services-container").height($("#our-services-container img").height());
});
$(document).ready(function () {

    $('#slideshow').cycle({
        fx: 'fade',
        pager: '#smallnav',
        pause:1,
        speed: 1800,
        timeout: 3500
    });

    //set popup status for dashboard
    $.cookie("wwam_popupClosed", null, {path: '/'});
});