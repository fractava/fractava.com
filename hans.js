
$(window).scroll(function() {
	if ($(this).scrollTop() < 500) {
		$(".sidebutton").removeClass("black").addClass("white");
	} else if ($(this).scrollTop() < 1000) {
		$(".sidebutton").removeClass("white").addClass("black");
	}
});