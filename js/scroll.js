$(document).ready(function(){

  $('#workLink').click(function(e){
    e.preventDefault();
    $('html, body').animate({ scrollTop:  $('#work').offset().top+50}, 200);
  });

  $('#aboutLink').click(function(e){
    e.preventDefault();
    $('html, body').animate({ scrollTop:  $('#about').offset().top}, 300);
  });
  
});