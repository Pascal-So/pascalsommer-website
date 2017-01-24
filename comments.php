<?php

include_once("app/comment.php");

if(isset($_POST["photo_id"]) && isset($_POST["name"]) && isset($_POST["comment"])){
	post_comment(intval($_POST["photo_id"]), intval($_POST["name"]), intval($_POST["comment"]));
}

if(isset($_GET["photo_id"])){
	$photo_id = intval($_GET["photo_id"]);
	$comments = get_comments_array_by_photo($photo_id);

	array_map("generate_comment_html", $comments);
}

?>