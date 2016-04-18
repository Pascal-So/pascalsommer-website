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

    $start = 0;
    $showentries = 8;
    var arg=$("#args").html();
    //console.log(arg);
    $args=arg.split("-");
    if($args[0]!=""){
        $showentries = parseInt($args[0]);
    }
    if($args[1]!=""){
        $start = parseInt($args[1]);
    }
    
    $nrentries = parseInt($("#phpinfo").html());
    if($start+$showentries>$nrentries){
        $("#older").hide();
    }

    $(".entry").slice($start, $start + $showentries).show();
    $("#older").click(function(){
	$(".entry").hide();
	$start += $showentries;
	if($start > 0){
	    $("#newer").show();
	}
	if($start + $showentries >= $nrentries){
	    
	    $("#older").hide();
	}
	$(".entry:hidden").slice($start, $start + $showentries).show();
	$('html, body').animate({ scrollTop:  $('#blog').offset().top}, 0);
    });
    $("#newer").click(function(){
	$(".entry").hide();
	$start -= $showentries;
	if($start <= 0){
	    $start = 0;
	    $("#newer").hide();
	}
	$("#older").show();
	$(".entry:hidden").slice($start, $start + $showentries).show();
	$('html, body').animate({ scrollTop:  $('#blog').offset().top}, 0);
    });

    $('#blogLink').click(function(e){
	e.preventDefault();
	$('html, body').animate({ scrollTop:  $('#blog').offset().top}, 200);
    });


    $(".togglecomments").click(function(e){
	//console.log("hi");
	$(e.target).siblings(".comments").toggle();
	$(e.target).siblings(".newcomment").toggle();
	//$('html, body').animate({ scrollTop:  $(e.target).offset().top}, 0);  
    });

    $("form").on("submit", function(e){
	$nameObj = $(this).children("input[type='text']");
	$contentObj = $(this).children("textarea");
	$commentsDiv = $(this).parent().siblings(".comments");
	$nameObj.css({
            'background-color':'#080808'
	});
	$contentObj.css({
            'background-color':'#080808'
	});

	if($nameObj.val()==""){
            $nameObj.css({
		'background-color':'#511'
            });
            return false;
	}
	if($contentObj.val() == ""){
            $contentObj.css({
		'background-color':'#511'
            });
            return false;
	}

	e.preventDefault();
	$.ajax({
            url: "postcomment.php",
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
		$commentsDiv.html(data);
		console.log(data);
		$nameObj.val("");
		$contentObj.val("");
            }
	});
    });

});
