
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


function handle_recordings(payload_recordings) {
if (parseInt(payload_recordings[payload_recordings.length - 1]) != recordings_revision) {

    if (payload_recordings.justone != undefined) {

        if ($('.recording[title="' + payload_recordings.rowid + '"]').length == 0 &&
            payload_recordings.deleted != 1 && payload_recordings.deleted != "1") {


            name = payload_recordings.name;
            if (payload_recordings.name == null || payload_recordings.name == '1')
                name = payload_recordings.rowid;


            newbutton = $('<button' +
                ' class="sbutton recording" title="' + payload_recordings.rowid +
                '" value="sounds\\recorded\\' + (payload_recordings.rowid) + '.wav">' + (name) + '</button>');

            $($("#recordings").children(".recording")[0]).before(newbutton);

        }

        recordings_revision = payload_recordings.revision;

        var rec = $('#recordings[title="' + payload_recordings.rowid + '"]');
        $(rec).html(payload_recordings.name);

        if (payload_recordings.deleted == 1 || payload_recordings.deleted == "1")
            $(rec).remove();
        if (payload_recordings.category != undefined) {
            $.each($('.rcategory[value="' + payload_recordings.category + '"] .recording'), function(i, element) {
                if (parseInt($(rec).attr("title")) > parseInt($(element).attr("title"))) {
                    $(element).before(rec);
                    return false;
                }
            });
        } else {
            $.each($('#recordings > .recording'), function(i, element) {
                if (parseInt($(rec).attr("title")) > parseInt($(element).attr("title"))) {
                    $(element).before(rec);
                    return false;
                }
            });

        }


    } else {

        recordings_revision = parseInt(payload_recordings.pop());

        div_recordings = document.getElementById('recordings'); 
        div_recordings.innerHTML = '<div id="rcat_1" style="float:left;width:50%;" ></div>'+
            '<div id="rcat_2" style="float:left;width:50%;" ></div>'+
            '<br style="clear:both" />';

        biggest = 0;
        rec_playcounts = [];
        console.log("line 816: " + (new Date().getTime() - start_time) + "ms");

        cats = {};
        $.each($('.rcategory'), function() {
            cats[$(this).attr('value')] = $(this);
        });

        $.each(payload_recordings.reverse(), function(i, rec) {


            rec_playcounts[parseInt(rec.rowid)] = (parseInt(rec.playcount));
            if (rec.playcount > biggest)
                biggest = rec.playcount;

            if (rec.category != undefined && rec.category != "null") {
                if (!(rec.category in cats)) { //$('.rcategory[value="' + rec.category + '"]').length == 0) {


                    newdiv = '<div class="rcategory" value="'+rec.category+'" style="'+
                        "min-height:77;"+
                        "min-width:100;"+
                        "border:2px solid;"+
                        "margin:10px;"+
                        "padding:5px;"+
                        '">' + rec.category + '<p></div>';
                    cats[rec.category] = newdiv;

                }
            }
        });
        console.log("line a: " + (new Date().getTime() - start_time) + "ms");
        prevdate = "";


        var newrecordings = '';
        tocat = [];
        $.each(payload_recordings.reverse(), function(i, rec) {

            name = rec.name;
            if (rec.name == null || rec.name == '1')
                name = rec.rowid;



            newbutton = '<button' +
                ' class="sbutton recording" title="' + rec.rowid +
                '" value="sounds\\recorded\\' + (rec.rowid) + '.wav">' + (name) + '</button>';



            if (rec.category != undefined && rec.category != "null") {
                //$('.rcategory[value="' + rec.category + '"]').append(newbutton);
                //tocat[rec.category] += newbutton;
                 cats[rec.category] = cats[rec.category].splice(cats[rec.category].length - 6,0,newbutton);
            } else {
                if (rec.date != prevdate) {
                    //$('#recordings').append("<br>" + rec.date + "<br>");
                    newrecordings += ("<br>" + rec.date + "<br>");
                }
                prevdate = rec.date;
                //$('#recordings').append(newbutton);
                newrecordings += newbutton;
            }

        });
        var index;
        $.each(cats,function(i,e){
            div_recordings.innerHTML = e + div_recordings.innerHTML;
        })
        console.log("line b: " + (new Date().getTime() - start_time) + "ms");

        $(div_recordings).html($(div_recordings).html() + newrecordings);

       console.log("line c: " + (new Date().getTime() - start_time) + "ms"); 


        $('.rcategory').each(function() {
            if ($('#rcat_1 .sbutton').length < $('#rcat_2 .sbutton').length)
                $('#rcat_1').prepend($(this));
            else
                $('#rcat_2').prepend($(this));
        });



        console.log("line 896: " + (new Date().getTime() - start_time) + "ms");


        console.log("line 919: " + (new Date().getTime() - start_time) + "ms");


        //updateplaycounts();
    }
}
}
