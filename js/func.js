$(document).ready(function(){

  $vh = $('header').height();
  $vw = $('header').width();

  $picheight = $vh;

  if($vh*1920<$vw*1101){
    $picheight=$vw*1101/1920;
  }

  $('header').css({
    "height":$vh,
    "background-size":"auto "+ $picheight + "px"
  });

  $('#workLink').click(function(e){
    e.preventDefault();
    $('html, body').animate({ scrollTop:  $('#work').offset().top+50}, 200);
  });

  $('#aboutLink').click(function(e){
    e.preventDefault();
    $('html, body').animate({ scrollTop:  $('#about').offset().top}, 300);
  });

  $('#vid1bt').click(function(e){
    if($('#vid1').css("display")=="none"){
      $('#vid1').toggle();
    }
  });

  $('#vid2bt').click(function(e){
    if($('#vid2').css("display")=="none"){
      $('#vid2').toggle();
    }
  });

  $('#photos div').click(function(e){
    //console.log(e.target.id);
    $('#pview').css({
      "padding-bottom":"40%"
    });
    setImg(e.target.id.substring(1,3));
    if($(document).scrollTop()>$('#phot').offset().top){
      $('html, body').animate({ scrollTop:  $('#phot').offset().top-30}, 100);
    }
  });

  $currentImage="00";

  function setImg(num){
    $currentImage = num
    $('#phot').css({
      "background-image":"url(/img/pic"+num+".jpg)"
    });
  }

  $('#forwardbutton').click(function(e){
    $bgimg = $('#phot').css("background-image");
    //document.getElementById("workTitle").innerHTML=$bgimg;
    //console.log("asdf");
    if($bgimg!="none"){
      $num = parseInt($currentImage)+1;
      if($num==13){$num=1;}
      if($num>=10){
        $next = $num.toString();
      }else{
        $next = "0"+$num.toString();
      }
      setImg($next);
    }
  });

  $('#backbutton').click(function(e){
    $bgimg = $('#phot').css("background-image");
    if($bgimg!="none"){
      $num = parseInt($currentImage)-1;
      if($num==0){$num=12;}
      if($num>=10){
        $next = $num.toString();
      }else{
        $next = "0"+$num.toString();
      }
      setImg($next);
    }
  });

  $('#closebutton').click(function(e){
    $('#pview').css({
      "padding-bottom":"0%"
    });
  });
  
});