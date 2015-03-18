
/* 
 * EMOTICONS
 */


//Poista hymiˆ
$('body').on("click", ".deleteemo", function() {
    if (confirm("Oletko varma, ett‰ haluat poistaa hymiˆn?")) {
        var s = $(this).next().html();
        console.log(s);
        $.ajax({
            type: 'post',
            url: 'emoticonssc.php',
            data: {
                dothis: 1,
                sana: s
            }
        });
    }
});


//Klikkaa hymiˆt‰
$('body').on("click", "img.emoticon", function(e) {
    if ($('#tts').val() == $('#tts').attr('alt'))
        $('#tts').val("");
    $('#tts').val($('#tts').val() + $(this).attr('alt'));
    $('#tts').focus();
});
//Piilota hymiot
$('body').on("click", "#hideemos", function() {
    $('#emoticons').toggle();
});
function handle_payload_emoticons(payload_emoticons) {
    emoticons_revision = payload_emoticons.pop();
    console.log(emoticons_revision);
    $('#emoticons_tab').html('<ul></ul>');
    $('#emoticons').html('');
    newhtml = '';
    newhtml_tab = '';
    $.each(payload_emoticons, function(i, emo) {

        newhtml += '<img style="max-width:50px;max-height:50px"src="' + emo.linkki + '" alt="' + emo.sana + '" class="emoticon"/>';

        newhtml_tab +=
            '<li>' +
            '<button style="padding:2px;min-width:40px;" class="deleteemo">X</button>' +
            '<span>' + emo.sana + '</span> -- ' +
            '<img style="max-width:50px;max-height:50px"src="' +
            emo.linkki + '"/></li>';
    });

    $('#emoticons').html(newhtml);

    $('#emoticons_tab ul').html(newhtml_tab);

}function longPoll(loop) {
    console.log("starting stream! session = " + session);
    known_users = [];

    $("#users span").each(function() {
        known_users.push($(this).text());
    });
    console.log(JSON.stringify(known_users));
    $.ajax({
        data: {
            rowid: $("#shoutbox table tbody tr:first-child").attr("id"),
            kohta: 0,
            user: $('#username').val(),
            users: JSON.stringify(known_users),
            rec: recording,
            online: online,
            vitsit_revision: vitsit_revision,
            emoticons_revision: emoticons_revision,
            recordings_revision: recordings_revision,
            teamspeak_revision: teamspeak_revision,
            youtube_rowid: youtube_rowid,
            cookie_rowid: cookie_rowid,
            teamspeak_chat_rowid: teamspeak_chat_rowid,
            processes_revision: processes_revision,
            memes_revision: memes_revision,
            session_id: session
        },
        type: 'GET',
        url: 'shoutstream.php',
        dataType: 'json',
        timeout: ajaxtimeout,
        success: function(payload) {
            start_time = new Date().getTime();
            //console.log('longpoll success!' + payload.debug);
            //console.log("recording: " + payload.rec);
            if (payload.status == "results" || payload.status == "no-results") {
                if (payload.status == "results") {
                    //console.log(JSON.stringify(payload));
                    console.log(payload);
                    if (payload.messages != undefined && payload.messages.length > 0) {
                        var newhtml = '';
                        $.each(payload.messages, function(i, msg) {
                            newhtml =
                                '<tr id="' + msg.rowid + '">' +
                                '<td>' + msg.time + '</td>' +
                                '<td><span class="username ' +
                                msg.user + '" style="color:#' +
                                msg.color + '">' + msg.user +
                                '</td>' +
                                '<td>' + msg.msg + '</td>' +
                                '</tr>' + newhtml;

                        });
                        //Vilkkuminen
                        if (focusvar == 0 && newhtml !== '') {
                            happening = true;
                            changeFavicon("/images/kapparoll/tmp-0.gif")

                        }

                        $("#shoutbox table tbody").prepend(newhtml);
                        $("#shoutbox table tbody tr:nth-child(50)").remove();

                    }
                    if (payload.users != undefined && payload.users.length > 0) {
                        document.getElementById("users").innerHTML = "Paikalla: ";
                        $.each(payload.users, function(i, user) {
                            $("#users").append('<span>' + user + '</span>   ');
                        });
                    }
                    if (payload.rec != undefined) {
                        handle_recording_state(payload.rec);
                    }

                    if (payload.vitsit != undefined) {
                        vitsit_revision = payload.vitsit.pop();
                        $('#vitsit').html('<ul></ul>');
                        newhtml = '';
                        $.each(payload.vitsit, function(i, vitsi) {
                            newhtml += '<li data-rowid="' +
                                vitsi.rowid +
                                '"><button style="padding:2px;min-width:40px;" class="deletevitsi">X</button><button class="vitsi_rate">lis√§√§ memeihin</button>' +
                                vitsi.vitsi +
                                '</li>';
                        });
                        $('#vitsit ul').html(newhtml);
                        $('.vitsi_rate').click(function(){
                            $(this).after('<div id="vitsi_raty"></div>');
                            $('#vitsi_raty').raty({path:'images/raty',
                                            click:function(score){
                                                console.log("rowid = "+$(this).parent().attr('data-rowid'));
                                                $.ajax({
                                                    url:'ratememe.php',
                                                    type:'POST',
                                                    data:{rating:score,
                                                        user:session,
                                                        vitsi:$(this).parent().attr('data-rowid')},
                                                    success:function(data){
                                                    console.log(data);
                                                    }
                                                })
                                                $(this).remove();
                                            }
                                                });
                        });


                    }
                    if (payload.emoticons != undefined) {
                        handle_payload_emoticons(payload.emoticons);
                    }
                    if (payload.rec != undefined) {
                        recording = payload.rec;
                        handle_recording_state(recording);
                    }
                    if (payload.recordings != undefined) {
                        handle_recordings(payload.recordings);
                    }
                    console.log((new Date().getTime() - start_time) + "ms");
                            console.log("line d: " + (new Date().getTime() - start_time) + "ms");

                    if (payload.youtube != undefined) {
                            handle_payload_youtube(payload.youtube);
                    }
                            console.log("line f: " + (new Date().getTime() - start_time) + "ms");

                    if (payload.teamspeak != undefined) {
                        handle_payload_teamspeak(payload.teamspeak);
                    }
                            console.log("line g: " + (new Date().getTime() - start_time) + "ms");
                    if (payload.teamspeakchat != undefined) {
                        handle_payload_teamspeakchat(payload.teamspeakchat);
                        
                    }
                            console.log("line h: " + (new Date().getTime() - start_time) + "ms");

                    if (payload.processes != undefined) {
                        processes_revision = payload.processes.pop();
                        var div = $("#processes");
                        div.html("<ul></ul>");
                        $.each(payload.processes, function(i, e) {
                            div.children("ul").append('<li>' + e.name + '<button class="killpid" title="' + e.pid + '" style="padding:2px;min-width:20px;">X</button></li>');
                            if (e.name.substring(0,2) == "yt") {
                                callPlayer(rand, function() {
                                    // This function runs once the player is ready ("onYouTubePlayerReady")
                                    setTimeout(function() {
                                        callPlayer(rand, "playVideo");
                                        callPlayer(rand, "mute");
                                    },1700);
                                });
                            }
                        })
                    }

                            console.log("line i: " + (new Date().getTime() - start_time) + "ms");
                    if (payload.memes != undefined) {
                        handle_payload_memes(payload.memes);
                    }


                    if (payload.cookie != undefined) {
                        cookie_rowid = payload.cookie.rowid;
                    }
                    if (payload.online != undefined) {
                        online = payload.online;

                    }
                    if (online == 1) {
                        enablejukebox();
                    }
                    if (online == 0) {
                        disablejukebox();
                    }
                }
                diff = new Date().getTime() - start_time;
                console.log("Payload function took " + diff + "ms");
                if (loop == undefined)
                    t = setTimeout(longPoll, 100);
            }
        },
        error: function(e) {
            errorText = e.responseText;
            console.log('longpoll error!' + $(errorText).text());
            if (loop == undefined)
                t = setTimeout(longPoll, 10000);
        }

    });
}
Ôªø

//init
var version = 12;
var files;
var recording = 0;
var online = 0;
var t; //setTimeout
var vitsit_revision = -1;
var emoticons_revision = -1;
var recordings_revision = -1;
var teamspeak_revision = -1;
var processes_revision = -1;
var teamspeak_chat_rowid = -1;
var memes_revision = -1;
var youtube_rowid = 0;
var cookie_rowid = -1;
var session = "";
var rec_playcounts;
var shoutbox_counter;
var focusvar = 1;
var happening = false;
var vilkku = false;
var usercolor = "";
var username = "";




//console.log = function(msg){};
//
String.prototype.splice = function( idx, rem, s ) {
    return (this.slice(0,idx) + s + this.slice(idx + Math.abs(rem)));
};

document.title = "Koppislandia";
if ((/iPhone|iPod|iPad|Android|BlackBerry/).test(navigator.userAgent)) {
    mobile = true;
    var ajaxtimeout = 1000;
    $("#usercolor").val('#000000');
} else {
    mobile = false;
    var ajaxtimeout = 120000;
}
//endinit



//Kun focus tulee textarea-luokkaan
$("body").on("focus", ".textarea", function(e) {
    if ($(this).val() == $(this).attr('alt')) {
        $(this).val("");
    }
});
$("body").on("blur", ".textarea", function(e) {
    if ($("#username").val() == "ADMIN")
        $("#username").val("");
    if ($(this).val() == "")
        $(this).val($(this).attr('alt'));
});

document.head || (document.head = document.getElementsByTagName('head')[0]);

function changeFavicon(src) {
    var link = document.createElement('link'),
        oldLink = document.getElementById('dynamic-favicon');
    link.id = 'dynamic-favicon';
    link.rel = 'shortcut icon';
    link.href = src;
    if (oldLink) {
        document.head.removeChild(oldLink);
    }
    document.head.appendChild(link);
}

//Kun ikkunaan tulee focus/pois focus
$(window).on('focus', function() {
    document.title = "Koppislandia";
    focusvar = 1;
    happening = false;
    changeFavicon("/kappa.png");
});
$(window).blur(function() {
    focusvar = 0;
});

//Yrit√§ disconnectia viel√§, ettei hyv√§ll√§ tuurilla tarvitse timeouttia
$(window).on("beforeunload", function() {
    $.ajax({
        type: 'GET',
        url: 'disconnect.php',
        data: {
            user: $('#username').val()
        },
        async: true
    });
});






/* 
 * ***************************************************************************************
 * SOUNDBOARD
 * ***************************************************************************************
 */

//Piilota √§√§nikategoria
$('body').on("click", ".hidecat", function() {
    $(this).next().children().toggle('fast');

});

//Toista √§√§ni
$('body').on("click", ".sbutton", function() {
    if (document.getElementById("play_through_web").checked == true){
console.log('pressed sbutton ' + $(this).val());
    var audio = new Audio('/' + $(this).val());
    audio.play();
}else
    if (!$(this).is(":disabled")) {

        $.ajax({
            type: 'POST',
            url: 'playvlc.php',
            data: {
                yt: 0,
                path: $(this).val()
            },
            success: function(data) {
                console.log("data: " + data);
            }
        });
    }
});







/* 
 * ***************************************************************************************
 * DOCUMENT READY
 * ***************************************************************************************
 */



//DOCUMENT READY ALKAA
$(document).ready(function() {
    changeFavicon("/kappa.png");

    disablejukebox();

    //Alustaa v√§lilehdet
    $("#tabs").tabs({
        activate: function(event, ui) {
            console.log(ui.newTab.index());
            if (ui.newTab.index() == 7) {
                $("#streamchat").append($("#chatstuff"))
            } else {
                $("#frag-1").append($("#chatstuff"))
            }
        }
    });
    if (mobile) {
        $("#teamspeak").remove();
        $("#teamspeak2").attr("id", "teamspeak");
        $("div.ui-tabs-panel").css('padding', '0px');
    } else {

        $("#tabs").tabs("disable", 6);

    }

    //Kekseist√§ haetaan nimi, v√§ri ja viestihistoria
    $.cookie.json = true;

    if ($.cookie("yt_open") != undefined)
        $("#hideyoutube").after('<div id="youtube"></div>');


    if ($.cookie("shoutname") != undefined && $.cookie("shoutname") != "Username") {
        $('#username').val($.cookie("shoutname"));
    } else {
        names = ['Lawanda', 'Becky', 'Arielle', 'Ming', 'Kara', 'Giuseppina', 'Phyllis', 'Wan', 'Kallie',
            'Cleotilde', 'Kellye', 'Noemi', 'Tijuana', 'Lauri', 'Maryellen', 'Mireya', 'Staci', 'Maryjo',
            'Cleopatra', 'Estella', 'Amiee', 'Yajaira', 'Griselda', 'Corene', 'Matha', 'Tula', 'Flavia',
            'Rebbeca', 'Ellyn', 'Kaylene', 'Patience', 'Chantay', 'Franchesca', 'Lakiesha', 'Haydee', 'Sindy',
            'Jenee', 'Sharell', 'Billi', 'Brenda', 'Debbie', 'Shellie', 'Leisa', 'Alyce', 'Deane', 'Britney',
            'Antonina', 'Shavonda', 'Mavis', 'Virginia'
        ];
        $('#username').val(names[Math.floor(Math.random() * names.length)]);
        $.cookie("shoutname", $('#username').val(), {
            expires: 10
        });
    }

    if ($.cookie("usercolor") != undefined)
        $('#usercolor').val($.cookie("usercolor"));

    if ($.cookie("session") != undefined){
        session = $.cookie("session");
        $.cookie("session", session, {
            expires: 100
        });
}   else {
        session = $.now().toString() + $('#username').val();
        $.cookie("session", session, {
            expires: 100
        });
    }

    ma = [];
    if ($.cookie("sentmessages") != undefined)
        ma = JSON.parse($.cookie("sentmessages"));

    shoutbox_counter = ma.length;

    //ilmoitusvilkutus
    setInterval(function() {
        if (happening) {
            if (vilkku) {
                document.title = "Koppislandia";
            } else {
                document.title = "**Uusi viesti!**";
            }
            vilkku = !vilkku;
        }
    }, 1000);



    updateTJt();
    longPoll();

    $('body').show();


});



function addslashes(string) {
    return string.replace(/\\/g, '\\\\').
    replace(/\u0008/g, '\\b').
    replace(/\t/g, '\\t').
    replace(/\n/g, '\\n').
    replace(/\f/g, '\\f').
    replace(/\r/g, '\\r').
    replace(/'/g, '\\\'').
    replace(/"/g, '\\"');
}




function postmessage(usr, msg, kieli, tts) {
    //hommataan DateTime-muodossa aika
    var currentdate = new Date();
    var realdate = currentdate.toString().match(/\d\d:\d\d:\d\d/);
    var datetime = currentdate.toISOString().match(/\d\d\d\d-\d\d-\d\d/);
    datetime += " " + realdate;



    //nimi keksiin
    $.cookie("shoutname", usr, {
        expires: 10
    });
    //Jos pit√§√§ puhua laitetaan tts.phplle
    if (tts) {
        var $data = {
            kieli: kieli,
            badumtss: 0,
            yt: 0,
            vitsi: msg.replace(/<a href=.*>(.*)<\/a>/g, "$1")
        };
        $.ajax({
            type: 'POST',
            url: 'tts.php',
            data: $data,
            success: function(data) {
                console.log(data);
            }
        });
    }
    console.log($data)
    console.log({
        date: datetime,
        user: usr,
        msg: msg
    })
    $.ajax({
        type: 'POST',
        url: 'shout.php',
        data: {
            date: datetime,
            user: usr,
            msg: msg,
            session:session
        },
        success: function(data) {
            console.log(data);
        }
    });
    if (mobile) {
        longPoll(true);
    }
}





function makerecordingsdraggable() {

    $('.rcategory').droppable({
        accept: ".recording",
        activeClass: "ui-state-highlight",
        drop: function(event, ui) {

            $.each($(this).children(), function(i, element) {
                if (parseInt($(ui.draggable).attr("title")) > parseInt($(element).attr("title"))) {
                    $(element).before(ui.draggable);
                    return false;
                }
            });
            recordings_revision += 1;
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

    $(".recording").draggable({
        cancel: "none",
        stack: '.recording',
        helper: "clone",
        scroll: false,
        distance: 50,
        "revert": function(a) {

            if (a == false) {
                $.ajax({
                    type: 'POST',
                    url: 'moverecording.php',
                    data: {
                        rowid: $(this).attr('title'),
                        newcat: 'null'
                    }
                });
                recordings_revision += 1;
                $.each($("#recordings .recording"), function(i, element) {
                    if (parseInt($(this).attr("title")) > parseInt($(element).attr("title"))) {
                        $(element).before($(this));
                        return false;
                    }
                });
            }
        }
    });

}



function updateplaycounts() {
    biggest = 0;
    for (i = 0; i < rec_playcounts.length; i++) {
        if (rec_playcounts[i] == undefined) continue;
        if (rec_playcounts[i] > biggest)
            biggest = rec_playcounts[i];
    }
    $(".recording").each(function() {
        i = $(this).attr('title');
        other_colors = (Math.floor(255 - (255 * (rec_playcounts[i] / biggest)))).toString(16);

        if (other_colors.length == 1)
            other_colors = "0" + other_colors;

        color = "#" + other_colors + "FF" + other_colors;
        $(this).css('background-color', color);
    });

}



function updatecolor() {
    console.log(username);
    $('.' + $('#username').val()).css('color', $("#usercolor").val());
}

//NimiAlueesta focus pois
$("body").on("blur", "#username", sendcolor);

function sendcolor() {
    console.log("sent color");
    $.cookie("usercolor", $("#usercolor").val(), {
        expires: 10
    });
    $.cookie("shoutname", $("#username").val(), {
        expires: 10
    });
    $.ajax({
        data: {
            session: session,
            color: $("#usercolor").val()
        },
        type: 'GET',
        url: 'updatecolor.php'
    });
}

function updateTJt() {
    $.ajax({
        data: {
            rowcount: $('#tjt > ul > li').length
        },
        type: 'POST',
        url: 'tj.php',
        success: function(data) {
            if (data.length > 0) {
                $('#tjt').html(data);
            }
        }
    });
}



function disablejukebox() {

    $('#recordbutton').css('color', 'black');
    $('#recordbutton').text("Record");
    $('#recordbutton').attr("disabled", "disabled");
    $('#recordbutton').removeClass("recordbutton");
    //$('.sbutton').attr("disabled", "disabled");
    //$('.recording').attr("disabled", "disabled");
    //$('.youtube').attr('disabled','disabled');
    $('.toista').attr('disabled', 'disabled');
    $('.stop_youtube').attr('disabled', 'disabled');
    $('.stop').attr('disabled', 'disabled');
    $('#kerrovitsi').attr('disabled', 'disabled');
    $('.not_online').show();
}

function enablejukebox() {
    if (recording != 1) {
        $('#recordbutton').removeAttr("disabled");
        $('#recordbutton').addClass("recordbutton");
    }
    $('.sbutton').removeAttr("disabled");
    $('.recording').removeAttr("disabled");
    //$('.youtube').removeAttr("disabled");
    $('.toista').removeAttr("disabled");
    $('.stop').removeAttr("disabled");
    $('.stop_youtube').removeAttr("disabled");
    $('#kerrovitsi').removeAttr("disabled");
    $('.not_online').hide();
}



function memerate_handler(rating, evt) {

    if (isNaN(parseInt(rating))) rating = 0;
    
    console.log("rec : "+$(this).prev().attr('title'));
    console.log("rating : "+(parseInt(rating)*2));
    console.log("myrating : "+(parseInt($(this).attr("data-myscore"))));

    if (rating == (parseInt($(this).attr("data-myscore")))) return;
    $(this).css('background-color','');    
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
function vitstirating_handler(score){
        vitsi = $(this).prev().attr('title');
            $.ajax({
                url:'ratememe.php',
                type:'POST',
                data:{rating:score*2,
                    user:session,
                    vitsi:vitsi},
                success:function(data){
                console.log(data);
                }})
    }

function handle_payload_memes (payload_memes){
    memes_revision = payload_memes.shift().rating;
    payload_memes.sort(function(a,b) {return (b.rating) - parseFloat(a.rating)})
    //if ($('#memet').text() == "") {
        newmemes = "";
        $.each(payload_memes, function (i,e) {
            if (e.rec != null) {
                //b = $('.recording[title='+e.rec+']').first();
                style = (e.myrating == null ? 'style="background-color:#FF0000;"' : "");
                meme = '<div style="display:inline-block;margin:10px" rec="'+e.rec+
                '"><button class="sbutton" '+style+' title="'+e.rec+'" value="sounds\\recorded\\' + e.rec + '.wav">'+
                e.recname+'</button>'+(e.myrating != null ? e.myrating/2 : "")+
                '<div data-myscore="'+(e.myrating != null ? e.myrating/2 : -1)+
                '" class="memerating" data-score="'+(e.rating/2)+'"></div></div>';
            } else if (e.vitsi != null) {
                /*v = $('#vitsit li[data-rowid='+e.vitsi+']').first();
                teksti = v.contents().filter(function(){ 
                      return this.nodeType == 3; 
                    })[0].nodeValue
               */ 
                meme = '<div style="display:inline-block;margin:10px" vitsi="'+e.vitsi+
                '"><button class="sbutton"  title="'+e.vitsi+'" value="vitsi'+e.vitsitext+'">'+
                e.vitsitext+'</button>'+(e.myrating != null ? e.myrating/2 : "")+
                '<div data-myscore="'+(e.myrating != null ? e.myrating/2 : -1)+
                '" class="vitsi_memerating" data-score="'+(e.rating/2)+'"></div></div>';
                
            }
            newmemes += meme;
        })
        $('#memet').html(newmemes);

        $('.vitsi_memerating').raty({numberMax:10,
                    score:function() {return parseFloat($(this).attr('data-score'))},
                    path:'images/raty',
                    cancel: true,
                    click: vitstirating_handler
        });

        $('.memerating').raty({numberMax:10,
                    score:function() {return parseFloat($(this).attr('data-score'))},
                    path:'images/raty',
                    cancel: true,
                    click: memerate_handler
                    });
   /* } else {
        memearray = $('#memet > div')
        memearray.each(function(i) {
            e = $(this);
            meme = payload_memes[i]
            if (meme.vitsi != null) {
                if (meme.vitsi != e.attr('vitsi')) {
                    if (meme.vitsi != e.next().attr('vitsi')) {
                    v = $('#vitsit li[data-rowid='+meme.vitsi+']').first();
                    teksti = v.contents().filter(function(){
                          return this.nodeType == 3; 
                        })[0].nodeValue
                    e.before('<div style="display:inline-block;margin:10px" vitsi="'+meme.vitsi+
                    '"><button class="sbutton" title="'+meme.vitsi+'" value="vitsi'+teksti+'">'+
                    teksti+'</button>'+(meme.myrating != null ? meme.myrating/2 : "")+
                    '<div data-myscore="'+(meme.myrating != null ? meme.myrating/2 : -1)+
                    '" class="vitsi_memerating" data-score="'+(meme.rating/2)+'"></div></div>');
                    } else {
                        e.remove();
                    }
                }
            } else if (meme.rec != null) {
                if (meme.rec != e.attr('rec')) {
                    if (meme.rec != e.next().attr('rec')) {
                    b = $('.recording[title='+meme.rec+']').first();
                    e.before( '<div style="display:inline-block;margin:10px" rec="'+meme.rec+
                    '"><button class="sbutton" title="'+meme.rec+'" value="'+b.val()+'">'+
                    b.html()+'</button>'+(meme.myrating != null ? meme.myrating/2 : "")+
                    '<div data-myscore="'+(meme.myrating != null ? meme.myrating/2 : -1)+
                    '" class="memerating" data-score="'+(meme.rating/2)+'"></div></div>');
                    } else {
                        e.remove();
                    }
                }
            }
        })
    }*/
}

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
    //if (confirm("Oletko varma, ett‰ haluat poistaa aanityksen?")) {
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
/*
 * ***************************************************************************************
 * SHOUTBOX
 * ***************************************************************************************
 */

function chatmessage() {
    var val = $('#tts').val();
    var usr = $('#username').val();

    if (val.length > 0 && val.length < 5000 && val != "Text-to-speech") {
        postmessage(usr, val, $("#kieli").val(), true);



        value = addslashes(val);

        var edellinen;
        edellinen = ma.indexOf(value);

        while (edellinen != -1) {
            ma.splice(edellinen, 1);
            edellinen = ma.indexOf(value);
        }
        if (ma[ma.length - 1] != value)
            ma.push(value);
        if (ma.length > 30)
            ma.splice(0, 1);
        shoutbox_counter = ma.length;

        $.cookie("sentmessages", JSON.stringify(ma), {
            expires: 10
        });

        $("#tts").val('');
    }

}

//Kun painetaan viestikent‰ss‰ enter tai ylˆsalas
$("body").on('keydown', '#tts', function(a) {
    if (a.keyCode == 40) {
        if (shoutbox_counter < (ma.length - 1)) {
            shoutbox_counter += 1;
            $('#tts').val(ma[shoutbox_counter]);
        } else {
            shoutbox_counter = ma.length;
            $('#tts').val("");
        }
    }
    if (a.keyCode == 38) {
        if (shoutbox_counter > 0)
            shoutbox_counter -= 1;
        $('#tts').val(ma[shoutbox_counter]);
    }
    if (a.keyCode == 13 && $(this).val() != "") {

        chatmessage();


    }

});


//Klikataan sendmsg nappia
$("body").on('click', "#sendmsg", function() {
    chatmessage();
});

//Lis‰t‰‰n emoticon
$("body").on('click', "#addemoticon", function() {

    var s = $("#addemoticon_sana").val();
    var l = $("#addemoticon_linkki").val();
    console.log("l = " + l);
    console.log("s = " + s);
    $.ajax({
        type: 'post',
        url: 'emoticonssc.php',
        data: {
            dothis: 0,
            sana: s,
            linkki: l
        }
    });

});

//Lis‰‰ viestej‰
$("body").on('click', '#moreshouts', function() {
    var rowcount = $('#shoutbox table tbody tr').length;
    $.ajax({
        type: 'GET',
        url: 'getshouts.php',
        data: {
            dothis: 'getshouts',
            kohta: rowcount,
            rowcount: 0
        },
        success: function(data) {
            $('#shoutbox table tbody tr:last-child').after(data);
        }
    });
});
/* 
 * ***************************************************************************************
 * SIDEBAR
 * ***************************************************************************************
 */
function handle_payload_youtube(payload_youtube) {
    if ($('#youtube').length != 0) {
        id = "";
        arr = payload_youtube.link.match("(?:[\?&]v=|be\/)([^&#]*)");
        if (arr != null) {
            if (arr.length > 1)
                id = arr[1];

            rand = Math.random();

            $('#youtube').html('');
            $('#youtube').html('<a href="' + payload_youtube.link + '">' +
                payload_youtube.name + '</a>' +
                '<iframe id="' + rand + '" type="text/html" width="100%" height="100%"' +
                ' src="http://www.youtube.com/embed/' + id + '?enablejsapi=1&autohide=1&showinfo=0" frameborder="0"/>'
            );
            if (youtube_rowid != 0) {
                console.log(youtube_rowid);
                callPlayer(rand, function() {
                    // This function runs once the player is ready ("onYouTubePlayerReady")
                    setTimeout(function() {
                        callPlayer(rand, "playVideo");
                        callPlayer(rand, "mute");
                    },2500);
                });
            }
        }
    }
    youtube_rowid = payload_youtube.rowid;
}
 handle_youtube_link = function() {
    var v = $('.youtube').val();
    v = v.replace("https", "http");
    console.log(v);
    var $path = {
        yt: 1,
        path: v
    };
    $('.youtube').val("");
    $.ajax({
        type: 'POST',
        url: 'playvlc.php',
        data: $path,
        success: function(data) {
            console.log(data);
        }
    });
 }

//Youtube-linkki-alue enterpainallus
$("body").on('keypress', '.youtube', function(e) {
    if (e.keyCode == 13) {
        handle_youtube_link();
    }
});

//Youtube-linkki-alue click
$("body").on('click', '.youtube_submit', handle_youtube_link);


//Klikataan killpid
$("body").on('click', '.killpid', function() {
    $.ajax({
        type: 'GET',
        url: 'stopprocess.php',
        data: {
            pid: $(this).attr("title")
        }
    });

});

//Klikataan stop youtube -nappia
$("body").on('click', '.stop_youtube', function() {
    $.ajax({
        type: 'POST',
        url: 'playvlc.php',
        data: {
            yt: 0,
            path: "stopyoutube"
        }
    });

});

//Klikataan stop music-nappia
$("body").on("click", ".stop", function() {
    $.ajax({
        type: 'POST',
        url: 'playvlc.php',
        data: {
            yt: 0,
            path: "stop"
        }
    });

});


//ts_chatin enterpainallus
$("body").on("keypress", "#ytchat_input", function(e) {
    if (e.keyCode == 13 && $('#ytchat_input').val() != "") {
        msg = $('#ytchat_input').val();



        $.ajax({
            type: 'POST',
            url: '/dev/teamspeak/tschatmessage.php',
            data: {
                user: $('#username').val(),
                msg: msg
            },
            success: function(msg) {
                console.log('tschatmessage.php: ');
                console.log(msg);
            }
        });
        $('#ytchat_input').val('');
    }
});



//click youtubehide
$('body').on("click", "#hideyoutube", function() {
    if ($("#youtube").length == 1) {
        $('#youtube').remove();
        $.removeCookie('yt_open');
    } else {
        $(this).after('<div id="youtube"></div>');
        $.cookie("yt_open", true, {
            expires: 10
        });
        youtube_rowid = 0;
        longPoll(true);
    }
});

//click youtube enlarge
$('body').on("click", "#enlargeyoutube", function() {
    if ($("#youtube").css('position') == "absolute") {
        $('#youtube').css('position', 'static');
        $('#youtube').css('z-index', 0);
        $('#youtube').css('width', '');
        $('#youtube').css('height', '');

    } else {
        $('#youtube').css('height', '480px');
        $('#youtube').css('position', 'absolute');
        $('#youtube').css('z-index', 1);
        $('#youtube').css('width', '854px');
    }
});

function handle_payload_teamspeak(payload_teamspeak) {
    teamspeak_revision = payload_teamspeak.pop();

    newlist = $("<ul></ul>");

    $.each(payload_teamspeak, function(i, a) {
        if (a.type == 1 && a.parent == 0) {
            $(newlist).append('<li style="list-style-type: none;" value="' + a.id + '">' +
                '<img src="teamspeak/images/default_colored_2014/channel_green_subscribed.png" /> ' + a.name + "<ul></ul></li>");
        }
    });
    $.each(payload_teamspeak, function(i, a) {
        if (a.type == 1 && a.parent != 0) {
            $(newlist).find('li[value="' + a.parent + '"]').children('ul').append('<li style="list-style-type: none;" value="' + a.id + '">' +
                '<img src="teamspeak/images/default_colored_2014/channel_green_subscribed.png" /> ' + a.name + '<ul></ul></li>');
        }
    });
    $.each(payload_teamspeak, function(i, a) {
        if (a.type == 0 && a.online == 1) {
            var nickname, lolname = a.name;
            switch (a.name) {
                case "omena":
                    lolname = "Happy%20Omena";
                    break;
                case "Super":
                    lolname = "Twitch%20Chat";
                    break;
                case "Koppis":
                    lolname = "Koppis1337";
                    break;

            }
            if (a.summonerid == null)
                nickname = a.name;
            else
                nickname = '<a target="_blank" href="http://www.elophant.com/league-of-legends/summoner/eune/'+a.summonerid+'/recent-games">'+a.name+'</a>';
            var clienticon = $('<li style="list-style-type: none;" class="ts_client" value="' + a.id + '">' + nickname + 
                (a.lolchamp != null ? " - <a href='http://www.carry.gg/eune/current/"+lolname+"' target='_blank'><img  src='/images/lol/champion/"+a.lolchamp+".png' /></a>":"") + '</li>');
            $(newlist).find('li[value="' + a.channel + '"]').children('ul').prepend(clienticon);
            switch (a.mode) {
                case 0:
                    clienticon.prepend('<img src="teamspeak/images/default_colored_2014/player_off.png" /> ');
                    break;
                case 1:
                    clienticon.prepend('<img src="teamspeak/images/default_colored_2014/input_muted.png" /> ');
                    break;
                case 2:
                    clienticon.prepend('<img src="teamspeak/images/default_colored_2014/output_muted.png" /> ');
                    break;
                case 3:
                    clienticon.prepend('<img src="teamspeak/images/default_colored_2014/away.png" /> ');
                    break;
            }
        }
    });

    $("#teamspeak").html(newlist);
}
function handle_payload_teamspeakchat(payload_teamspeakchat){
    teamspeak_chat_rowid = payload_teamspeakchat[payload_teamspeakchat.length - 1].rowid;
    if ($('#teamspeakchat').length == 0) {
        $('#teamspeak').after('<input type="text" size="33" class="textarea" id="ytchat_input" ' +
            'alt="Teamspeak chat" value="Teamspeak chat"></input><br>' +
            '<ul id="teamspeakchat" style="padding-left:10px"></ul>');
    }
    toappend = '';
    $.each(payload_teamspeakchat, function(i, e) {
        $('#teamspeakchat li:nth-child(20)').remove();

        msg = e.msg;

        if ((e.msg).search(/\[URL\](.*)\[\/URL\]/g) != -1) {
            msg = msg.replace(/\[URL\]/g, '<a target="_blank" href="');
            msg = msg.replace(/\[\/URL\]/g, '">' + ((e.msg).match(/\[URL\](.*)\[\/URL\]/i))[1] + '</a>');
        }

        toappend = '<li style="list-style-type: none;"><b>' + e.user + '</b>: ' + msg + '</li>' + toappend

    });
    $('#teamspeakchat').prepend(toappend);
    if (focusvar == 0) {
        happening = true;
        changeFavicon("/images/kapparoll/tmp-0.gif")


    }
}
Ôªø

/* 
 * VITSIT
 */
//Lis√§t√§√§n vitsi
$("body").on('keypress', '#addjoke', function(e) {
    if (e.keyCode == 13) {
        var v = $(this).val();
        $.ajax({
            type: 'POST',
            url: 'vitsisivusc.php',
            data: {
                kieli: 'fi',
                vitsi: v,
                dothis: 0
            }
        });
        $(this).val("");
    }
});

//Kerro vitsi
$("body").on("click", '#kerrovitsi', function() {
    $.ajax({
        data: {
            kieli: 'fi',
            vitsi: '**random**',
            badumtss: 1
        },
        url: 'tts.php',
        type: 'POST',
        success: function(data) {
            console.log(data);
        }
    });
});


//Toista vitsi
$("body").on("click", ".toista", function() {
    var kohde = $(this).parent().prev();
    var v = kohde.html();
    console.log(kohde);
    $.ajax({
        type: 'POST',
        url: 'tts.php',
        data: {
            kieli: "fi",
            badumtss: 1,
            yt: 0,
            vitsi: v
        }
    });
});


//Poista vitsi
$("body").on("click", ".deletevitsi", function() {
    var id = $(this).parent().attr("data-rowid");
    console.log(id);
    if (confirm("Oletko varma, ett√§ haluat poistaa vitsin?"))
        deleteVitsi(id);
});
//Muokkaa vitsi√§
$("body").on("click", ".edit_button", function() {
    var kohde = $(this).parent().prev().prev().prev();
    console.log(kohde.children());
    if (kohde.children().is("input")) return;
    var v = kohde.html();
    console.log(kohde);

    kohde.html('<input type="text" class="edit_area" value="' +
        v + '" size="' + (v.length * 1.1) + '">');
    updating = false;
    kohde.children("input").focus();

});
//Vitsinmuokkausalue
$("body").on("blur", ".edit_area", function() {
    var id = $(this).parent().parent().attr("id");
    var v = $(this).val();
    $("#edit_area").replaceWith(v);
    editVitsi(id, v);

});
//Vitsinmuokkausalueen napinpainallus
$("body").on("keypress", ".edit_area", function(e) {
    if (e.keyCode == 13) {
        var id = $(this).parent().parent().attr("id");
        var v = $(this).val();
        editVitsi(id, v);
    }
});

function editVitsi(id, v) {
    $.ajax({
        type: 'POST',
        url: 'vitsisivusc.php',
        data: {
            dothis: 2,
            id: id,
            newname: v
        }
    });
}

function deleteVitsi(id) {
    $("#" + id).fadeOut('fast');
    $.ajax({
        data: {
            dothis: 1,
            id: id
        },
        type: 'POST',
        url: 'vitsisivusc.php'
    });
}/**
 * @author       Rob W <gwnRob@gmail.com>
 * @website      http://stackoverflow.com/a/7513356/938089
 * @version      20131010
 * @description  Executes function on a framed YouTube video (see website link)
 *               For a full list of possible functions, see:
 *               https://developers.google.com/youtube/js_api_reference
 * @param String frame_id The id of (the div containing) the frame
 * @param String func     Desired function to call, eg. "playVideo"
 *        (Function)      Function to call when the player is ready.
 * @param Array  args     (optional) List of arguments to pass to function func*/

function callPlayer(frame_id, func, args) {
    if (window.jQuery && frame_id instanceof jQuery) frame_id = frame_id.get(0).id;
    var iframe = document.getElementById(frame_id);
    if (iframe && iframe.tagName.toUpperCase() != 'IFRAME') {
        iframe = iframe.getElementsByTagName('iframe')[0];
    }
    console.log(iframe);

    // When the player is not ready yet, add the event to a queue
    // Each frame_id is associated with an own queue.
    // Each queue has three possible states:
    //  undefined = uninitialised / array = queue / 0 = ready
    if (!callPlayer.queue) callPlayer.queue = {};
    var queue = callPlayer.queue[frame_id],
        domReady = document.readyState == 'complete';

    if (domReady && !iframe) {
        // DOM is ready and iframe does not exist. Log a message
        window.console && console.log('callPlayer: Frame not found; id=' + frame_id);
        if (queue) clearInterval(queue.poller);
    } else if (func == 'listening') {
        // Sending the "listener" message to the frame, to request status updates
        if (iframe && iframe.contentWindow) {
            func = '{"event":"listening","id":' + JSON.stringify('' + frame_id) + '}';
            iframe.contentWindow.postMessage(func, '*');
        }
    } else if (!domReady ||
        iframe && (!iframe.contentWindow || queue && !queue.ready) ||
        (!queue || !queue.ready) && typeof func == 'function') {
        if (!queue) queue = callPlayer.queue[frame_id] = [];
        queue.push([func, args]);
        if (!('poller' in queue)) {
            // keep polling until the document and frame is ready
            queue.poller = setInterval(function() {
                callPlayer(frame_id, 'listening');
            }, 250);
            // Add a global "message" event listener, to catch status updates:
            messageEvent(1, function runOnceReady(e) {
                if (!iframe) {
                    iframe = document.getElementById(frame_id);
                    if (!iframe) return;
                    if (iframe.tagName.toUpperCase() != 'IFRAME') {
                        iframe = iframe.getElementsByTagName('iframe')[0];
                        if (!iframe) return;
                    }
                }
                if (e.source == iframe.contentWindow) {
                    // Assume that the player is ready if we receive a
                    // message from the iframe
                    clearInterval(queue.poller);
                    queue.ready = true;
                    messageEvent(0, runOnceReady);
                    // .. and release the queue:
                    while (tmp = queue.shift()) {
                        callPlayer(frame_id, tmp[0], tmp[1]);
                    }
                }
            }, false);
        }
    } else if (iframe && iframe.contentWindow) {
        // When a function is supplied, just call it (like "onYouTubePlayerReady")
        if (func.call) return func();
        // Frame exists, send message
        iframe.contentWindow.postMessage(JSON.stringify({
            "event": "command",
            "func": func,
            "args": args || [],
            "id": frame_id
        }), "*");
    }
    /* IE8 does not support addEventListener... */
    function messageEvent(add, listener) {
        var w3 = add ? window.addEventListener : window.removeEventListener;
        w3 ?
            w3('message', listener, !1) :
            (add ? window.attachEvent : window.detachEvent)('onmessage', listener);
    }
}
