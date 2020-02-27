$(document).ready(function () {
    //$("div#events").alternateScroll({'vertical-bar-class': 'styled-green-v-bar', 'hide-bars': false });

    var event_date = new Date();
    event_date.setHours(0, 0, 0, 0);

    $("#from_date").datepicker({
        inline: true,
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
    });
    $("#to_date").datepicker({
        inline: true,
        showOtherMonths: true,
        dayNamesMin: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat']
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