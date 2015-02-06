
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
