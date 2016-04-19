<?php

  $mysql_username = "root";//"pascalsommer_ch";
  $mysql_password = "";//"Nosvctxk";
  $mysql_database = "pascalsommer_ch";


  $entries = scandir("entries", 1);
  $month = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

  function printPost($entry, $conn){
    global $mysql_username, $mysql_password, $mysql_database, $month;
    $nameparts = explode("_", $entry);
    $title = str_replace("-", " ", $nameparts[1]);
    $dateparts = explode(".",$nameparts[0]);
    $datestring = $dateparts[2] . ". " . $month[intval($dateparts[1])] . " " . $dateparts[0];

    print("<div class='entry'>");
    print("  <h2>".$title."</h2><hr>");
    print("  <div class='entrycontent'>");

    // -------------------- Pictures ----------------

    $pics=scandir("entries/".$entry);
    foreach($pics as $p){
      if($p!="." && $p!=".."){
        print("<img src = 'entries/".$entry."/".$p."'>");
      }
    }
    print("  </div><hr>");
    print("  <div class='lower'><p class='date'>".$datestring."</p>");


    // -------------------- Comments -----------------

    $query="select name, content, date_format(time, '%e.%c.%Y') as date from comments where post = '". $entry . "'";
    $result = $conn->query($query);
    if($result->num_rows>0){
      if($result->num_rows>1){
        print("<p class='togglecomments'>".$result->num_rows." comments</p>");
      }else{
        print("<p class='togglecomments'>1 comment</p>");
      }
      print("<div class='comments'>");
      while($row=$result->fetch_assoc()){
        print("<div class='comment'><div class='date'>".$row["date"]."</div>");
        print("<h3>".htmlspecialchars($row["name"])."</h3><p>".nl2br(htmlspecialchars($row["content"]))."</p></div>");
      }
      print("</div>");
    }else{
      print("<p class='togglecomments'>no comments yet</p>");
      print("<div class='comments'></div>");
    }
    print("<div class='newcomment'><form method='POST' action='postcomment.php'>");
    print("<input type='hidden' name='post' value='" . $entry . "'>");
    print("<p>Name:</p><input type='text' placeholder='' name='name'><br>");
    print("<p>Comment:</p><textarea name='content'></textarea><br>");
    print("<input type='submit' value='submit'></form>");
    print("</div></div></div>");
  }
?>

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
  <div style="display:none;" id="phpinfo">
    <?php
      print(count($entries)-2);
    ?></div>
<div style="display:none;" id="args"><?php
if(isset($_GET["show"])){
    print $_GET["show"];
}
print "-";
if(isset($_GET["start"])){
    print $_GET["start"];
}
?></div>
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
<?php     
  $conn = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

  foreach($entries as $e){   
    if($e!="." && $e!=".."){        
      printPost($e, $conn);
    }      
  }
  $conn->close();

?>

<div id="older" class="button">show older posts</div>
</div>

<div id="footer">
  <div id="overlay">
    <p>copyright</p>
    <span>Pascal Sommer | 2016</span>
  </div>
</div>

</body>
</html>
