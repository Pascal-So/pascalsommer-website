$(function(){
    $( "#sortable" ).sortable();
    $( "#sortable" ).disableSelection();

    function toggle_active(element){ // element is the parent jquery element
        var info_active_div = element.children(".info-active");
        var current_state = parseInt(info_active_div.html());
        var new_state = 1-current_state;

        var thumbnail = element.children("img");
        if(new_state){
            thumbnail.removeClass("thumbnail-inactive");
            thumbnail.addClass("thumbnail-active");
        }else{
            thumbnail.removeClass("thumbnail-active");
            thumbnail.addClass("thumbnail-inactive");
        }

        info_active_div.html((1-current_state).toString());
    }

    $(".thumbnail-div img").click(function(){
    	toggle_active($(this).parent());
    });

});


function extract_data(){

}

function extract_active_ids(){
    
}