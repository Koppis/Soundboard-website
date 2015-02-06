
/* 
 * ***************************************************************************************
 * RECORDINGS
 * ***************************************************************************************
 */

function handle_recording_state(recording){
    if (recording == 1) {
        $('#recordbutton').css('color', 'red');
        $('#recordbutton').text("*Recording*");
        //disable record button
        $('#recordbutton').attr("disabled", "disabled");
        $('#recordbutton').removeClass("recordbutton");
        //disable play recorded-button					
    } else {
        $('#recordbutton').css('color', 'black');
        $('#recordbutton').text("Record");
        //enable buttons
        $('#recordbutton').removeAttr("disabled");
        $('#recordbutton').addClass("recordbutton");
    }
    console.log("recording: " + recording);
}



//Klikataan makedraggable-nappia
$("body").on('click', '#makedraggable', function() {
    makerecordingsdraggable();
    $(this).attr("disabled", "disabled");
});



//click new rcategory
$('body').on("click", "#newrcategory", function() {
    category = prompt("Anna uuden kategorian nimi");
    newdiv = $('<div>' + category + '<p></div>');
    newdiv.attr('class', 'rcategory');
    newdiv.attr('value', category);
    newdiv.css('min-height', 77);
    newdiv.css('min-width', 100);
    newdiv.css('max-width', '40%');
    newdiv.css('border', '2px solid');
    newdiv.css('margin', '10px');
    newdiv.css('padding', '5px');
    newdiv.css('float', 'left');
    newdiv.droppable({
        accept: ".recording",
        activeClass: "ui-state-highlight",
        drop: function(event, ui) {
            $(this).append(ui.draggable);
            console.log(ui.draggable.attr('title'));
            console.log($(this).attr('value'));

            $.ajax({
                type: 'POST',
                url: 'moverecording.php',
                data: {
                    rowid: ui.draggable.attr('title'),
                    newcat: $(this).attr('value')
                }
            });
        }
    });
    $('#recordings').prepend(newdiv);
});


//right click on recording
$('body').on("contextmenu", ".recording", function() {
    if ($("#modifyrecording").length == 0) {

        oldwidth = $(this).width();

        $(this).after('<div id="modbox" rec="'+$(this).attr('title')+'"><input id="modifyrecording" size="7" title="' + $(this).html() + '" value="' + $(this).html() + '"/>' +
            '<button id="deleterecording" style="padding:2px;min-width:20px;z-index:10;' +
            'position: relative;left: 10px;top: -8px;margin-left: -2px;margin-top : 10px;">x</button>'+
            '<div id="raty"></div>'+
            '</div>');

        $("#modbox").css('position', 'absolute');
        $("#modbox").css('top', $(this).position().top);
        $("#modbox").css('left', $(this).position().left);
        $("#modbox").css("z-index", "10");

        $("#modifyrecording").focus();
        $("#modifyrecording").select();
        $(this).attr("disabled", "disabled");
        $(this).css("position", "relative");
        $(this).css("z-index", "1");
        

        $('#raty').raty({numberMax:10,
                        path:'images/raty',
            click: memerate_handler});
        
        
            }
    return false;
});

function memerate_handler(rating, evt) {

    if (isNaN(parseInt(rating))) rating = 0;
    
    console.log("rec : "+$(this).prev().attr('title'));
    console.log("rating : "+(parseInt(rating)*2));
    console.log("myrating : "+(parseInt($(this).attr("data-myscore"))));

    if (rating == (parseInt($(this).attr("data-myscore")))) return;
    
    $.ajax({
    type: 'POST',
    url: 'ratememe.php',
    data: {
    rec:$(this).parent().attr('rec'),
    rating: (parseInt(rating)*2),
    user:session
    },
    success: function(data) {
    console.log(data);
    },
    error: function(data) {
    console.log(data);
    }


    });
}

//Modifying a recording
var modify_recording = function(element) {
    e_parent = $(element).parent().prev();
    newname = $(element).val();
    oldname = $(element).attr('title');
    rowid = e_parent.attr('title');
    if (newname != oldname) {
        $.ajax({
            type: 'POST',
            url: 'renamerecording.php',
            data: {
                rowid: rowid,
                newname: newname
            }
        });

    }

    e_parent.removeAttr("disabled");
    e_parent.html(newname);
    element.parent().remove();
};
//recordingmuokkausalue
$("body").on("blur", "#modifyrecording", function() {
    setTimeout($.proxy(function() {
        modify_recording($(this));
    }, this), 500);
});
//recordingmuokkausalueen napinpainallus
$("body").on("keypress", "#modifyrecording", function(e) {
    if (e.keyCode == 13) {
        modify_recording($(this));
    }
});



//poista reconrding
$('body').on("click", "#deleterecording", function() {
    //if (confirm("Oletko varma, että haluat poistaa aanityksen?")) {
    $.ajax({
        type: 'POST',
        url: 'deleterecording.php',
        data: {
            rowid: $(this).parent().prev().attr('title')
        }
    });
    recordings_revision += 1;
    $(this).parent().prev().remove();
    $('#modbox').remove();
    //}

});

//Painetaan record-nappia (joka on enabloitu)
$('body').on("click", ".recordbutton", function() {
    $.ajax({
        type: 'POST',
        url: 'playvlc.php',
        data: {
            yt: 0,
            path: "record"
        }
    });

});