function scrollTo(target){
	if(target.length){
		$('html, body').animate({
	        scrollTop: target.offset().top
	    }, 300);
	}
}

function scrollToLink(link, target){
	link.click(function() {
	    scrollTo(target);
	});
}