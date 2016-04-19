<?php

if(!isset($_POST["start"]) || !isset($_POST["end"])){
	exit();
}

$start = intval($_POST["start"]);
$end = intval($_POST["end"]);

$entries = scandir("entries", 1);
$nrEntries = count($entries) -2;

if($start > $end || $start<0 || $start>=$nrEntries){
	exit();
}
$end = min($end, $nrEntries-1);

$mysql_username = "root";//"pascalsommer_ch";
$mysql_password = "";//"Nosvctxk";
$mysql_database = "pascalsommer_ch";

$month = array("", "Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec");

$conn = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

for($i = $start+2; $i<=$end+2; $i++){
	printPost($entries[$i]);
}

function printPost($entry){
    global $conn, $month;
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