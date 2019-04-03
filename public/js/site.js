
+function($){

function toggle_main_menu(hide) {
  hide = !!hide;
  $('#main-menu')[hide ? 'addClass' : 'removeClass']('hide-me');
}



$(function(){

$('.the-key').focus(function(){
  $(this).select();
});

$(document.body).click(function(e){
  if(!$(e.target).closest('#main-menu').length)
    toggle_main_menu(true);
});

$(document).on('click', '.copy-btn', function(ev){
  ev.preventDefault();
  var the_key = $('.the-key');
  the_key.focus();
  the_key.select();
  
  try {
    var res = document.execCommand('copy');
    if(res) $(this).hide();
  } catch(err) {
    
  }
  
});

});


}(jQuery);
