$(document).ready(function () {
    $("div.btn-holder a.more-events").click(function(e){
        e.preventDefault();
        var count=  $(this).data("count");
        var rows = Math.ceil(count/10);
        var current_rows = $("div#events-inner-container").height()/1075;
        if(rows == Math.ceil(current_rows)) {
            $("div#events-inner-container").height(1075);
            return;
        }

        var previous_height = $("div#events-inner-container").height();
        var remaining = count - (current_rows * 10)
        var new_height = previous_height + (remaining>10 ? 107.5*10 : remaining*107.5) ;
        $("div#events-inner-container").height(new_height);
    });
});


