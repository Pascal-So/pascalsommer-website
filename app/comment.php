<?php

include_once('dbConn.php');

function get_comments_array_by_photo($photo_id){
	$db = new dbConn();

	$res = $db->query("SELECT id, name, comment, DATE_FORMAT(created, '%d.%m.%Y') AS created FROM comments WHERE photo_id = ? ORDER BY created DESC", $photo_id);

	return $res;
}

function get_nr_comments_by_photo($photo_id){
	$db = new dbConn();

	$res = $db->query("SELECT COUNT(*) FROM comments WHERE photo_id = ?", $photo_id);

	return $res[0];
}

function post_comment($photo_id, $name, $comment){
	$db = new dbConn();

	$db->query("INSERT INTO comments (photo_id, name, comment) values (?, ?, ?)", $photo_id, $name, $comment);
}

function generate_comment_html($comment){
	?>
	<div class="card ma1">
		<h3 class="f5 ma0"><?php echo htmlspecialchars($comment["name"]) ?> - <?php echo htmlspecialchars($comment["created"]) ?></h3>
		<p class="f5 alignLeft ma0 mt2"><?php echo htmlspecialchars($comment["comment"]) ?></p>
	</div><br>
	<?php
}

?>