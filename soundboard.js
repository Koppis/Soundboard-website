
//init
var version = 11;
var files;
var recording = 0;
var online = 0;
var t;
var vitsit_revision = 0;
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

//Toista ääni
$('body').on("click",".sbutton",function(){
		if (!$(this).is(":disabled")) {
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
				var s = $(this).parent().prev().prev().html();
				console.log(s);
				$.ajax({
					type: 'post',
					url: 'emoticonssc.php',
					data: {dothis:1,sana:s},
					success: updateEmoticons
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
	$( "#tabs" ).tabs();

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
			v += "&hd=1";
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
            data: {dothis:2,sana:s,linkki:l},
            success: function (data) {
            	updateEmoticons()
				console.log(data);
            }
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
    	success: function(){
    		updateVitsit();
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
	
	
	//Hymiökuvakkeet
	$.ajax({
		data:{dothis:'getemoticons'},
		url:'getshouts.php',
		type:'GET',
		success: function (data) {
		if ($("<div />").append($("#emoticons").clone()).html() != data)
		$('#emoticons').replaceWith(data);
		}
	});
	
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
		clearTimeout(t);
		longPoll();
	}
}


function longPoll(){
    console.log("starting stream! lastrow = "+$("#shoutbox table tbody tr:first-child").attr("id"));
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
        vitsit_revision:vitsit_revision},
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
					//disable play recorded-button					} else {
					$('#recordbutton').css('color', 'black');
					$('#recordbutton').text("Record");
					//enable buttons
					$('#recordbutton').removeAttr("disabled");
					$('#recordbutton').addClass("recordbutton");
                }
					
					
					
					console.log("recording: " + recording);
				}
				if (payload.online != null){
					online = payload.online;
					if (online == 1) {
						enablejukebox();
					}
					if (online == 0) {
						disablejukebox();
						
					}
				}
                if (payload.vitsit != null) {
                    vitsit_revision = payload.vitsit.pop();
                    $('#vitsit').html('<ul></ul>');
                    $.each(payload.vitsit, function (i, vitsi){
                        $('#vitsit ul').html($('#vitsit ul').html() + 
                            '<li id="'+vitsi.rowid+'"><button style="padding:2px;min-width:40px;" class="deletevitsi">X</button>' + vitsi.vitsi + '</li>');
                    })

                }
			}
		t = setTimeout(longPoll,100);
		}
		},
		error: function(e){
			errorText = e.responseText;
		console.log('longpoll error!' + $(errorText).text());
		t = setTimeout(longPoll,10000);
		}
	
	});
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

function updateEmoticons(){
	$.ajax({
		data:{dothis:0},
		type:'POST',
		url:'emoticonssc.php',
		always: function (data){
			console.log(data);
		},
		success: function (data){
			if (data.length > 0){
			$('#emoticons_tab').html(data);
			}
		}
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
	$('#recordbutton').removeAttr("disabled");
	$('#recordbutton').addClass("recordbutton");
	$('.sbutton').removeAttr("disabled");
	$('.youtube').removeAttr("disabled");
	$('.toista').removeAttr("disabled");
	$('.stop').removeAttr("disabled");
	$('#kerrovitsi').removeAttr("disabled");
	$('#not_online').hide()
}
