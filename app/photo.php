<?php

include_once('dbConn.php');

function get_photos_array_by_post($post_id){
	$db = new dbConn();

	$res = $db->query("SELECT photos.id, photos.path, COALESCE(photos.description, ''), count(comments.photo_id) AS description FROM photos LEFT JOIN comments ON comments.photo_id = photos.id GROUP BY comments.photo_id WHERE photos.post_id = ?", $post_id);

	return $res;
}


function get_photo($photo_id){
	$db = new dbConn();

	$res = $db->query("SELECT photos.id, photos.path, COALESCE(photos.description, '') AS description, posts.title as post_title
					   FROM photos INNER JOIN posts ON posts.id = photos.post_id WHERE photos.id = ?", $photo_id);

	if(count($res) == 0){
		return -1;
	}else{
		return $res[0];
	}
}

function get_newest_photo_id(){
	$db = new dbConn();

	$res = $db->query("SELECT photos.id FROM photos INNER JOIN posts ON posts.id = photos.post_id ORDER BY posts.created DESC, posts.id DESC, photos.id DESC LIMIT 1");

	if(count($res) == 0){
		// no photo available
		return -1;
	}

	return $res[0]["id"];
}

function get_post_id_created($photo_id){
	$db = new dbConn();

	$post_id_created = $db->query("
		SELECT posts.id, posts.created FROM photos INNER JOIN posts ON posts.id = photos.post_id 
		WHERE photos.id = ?", $photo_id);

	if(count($post_id_created) == 0){
		// invalid photo specified
		return -1;
	}else{
		return $post_id_created[0];
	}
}

function get_previous_photo_id($photo_id){

	$post_id_created = get_post_id_created($photo_id);

	if($post_id_created == -1){
		// invalid photo specified
		return -1;
	}

	$res = $db->query("
		SELECT photos.id FROM photos INNER JOIN posts On posts.id = photos.post_id
		WHERE (posts.created, posts.id, photos.id) < (?, ?, ?)
		ORDER BY posts.created DESC, posts.id DESC, photos.id DESC
		LIMIT 1", 
		$post_id_created["created"], $post_id_created["id"], $photo_id);

	if(count($res) == 0){
		// no previous photo available
		return -1;
	}else{
		return $res[0]["id"];
	}
}

function get_next_photo_id($photo_id){

	$post_id_created = get_post_id_created($photo_id);

	if($post_id_created == -1){
		// invalid photo specified
		return -1;
	}

	$res = $db->query("
		SELECT photos.id FROM photos INNER JOIN posts On posts.id = photos.post_id
		WHERE (posts.created, posts.id, photos.id) > (?, ?, ?)
		ORDER BY posts.created ASC, posts.id ASC, photos.id ASC
		LIMIT 1", 
		$post_id_created["created"], $post_id_created["id"], $photo_id);

	if(count($res) == 0){
		// no newer photo available
		return -1;
	}else{
		return $res[0]["id"];
	}
}

function generate_pic_html($pic, $prev_id, $next_id){
	?>
	<h1 class="f4 ma2 uppercase"><?php echo htmlspecialchars($pic["post_title"]) ?></h1>

	<img src="<?php echo $pic["path"] ?>" class="pic ma0 mb1" alt="<?php echo htmlspecialchars($pic["description"]) ?>">

	<br>

	<?php if($prev_id != -1){ // link to previous pic ?>
	<a href="?id=<?php echo $prev_id ?>" class="f5 ma2"> <img src="img/lArrow.png"></a>
	<?php } ?>

	<!-- link to main menu -->
	<a href="../" class="f5 ma2" style="position: relative; bottom: -3px;"> <img src="img/menu.png"></a>

	<?php if($next_id != -1){ // link to next pic ?>
	<a href="?id=<?php echo $next_id ?>" class="f5 ma2"> <img src="img/rArrow.png"></a>
	<?php } ?>	

	<span style="display: inline-block; width: 30px"></span>
	<a href="#comments" class="f5 ma2" id="bt_comments"><?php echo $pic["nr_comments"] ?>&nbsp;<img src="img/cmt.png"></a>

	<?php
}

?>