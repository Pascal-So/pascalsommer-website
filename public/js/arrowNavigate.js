
var left_el = document.getElementById('link-left');
var right_el = document.getElementById('link-right');

document.addEventListener('keydown', function(e){
    switch(e.keyCode){
    case 37: //left
        if(left_el != null){
            var url_left = left_el.href;

            window.location = url_left;
        }
        break;
    case 39: //right
        if(right_el != null){
            var url_right = right_el.href;

            window.location = url_right;
        }
        break;
    }
});