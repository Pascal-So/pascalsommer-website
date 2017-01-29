function slugify(input){
	var output = "";
	var dash_in_last_char = true; // don't use dash as first char

	input = input.toLowerCase();

	var len = input.length;
	for(var i = 0; i < len; i++){
		var c = input[i];
		if(c.match(/[a-z0-9]/)){
			dash_in_last_char = false;
			output += c;
		}else if(c == "'"){
			// ignore this char, don't put line
		}else{
			if(!dash_in_last_char){
				output += '-';
			}
			dash_in_last_char = true;
		}
	}

	if(output.slice(-1) == '-'){
		// remove trailing dash
		output = output.slice(0, -1);
	}

	return output;
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
	var slug = tx_slug.val();

	check_slug(slug);
}