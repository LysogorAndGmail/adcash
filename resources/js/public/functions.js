( function( $ ) {
	
	$("#mobile-toggle").on('touchstart click', function(e) {
		$("body").toggleClass("noscroll");
		$("#header-items").fadeToggle();
		$(".menui").toggleClass("animate");
		e.preventDefault();
	});

})( jQuery );