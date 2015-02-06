
/* 
 * ***************************************************************************************
 * SIDEBAR
 * ***************************************************************************************
 */


//Youtube-linkki-alue enterpainallus
$("body").on('keypress', '.youtube', function(e) {
    if (e.keyCode == 13) {
        var v = $(this).val();
        v = v.replace("https", "http");
        console.log(v);
        var $path = {
            yt: 1,
            path: v
        };
        $(this).val("");
        $.ajax({
            type: 'POST',
            url: 'playvlc.php',
            data: $path,
            success: function(data) {
                console.log(data);
            }
        });
    }
});


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

