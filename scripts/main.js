

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

