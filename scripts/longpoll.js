function longPoll(loop) {
    console.log("starting stream! session = " + session);
    known_users = [];

    $("#users span").each(function() {
        known_users.push($(this).text());
    });
    console.log(JSON.stringify(known_users));
    $.ajax({
        data: {
            rowid: $("#shoutbox table tbody tr:first-child").attr("id"),
            kohta: 0,
            user: $('#username').val(),
            users: JSON.stringify(known_users),
            rec: recording,
            online: online,
            vitsit_revision: vitsit_revision,
            emoticons_revision: emoticons_revision,
            recordings_revision: recordings_revision,
            teamspeak_revision: teamspeak_revision,
            youtube_rowid: youtube_rowid,
            cookie_rowid: cookie_rowid,
            teamspeak_chat_rowid: teamspeak_chat_rowid,
            processes_revision: processes_revision,
            memes_revision: memes_revision,
            session_id: session
        },
        type: 'GET',
        url: 'shoutstream.php',
        dataType: 'json',
        timeout: ajaxtimeout,
        success: function(payload) {
            start_time = new Date().getTime();
            //console.log('longpoll success!' + payload.debug);
            //console.log("recording: " + payload.rec);
            if (payload.status == "results" || payload.status == "no-results") {
                if (payload.status == "results") {
                    //console.log(JSON.stringify(payload));
                    console.log(payload);
                    console.log(Date.now());
                    if (payload.youtube != undefined) {
                            handle_payload_youtube(payload.youtube);
                    }
                            console.log("line f: " + (new Date().getTime() - start_time) + "ms");
                    if (payload.messages != undefined && payload.messages.length > 0) {
                        var newhtml = '';
                        $.each(payload.messages, function(i, msg) {
                            newhtml =
                                '<tr id="' + msg.rowid + '">' +
                                '<td>' + msg.time + '</td>' +
                                '<td><span class="username ' +
                                msg.user + '" style="color:#' +
                                msg.color + '">' + msg.user +
                                '</td>' +
                                '<td>' + msg.msg + '</td>' +
                                '</tr>' + newhtml;

                        });
                        //Vilkkuminen
                        if (focusvar == 0 && newhtml !== '') {
                            happening = true;
                            changeFavicon("/images/kapparoll/tmp-0.gif")

                        }

                        $("#shoutbox table tbody").prepend(newhtml);
                        $("#shoutbox table tbody tr:nth-child(50)").remove();

                    }
                    if (payload.users != undefined && payload.users.length > 0) {
                        document.getElementById("users").innerHTML = "Paikalla: ";
                        $.each(payload.users, function(i, user) {
                            $("#users").append('<span>' + user + '</span>   ');
                        });
                    }
                    if (payload.rec != undefined) {
                        handle_recording_state(payload.rec);
                    }

                    if (payload.vitsit != undefined) {
                        vitsit_revision = payload.vitsit.pop();
                        $('#vitsit').html('<ul></ul>');
                        newhtml = '';
                        $.each(payload.vitsit, function(i, vitsi) {
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
                    if (payload.emoticons != undefined) {
                        handle_payload_emoticons(payload.emoticons);
                    }
                    if (payload.rec != undefined) {
                        recording = payload.rec;
                        handle_recording_state(recording);
                    }
                    if (payload.recordings != undefined) {
                        handle_recordings(payload.recordings);
                    }
                    console.log((new Date().getTime() - start_time) + "ms");
                            console.log("line d: " + (new Date().getTime() - start_time) + "ms");


                    if (payload.teamspeak != undefined) {
                        handle_payload_teamspeak(payload.teamspeak);
                    }
                            console.log("line g: " + (new Date().getTime() - start_time) + "ms");
                    if (payload.teamspeakchat != undefined) {
                        handle_payload_teamspeakchat(payload.teamspeakchat);
                        
                    }
                            console.log("line h: " + (new Date().getTime() - start_time) + "ms");

                    if (payload.processes != undefined) {
                        processes_revision = payload.processes.pop();
                        var div = $("#processes");
                        div.html("<ul></ul>");
                        $.each(payload.processes, function(i, e) {
                            div.children("ul").append('<li>' + e.name + '<button class="killpid" title="' + e.pid + '" style="padding:2px;min-width:20px;">X</button></li>');
                            if (e.name.substring(0,2) == "yt") {
                                callPlayer(13371234, function() {
                                    // This function runs once the player is ready ("onYouTubePlayerReady")
                                        callPlayer(13371234, "playVideo");
                                        callPlayer(13371234, "mute");
                                        setTimeout(function(){
                                            callPlayer(13371234, "seekTo",[2,false]);
                                            callPlayer(13371234, "playVideo");
                                        },700 - ping);
                                });
                            }
                        })
                    }

                            console.log("line i: " + (new Date().getTime() - start_time) + "ms");
                    if (payload.memes != undefined) {
                        handle_payload_memes(payload.memes);
                    }


                    if (payload.cookie != undefined) {
                        cookie_rowid = payload.cookie.rowid;
                    }
                    if (payload.online != undefined) {
                        online = payload.online;

                    }
                    if (online == 1) {
                        enablejukebox();
                    }
                    if (online == 0) {
                        disablejukebox();
                    }
                }
                diff = new Date().getTime() - start_time;
                console.log("Payload function took " + diff + "ms");
                var oldtime = new Date;

                $.ajax({ type: "POST",
                        url: "ping.php",
                        cache:false,
                        success: function(output){ 

                                    ping = new Date - oldtime;
                                    $("#ping").html("Ping: " + ping);
                                        }
                });
                if (loop == undefined)
                    t = setTimeout(longPoll, 100);
            }
        },
        error: function(e) {
            errorText = e.responseText;
            console.log('longpoll error!' + $(errorText).text());
            if (loop == undefined)
                t = setTimeout(longPoll, 10000);
        }

    });
}
