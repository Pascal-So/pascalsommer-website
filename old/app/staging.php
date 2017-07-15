<?php

include_once("dbConn.php");

function save_states($states){

	$db = new dbConn();
	
	$index = 4;
	foreach($states as $state){
		$db->query("
			UPDATE staging SET active = ?, description = ?, ordering = ? 
			WHERE id = ?", 
			$state["active"], $state["description"], $index, $state["id"]);

		$index++;
	}
}

function delete_staged_pic($id){
	if($id == 0){
		return false;
	}

	$db = new dbConn();

	$res = $db->query("SELECT path FROM staging WHERE id = ?", $id);
	if(count($res) == 0){
		return false;
	}

	$path = $res[0]["path"];

	unlink($path); // delete the file

	$db->query("DELETE FROM staging WHERE id = ?", $id);

	return true;
}

function generate_safe_name($name){
	$chars = str_split($name);
	$good_chars = array_filter($chars, function($char){
		return ctype_alnum($char) || $char == "." || $char == "-" || $char == "_";
	});

	$good_string = implode("", $good_chars);

	if($good_string == ""){
		$good_string = "photo";
	}

	return $good_string;
}

function generate_collision_avoiding_name($name){
	if(preg_match('/^(.*)_(\d+).(\w+)$/', $name, $matches)){
		$base = $matches[1][0];
		$num = intval($matches[2][0]);
		$ext = $matches[3][0];
		return $base . '_' . (string)($num + 1) . '.' . $ext;
	}elseif(preg_match('/^(.*).(\w+)$/', $name, $matches)){
			$base = $matches[1][0];
			$ext = $matches[2][0];
			return $base . '_1.' . $ext;
	}else{
		return $name . "_1";
	}
}

function upload_file($tmp_name, $target_filename){

	$target_filename = generate_safe_name($target_filename);

	$target_dir = "staging_area/";

	while(file_exists($target_dir . $target_filename)){
		$target_filename = generate_collision_avoiding_name($target_filename);
	}

	$target = $target_dir . $target_filename;


	if(!move_uploaded_file($tmp_name, $target)){
		die("Error: Could not move file ${target_filename} from ${tmp_name} to ${target}.");
	}

	$db = new dbConn();

	$db->query("INSERT INTO staging (path, active) VALUES (?, 1)", $target);
}


function generate_staged_item_html($pic){
	$active_class = ($pic["active"] == 1) ? "state-active" : "state-inactive";

	?>
		<li class="ui-state-default inline-block ma1 mt2 thumbnail-div">
			<img src=" <?php echo $pic["path"] ?> " class="ma0">
			<div class="button bt-active  <?php echo $active_class ?>  mt05 mb05">Active state</div>
			<br>
			<textarea name="description" id="tx-description" class="ma0 textinput mb05"><?php echo htmlspecialchars($pic["description"]) ?></textarea>
			<div class="button bt-delete">Delete</div>
			<div class="info-id hidden"><?php echo $pic["id"] ?></div>
			<div class="info-active hidden"><?php echo $pic["active"] ?></div>
		</li>
	<?php

	/*
	<li class="ui-state-default inline-block ma1 mt2 thumbnail-div">
			<img src="img/ino.jpg" class="ma0">
			<div class="button bt-active state-active mt05 mb05">Active state</div>
			<br>
			<textarea name="description" id="tx-description" class="ma0 textinput mb05"></textarea>
			<div class="button bt-delete">Delete</div>
			<div class="info-id hidden">1</div>
			<div class="info-active hidden">1</div>
		</li>
		*/
}

?>
