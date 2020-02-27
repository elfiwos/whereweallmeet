$(document).ready(function () {
    members_count = $(".browse-members div.member-listing div.member").length;
    $("#search-count").text(members_count + ' Members');
});


