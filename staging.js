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

    $(".bt-delete").click(function(){
        var div = $(this).parent();
        var id = parseInt(div.children(".info-id").html());
        delete_pic(id, div);
    });

    $("#bt-save").click(function (){
        send_picture_data();
    });

    $("bt-publish").click(function(){
        send_picture_data();
        publish();
    });

});

function publish(){
    var title = $("tx-title").val();
    var slug = $("tx-slug").val();

    $.post("", {post_title: title, slug: slug})
        .done(function(){
            alert("upload successful");
        })
        .fail(function(){
            alert("upload failed");
        });
}

function get_picture_data(){
    return $(".thumbnail-div")
        .map(function(){
            return {
                id: $(this).children(".info-id").html(),
                active: $(this).children(".info-active").html();
                description: $(this).children("textarea").val();
            }
        });
}

function delete_pic(id, div){
    if(confirm("Do you really want to delete picture " + id.toString() + " from the staging area?")){
        $.post("", {delete_pic: id})
            .done(function(){
                div.remove();
            })
            .fail(function(){
                alert("Error while deleting picture, please reload page and try again.");
            });
    }
}

function send_picture_data(){
    // ignores the order, is only used for saving active/inactive and description data.

    var data = JSON.stringify(get_picture_data());
}
