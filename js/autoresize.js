/*
 * Scale all textareas dynamically on the page
 * Requires jQuery
 */
function scaleTextareas() {
  jQuery('.autoresize').each(function(i, t){
    var m = 0;
    $($(t).val().split("\n")).each(function(i, s){
      m += (s.length/(t.offsetWidth/10)) + 1;
    });
    t.style.height = Math.floor(m + 8) + 'em';
  });
  setTimeout(scaleTextareas, 1000);
};