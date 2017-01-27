<?php

include_once("app/dbConn.php");
include_once("app/staging.php");

session_start();

function redirect($address){
	header("Location: ".$address);
	die();
}

$is_logged_in = isset($_SESSION["access_granted"]) && $_SESSION["access_granted"] == 1;

if(!$is_logged_in){
	redirect("login.php");
}


// check slug, returns bool if slug is ok as 0 or 1

if(isset($_POST["check_slug"])){
	$slug = $_POST["check_slug"];
	$date = date("Y-m-d");
	$combined_slug = $date . "-" . $slug;

	$db = new dbConn();

	$res = $db->query("SELECT id FROM posts WHERE slug = ?", $combined_slug);

	if(count($res) > 0){
		// not ok
		echo 0;
	}else{
		// slug is ok
		echo 1;
	}

	die();
}

// delete pic from staging area

if(isset($_POST["delete_pic"])){
	$id = intval($_POST["delete_pic"]);

	$res = delete_staged_pic($id);
	if(!$res){
		die("Error");
	}

	die();
}

// save states

if(isset($_POST["save_states"])){
	$states = json_decode($_POST["save_states"]);

	if($states == NULL){
		die("invalid format");
	}
	save_states($states);

	die();
}


// publish post
if(isset($_POST["post_title"]) && isset($_POST["slug"])){
	// $_POST["order"] is a json array
	$date = date("Y-m-d");
	$combined_slug = $date . "-" . $_POST["slug"];
	$title = $_POST["slug"];

	// attempt to create directory where the pics will be moved
	$path = "posts/" . $combined_slug;
	if(!mkdir($path)){
		die("Error while creating dir ${path}.");
	}

	// create the entry in post table
	$db = new dbConn();
	$db->query("INSERT INTO posts (title, slug) VALUES (?, ?)", $title, $combined_slug);
	$post_id = $db->insert_id;

	$pics = $db->query("SELECT path, description FROM staging WHERE active = 1 ORDER BY order DESC");

	// move every pic, then add it to the pics table
	for($pics as $pic){
		$old_path = $pic["path"];
		$basename = basename($old_path);
		$new_path = $path . $basename;

		if(!rename($old_path, $new_path)){
			echo "<h1 class='f1'>Error when moving file: Left file ${basename} in ${old_path}, fix manually and adjust `path` value in `photos` table.</h1>";
			$new_path = $old_path;
		}

		$db->query("
			INSERT INTO photos (post_id, path, description) VALUES 
			(?,?,?)
			", $post_id, $new_path, $pic["description"]);
	}

	$db->query("DELETE FROM order WHERE active = 1");
}

// upload pictures to staging area

if(isset($_FILES["pictures"])){

	function array_transpose($array) {
		if (!is_array($array)) return false;
	    $return = array();
	    foreach($array as $key => $value) {
	        if (!is_array($value)) return $array;
	        foreach ($value as $key2 => $value2) {
	            $return[$key2][$key] = $value2;
	        }
	    }
	    return $return;
	} 

	$transposed_files = array_transpose($_FILES);

	foreach($transposed_files as $file){
		upload_file($file["tmp_name"], $file["name"]);
	}

}


$db = new dbConn();

$pics = $db -> query("SELECT id, path, description, active FROM staging ORDER BY order ASC");

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<title>Upload post</title>

	<link rel="stylesheet" href="base.css"/>
	<link rel="stylesheet" href="upload.css"/>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<script type="text/javascript" src="urlSlug.js"></script>
	<script type="text/javascript" src="staging.js"></script>
</head>
<body class="alignCenter">



<h1 class="f1 ma0 mt2 mb5">Upload post</h1>

<section class="mt4 mb8">
	<h2 class="f3 mb2">Upload photos</h2>

	<form action="upload.php" method="post" enctype="multipart/form-data">
		<input multiple="multiple" type="file" accept="image/*" name="pictures[]">
		<br>
		<input type="submit" name="ok" value="Upload" class="button ma0 mt3 f5">
	</form>

</section>


<section class="mt4 mb8">
	<h2 class="f3 mt1 mb2">Staging area</h2>

	<ul id="sortable" class="ma0">
		<?php
		for($pics as $pic){
			generate_staged_item_html($pic);
		}
		?>
	</ul>
	<br>
	<div class="button ma0 mt3 f5" id="bt-save">Save descriptions and states</div><br><br>
</section>



<section class="mt4 mb8">
	<h2 class="f3 mb2">Publish active photos</h2>
	<br>
	<label class="f5 inline-block" for="tx-title">Title</label><br>
	<input class="mt1 mb3 textinput" type="text" id="tx-title" name="title" oninput="generate_slug()"><br>
	<label class="f5 inline-block" for="tx-slug">Slug</label><br>
	<input class="mt1 mb3 textinput" type="text" id="tx-slug"  name="slug" oninput="slug_changed()">
	<br>
	<div class="button ma0 mt3 f5" id="bt-publish">PUBLISH POST</div><br><br>
</section>



</body>
</html>