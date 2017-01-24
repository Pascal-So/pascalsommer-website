<?php 


?>


<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon">
	<title>Pascal Sommer</title>
	<meta name="description" content="My personal Blog about Photography">
	<meta name="keywords" content="Pascal Sommer,Photography,Photos">
	<meta name="author" content="Pascal Sommer">

	<link rel="stylesheet" href="style.css"/>
	<link rel="stylesheet" type="text/css" href="base.css">
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script type="text/javascript" src="main.js"></script>
	<script type="text/javascript" src="post_loader.js"></script>

	<script type="text/javascript">
		$(function(){
			scrollToLink($("#link-blog"), $("#blog"));
		});
	</script>

</head>

<body class="alignCenter">

<header class="mb8">
	<h1 class="f1 ma0 mt5">Pascal Sommer<br>Photography</h1>
	<h2 class="f3 ma0 mt3 uppercase"><a href="#blog" id="link-blog" class="link">Blog</a></h2>
	<h2 class="f3 ma0 mt1 uppercase"><a href="about.html" class="link">About</a></h2>
	<h2 class="f3 ma0 mt1 uppercase"><a href="http://codelis.ch" class="link">Projects</a></h2>
	<p class="mt2">
		<a href="https://github.com/Pascal-So" class="ma1"><img alt="Social Media Icon Github"src="img/github.svg"></a>
		<a href="http://twitter.com/sommerpascal" class="ma1"><img alt="Social Media Icon Twitter"src="img/twitter.svg"></a>
		<a href="https://www.youtube.com/user/PascalSommerMovies" class="ma1"><img alt="Social Media Icon Youtube"src="img/youtube.svg"></a>
	</p>
</header>


<hr>

<section id="blog" class="mt5">

	<article>
		<h2 class="f2 ma0 mt2 mb1">Иннополис</h2>
		<h3 class="f5 ma0 mb3">20.01.2016</h3>
		<a href="photodetail.php">
			<img src="img/ino.jpg" class="blogPic">
			<p class="f5 mb3 mt0 alignRight">0&nbsp;<img src="img/cmt.png"></p>
		</a>
		<a href="photodetail.php">
			<img src="img/ino2.jpg" class="blogPic">
			<p class="f5 mb3 mt0 alignRight">0&nbsp;<img src="img/cmt.png"></p>
		</a>
	</article>
	
</section>
<!-- 
<div id="overlay" class="darken" style="display: block">
	<div class="zoom-img-container"></div>
</div> -->

</body>
</html>