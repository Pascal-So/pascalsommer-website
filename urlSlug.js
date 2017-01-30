function slugify(input){

	return input
		.toLowerCase()
		.replace(/[^a-z0-9]/g, "-")
		.replace(/-+/g, "-")
		.replace(/^-/, "")
		.replace(/-$/, "");

}


function check_slug(slug){
	var tx_slug = $("#tx-slug");
	tx_slug.removeClass("invalidinput");
	//tx_slug.removeClass("validinput");

	$.post("", {check_slug: slug})
		.done(function(data){
			//console.log("slug check returned data: ", data);
			if(parseInt(data)){
				// slug ok
				tx_slug.removeClass("invalidinput");
				tx_slug.addClass("validinput");
			}else{
				// slug not ok
				tx_slug.removeClass("validinput");
				tx_slug.addClass("invalidinput");
			}
		})
		.fail(function () {
			alert("error when contacting server. please try again");
		});
}

function generate_slug(){
	var tx_title = $("#tx-title");
	var tx_slug = $("#tx-slug");

	var input = tx_title.val();
	var slug = slugify(input);
	tx_slug.val(slug);
	slug_changed();
}

function slug_changed() {
	var tx_slug = $("#tx-slug");
	var slug = slugify(tx_slug.val());
	tx_slug.val(slug);

	check_slug(slug);
}