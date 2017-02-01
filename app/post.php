<?php

include("dbConn.php");

function search_posts($pattern){
	$db = new dbConn();

	$search_string = "%${pattern}%";

	$res = $db->query("
		SELECT posts.id, posts.title FROM posts
		LEFT JOIN photos ON photos.post_id = posts.id
		WHERE posts.title LIKE ?
			OR posts.slug LIKE ?
			OR photos.description LIKE ?
		", $search_string, $search_string, $search_string);

	return $res;
}

function get_post_ids_before($nr, $id){
	$db = new dbConn();

	$res = $db->query("
			SELECT id FROM posts 
			WHERE (created, id) < ((SELECT created FROM posts WHERE id = ?), ?)
			ORDER BY created DESC, id DESC LIMIT ?"
		, $id, $id, $nr);

	return $res;
}

function get_posts_ids_until($id){
	$db = new dbConn();

	$res = $db->query("
			SELECT id FROM posts 
			WHERE (created, id) >= ((SELECT created FROM posts WHERE id = ?), ?)
			ORDER BY created DESC, id DESC"
		, $id, $id);

	return $res;
}

function get_post_data($id){
	$db = new dbConn();

	$res = $db->query("SELECT id, title, DATE_FORMAT(created, '%d.%m.%Y') AS created FROM posts WHERE id = ?", $id);

	if(count($res) == 0){
		return -1;
	}

	return $res[0];
}


function get_newest_post_ids($nr){
	$db = new dbConn();

	$res = $db->query("SELECT id FROM posts ORDER BY created DESC, id DESC LIMIT ?", $nr);

	return $res;
}


function generate_post_html($post, $pics){
	// $pics is array of $pic data with added 
	// field "nr_comments" on each pic.
?>
	<article id="<?php echo "post_" . $post["id"] ?>">
		<h2 class="f2 ma0 mt2 mb1"><?php echo htmlspecialchars($post["title"]) ?></h2>
		<h3 class="f5 ma0 mb3"><?php echo htmlspecialchars($post["created"]) ?></h3>

		<?php foreach($pics as $pic){ ?>
			<a href="view.php?id=<?php echo $pic["id"] ?>">
				<img id="<?php echo "post_" . $post["id"] . "_" . $pic["id"]?>" src="<?php echo $pic["path"] ?>" class="blogPic" alt="<?php echo htmlspecialchars($pic["description"]) ?>">
				<p class="f5 mb3 mt05 alignRight"><?php echo $pic["nr_comments"] ?>&nbsp;<img src="img/cmt.png"></p>
			</a>
		<?php } ?>
		
	</article>
<?php
}




?>