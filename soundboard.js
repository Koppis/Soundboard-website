
//init
var version = 11;
var files;
var recording = 0;
var online = 0;
var t;
var vitsit_revision = -1;
var emoticons_revision = -1;
var recordings_revision = -1;
var youtube_rowid = 0;
var cookie_rowid = -1;
var session = "";
var rec_playcounts;

document.title = "Koppislandia";
focusvar = 1;
happening = false;
vilkku = false;
usercolor = "";
username = "";
if ((/iPhone|iPod|iPad|Android|BlackBerry/).test(navigator.userAgent)) {
    mobile = true;
    var ajaxtimeout = 1000;
    $("#usercolor").val('#000000')
} else {
    mobile = false;
    var ajaxtimeout = 120000;
}
//endinit

 $(window).on("beforeunload", function() {
    $.ajax({
    	type: 'GET',
    	url: 'disconnect.php',
    	data: {user:$('#username').val()},
    	async: true
    });
}) 

//click new rcategory
$('body').on("click","#newrcategory",function(){
    category = prompt("Anna uuden kategorian nimi");
    newdiv = $('<div>' + category + '<p></div>')
    newdiv.attr('class','rcategory');
    newdiv.attr('value', category);
    newdiv.css('min-height',77);
    newdiv.css('min-width',100);
    newdiv.css('max-width','40%');
    newdiv.css('border','2px solid');
    newdiv.css('margin','10px');
    newdiv.css('padding','5px');
    newdiv.css('float','left');
    newdiv.droppable({accept: ".recording",activeClass: "ui-state-highlight",
        drop: function( event, ui ) {
            $(this).append(ui.draggable)
            console.log(ui.draggable.attr('title'))
            console.log($(this).attr('value'))
            
            $.ajax({
                type: 'POST',
                url: 'moverecording.php',
                data: {rowid:ui.draggable.attr('title'),newcat:$(this).attr('value')}
            });
        }})
    $('#recordings').prepend(newdiv);
	});

//click youtubehide
$('body').on("click","#hideyoutube",function(){
        if($("#youtube").length == 1)
            $('#youtube').remove();
        else {
            $(this).after('<div id="youtube"></div>')
            youtube_rowid = 0;
            longPoll(true);
        }
	});





//right click on recording
$('body').on("contextmenu",".recording",function(){
    if ($("#modifyrecording").length == 0) {
    
        oldwidth = $(this).width();
        
        $(this).after('<div id="modbox"><input id="modifyrecording" title="' + $(this).html() + '" value="' + $(this).html() + '"/>' +
        '<button id="deleterecording" style="padding:2px;min-width:20px;z-index:10;' +
        'position: relative;left: 10px;top: -8px;margin-left: -2px;margin-top : 10px;">x</button></div>');
        
        /*
        $(this).html('<input id="modifyrecording" title="' + $(this).html() + '" value="' + $(this).html() + '"/>' +
        '<button id="deleterecording" style="padding:2px;min-width:20px;z-index:10;' +
        'position: relative;left: 10px;top: -8px;margin-left: -2px;margin-top : 10px;">x</button>');
        
        $(this).css('margin-right', oldwidth - $(this).width());
        $(this).css('margin-top', '-16');
        $(this).css('margin-bottom', '-10');
        */
        
        $("#modbox").css('position', 'absolute');
        $("#modbox").css('top', $(this).position()['top']);
        $("#modbox").css('left', $(this).position()['left']);
        $("#modbox").css("z-index","10");
        
		$("#modifyrecording").focus();
        $("#modifyrecording").select();
        $(this).attr("disabled","disabled");
        $(this).css("position","relative");
        $(this).css("z-index","1");
    }
    
    return false;
});

//recordingmuokkausalue
$("body").on("blur","#modifyrecording",function(){
    if ($(this).val() !== $(this).attr('title')) {
        $.ajax({
            type: 'POST',
            url: 'renamerecording.php',
            data: {rowid:$(this).parent().prev().attr('title'),newname:$(this).val()}
        });
    }
    setTimeout($.proxy(function() {
        $(this).parent().prev().html($(this).val());
        $(this).parent().prev().removeAttr("disabled");
        /*
        $(this).parent().css('margin-right', '0');
        $(this).parent().css('margin-top', '0');
        $(this).parent().css('margin-bottom', '0');
        $(this).parent().css('z-index', '0');
        //$(this).parent().replaceWith('<button class="sbutton recording">' + $(this).val() + '</button>');
        */
        $('#modbox').remove();
    }, this),500);
	//$("#modifyrecording").replaceWith($(this).val());
    
    
	
});
//recordingmuokkausalueen napinpainallus
$("body").on("keypress","#modifyrecording",function(e){
		if (e.keyCode == 13){
            if ($(this).val() !== $(this).attr('title')) {
                $.ajax({
                    type: 'POST',
                    url: 'renamerecording.php',
                    data: {rowid:$(this).parent().prev().attr('title'),newname:$(this).val()}
                });
            }
            $(this).parent().prev().removeAttr("disabled");
            $(this).parent().prev().html($(this).val());
            $('#modbox').remove();
            //("#modifyrecording").replaceWith($(this).val());
		}
	});


    
//poista reconrding
$('body').on("click","#deleterecording",function(){
		//if (confirm("Oletko varma, että haluat poistaa aanityksen?")) {
            $.ajax({
				type: 'POST',
				url: 'deleterecording.php',
				data: {rowid:$(this).parent().prev().attr('title')}
			});
        //}

	});

//Toista ääni
$('body').on("click",".sbutton",function(){
		if (!$(this).is(":disabled")) {
            
            if ($(this).parent('div#recordings').length) {
                rec_playcounts[$(this).index()] += 1;
                updateplaycounts();
            }
            
			$.ajax({
				type: 'POST',
				url: 'playvlc.php',
				data: {yt:0, 
				path:$(this).val()},
				success: function(data){
				console.log("data: "+data);
				}
			  });
        }

	});
    
//Painetaan record-nappia (joka on enabloitu)
$('body').on("click",".recordbutton",function(){
    $.ajax({
        type: 'POST',
        url: 'playvlc.php',
        data: {yt:0, path:"record"}
      });

});
//Piilota äänikategoria
$('body').on("click",".hidecat",function(){
		$(this).next().children().toggle('fast');

	});
	
//Toista vitsi
$("body").on("click",".toista",function(){
	var kohde = $(this).parent().prev();
	var v = kohde.html();
	console.log(kohde);
	$.ajax({
		type: 'POST',
		url: 'tts.php',
		data: {kieli:"fi",badumtss:1,yt:0,vitsi:v}
	});
});
	

//Poista vitsi
$("body").on("click",".deletevitsi",function(){
		var id = $(this).parent().attr("id");
		console.log(id);
		if (confirm("Oletko varma, että haluat poistaa vitsin?"))
		deleteVitsi(id);
	});
//Muokkaa vitsiä
$("body").on("click",".edit_button",function(){
		var kohde = $(this).parent().prev().prev().prev();
		console.log(kohde.children())
		if (kohde.children().is("input")) return;
		var v = kohde.html();
		console.log(kohde);
		
		kohde.html('<input type="text" class="edit_area" value="'+
			v+'" size="'+(v.length*1.1)+'">');
		updating = false;
		kohde.children("input").focus();
		
	});
//Vitsinmuokkausalue
$("body").on("blur",".edit_area",function(){
		var id = $(this).parent().parent().attr("id");
	var v = $(this).val();
	$("#edit_area").replaceWith(v);
	editVitsi(id,v)
	
});
//Vitsinmuokkausalueen napinpainallus
$("body").on("keypress",".edit_area",function(e){
		if (e.keyCode == 13){
			var id = $(this).parent().parent().attr("id");
			var v = $(this).val();
			editVitsi(id,v)
		}
	});

//Poista hymiö
$('body').on("click",".deleteemo",function(){
			if (confirm("Oletko varma, että haluat poistaa hymiön?")) {
				var s = $(this).next().html();
				console.log(s);
				$.ajax({
					type: 'post',
					url: 'emoticonssc.php',
					data: {dothis:1,sana:s}
				});
          	}
        });


//Klikkaa hymiötä
$('body').on("click","img.emoticon",function(e){
		if ($('#tts').val() == $('#tts').attr('alt'))
			$('#tts').val("");
	$('#tts').val($('#tts').val() + $(this).attr('alt'));
	$('#tts').focus();
});
//Piilota hymiot
$('body').on("click","#hideemos",function(){
		$('#emoticons').toggle()
	});


//Kun ikkunaan tulee focus/pois focus
$(window).on('focus', function() {
	document.title = "Koppislandia";
	focusvar = 1;
	happening = false;
});
$(window).blur(function() {
	focusvar = 0;
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





//DOCUMENT READY ALKAA
$(document).ready(function(){
	disablejukebox();
    

	//Alustaa välilehdet
	$( "#tabs" ).tabs({activate: function( event, ui ){
        console.log(ui.newTab.index());
        if (ui.newTab.index() === 2) {
            recordings_revision = -1;
            longPoll(true);
        }
    }});
    
    

	//Klikataan stop-nappia
	$('.stop').click(function(){
		$.ajax({
            type: 'POST',
            url: 'playvlc.php',
            data: {yt:0, path:"stop"}
          });

	});

	//Kun focus tulee textarea-luokkaan
	$('.textarea').focus(
    function(){
    	if ($(this).val() == $(this).attr('alt')){
        	$(this).val("");
        	}
    });
	$('.textarea').focusout(
    function(){
    	if ($("#username").val() == "ADMIN")
    		$("#username").val("");
    	if ($(this).val() == "")
        	$(this).val($(this).attr('alt'));
    });

    //Youtube-linkki-alue enterpainallus
	$('.youtube').keypress(
    function(e){
        if (e.keyCode == 13) {
        	var v = $(this).val();
        	v = v.replace("https","http");
			console.log(v);
        	var $path = {yt:1, path:v};
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
    

    //Lisää viestejä
    $('#moreshouts').click(
    function(){
    	var rowcount = $('#shoutbox table tbody tr').length;
    	$.ajax({
    		type:'GET',
    		url:'getshouts.php',
    		data: {dothis:'getshouts',kohta:rowcount,rowcount:0},
    		success: function (data) {
    			$('#shoutbox table tbody tr:last-child').after(data);
    		}
    	});
    });
	//Klikataan sendmsg nappia
	$("#sendmsg").click(function(){
		chatmessage();
	});
	
	//Lisätään emoticon
	$("#addemoticon").click(function(){

			var s = $("#addemoticon_sana").val();
			var l = $("#addemoticon_linkki").val();
			console.log("l = " + l);
			console.log("s = " + s);
          $.ajax({
            type: 'post',
            url: 'emoticonssc.php',
            data: {dothis:0,sana:s,linkki:l}
          });

        });

    //Lisätään vitsi
    $('#addjoke').keypress(
    function(e){
        if (e.keyCode == 13) {
        	var v = $(this).val();
            $.ajax({
            	type: 'POST',
            	url: 'vitsisivusc.php',
            	data: {kieli:'fi',vitsi:v,dothis:0}
          	});
        	$(this).val("");
        }
    });
    //Kekseistä haetaan nimi, väri ja viestihistoria
    $.cookie.json = true;
    
 
    
	if ($.cookie("shoutname") != undefined)
		$('#username').val($.cookie("shoutname"));
    
    skip = false;
    
	if ($.cookie("usercolor") != undefined)
    	$('#usercolor').val($.cookie("usercolor"));
    	
    if ($.cookie("session") != undefined)
		session = $.cookie("session");
    else {
        session = $.now().toString() + $('#username').val();
        $.cookie("session", session, { expires : 10 });
        }
    
    ma = [];
    if ($.cookie("sentmessages") != undefined)
    ma = JSON.parse($.cookie("sentmessages"));

    counter = ma.length;
    
    //Kerro vitsi
    $('#kerrovitsi').click(
    function(){
    	$.ajax({
    	data:{kieli:'fi',vitsi:'**random**',badumtss:1},
    	url:'tts.php',
    	type:'POST',
    	success: function(data){
    		console.log(data);
    	}});
    
    
    });
    
    
    //Kun painetaan viestikentässä enter tai ylösalas
    $('#tts').keydown(
    function(a){
    	if (a.keyCode == 40) {
    		if (counter < (ma.length-1)){
    			counter += 1;
    			$('#tts').val(ma[counter]);}
    		else{
    			counter = ma.length;
    			$('#tts').val("");
    		}
    	}
    	if (a.keyCode == 38) {
    		if (counter > 0)
    			counter -= 1;
    		$('#tts').val(ma[counter]);
    	}
        if (a.keyCode == 13 && $(this).val() != "") {
        	
				chatmessage();
    			
        	
        }

    });
    

    
    

	//ilmoitusvilkutus
	setInterval(function () {
		if (happening){
			if (vilkku){
				document.title = "Koppislandia";
			}else{
				document.title = "**Uusi viesti!**";
			}
			vilkku = !vilkku;
		}
	}, 1000);
	
	

	updateTJt();
	longPoll();

	$('body').show();
});

function checkforUpdate(){
	$.ajax({
		type:'POST',
		url:"version.php",
		data:{ver:version},
		success: function(data){
			if (data == "1")
				location.reload();
		}
		});
}

function chatmessage(){
	var val = $('#tts').val();
	var usr = $('#username').val();
	
	if (val.length < 5000)
	postmessage(usr,val,$( "#kieli" ).val(),true);
	

	
	value = addslashes($('#tts').val());
	
	var edellinen;
	edellinen = ma.indexOf(value);
	
	while (edellinen !== -1){
		ma.splice(edellinen,1)
		edellinen = ma.indexOf(value);
	}
	if (ma[ma.length-1] != value)
		ma.push(value);
	if (ma.length > 100)
		ma.splice(0,1);
	counter = ma.length;
	
	$.cookie("sentmessages", JSON.stringify(ma) , { expires : 10 });
	
	$("#tts").val("");
	skip = true;

}

function postmessage(usr,msg,kieli,tts){
	//hommataan DateTime-muodossa aika
	var currentdate = new Date(); 
	var realdate = currentdate.toString().match(/\d\d:\d\d:\d\d/);
	var datetime = currentdate.toISOString().match(/\d\d\d\d-\d\d-\d\d/);
	datetime += " "+realdate;
	
	
	
	//nimi keksiin
	$.cookie("shoutname", usr, { expires : 10 });
	//Jos pitää puhua laitetaan tts.phplle
	if (tts){
	var $data = {kieli:kieli,badumtss:0,yt:0,
	vitsi:msg.replace(/<a href=.*>(.*)<\/a>/g, "$1")};
	$.ajax({
		type: 'POST',
		url: 'tts.php',
		data: $data
	});
	}
	
	$.ajax({
		type: 'POST',
		url: 'shout.php',
		data: {
			date:datetime,
			user:usr,
			msg:msg}
	});
	if (mobile){
		longPoll(true);
	}
}


function longPoll(loop){
    console.log("starting stream! session = "+session);
	known_users = [];
	
	$("#users span").each(function() { known_users.push($(this).text()) });
    console.log(JSON.stringify(known_users));
    $.ajax({
		data:{
		rowid:$("#shoutbox table tbody tr:first-child").attr("id"),
		kohta:0,
		user:$('#username').val(),
		users:JSON.stringify(known_users),
        rec:recording,
        online:online,
        vitsit_revision:vitsit_revision,
        emoticons_revision:emoticons_revision,
        recordings_revision:recordings_revision,
        youtube_rowid:youtube_rowid,
        cookie_rowid:cookie_rowid,
        session_id:session},
		type:'GET',
		url: 'shoutstream.php',
		dataType:'json',
		timeout:ajaxtimeout,
		success: 
	function(payload){
		console.log('longpoll success!' + payload.debug);
        console.log("recording: " + payload.rec);
		if (payload.status == "results" || payload.status == "no-results"){
			if (payload.status == "results"){
				console.log(JSON.stringify(payload));
				//console.log(payload);
			if (payload.messages != null && payload.messages.length > 0){
			$.each(payload.messages, function(i, msg){
				$("#shoutbox table tbody").prepend(
					'<tr id="' + msg.rowid + '">' +
					'<td>' + msg.time + '</td>' +
					'<td><span class="username ' + 
						msg.user + '" style="color:'+
						msg.color + '">' + msg.user + 
					'</td>' +
					'<td>' + msg.msg + '</td>' +
					'</tr>'
					);
				$("#shoutbox table tbody tr:nth-child(50)").remove()
				
				//Vilkkuminen
				if (focusvar == 0){happening = true;}
			});
			}
			if (payload.users != null && payload.users.length > 0){
				$("#users").html("Paikalla: ");
			$.each(payload.users, function(i, user){
				$("#users").append('<span>'+user+'</span>   ');
			});
			}
				if (payload.rec != null){
					recording = payload.rec;
					if (recording == 1) {
                        $('#recordbutton').css('color', 'red');
                        $('#recordbutton').text("*Recording*");
                        //disable record button
                        $('#recordbutton').attr("disabled","disabled");
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

                if (payload.vitsit != null) {
                    vitsit_revision = payload.vitsit.pop();
                    $('#vitsit').html('<ul></ul>');
                    $.each(payload.vitsit, function (i, vitsi){
                        $('#vitsit ul').html($('#vitsit ul').html() + 
                            '<li id="'+
                            vitsi.rowid+
                            '"><button style="padding:2px;min-width:40px;" class="deletevitsi">X</button>' + 
                            vitsi.vitsi + 
                            '</li>');
                    })

                }
                if (payload.emoticons != null) {
                    emoticons_revision = payload.emoticons.pop();
                    console.log(emoticons_revision);
                    $('#emoticons_tab').html('<ul></ul>');
                    $('#emoticons').html('');
                    $.each(payload.emoticons, function (i, emo){
                        $('#emoticons').html($('#emoticons').html() + 
                        '<img style="max-width:50px;max-height:50px"src="'+emo.linkki+'" alt="'+emo.sana+'" class="emoticon"/>');

                        $('#emoticons_tab ul').html($('#emoticons_tab ul').html() + 
                            '<li>'+
                            '<button style="padding:2px;min-width:40px;" class="deleteemo">X</button>'+
                            '<span>' + emo.sana + '</span> -- ' +
                            '<img style="max-width:50px;max-height:50px"src="'+
                            emo.linkki+'"/></li>');
                    })
                    
                }
				if (payload.recordings != null){
                    console.log(payload.recordings);
					recordings_revision = payload.recordings.pop();
                    $('#recordings').html('');
                    
                    for (i=0; i<0; i++) {
                        newdiv = $('<div>eero<p></div>')
                        newdiv.attr('class','rcategory');
                        newdiv.attr('value','eero');
                        newdiv.css('min-height',77);
                        newdiv.css('min-width',100);
                        newdiv.css('max-width','40%');
                        newdiv.css('border','2px solid');
                        newdiv.css('margin','10px');
                        newdiv.css('padding','5px');
                        newdiv.css('float','left');
                        newdiv.droppable({accept: ".recording",activeClass: "ui-state-highlight",
                                        drop: function( event, ui ) {
                                            $(this).append(ui.draggable)
                                            //$(this).css('height',$(this).height() + 39 )
                                        }})
                        
                        $('#recordings').append(newdiv);
                    }
                    $('#recordings').append('<br style="clear:both" />');
                    
                    biggest = 0;
                    rec_playcounts = [];
                    $.each(payload.recordings, function(i, rec) {
                        rec_playcounts[parseInt(rec.rowid)] = (parseInt(rec.playcount));
                        if (rec.playcount > biggest)
                            biggest = rec.playcount;
                    })
                    console.log("biggest: " + biggest);
                    $.each(payload.recordings, function(i, rec) {
                        name = rec.name
                        if (rec.name == null || rec.name == '1')
                            name = rec.rowid;
                        
                        
                        newbutton = $('<button' +
                        ' class="sbutton recording" title="'+rec.rowid+
                        '" value="sounds\\recorded\\' + (rec.rowid) + '.wav">' + (name) + '</button>');
                        
                        if (rec.category != null && rec.category != "null") {
                            if ($('.rcategory[value="' + rec.category + '"]').length == 0) {
                                newdiv = $('<div>' + rec.category + '<p></div>')
                                newdiv.attr('class','rcategory');
                                newdiv.attr('value', rec.category);
                                newdiv.css('min-height',77);
                                newdiv.css('min-width',100);
                                newdiv.css('max-width','40%');
                                newdiv.css('border','2px solid');
                                newdiv.css('margin','10px');
                                newdiv.css('padding','5px');
                                newdiv.css('float','left');
                                newdiv.droppable({accept: ".recording",activeClass: "ui-state-highlight",
                                        drop: function( event, ui ) {
                                            $(this).append(ui.draggable)
                                            
                                            $.ajax({
                                                type: 'POST',
                                                url: 'moverecording.php',
                                                data: {rowid:ui.draggable.attr('title'),newcat:$(this).attr('value')}
                                            });
                                        }})
                                $('#recordings').prepend(newdiv);
                            }
                            $('.rcategory[value="' + rec.category + '"]').append(newbutton);
                        } else {
                            $('#recordings').append(newbutton);
                        }
                        
                    })
                    
                    updateplaycounts();
                    
                    
                    $(".recording").draggable({cancel: "none",stack:'.recording',helper: "clone",
                        scroll : false,
                        "revert": function(a) {

                            if (a == false) {
                                $.ajax({
                                    type: 'POST',
                                    url: 'moverecording.php',
                                    data: {rowid:$(this).attr('title'),newcat:'null'}
                                });
                                return true;
                            } else {
                                return false;
                            }
                        }});
				}
                if (payload.youtube != null){
                    id = "";
                    arr = payload.youtube.link.match("(?:[\?&]v=|be\/)([^&#]*)")
                    if (arr.length > 1)
                        id = arr[1];
                    
                    rand = Math.random();
                    
                    $('#youtube').html('');
                    $('#youtube').html('<a href="' + payload.youtube.link + '">' +
                    payload.youtube.name + '</a>' +
                    '<iframe id="'+rand+'" type="text/html" width="100%"'+
                    ' src="http://www.youtube.com/embed/'+id+'?enablejsapi=1&autohide=1&showinfo=0" frameborder="0"/>'
                    );      
                    if (youtube_rowid !== 0) {
                        console.log(youtube_rowid);
                        callPlayer(rand, function() {
                            // This function runs once the player is ready ("onYouTubePlayerReady")
                            callPlayer(rand, "playVideo");
                            callPlayer(rand, "mute");
                        });
                    }
                        
                        
                    youtube_rowid = payload.youtube.rowid;

				}
                
                if (payload.cookie != null){
                    cookie_rowid = payload.cookie.rowid;
                }
				if (payload.online != null){
					online = payload.online;

				}
                if (online == 1) {
                    enablejukebox();
                }
                if (online == 0) {
                    disablejukebox();
                }
			}
        
        if (loop == undefined)
            t = setTimeout(longPoll,100);
		}
		},
		error: function(e){
			errorText = e.responseText;
		console.log('longpoll error!' + $(errorText).text());
        if (loop == undefined)
            t = setTimeout(longPoll,10000);
		}
	
	});
}



function updateplaycounts() {
    biggest = 0
    for (i=0; i<rec_playcounts.length; i++) {
        if (rec_playcounts[i] == undefined) continue;
        if (rec_playcounts[i] > biggest)
            biggest = rec_playcounts[i]
    }
    
    for (i=0; i<rec_playcounts.length; i++) {
        if (rec_playcounts[i] == undefined) continue;
        other_colors = (Math.floor(255 - (255 * (rec_playcounts[i] / biggest)))).toString(16);
        
        if (other_colors.length == 1)
            other_colors = "0" + other_colors;

        color = "#" + other_colors + "FF" + other_colors;
        $(".recording[title='" + i + "']").css('background-color',color);
    }
}



function updatecolor(){
	console.log(username);
	$('.' + $('#username').val()).css('color',$("#usercolor").val());
}

//NimiAlueesta focus pois
$("body").on("blur","#username",sendcolor);

function sendcolor(){
	console.log("sent color");
	$.cookie("usercolor", $("#usercolor").val(), { expires : 10 });
	$.cookie("shoutname", $("#username").val(), { expires : 10 });
	$.ajax({
		data:{
			user:$('#username').val(),
			color:$("#usercolor").val()},
		type:'GET',
		url:'updatecolor.php'
	});
}

function updateTJt(){
	$.ajax({
			data:{rowcount:$('#tjt > ul > li').length},
			type:'POST',
			url:'tj.php',
			success: function (data){
				if (data.length > 0){
				$('#tjt').html(data);
				}
			}
	});
}


function editVitsi(id,v){
	$.ajax({
		type: 'POST',
		url: 'vitsisivusc.php',
		data: {dothis:2,id:id,new:v}
    });
}

function deleteVitsi(id){
	$("#"+id).fadeOut('fast');
	$.ajax({
		data:{dothis:1,id:id},
		type:'POST',
		url:'vitsisivusc.php'
    });
}

function disablejukebox(){

	$('#recordbutton').css('color', 'black');
	$('#recordbutton').text("Record");
	$('#recordbutton').attr("disabled","disabled");
	$('#recordbutton').removeClass("recordbutton");
	$('.sbutton').attr("disabled","disabled");
	$('.youtube').attr('disabled','disabled');
	$('.toista').attr('disabled','disabled');
	$('.stop').attr('disabled','disabled');
	$('#kerrovitsi').attr('disabled','disabled');
	$('#not_online').show()
}
function enablejukebox(){
    if (recording != 1) {
	$('#recordbutton').removeAttr("disabled");
	$('#recordbutton').addClass("recordbutton");
    }
	$('.sbutton').removeAttr("disabled");
	$('.youtube').removeAttr("disabled");
	$('.toista').removeAttr("disabled");
	$('.stop').removeAttr("disabled");
	$('#kerrovitsi').removeAttr("disabled");
	$('#not_online').hide()
}

/**
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
    } else if (func === 'listening') {
        // Sending the "listener" message to the frame, to request status updates
        if (iframe && iframe.contentWindow) {
            func = '{"event":"listening","id":' + JSON.stringify(''+frame_id) + '}';
            iframe.contentWindow.postMessage(func, '*');
        }
    } else if (!domReady ||
               iframe && (!iframe.contentWindow || queue && !queue.ready) ||
               (!queue || !queue.ready) && typeof func === 'function') {
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
                if (e.source === iframe.contentWindow) {
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
            w3('message', listener, !1)
        :
            (add ? window.attachEvent : window.detachEvent)('onmessage', listener);
    }
}
