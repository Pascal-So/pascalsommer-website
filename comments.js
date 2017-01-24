var comment_request_ongoing = false;

function set_comment_request_ongoing(){
	comment_request_ongoing = true;
	$("#bt_send_comment").hide();
	$("#comments_loading").show();
}

function reset_comment_request_state(){
	comment_request_ongoing = false;
	$("#bt_send_comment").show();
	$("#comments_loading").hide();
}

function check_and_send_comment(){
	if(comment_request_ongoing){
		return false;
	}

	var tx_name = $("#tx-name");
	var tx_comment = $("#tx-comment");

	tx_name.removeClass("invalidinput");
	tx_comment.removeClass("invalidinput");

	var name_ok = true;
	var comment_ok = true;

	if(tx_name.val()==""){
		name_ok = false;
		tx_name.addClass("invalidinput");
	}

	if(tx_comment.val()==""){
		comment_ok = false;
		tx_comment.addClass("invalidinput");
	}

	//return name_ok && comment_ok;
	if(! (name_ok && comment_ok)){
		// some info missing
		return false;
	}

	set_comment_request_ongoing();

	var tx_photo_id = $("#tx-photo-id");

	var name = tx_name.val();
	var comment = tx_comment.val();
	var photo_id = tx_photo_id.val();

	var comments_body = $("#comments_body");

	$.post("comments.php?id=" + photo_id, {name: name, comment: comment, photo_id: photo_id})
		.done(function(data){
			comments_body.html(data);
		})
		.fail(function(){
			alert("Error while sending comment, please try again.");
		})
		.always(function(){
			reset_comment_request_state();
		});

	return false;
}