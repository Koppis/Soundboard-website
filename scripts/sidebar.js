
/* 
 * ***************************************************************************************
 * SIDEBAR
 * ***************************************************************************************
 */
function syncyoutube() {
    var processpingtime = (new Date().getTime());
    $.ajax({
        data:{time:youtube_synctime},
        url:"processping.php",
        type:'GET',
        dataType: 'json',
        success:function(data){
            console.log("Success in process ping! data: "+data);
            console.log("your ping was " + (new Date().getTime() - processpingtime));
            $("#syncyoutube").html("Sync - lastping: " + (new Date().getTime() - processpingtime));
            delay = parseInt(data);
            //delay += 50;
            delay += (new Date().getTime() - processpingtime) / 2;
            seconds = Math.floor(delay/1000);
            mseconds = delay % 1000;
            console.log("\nseconds = " + seconds + "\nmilliseconds = " + mseconds);
            callPlayer(13371234, function() {
                // This function runs once the player is ready ("onYouTubePlayerReady")
                    callPlayer(13371234, "playVideo");
                    callPlayer(13371234, "mute");
                    setTimeout(function(){
                        callPlayer(13371234, "seekTo",[(seconds + 1)]);
                        console.log("seeking to " + (seconds + 1));
                        callPlayer(13371234, "playVideo");
                    },1000 - mseconds);
            });
        }
    })
}
function handle_payload_youtube(payload_youtube) {
    if ($('#youtube').length != 0) {
        id = "";
        arr = payload_youtube.link.match("(?:[\?&]v=|be\/)([^&#]*)");
        if (arr != null) {
            if (arr.length > 1)
                id = arr[1];


            $('#youtube').html('');
            $('#youtube').html('<a href="' + payload_youtube.link + '">' +
                payload_youtube.name + '</a>' +
                '<iframe id="13371234" type="text/html" width="100%" height="100%"' +
                ' src="http://www.youtube.com/embed/' + id + '?enablejsapi=1&autohide=1&showinfo=0" frameborder="0"/>'
            );
            if (youtube_rowid != 0) {
                console.log(youtube_rowid);
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


//process_command keypress
$("body").on("keypress", ".process_command", function(e) {
    if (e.keyCode == 13 && $(this).val() != "") {
        msg = $(this).val();

        pid = $(this).prev().attr("title"); 

        $.ajax({
            type: 'POST',
            url: 'process_command.php',
            data: {
                user: $('#username').val(),
                msg: msg,
                pid:pid
            },
            success: function(msg) {
                console.log('process_command.php: ');
                console.log(msg);
            }
        });
    }
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

//Youtube-sync click
$("body").on('click', '#syncyoutube', syncyoutube);
