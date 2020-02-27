$(document).ready(function () {	

		$("#client-popup-container").hide();

		$("#invite-friend-container a").click(function(e){

		   $("#client-popup-container").show();
		});

});

function check(e) {
var target = (e && e.target) || (event && event.srcElement);
var obj = document.getElementById('client-popup-container');
var obj2 = document.getElementById('btn');
checkParent(target) ? obj.style.display = 'none' : null;
target == obj2 ? obj.style.display = 'block' : null;
}

function checkParent(t) {
while (t.parentNode) {
if (t == document.getElementById('client-popup-container')) {
return false
} else if (t == document.getElementById('close')) {
return true
}
t = t.parentNode
}
return true
}