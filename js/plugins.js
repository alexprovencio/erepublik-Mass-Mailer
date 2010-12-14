$(document).ready(function(){
	/*
	// Autoresize for message
	$('#message').autoResize({
		// On resize:
		onResize : function() { $(this).css({opacity:0.8}); },
		// After resize:
		animateCallback : function() { $(this).css({opacity:1}); },
		animateDuration : 150, extraSpace : 20
	});
	*/
	
	scaleTextareas();
	
	// Textlimit for message
	jQuery("#message").textlimit('span.counter',2000);
	
	// Manual resize
	$('textarea.resizable:not(.processed)').TextAreaResizer();
});
