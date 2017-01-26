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

    $("#bt-save").click(function (){
        extract_data();
    });

});


function get_picture_data(){
    return $(".thumbnail-div")
        .map(function(){
            return {
                id: $(this).children(".info-id").html(),
                active: $(this).children(".info-active").html() == 1;
                description: $(this).children("textarea").val();
            }
        });
}

function extract_data(){
    // ignores the order, is only used for saving active/inactive and description data.

    var data = JSON.stringify(get_picture_data());
}

function extract_order(){
    // only takes in to account the active pictures.

    var pic_ids = get_picture_data()
        .filter(function(el) {
            return el.active;
        })
        .map(function (el){
            return el.id;
        });

    var data = JSON.stringify(pic_ids);

    $.post()
}