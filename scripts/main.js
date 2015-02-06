

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

//Yritä disconnectia vielä, ettei hyvällä tuurilla tarvitse timeouttia
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

//Piilota äänikategoria
$('body').on("click", ".hidecat", function() {
    $(this).next().children().toggle('fast');

});

//Toista ääni
$('body').on("click", ".sbutton", function() {
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




/* 
 * ***************************************************************************************
 * DOCUMENT READY
 * ***************************************************************************************
 */



//DOCUMENT READY ALKAA
$(document).ready(function() {
    changeFavicon("/kappa.png");

    disablejukebox();

    //Alustaa välilehdet
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

    //Kekseistä haetaan nimi, väri ja viestihistoria
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

    if ($.cookie("session") != undefined)
        session = $.cookie("session");
    else {
        session = $.now().toString() + $('#username').val();
        $.cookie("session", session, {
            expires: 10
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
    //Jos pitää puhua laitetaan tts.phplle
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


function longPoll(loop) {
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
                                '"><button style="padding:2px;min-width:40px;" class="deletevitsi">X</button><button class="vitsi_rate">lisää memeihin</button>' +
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
                        if ($('#youtube').length != 0) {
                            id = "";
                            arr = payload.youtube.link.match("(?:[\?&]v=|be\/)([^&#]*)");
                            if (arr.length > 1)
                                id = arr[1];

                            rand = Math.random();

                            $('#youtube').html('');
                            $('#youtube').html('<a href="' + payload.youtube.link + '">' +
                                payload.youtube.name + '</a>' +
                                '<iframe id="' + rand + '" type="text/html" width="100%" height="100%"' +
                                ' src="http://www.youtube.com/embed/' + id + '?enablejsapi=1&autohide=1&showinfo=0" frameborder="0"/>'
                            );
                            if (youtube_rowid != 0) {
                                console.log(youtube_rowid);
                                callPlayer(rand, function() {
                                    // This function runs once the player is ready ("onYouTubePlayerReady")
                                    callPlayer(rand, "playVideo");
                                    callPlayer(rand, "mute");
                                });
                            }
                        }

                        youtube_rowid = payload.youtube.rowid;

                    }
                            console.log("line f: " + (new Date().getTime() - start_time) + "ms");

                    if (payload.teamspeak != undefined) {
                        //if (payload.teamspeak.changes != undefined) {
                        teamspeak_revision = payload.teamspeak.pop();

                        newlist = $("<ul></ul>");

                        $.each(payload.teamspeak, function(i, a) {
                            if (a.type == 1 && a.parent == 0) {
                                $(newlist).append('<li style="list-style-type: none;" value="' + a.id + '">' +
                                    '<img src="teamspeak/images/default_colored_2014/channel_green_subscribed.png" /> ' + a.name + "<ul></ul></li>");
                            }
                        });
                        $.each(payload.teamspeak, function(i, a) {
                            if (a.type == 1 && a.parent != 0) {
                                $(newlist).find('li[value="' + a.parent + '"]').children('ul').append('<li style="list-style-type: none;" value="' + a.id + '">' +
                                    '<img src="teamspeak/images/default_colored_2014/channel_green_subscribed.png" /> ' + a.name + '<ul></ul></li>');
                            }
                        });
                        $.each(payload.teamspeak, function(i, a) {
                            if (a.type == 0 && a.online == 1) {
                                var clienticon = $('<li style="list-style-type: none;" class="ts_client" value="' + a.id + '">' + a.name + '</li>');
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

                        //}
                    }
                            console.log("line g: " + (new Date().getTime() - start_time) + "ms");
                    if (payload.teamspeakchat != undefined) {
                        //console.log(payload.teamspeakchat);
                        teamspeak_chat_rowid = payload.teamspeakchat[payload.teamspeakchat.length - 1].rowid;
                        if ($('#teamspeakchat').length == 0) {
                            $('#teamspeak').after('<input type="text" size="33" class="textarea" id="ytchat_input" ' +
                                'alt="Teamspeak chat" value="Teamspeak chat"></input><br>' +
                                '<ul id="teamspeakchat" style="padding-left:10px"></ul>');
                        }
                        toappend = '';
                        $.each(payload.teamspeakchat, function(i, e) {
                            $('#teamspeakchat li:nth-child(20)').remove();

                            msg = e.msg;

                            if ((e.msg).search(/\[URL\](.*)\[\/URL\]/g) != -1) {
                                msg = msg.replace(/\[URL\]/g, '<a href="');
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
                            console.log("line h: " + (new Date().getTime() - start_time) + "ms");

                    if (payload.processes != undefined) {
                        processes_revision = payload.processes.pop();
                        var div = $("#processes");
                        div.html("<ul></ul>");
                        $.each(payload.processes, function(i, e) {
                            div.children("ul").append('<li>' + e.name + '<button class="killpid" title="' + e.pid + '" style="padding:2px;min-width:20px;">X</button></li>');
                        })
                    }

                    if (payload.memes != undefined) {
                        memes_revision = payload.memes.shift().rating;
                        payload.memes.sort(function(a,b) {return (b.rating) - parseFloat(a.rating)})
                        //if ($('#memet').text() == "") {
                            newmemes = "";
                            $.each(payload.memes, function (i,e) {
                                if (e.rec != null) {
                                    b = $('.recording[title='+e.rec+']').first();
                                    style = (e.myrating == null ? 'style="background-color:#FF0000;"' : "");
                                    meme = '<div style="display:inline-block;margin:10px" rec="'+e.rec+
                                    '"><button class="sbutton" '+style+' title="'+e.rec+'" value="'+b.val()+'">'+
                                    b.html()+'</button>'+(e.myrating != null ? e.myrating/2 : "")+
                                    '<div data-myscore="'+(e.myrating != null ? e.myrating/2 : -1)+
                                    '" class="memerating" data-score="'+(e.rating/2)+'"></div></div>';
                                } else if (e.vitsi != null) {
                                    v = $('#vitsit li[data-rowid='+e.vitsi+']').first();
                                    teksti = v.contents().filter(function(){ 
                                          return this.nodeType == 3; 
                                        })[0].nodeValue
                                    
                                    meme = '<div style="display:inline-block;margin:10px" vitsi="'+e.vitsi+
                                    '"><button class="sbutton"  title="'+e.vitsi+'" value="vitsi'+teksti+'">'+
                                    teksti+'</button>'+(e.myrating != null ? e.myrating/2 : "")+
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
                                meme = payload.memes[i]
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

