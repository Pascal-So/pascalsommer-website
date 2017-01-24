<?php 

include_once('app/post.php');
include_once('app/photo.php');

function load_posts($ids){
	// takes array of ids, outputs html as side effect

	foreach($ids as $id){
		$post = get_post_data($id);
		$pics = get_photos_array_by_post($id);
		generate_post_html($post, $pics);
	}
}

$nr = 0;
$id = 0;

if(isset($_GET["id"])){
	$id = intval($_GET["id"]); // inval defaults to 0 on invalid input..
}
if(isset($_GET["nr"])){
	$nr = intval($_GET["nr"]);
}

// ids of posts to be loaded will be stored in here
$id_rows = array();

if($nr == 0 && $id > 0){
	// load from newest until this id
	$id_rows = get_posts_ids_until($id);
}elseif($nr > 0 && $id == 0){
	// initial - newest posts
	$id_rows = get_newest_post_ids($nr);
}elseif($nr > 0 && $id > 0){
	// load `nr` additional posts **after** `id`
	$id_rows = get_post_ids_before($nr, $id);
}else{
	// default action if nothing specified - load
	// 10 newest posts
	$id_rows = get_newest_post_ids(10);
}

function extract_id($result_row){
	return $result_row["id"];
}

$ids = array_map("extract_id", $id_rows);
load_posts($ids);

// id of oldest post contained in this request. this 
// will be used by the js to request additional posts. 
$last_loaded = end($ids);


?>

<!-- These divs are used as messages to the js on client side -->

<div id="last_loaded" class="hidden"><?php echo $last_loaded ?></div>


<?php


$nr_results = count($ids);
if($nr_results == 0){
	?>
	<div id="no_more_posts" class="hidden"></div>
	<?php
}

?>