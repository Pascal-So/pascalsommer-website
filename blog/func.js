$(document).ready(function(){

    var vh = $('header').height();
    var vw = $('header').width();

    var picheight = vh;

    if(vh*1920<vw*1101){
		picheight=vw*1101/1920;
    }

    $('header').css({
		"height":vh,
		"background-size":"auto "+ picheight + "px"
    });

    function addCommentEvents(){
    	$(".togglecomments").click(function(e){
			$(e.target).siblings(".comments").toggle();
			$(e.target).siblings(".newcomment").toggle();
	    });

	    $("form").on("submit", function(e){
			var nameObj = $(this).children("input[type='text']");
			var contentObj = $(this).children("textarea");
			var commentsDiv = $(this).parent().siblings(".comments");
			nameObj.css({
		        'background-color':'#080808'
			});
			contentObj.css({
		      	'background-color':'#080808'
			});

			if(nameObj.val()==""){
		        nameObj.css({
					'background-color':'#511'
		        });
	            return false;
			}
			if(contentObj.val() == ""){
	            contentObj.css({
					'background-color':'#511'
	            });
	            return false;
			}

			e.preventDefault();
			$.post("postcomment.php", $(this).serialize())
				.done(function(data){
					commentsDiv.html(data);
					nameObj.val("");
					contentObj.val("");
				});
	    });
    }

    function showEntries(startE, nrE){
    	$.post("fetchPosts.php", {start: startE, nr: nrE})
    		.done(function(data){
    			$("#blog").append(data);
    			addCommentEvents();
    		});
    }

    var infoString = $("#show").html();
    var parts = infoString.split("-");
    var currentEntry = parseInt(parts[0]);
    var nrEntries = parseInt(parts[1]);

    showEntries(currentEntry, nrEntries);

    $("#older").click(function(){
    	currentEntry+=nrEntries;
    	showEntries(currentEntry, nrEntries);
	});


    $('#blogLink').click(function(e){
		e.preventDefault();
		$('html, body').animate({ scrollTop:  $('#blog').offset().top}, 200);
    });

});
