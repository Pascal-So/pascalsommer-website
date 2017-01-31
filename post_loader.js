var nr_posts_to_load = 14;

var post_request_ongoing = false;

function set_post_request_ongoing(){
	post_request_ongoing = true;
	$("#bt_load_posts").hide();
	$("#loading").show();
}

function reset_post_request_state(){
	post_request_ongoing = false;
	
	if($("#no_more_posts").length == 0){
		// only show load_posts button if there are more posts left
		$("#bt_load_posts").show();
	}


	$("#loading").hide();
}

$(function(){
	var content_area = $("#blog");

	var matches = window.location.hash.match(/^#post_(\d+)_(\d+)$/);

	if(matches){ // specified post_id (e.g. blog/#post_35)
		var id = parseInt(matches[1]);
		var pic_id = parseInt(matches[2]);

		var post_element_id = window.location.hash;
		if($( post_element_id ).length){ // requested post is already loaded
			scrollTo($(post_element_id));
		}else{ // need to load requested post
			load_up_to(id, pic_id);
		}
	}else{ // did not specify post_id
		//if(content_area.html() == ""){
			load_initial(nr_posts_to_load);
		//}
	}

	$("#bt_load_posts").click(function(){
		if(post_request_ongoing){
			// need this check in addition to the one in `request()`, because
			// this function has the side effect of deleting the last_loaded_div
			return;
		}

		// div that contains the id of the oldest post that is currently loaded
		var last_loaded_div = $("#last_loaded");

		if(last_loaded_div.length){
			// load things before oldest_post_id_loaded
			var oldest_post_id_loaded = parseInt(last_loaded_div.html());
			last_loaded_div.remove();

			load_additional_before(oldest_post_id_loaded, nr_posts_to_load);
		}else{
			// no previous data here, or some other kind of weird error. reset.
			load_initial(nr_posts_to_load);	
		}
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
	if(post_request_ongoing){
		return;
	}
	set_post_request_ongoing();

	function send_request(){
		$.get( "get_posts.php?id=" + id.toString() + "&nr=" + nr.toString())
			.done(function(data){
				callback(data);
			})
			.fail(function(){
				alert("Error while loading post data. Please try again.");
			})
			.always(function(){
				setTimeout(reset_post_request_state, 200);
			});
	}

	setTimeout(send_request, 40);
}

function load_up_to(id, pic_id){
	request(id, 0, function(data){
		insert_post_data(true, data);
		setTimeout(function(){scrollTo($("#post_" + id.toString() + "_" + pic_id.toString()));}, 100);
		$("#no_more_posts").remove();
	});
}

function load_initial(nr){
	request(0, nr, function(data){
		insert_post_data(true, data);
	});
}

function load_additional_before(id, nr){
	request(id, nr, function(data){
		insert_post_data(false, data);
	});
}