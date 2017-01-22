<?php

include("dbConn.php");


function get_post_ids_before($id, $nr){
	$db = new dbConn();

	$res = $db->query("
			SELECT id FROM posts 
			WHERE (created, id) < ((SELECT created FROM posts WHERE id = ?), ?)
			ORDER BY created DESC, id DESC LIMIT ?"
		, $id, $id, $nr);

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


function get_newest_post_id(){
	$db = new dbConn();

	$res = $db->query("SELECT id FROM posts ORDER BY created DESC, id DESC LIMIT 1");

	return $res[0]["id"];
}


function generate_post_html($post, $pics){
?>
	<article>
		<h2 class="f2 ma0 mt2 mb1"><?php echo $post["title"] ?></h2>
		<h3 class="f5 ma0 mb3"><?php echo $post["created"] ?></h3>

		<?php foreach($pics as $pic){ ?>
			<a href="link.php?id=<?php echo $pic["id"] ?>">
				<img src="<?php echo $pic["path"] ?>" class="blogPic" alt="<?php echo $pic["description"] ?>">
				<p class="f5 mb3 mt0 alignRight"><?php echo $pic["nr_comments"] ?> <img src="img/cmt.png"></p>
			</a>
		<?php } ?>
		
	</article>
<?php
}




?>