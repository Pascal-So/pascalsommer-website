<?php
  //ini_set('display_errors', 1);
  //ini_set('display_startup_errors', 1);
  //error_reporting(E_ALL);


  $mysql_username = "root";//"pascalsommer_ch";
  $mysql_password = "";//"Nosvctxk";
  $mysql_database = "pascalsommer_ch";

  if(!isset($_POST["name"]) || !isset($_POST["content"]) || !isset($_POST["post"])){
    exit();
  }


  $conn = new mysqli("localhost", $mysql_username, $mysql_password, $mysql_database);

  $prep = $conn->prepare("insert into comments (post, name, content) values (?, ?, ?)");
  $prep->bind_param("sss", $_POST["post"], $_POST["name"], $_POST["content"]);
  $prep->execute();
  $prep->close();

  $prep = $conn->prepare("select name, content, date_format(time, '%e.%c.%Y') from comments where post = ?");
  $prep->bind_param("s", $_POST["post"]);
  $prep->execute();
  $prep->bind_result($name, $content, $date);

  while($prep->fetch()){
    print("<div class='comment'><div class='date'>" . $date . "</div><h3>". htmlspecialchars($name) . "</h3>");
    print("<p>" . nl2br(htmlspecialchars($content)) . "</p></div>");
  }

  $prep->close();
  
  $conn->close();

  
?>