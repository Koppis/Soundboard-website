function handle_payload_vitsit(vitsit) {
    vitsit_revision = vitsit.pop();
    $('#vitsit').html('<ul></ul>');
    newhtml = '';
    $.each(vitsit, function(i, vitsi) {
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

/* 
 * VITSIT
 */
//Lisätään vitsi
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
    if (confirm("Oletko varma, että haluat poistaa vitsin?"))
        deleteVitsi(id);
});
//Muokkaa vitsiä
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
}
