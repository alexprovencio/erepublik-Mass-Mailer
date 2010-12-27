$(document).ready(function(){
	// Autoresize for message
	scaleTextareas();
	
	// Manual resize
	$('textarea.resizable:not(.processed)').TextAreaResizer();
	
	// Tooltips
	$('a.profileLink').tipsy({delayIn: 100, delayOut: 100, fade: true, trigger: 'hover', gravity: 'w', opacity: 0.9, title: 'href'});	
	$('textarea').tipsy({delayIn: 100, delayOut: 1000, fade: true, trigger: 'hover', gravity: 'w', opacity: 0.9});	
	$('input').tipsy({delayIn: 100, delayOut: 1000, fade: true, trigger: 'hover', gravity: 'w', opacity: 0.9});	
});
