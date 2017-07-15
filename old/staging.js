$(function(){
    $( "#sortable" ).sortable();
    //$( "#sortable" ).disableSelection();

    

    $(".bt-active").click(function(){
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

    $("#bt-publish").click(function(){
        send_picture_data();
        publish();
    });

});


function toggle_active(element){ // `element` is the parent jquery element <li>
    var info_active_div = element.children(".info-active");
    var current_state = parseInt(info_active_div.html());
    var new_state = 1-current_state;

    var bt_state = element.children(".bt-active");
    if(new_state){
        bt_state.removeClass("state-inactive");
        bt_state.addClass("state-active");
    }else{
        bt_state.removeClass("state-active");
        bt_state.addClass("state-inactive");
    }

    info_active_div.html((1-current_state).toString());
}


function publish(){
    var title = $("#tx-title").val();
    var slug = $("#tx-slug").val();
    var date = $("#tx-date").val();

    if(date.match(/^\s+$/)){
        date = "";
    }

    $.post("", {post_title: title, slug: slug, date: date})
        .done(function(data){
            alert(data);
        })
        .fail(function(){
            alert("upload failed due to networking errors");
        });
}

function get_picture_data(){
    return $(".thumbnail-div")
        .map(function(){
            return {
                id: $(this).children(".info-id").html(),
                active: $(this).children(".info-active").html(),
                description: $(this).children("textarea").val()
            };
        })
        .get();
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

    $.post("", {save_states: data})
        .done(function(ret){
            //console.log("saved data: " + data + "\nreturned:\n" + ret);
        })
        .fail(function(){
            alert("Error while saving data, please reload page and try again.");
        });
}
