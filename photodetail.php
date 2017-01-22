<?php 

	

?>

<!DOCTYPE html>
<html>
<head>
	<title>Photo</title>
	<link rel="stylesheet" type="text/css" href="base.css">
	<link rel="stylesheet" type="text/css" href="photodetail.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

	<script type="text/javascript">
		function checkcomment(){
			var tx_name = $("#tx-name");
			var tx_comment = $("#tx-comment");

			tx_name.removeClass("invalidinput");
			tx_comment.removeClass("invalidinput");

			var name_ok = true;
			var comment_ok = true;

			if(tx_name.val()==""){
				name_ok = false;
				tx_name.addClass("invalidinput");
			}

			if(tx_comment.val()==""){
				comment_ok = false;
				tx_comment.addClass("invalidinput");
			}

			return name_ok && comment_ok;
		}
	</script>
</head>
<body class="alignCenter">

<h1 class="f4 ma2 uppercase">Title of post</h1>

<img src="img/ino2.jpg" class="pic ma0 mb1">

<br>

<a href="" class="f5 ma2"> <img src="img/lArrow.png"></a>
<a href="" class="f5 ma2" style="position: relative; bottom: -3px;"> <img src="img/menu.png"></a>
<a href="" class="f5 ma2"> <img src="img/rArrow.png"></a>
<span style="display: inline-block; width: 30px"></span>
<a href="#comments" class="f5 ma2" id="bt_comments">0&nbsp;<img src="img/cmt.png"></a>

<script type="text/javascript">
	$(function(){
		$("#bt_comments").click(function() {
		    $('html, body').animate({
		        scrollTop: $("#comments").offset().top
		    }, 200);
		});
	});
</script>


<div id="comments" class="comments ma0 mt4">
	<div class="card ma1">
		<h3 class="f5 ma0">Pascal - 10.02.2016</h3>
		<p class="f5 alignLeft ma0 mt2">Test lorem ipsum</p>
	</div><br>
	<div class="card ma1">
		<h3 class="f5 ma0">Someone with a really really long name - 20.02.2016</h3>
		<p class="f5 alignLeft ma0 mt2">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua.</p>
	</div><br>
	<div class="card ma1">
		<h3 class="f5 ma0">Pascal - 23.02.2016</h3>
		<p class="f5 alignLeft ma0 mt2">Test comment</p>
	</div><br>
	<div class="card ma1">
		<h3 class="f5 ma0">New Comment</h3>
		<form action="" method="post" onsubmit="return checkcomment()" class="ma0 mt2">
			<label for="tx-name" class="f5">Name: </label><br>
			<input type="text" id="tx-name" name="name" class="ma0 mt1 mb1 textinput"><br>
			<br>
			<label for="tx-comment" class="f5">Comment: </label><br>
			<textarea id="tx-comment" name="comment" class="ma0 mt1 mb1 textinput"></textarea><br>
			<br>
			<input type="submit" class="f5" value="Send"><br>
		</form>
	</div><br>
	<br>
</div>

</body>
</html>