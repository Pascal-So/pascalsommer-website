function checkcomment(){
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

	return name_ok && comment_ok;
}

function scrollTo(target){
	$('html, body').animate({
        scrollTop: target.offset().top
    }, 150);
}

function scrollToLink(link, target){
	link.click(function() {
	    scrollTo(target);
	});
}