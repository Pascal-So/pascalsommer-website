$(document).ready(function(){
  var ab = 0;
  var ph = 0;
  $("#about").hide();
  $("#photography").hide();
  $("#aboutTitle").click(function() {
    $("#about").toggle(100);
    if(ab == 0){
      $('html, body').animate({
          scrollTop: $("#about").offset().top-60
      }, 500);
      ab=1;
    }else{
      ab=0;
    }
  });
  $("#photographyTitle").click(function() {
    $("#photography").toggle(100);
    if(ph==0){
      $('html, body').animate({
          scrollTop: $("#photography").offset().top-60
      }, 500);
      ph=1;
    }else{
      ph=0;
    }
  });
})
