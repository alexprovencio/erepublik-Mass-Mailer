$(document).ready(function(){
	// Autoresize for message
	scaleTextareas();
	
	// Manual resize
	$('textarea.resizable:not(.processed)').TextAreaResizer();
	
	// Tooltips
	$('a.profileLink').tipsy({fade: true, trigger: 'hover', gravity: 'w', opacity: 0.9});	
	$('textarea').tipsy({delayIn: 100, delayOut: 1000, fade: true, trigger: 'hover', gravity: 'w', opacity: 0.9});	
	$('input').tipsy({delayIn: 100, delayOut: 1000, fade: true, trigger: 'hover', gravity: 'w', opacity: 0.9});
	
	// Show/hide toggle
	$('.toggle').showhide({target_obj: $('#' + $('.toggle').attr('title')), default_open: false, plus_text: 'Show', minus_text: 'Hide', use_cookie: true, cookie_name: 'replacementField'});
});
