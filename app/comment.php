<?php

include_once('dbConn.php');

function get_comments_array_by_photo($photo_id){
	$db = new dbConn();

	$res = $db->query("SELECT id, name, COALESCE(website, '') AS website, comment, created FROM comments WHERE photo_id = ?", $photo_id);

	return $res;
}


?>