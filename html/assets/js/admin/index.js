$(document).ready(function () {
    $(".date-picker").each(function(){
        var id = $(this).attr("id");
        $("#"+id).datepicker({ dateFormat: "yy-mm-dd" });
    });

    $( "#subscription-expiry-date" ).datepicker({ dateFormat: "yy-mm-dd" });
});
