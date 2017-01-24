var nr_posts_to_load = 14;

var request_ongoing = false;

function set_request_ongoing(){
	request_ongoing = true;
	$("#bt_load_posts").hide();
	$("#loading").show();
}

function reset_request_state(){
	request_ongoing = false;
	$("#bt_load_posts").show();
	$("#loading").hide();
}

$(function(){
	var content_area = $("#blog");

	var matches = window.location.hash.match(/^#post_\d+$/);

	if(matches){ // specified post_id (e.g. blog/#post_35)
		var id = parseInt(matches[1]);
		var post_element_id = window.location.hash;
		if($( post_element_id ).length){ // requested post is already loaded
			scrollTo($(post_element_id));
		}else{ // need to load requested post
			load_up_to(id);
		}
	}else{ // did not specify post_id
		if(content_area.html() == ""){
			load_initial(nr_posts_to_load);
		}
	}

	$("#bt_load_posts").click(function(){

	});
});

function insert_post_data(replace, data){
	var content_area = $("#blog");

	if(replace){
		content_area.html(data);
	}else{
		content_area.append(data);
	}
}

function request(id, nr, callback){
	if(request_ongoing){
		return;
	}
	set_request_ongoing();

	$.get( "get_posts.php?id=" + id.toString() + "&nr=" + nr.toString())
		.done(function(data){
			callback(data);
		})
		.fail(function(){
			alert("Error while loading post data. Please try again.");
		})
		.always(function(){
			setTimeout(reset_request_state, 200);
		});
}

function load_up_to(id){
	request(id, 0, function(data){
		insert_post_data(true, data);	
	});
}

function load_initial(nr){
	request(0, nr, function(data){
		insert_post_data(true, data);
	});
}

function load_additional_before(nr, id){
	request(id, nr, function(data){
		insert_post_data(false, data);
	});
}