var nr_posts_to_load = 14;

$(function(){
	var matches = window.location.hash.match(/^post_\d+$/);

	if(matches){ // specified post_id (e.g. blog/#post_35)
		var id = parseInt(matches[1]);
		load_up_to(id);

	}else{ // did not specify post_id
		load_initial(nr_posts_to_load);
	}
});

function insert_post_data(data){

}

function load_up_to(id){

}

function load_initial(nr){

}

function load_additional_before(nr, id){

}