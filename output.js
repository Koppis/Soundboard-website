var version=11;var files;var recording=0;var online=0;var t;var vitsit_revision=-1;var emoticons_revision=-1;var recordings_revision=-1;var teamspeak_revision=-1;var teamspeak_chat_rowid=-1;var youtube_rowid=0;var cookie_rowid=-1;var session="";var rec_playcounts;console.log=function(a){};document.title="Koppislandia";focusvar=1;happening=false;vilkku=false;usercolor="";username="";if((/iPhone|iPod|iPad|Android|BlackBerry/).test(navigator.userAgent)){mobile=true;var ajaxtimeout=1000;$("#usercolor").val("#000000")}else{mobile=false;var ajaxtimeout=120000}$(window).on("beforeunload",function(){$.ajax({type:"GET",url:"disconnect.php",data:{user:$("#username").val()},async:true})});$("body").on("keypress","#ytchat_input",function(a){if(a.keyCode==13&&$("#ytchat_input").val()!=""){$.ajax({type:"POST",url:"dev/teamspeak/tschatmessage.php",data:{user:$("#username").val(),msg:$("#ytchat_input").val(),success:function(b){console.log("tschatmessage.php: "+b)}}});$("#ytchat_input").val("")}});$("body").on("click","#newrcategory",function(){category=prompt("Anna uuden kategorian nimi");newdiv=$("<div>"+category+"<p></div>");newdiv.attr("class","rcategory");newdiv.attr("value",category);newdiv.css("min-height",77);newdiv.css("min-width",100);newdiv.css("max-width","40%");newdiv.css("border","2px solid");newdiv.css("margin","10px");newdiv.css("padding","5px");newdiv.css("float","left");newdiv.droppable({accept:".recording",activeClass:"ui-state-highlight",drop:function(a,b){$(this).append(b.draggable);console.log(b.draggable.attr("title"));console.log($(this).attr("value"));$.ajax({type:"POST",url:"moverecording.php",data:{rowid:b.draggable.attr("title"),newcat:$(this).attr("value")}})}});$("#recordings").prepend(newdiv)});$("body").on("click","#hideyoutube",function(){if($("#youtube").length==1){$("#youtube").remove()}else{$(this).after('<div id="youtube"></div>');youtube_rowid=0;longPoll(true)}});$("body").on("contextmenu",".recording",function(){if($("#modifyrecording").length==0){oldwidth=$(this).width();$(this).after('<div id="modbox"><input id="modifyrecording" size="7" title="'+$(this).html()+'" value="'+$(this).html()+'"/><button id="deleterecording" style="padding:2px;min-width:20px;z-index:10;position: relative;left: 10px;top: -8px;margin-left: -2px;margin-top : 10px;">x</button></div>');$("#modbox").css("position","absolute");$("#modbox").css("top",$(this).position()["top"]);$("#modbox").css("left",$(this).position()["left"]);$("#modbox").css("z-index","10");$("#modifyrecording").focus();$("#modifyrecording").select();$(this).attr("disabled","disabled");$(this).css("position","relative");$(this).css("z-index","1")}return false});$("body").on("blur","#modifyrecording",function(){setTimeout($.proxy(function(){if($(this).val()!==$(this).attr("title")){$.ajax({type:"POST",url:"renamerecording.php",data:{rowid:$(this).parent().prev().attr("title"),newname:$(this).val()}})}$(this).parent().prev().html($(this).val());$(this).parent().prev().removeAttr("disabled");$("#modbox").remove()},this),500)});$("body").on("keypress","#modifyrecording",function(a){if(a.keyCode==13){if($(this).val()!==$(this).attr("title")){$.ajax({type:"POST",url:"renamerecording.php",data:{rowid:$(this).parent().prev().attr("title"),newname:$(this).val()}})}$(this).parent().prev().removeAttr("disabled");$(this).parent().prev().html($(this).val());$("#modbox").remove()}});$("body").on("click","#deleterecording",function(){$.ajax({type:"POST",url:"deleterecording.php",data:{rowid:$(this).parent().prev().attr("title")}});recordings_revision+=1;$(this).parent().prev().remove();$("#modbox").remove()});$("body").on("click",".sbutton",function(){if(!$(this).is(":disabled")){$.ajax({type:"POST",url:"playvlc.php",data:{yt:0,path:$(this).val()},success:function(a){console.log("data: "+a)}})}});$("body").on("click",".recordbutton",function(){$.ajax({type:"POST",url:"playvlc.php",data:{yt:0,path:"record"}})});$("body").on("click",".hidecat",function(){$(this).next().children().toggle("fast")});$("body").on("click",".toista",function(){var b=$(this).parent().prev();var a=b.html();console.log(b);$.ajax({type:"POST",url:"tts.php",data:{kieli:"fi",badumtss:1,yt:0,vitsi:a}})});$("body").on("click",".deletevitsi",function(){var a=$(this).parent().attr("id");console.log(a);if(confirm("Oletko varma, että haluat poistaa vitsin?")){deleteVitsi(a)}});$("body").on("click",".edit_button",function(){var b=$(this).parent().prev().prev().prev();console.log(b.children());if(b.children().is("input")){return}var a=b.html();console.log(b);b.html('<input type="text" class="edit_area" value="'+a+'" size="'+(a.length*1.1)+'">');updating=false;b.children("input").focus()});$("body").on("blur",".edit_area",function(){var b=$(this).parent().parent().attr("id");var a=$(this).val();$("#edit_area").replaceWith(a);editVitsi(b,a)});$("body").on("keypress",".edit_area",function(b){if(b.keyCode==13){var c=$(this).parent().parent().attr("id");var a=$(this).val();editVitsi(c,a)}});$("body").on("click",".deleteemo",function(){if(confirm("Oletko varma, että haluat poistaa hymiön?")){var a=$(this).next().html();console.log(a);$.ajax({type:"post",url:"emoticonssc.php",data:{dothis:1,sana:a}})}});$("body").on("click","img.emoticon",function(a){if($("#tts").val()==$("#tts").attr("alt")){$("#tts").val("")}$("#tts").val($("#tts").val()+$(this).attr("alt"));$("#tts").focus()});$("body").on("click","#hideemos",function(){$("#emoticons").toggle()});$("body").on("focus",".textarea",function(a){if($(this).val()==$(this).attr("alt")){$(this).val("")}});$("body").on("blur",".textarea",function(a){if($("#username").val()=="ADMIN"){$("#username").val("")}if($(this).val()==""){$(this).val($(this).attr("alt"))}});$(window).on("focus",function(){document.title="Koppislandia";focusvar=1;happening=false});$(window).blur(function(){focusvar=0});function addslashes(a){return a.replace(/\\/g,"\\\\").replace(/\u0008/g,"\\b").replace(/\t/g,"\\t").replace(/\n/g,"\\n").replace(/\f/g,"\\f").replace(/\r/g,"\\r").replace(/'/g,"\\'").replace(/"/g,'\\"')}$(document).ready(function(){disablejukebox();$("#tabs").tabs({activate:function(a,b){console.log(b.newTab.index());if(b.newTab.index()===2){}}});if(mobile){$("#teamspeak").remove();$("#teamspeak2").attr("id","teamspeak")}else{$("#tabs").tabs("disable",6)}$(".stop").click(function(){$.ajax({type:"POST",url:"playvlc.php",data:{yt:0,path:"stop"}})});$(".youtube").keypress(function(c){if(c.keyCode==13){var a=$(this).val();a=a.replace("https","http");console.log(a);var b={yt:1,path:a};$(this).val("");$.ajax({type:"POST",url:"playvlc.php",data:b,success:function(d){console.log(d)}})}});$("#moreshouts").click(function(){var a=$("#shoutbox table tbody tr").length;$.ajax({type:"GET",url:"getshouts.php",data:{dothis:"getshouts",kohta:a,rowcount:0},success:function(b){$("#shoutbox table tbody tr:last-child").after(b)}})});$("#sendmsg").click(function(){chatmessage()});$("#addemoticon").click(function(){var b=$("#addemoticon_sana").val();var a=$("#addemoticon_linkki").val();console.log("l = "+a);console.log("s = "+b);$.ajax({type:"post",url:"emoticonssc.php",data:{dothis:0,sana:b,linkki:a}})});$("#addjoke").keypress(function(b){if(b.keyCode==13){var a=$(this).val();$.ajax({type:"POST",url:"vitsisivusc.php",data:{kieli:"fi",vitsi:a,dothis:0}});$(this).val("")}});$.cookie.json=true;if($.cookie("shoutname")!=undefined){$("#username").val($.cookie("shoutname"))}skip=false;if($.cookie("usercolor")!=undefined){$("#usercolor").val($.cookie("usercolor"))}if($.cookie("session")!=undefined){session=$.cookie("session")}else{session=$.now().toString()+$("#username").val();$.cookie("session",session,{expires:10})}ma=[];if($.cookie("sentmessages")!=undefined){ma=JSON.parse($.cookie("sentmessages"))}counter=ma.length;$("#kerrovitsi").click(function(){$.ajax({data:{kieli:"fi",vitsi:"**random**",badumtss:1},url:"tts.php",type:"POST",success:function(a){console.log(a)}})});$("#tts").keydown(function(b){if(b.keyCode==40){if(counter<(ma.length-1)){counter+=1;$("#tts").val(ma[counter])}else{counter=ma.length;$("#tts").val("")}}if(b.keyCode==38){if(counter>0){counter-=1}$("#tts").val(ma[counter])}if(b.keyCode==13&&$(this).val()!=""){chatmessage()}});setInterval(function(){if(happening){if(vilkku){document.title="Koppislandia"}else{document.title="**Uusi viesti!**"}vilkku=!vilkku}},1000);updateTJt();longPoll();$("body").show()});function checkforUpdate(){$.ajax({type:"POST",url:"version.php",data:{ver:version},success:function(a){if(a=="1"){location.reload()}}})}function chatmessage(){var b=$("#tts").val();var c=$("#username").val();if(b.length<5000){postmessage(c,b,$("#kieli").val(),true)}value=addslashes($("#tts").val());var a;a=ma.indexOf(value);while(a!==-1){ma.splice(a,1);a=ma.indexOf(value)}if(ma[ma.length-1]!=value){ma.push(value)}if(ma.length>100){ma.splice(0,1)}counter=ma.length;$.cookie("sentmessages",JSON.stringify(ma),{expires:10});$("#tts").val("");skip=true}function postmessage(h,f,a,d){var c=new Date();var e=c.toString().match(/\d\d:\d\d:\d\d/);var g=c.toISOString().match(/\d\d\d\d-\d\d-\d\d/);g+=" "+e;$.cookie("shoutname",h,{expires:10});if(d){var b={kieli:a,badumtss:0,yt:0,vitsi:f.replace(/<a href=.*>(.*)<\/a>/g,"$1")};$.ajax({type:"POST",url:"tts.php",data:b})}$.ajax({type:"POST",url:"shout.php",data:{date:g,user:h,msg:f}});if(mobile){longPoll(true)}}function longPoll(a){console.log("starting stream! session = "+session);known_users=[];$("#users span").each(function(){known_users.push($(this).text())});console.log(JSON.stringify(known_users));$.ajax({data:{rowid:$("#shoutbox table tbody tr:first-child").attr("id"),kohta:0,user:$("#username").val(),users:JSON.stringify(known_users),rec:recording,online:online,vitsit_revision:vitsit_revision,emoticons_revision:emoticons_revision,recordings_revision:recordings_revision,teamspeak_revision:teamspeak_revision,youtube_rowid:youtube_rowid,cookie_rowid:cookie_rowid,teamspeak_chat_rowid:teamspeak_chat_rowid,session_id:session},type:"GET",url:"shoutstream.php",dataType:"json",timeout:ajaxtimeout,success:function(b){if(b.status=="results"||b.status=="no-results"){if(b.status=="results"){if(b.messages!=null&&b.messages.length>0){$.each(b.messages,function(d,e){$("#shoutbox table tbody").prepend('<tr id="'+e.rowid+'"><td>'+e.time+'</td><td><span class="username '+e.user+'" style="color:'+e.color+'">'+e.user+"</td><td>"+e.msg+"</td></tr>");$("#shoutbox table tbody tr:nth-child(50)").remove();if(focusvar==0){happening=true}})}if(b.users!=null&&b.users.length>0){$("#users").html("Paikalla: ");$.each(b.users,function(e,d){$("#users").append("<span>"+d+"</span>   ")})}if(b.rec!=null){recording=b.rec;if(recording==1){$("#recordbutton").css("color","red");$("#recordbutton").text("*Recording*");$("#recordbutton").attr("disabled","disabled");$("#recordbutton").removeClass("recordbutton")}else{$("#recordbutton").css("color","black");$("#recordbutton").text("Record");$("#recordbutton").removeAttr("disabled");$("#recordbutton").addClass("recordbutton")}console.log("recording: "+recording)}if(b.vitsit!=null){vitsit_revision=b.vitsit.pop();$("#vitsit").html("<ul></ul>");$.each(b.vitsit,function(d,e){$("#vitsit ul").html($("#vitsit ul").html()+'<li id="'+e.rowid+'"><button style="padding:2px;min-width:40px;" class="deletevitsi">X</button>'+e.vitsi+"</li>")})}if(b.emoticons!=null){emoticons_revision=b.emoticons.pop();console.log(emoticons_revision);$("#emoticons_tab").html("<ul></ul>");$("#emoticons").html("");$.each(b.emoticons,function(d,e){$("#emoticons").html($("#emoticons").html()+'<img style="max-width:50px;max-height:50px"src="'+e.linkki+'" alt="'+e.sana+'" class="emoticon"/>');$("#emoticons_tab ul").html($("#emoticons_tab ul").html()+'<li><button style="padding:2px;min-width:40px;" class="deleteemo">X</button><span>'+e.sana+'</span> -- <img style="max-width:50px;max-height:50px"src="'+e.linkki+'"/></li>')})}if(b.recordings!=null&&parseInt(b.recordings[b.recordings.length-1])!=recordings_revision){if(b.recordings.justone!=null){if($('.recording[title="'+b.recordings.rowid+'"]').length==0&&b.recordings.deleted!==1&&b.recordings.deleted!=="1"){name=b.recordings.name;if(b.recordings.name==null||b.recordings.name=="1"){name=b.recordings.rowid}newbutton=$('<button class="sbutton recording" title="'+b.recordings.rowid+'" value="sounds\\recorded\\'+(b.recordings.rowid)+'.wav">'+(name)+"</button>");$($("#recordings").children(".recording")[0]).before(newbutton);$(newbutton).draggable({cancel:"none",stack:".recording",helper:"clone",scroll:false,distance:50,revert:function(d){if(d==false){$.ajax({type:"POST",url:"moverecording.php",data:{rowid:$(this).attr("title"),newcat:"null"}});recordings_revision+=1;$.each($("#recordings .recording"),function(f,e){if(parseInt($(this).attr("title"))>parseInt($(e).attr("title"))){$(e).before($(this));return false}})}}})}recordings_revision=b.recordings.revision;var c=$('#recordings[title="'+b.recordings.rowid+'"]');$(c).html(b.recordings.name);if(b.recordings.deleted==1||b.recordings.deleted=="1"){$(c).remove()}if(b.recordings.category!=null){$.each($('.rcategory[value="'+b.recordings.category+'"] .recording'),function(e,d){if(parseInt($(c).attr("title"))>parseInt($(d).attr("title"))){$(d).before(c);return false}})}else{$.each($("#recordings > .recording"),function(e,d){if(parseInt($(c).attr("title"))>parseInt($(d).attr("title"))){$(d).before(c);return false}})}}else{recordings_revision=parseInt(b.recordings.pop());$("#recordings").html("");$("#recordings").append('<div id="rcat_1" style="float:left;width:50%;" ></div>');$("#recordings").append('<div id="rcat_2" style="float:left;width:50%;" ></div>');$("#recordings").append('<br style="clear:both" />');biggest=0;rec_playcounts=[];$.each(b.recordings.reverse(),function(d,e){rec_playcounts[parseInt(e.rowid)]=(parseInt(e.playcount));if(e.playcount>biggest){biggest=e.playcount}if(e.category!=null&&e.category!="null"){if($('.rcategory[value="'+e.category+'"]').length==0){newdiv=$("<div>"+e.category+"<p></div>");newdiv.attr("class","rcategory");newdiv.attr("value",e.category);newdiv.css("min-height",77);newdiv.css("min-width",100);newdiv.css("border","2px solid");newdiv.css("margin","10px");newdiv.css("padding","5px");newdiv.droppable({accept:".recording",activeClass:"ui-state-highlight",drop:function(f,g){$.each($(this).children(),function(j,h){if(parseInt($(g.draggable).attr("title"))>parseInt($(h).attr("title"))){$(h).before(g.draggable);return false}});recordings_revision+=1;$.ajax({type:"POST",url:"moverecording.php",data:{rowid:g.draggable.attr("title"),newcat:$(this).attr("value")}})}});$("#recordings").prepend(newdiv)}}});console.log("biggest: "+biggest);prevdate="";$.each(b.recordings.reverse(),function(d,e){name=e.name;if(e.name==null||e.name=="1"){name=e.rowid}newbutton=$('<button class="sbutton recording" title="'+e.rowid+'" value="sounds\\recorded\\'+(e.rowid)+'.wav">'+(name)+"</button>");if(e.category!=null&&e.category!="null"){$('.rcategory[value="'+e.category+'"]').append(newbutton)}else{if(e.date!==prevdate){$("#recordings").append("<br>"+e.date+"<br>")}prevdate=e.date;$("#recordings").append(newbutton)}});$(".rcategory").each(function(){console.log("#rcat_1: "+$("#rcat_1 .sbutton").length);console.log("#rcat_2: "+$("#rcat_2 .sbutton").length);if($("#rcat_1 .sbutton").length<$("#rcat_2 .sbutton").length){$("#rcat_1").prepend($(this))}else{$("#rcat_2").prepend($(this))}});$(".recording").draggable({cancel:"none",stack:".recording",helper:"clone",scroll:false,distance:50,revert:function(d){if(d==false){$.ajax({type:"POST",url:"moverecording.php",data:{rowid:$(this).attr("title"),newcat:"null"}});recordings_revision+=1;$.each($("#recordings .recording"),function(f,e){if(parseInt($(this).attr("title"))>parseInt($(e).attr("title"))){$(e).before($(this));return false}})}}});updateplaycounts()}}if(b.youtube!=null){id="";arr=b.youtube.link.match("(?:[?&]v=|be/)([^&#]*)");if(arr.length>1){id=arr[1]}rand=Math.random();$("#youtube").html("");$("#youtube").html('<a href="'+b.youtube.link+'">'+b.youtube.name+'</a><iframe id="'+rand+'" type="text/html" width="100%" src="http://www.youtube.com/embed/'+id+'?enablejsapi=1&autohide=1&showinfo=0" frameborder="0"/>');if(youtube_rowid!==0){console.log(youtube_rowid);callPlayer(rand,function(){callPlayer(rand,"playVideo");callPlayer(rand,"mute")})}youtube_rowid=b.youtube.rowid}if(b.teamspeak!=null){if(b.teamspeak.changes==null){teamspeak_revision=b.teamspeak.pop();newlist=$("<ul></ul>");$.each(b.teamspeak,function(e,d){if(d.type==1&&d.parent==null){$(newlist).append('<li style="list-style-type: none;" value="'+d.id+'"><img src="teamspeak/images/viewer/channel_open.png" /> '+d.name+"<ul></ul></li>")}});$.each(b.teamspeak,function(e,d){if(d.type==1&&d.parent!=null){$(newlist).find('li[value="'+d.parent+'"]').children("ul").append('<li style="list-style-type: none;" value="'+d.id+'"><img src="teamspeak/images/viewer/channel_open.png" /> '+d.name+"<ul></ul></li>")}});$.each(b.teamspeak,function(e,d){if(d.type==0&&d.online==1){$(newlist).find('li[value="'+d.channel+'"]').children("ul").prepend('<li style="list-style-type: none;" value="'+d.id+'"><img src="teamspeak/images/viewer/client_idle.png" /> '+d.name+"</li>")}});$("#teamspeak").html(newlist)}}if(b.teamspeakchat!=null){teamspeak_chat_rowid=b.teamspeakchat[b.teamspeakchat.length-1].rowid;if($("#teamspeakchat").length==0){$("#teamspeak").after('<input type="text" size="33" class="textarea" id="ytchat_input" alt="Teamspeak chat" value="Teamspeak chat"></input><br><ul id="teamspeakchat"></ul>')}$.each(b.teamspeakchat,function(d,f){$("#teamspeakchat li:nth-child(20)").remove();$("#teamspeakchat").prepend('<li style="list-style-type: none;">'+f.user+": "+f.msg+"</li>")})}if(b.cookie!=null){cookie_rowid=b.cookie.rowid}if(b.online!=null){online=b.online}if(online==1){enablejukebox()}if(online==0){disablejukebox()}}if(a==undefined){t=setTimeout(longPoll,100)}}},error:function(b){errorText=b.responseText;console.log("longpoll error!"+$(errorText).text());if(a==undefined){t=setTimeout(longPoll,10000)}}})}function updateplaycounts(){biggest=0;for(i=0;i<rec_playcounts.length;i++){if(rec_playcounts[i]==undefined){continue}if(rec_playcounts[i]>biggest){biggest=rec_playcounts[i]}}for(i=0;i<rec_playcounts.length;i++){if(rec_playcounts[i]==undefined){continue}other_colors=(Math.floor(255-(255*(rec_playcounts[i]/biggest)))).toString(16);if(other_colors.length==1){other_colors="0"+other_colors}color="#"+other_colors+"FF"+other_colors;$(".recording[title='"+i+"']").css("background-color",color)}}function updatecolor(){console.log(username);$("."+$("#username").val()).css("color",$("#usercolor").val())}$("body").on("blur","#username",sendcolor);function sendcolor(){console.log("sent color");$.cookie("usercolor",$("#usercolor").val(),{expires:10});$.cookie("shoutname",$("#username").val(),{expires:10});$.ajax({data:{user:$("#username").val(),color:$("#usercolor").val()},type:"GET",url:"updatecolor.php"})}function updateTJt(){$.ajax({data:{rowcount:$("#tjt > ul > li").length},type:"POST",url:"tj.php",success:function(a){if(a.length>0){$("#tjt").html(a)}}})}function editVitsi(b,a){$.ajax({type:"POST",url:"vitsisivusc.php",data:{dothis:2,id:b,newname:a}})}function deleteVitsi(a){$("#"+a).fadeOut("fast");$.ajax({data:{dothis:1,id:a},type:"POST",url:"vitsisivusc.php"})}function disablejukebox(){$("#recordbutton").css("color","black");$("#recordbutton").text("Record");$("#recordbutton").attr("disabled","disabled");$("#recordbutton").removeClass("recordbutton");$(".sbutton").attr("disabled","disabled");$(".recording").attr("disabled","disabled");$(".youtube").attr("disabled","disabled");$(".toista").attr("disabled","disabled");$(".stop").attr("disabled","disabled");$("#kerrovitsi").attr("disabled","disabled");$(".not_online").show()}function enablejukebox(){if(recording!=1){$("#recordbutton").removeAttr("disabled");$("#recordbutton").addClass("recordbutton")}$(".sbutton").removeAttr("disabled");$(".recording").removeAttr("disabled");$(".youtube").removeAttr("disabled");$(".toista").removeAttr("disabled");$(".stop").removeAttr("disabled");$("#kerrovitsi").removeAttr("disabled");$(".not_online").hide()}function callPlayer(f,g,c){if(window.jQuery&&f instanceof jQuery){f=f.get(0).id}var e=document.getElementById(f);if(e&&e.tagName.toUpperCase()!="IFRAME"){e=e.getElementsByTagName("iframe")[0]}console.log(e);if(!callPlayer.queue){callPlayer.queue={}}var b=callPlayer.queue[f],d=document.readyState=="complete";if(d&&!e){window.console&&console.log("callPlayer: Frame not found; id="+f);if(b){clearInterval(b.poller)}}else{if(g==="listening"){if(e&&e.contentWindow){g='{"event":"listening","id":'+JSON.stringify(""+f)+"}";e.contentWindow.postMessage(g,"*")}}else{if(!d||e&&(!e.contentWindow||b&&!b.ready)||(!b||!b.ready)&&typeof g==="function"){if(!b){b=callPlayer.queue[f]=[]}b.push([g,c]);if(!("poller" in b)){b.poller=setInterval(function(){callPlayer(f,"listening")},250);a(1,function h(j){if(!e){e=document.getElementById(f);if(!e){return}if(e.tagName.toUpperCase()!="IFRAME"){e=e.getElementsByTagName("iframe")[0];if(!e){return}}}if(j.source===e.contentWindow){clearInterval(b.poller);b.ready=true;a(0,h);while(tmp=b.shift()){callPlayer(f,tmp[0],tmp[1])}}},false)}}else{if(e&&e.contentWindow){if(g.call){return g()}e.contentWindow.postMessage(JSON.stringify({event:"command",func:g,args:c||[],id:f}),"*")}}}}function a(k,j){var l=k?window.addEventListener:window.removeEventListener;l?l("message",j,!1):(k?window.attachEvent:window.detachEvent)("onmessage",j)}};