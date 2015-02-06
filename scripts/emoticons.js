
/* 
 * EMOTICONS
 */


//Poista hymiö
$('body').on("click", ".deleteemo", function() {
    if (confirm("Oletko varma, että haluat poistaa hymiön?")) {
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


//Klikkaa hymiötä
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

}