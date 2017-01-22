<?php

include_once('dbConn.php');

function get_photos_array_by_post($post_id){
	$db = new dbConn();

	$res = $db->query("SELECT id, path, COALESCE(description, '') AS description FROM photos WHERE post_id = ?", $post_id);

	return $res;
}


function get_photo($photo_id){
	$db = new dbConn();

	$res = $db->query("SELECT id, path, COALESCE(description, '') AS description, DATE_FORMAT(created, '%d.%m.%Y') AS created 
					   FROM photos WHERE id = ?", $photo_id);

	return $res;
}

function get_previous_photo_id($photo_id){
	$db = new dbConn();

	$post_id_created = $db->query("
		SELECT posts.id, posts.created FROM photos INNER JOIN posts ON posts.id = photos.post_id 
		WHERE photos.id = ?", $photo_id);

	if(count($post_id_created) == 0){
		return -1;
	}

	$post_id_created = $post_id_created[0];

	$res = $db->query("
		SELECT photos.id FROM photos INNER JOIN posts On posts.id = photos.post_id
		WHERE (posts.created, posts.id, photos.id) < (?, ?, ?)
		ORDER BY posts.created DESC, posts.id DESC, photos.id DESC
		LIMIT 1", 
		$post_id_created["created"], $post_id_created["id"], $photo_id);

	if(count($res) == 0){
		return -1;
	}else{
		return $res[0]["id"];
	}
}

?>