<?php
  //print("hello");
  if(isset($_POST["name"]) && isset($_POST["content"]) && isset($_POST["post"])){
    $conn = new mysqli("localhost", "pascalsommer_ch", "Nosvctxk", "pascalsommer_ch");
    $prep = $conn->prepare("insert into comments (post, name, content) values (?, ?, ?)");
    $prep->bind_param("sss", $_POST["post"], $_POST["name"], $_POST["content"]);
    $prep->execute();
    $prep->close();

    
    $prep = $conn->prepare("select name, content, date_format(time, '%e.%c.%Y') from comments where post = ?");
    $prep->bind_param("s", $_POST["post"]);
    $prep->execute();
    $prep->bind_result($name, $content, $date);
    //$prep->fetch();
    //printf("a %s b", $name);
    while($prep->fetch()){
	//print($name);
	print("<div class='comment'><div class='date'>" . $date . "</div><h3>". htmlspecialchars($name) . "</h3><p>" . nl2br(htmlspecialchars($content)) . "</p></div>");
    }
    $prep->close();
    
    $conn->close();
  }
  //print("asdf");
  
?>