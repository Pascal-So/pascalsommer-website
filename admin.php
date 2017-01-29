<?php

include_once("app/dbConn.php");

session_start();

function redirect($address){
	header("Location: ".$address);
	die();
}

$is_logged_in = isset($_SESSION["access_granted"]) && $_SESSION["access_granted"] == 1;

if(!$is_logged_in){
	redirect("login.php");
}

if(isset($_POST["delete_post"])){
	$id = intval($_POST["delete_post"]);

	$db = new dbConn();
	
	$count = $db->query("SELECT count(*) as count FROM posts WHERE id = ?", $id);

	if($count[0]["count"] == 0){
		// post doesn't exist;
		die("post doesn't exist");
	}

	$folder_path = $db->query("SELECT slug FROM posts WHERE id = ?", $id)[0]["slug"];



	$db->query("DELETE FROM posts WHERE id = ?", $id);

	$pics_assoc = $db->query("SELECT id, path FROM photos WHERE post_id = ?", $id);

	foreach($pics_assoc as $pic_assoc){
		$pic_id = $pic_assoc["id"];
		$pic_path = $pic_assoc["path"];

		unlink($pic_path); // delete pic from filesystem.

		$db->query("DELETE FROM comments WHERE photo_id = ?", $pic_id);
	}
	


	$db->query("DELETE FROM photos WHERE post_id = ?", $id);

	if(!rmdir($folder_path)){
		die("couldn't delete folder " . $folder_path); 
	}

	die("1"); // ok
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<title>Admin</title>

	<link rel="stylesheet" href="base.css"/>
	<link rel="stylesheet" href="upload.css"/>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

</head>
<body class="alignCenter">

<script type="text/javascript">

function delete_post(post_id) {
	if(confirm("Do you really want to delete post " + post_id.toString() + "?")){
		$.post("", {delete_post: post_id})
			.done(function (data){
				var ok = data == "1";
				if(ok){
					alert("Deleting was successful.");
				}else{
					alert(data);
				}
			})
			.fail(function(){
				alert("Error when deleting post");
			});
	}else{
		return;
	}
}

$(function(){
	$("#bt-delete-post").click(function(){
		var post_id = $("#tx-post-id").val();
		delete_post(post_id);
	});
});
</script>

<h1 class="f1 ma0 mt2 mb5">Delete Post</h1>
<br>
<input class="textinput f5" type="number" name="post_id" id="tx-post-id"><br>
<div class="button f5 mt2" id="bt-delete-post">Delete</div>




</body>
</html>