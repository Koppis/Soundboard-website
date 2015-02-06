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

//Kun painetaan viestikentässä enter tai ylösalas
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

//Lisätään emoticon
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

//Lisää viestejä
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