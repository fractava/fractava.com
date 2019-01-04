
$(window).scroll(function() {
	if ($(this).scrollTop() < $(window).height()/2) {
		$(".sidebutton").removeClass("black").addClass("white");
	} else if ($(this).scrollTop() < $(window).height()) {
		$(".sidebutton").removeClass("white").addClass("black");
	}
});