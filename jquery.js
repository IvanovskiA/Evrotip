$("document").ready(function () {
	$(".navLink").css("font-weight", "bold");
	$("nav").show(500);
	$(".logo").show(500)
	$(".container").show(2000);
	$(".form").show(3000);
	$("footer").show(5000);
	$(".searchresult").show(6000);
	$(".searchresult table").css("width", "100%");
});
$(".navLink").hover(function () {
	$(this).css("background-color", "grey");
	$(this).css("color", "black");
}, function () {
	$(this).css("background-color", "transparent");
	$(this).css("color", "white");
});

// $("document").ready(function () {
// 	$(".navTime").append("<p>the page just loaded!</p>");
// });