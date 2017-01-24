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