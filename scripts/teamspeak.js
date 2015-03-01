function handle_payload_teamspeak(payload_teamspeak) {
    teamspeak_revision = payload_teamspeak.pop();

    newlist = $("<ul></ul>");

    $.each(payload_teamspeak, function(i, a) {
        if (a.type == 1 && a.parent == 0) {
            $(newlist).append('<li style="list-style-type: none;" value="' + a.id + '">' +
                '<img src="teamspeak/images/default_colored_2014/channel_green_subscribed.png" /> ' + a.name + "<ul></ul></li>");
        }
    });
    $.each(payload_teamspeak, function(i, a) {
        if (a.type == 1 && a.parent != 0) {
            $(newlist).find('li[value="' + a.parent + '"]').children('ul').append('<li style="list-style-type: none;" value="' + a.id + '">' +
                '<img src="teamspeak/images/default_colored_2014/channel_green_subscribed.png" /> ' + a.name + '<ul></ul></li>');
        }
    });
    $.each(payload_teamspeak, function(i, a) {
        if (a.type == 0 && a.online == 1) {
            var nickname, lolname = a.name;
            switch (a.name) {
                case "omena":
                    lolname = "Happy%20Omena";
                    break;
                case "Super":
                    lolname = "Twitch%20Chat";
                    break;
                case "Koppis":
                    lolname = "Koppis1337";
                    break;

            }
            if (a.summonerid == null)
                nickname = a.name;
            else
                nickname = '<a target="_blank" href="http://www.elophant.com/league-of-legends/summoner/eune/'+a.summonerid+'/recent-games">'+a.name+'</a>';
            var clienticon = $('<li style="list-style-type: none;" class="ts_client" value="' + a.id + '">' + nickname + 
                (a.lolchamp != null ? " - <a href='http://www.lolnexus.com/EUNE/search?name="+lolname+"&server=EUNE' target='_blank'><img  src='/images/lol/champion/"+a.lolchamp+".png' /></a>":"") + '</li>');
            $(newlist).find('li[value="' + a.channel + '"]').children('ul').prepend(clienticon);
            switch (a.mode) {
                case 0:
                    clienticon.prepend('<img src="teamspeak/images/default_colored_2014/player_off.png" /> ');
                    break;
                case 1:
                    clienticon.prepend('<img src="teamspeak/images/default_colored_2014/input_muted.png" /> ');
                    break;
                case 2:
                    clienticon.prepend('<img src="teamspeak/images/default_colored_2014/output_muted.png" /> ');
                    break;
                case 3:
                    clienticon.prepend('<img src="teamspeak/images/default_colored_2014/away.png" /> ');
                    break;
            }
        }
    });

    $("#teamspeak").html(newlist);
}
function handle_payload_teamspeakchat(payload_teamspeakchat){
    teamspeak_chat_rowid = payload_teamspeakchat[payload_teamspeakchat.length - 1].rowid;
    if ($('#teamspeakchat').length == 0) {
        $('#teamspeak').after('<input type="text" size="33" class="textarea" id="ytchat_input" ' +
            'alt="Teamspeak chat" value="Teamspeak chat"></input><br>' +
            '<ul id="teamspeakchat" style="padding-left:10px"></ul>');
    }
    toappend = '';
    $.each(payload_teamspeakchat, function(i, e) {
        $('#teamspeakchat li:nth-child(20)').remove();

        msg = e.msg;

        if ((e.msg).search(/\[URL\](.*)\[\/URL\]/g) != -1) {
            msg = msg.replace(/\[URL\]/g, '<a target="_blank" href="');
            msg = msg.replace(/\[\/URL\]/g, '">' + ((e.msg).match(/\[URL\](.*)\[\/URL\]/i))[1] + '</a>');
        }

        toappend = '<li style="list-style-type: none;"><b>' + e.user + '</b>: ' + msg + '</li>' + toappend

    });
    $('#teamspeakchat').prepend(toappend);
    if (focusvar == 0) {
        happening = true;
        changeFavicon("/images/kapparoll/tmp-0.gif")


    }
}
