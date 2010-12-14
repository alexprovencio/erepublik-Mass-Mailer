$(document).ready(function(){
	$('#message').autoResize({
		// On resize:
		onResize : function() { $(this).css({opacity:0.8}); },
		// After resize:
		animateCallback : function() { $(this).css({opacity:1}); },
		animateDuration : 150, extraSpace : 20
	});
});
