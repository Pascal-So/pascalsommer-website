<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Pascal Sommer</title>

  <link rel="shortcut icon" href="../img/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="main.css">
  <script src="../js/jquery-2.1.4.min.js"></script>
  <script src="func.js"></script>
</head>

<body>
<?php
print "<div id='show' style='display:none'>";
if(isset($_GET["start"])){
  print $_GET["start"];
}else{
  print "0";
}
print "-";
if(isset($_GET["nr"])){
  print $_GET["nr"];
}else{
  print "6";
}
print "</div>";
?>
<header>
  <div id="title">
    <div id="titleText">
      <span>PASCAL SOMMER</span>
      <p>PHOTOGRAPHY</p>
    </div>
  </div>
  <br>
  
  <nav>
    <span id="workLink"><a href="../#work">WORK</a></span>
    <span id="aboutLink"><a href="../#about">ABOUT ME</a></span>
    <span id="blogLink"><a href="#blog">BLOG</a></span>
  </nav>
</header>

<div id="newer" class="button">show newer posts</div>

<div id="blog">



</div>
<div id="older" class="button">show older posts</div>

<div id="footer">
  <div id="overlay">
    <p>copyright</p>
    <span>Pascal Sommer | 2016</span>
  </div>
</div>

</body>
</html>
