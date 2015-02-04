session = "";
username = "Anonymous";
searching = true;
turn = -1;




$(document).ready(function(){

	if ($.cookie("shoutname") != undefined)
		username = $.cookie("shoutname");

    if ($.cookie("session") != undefined)
		session = $.cookie("session");
    else {
        session = $.now().toString() + username;
        $.cookie("session", session, { expires : 10 });
        }



    longPoll();
})


$('html').on("click","#quitgame",function(){

    $.ajax({
        data:{
            id:session
        },
        type:'POST',
        url: 'endgame.php',
        success: function(data){
            console.log("data: "+data);
        }
    })

})


$('html').on("click","#board button",function(){
    console.log("x: " + $(this).parent().index() + " y: " + $(this).parent().parent().index())
    $.ajax({
        data:{
            id:session,
            turn:turn,
            x:$(this).parent().index(),
            y:$(this).parent().parent().index()
        },
        type:'POST',
        url: 'play.php',
        success: function(data){
            console.log("data: "+data);
        }
    })
})



function longPoll() {

    console.log("starting stream! session = "+session);
    $.ajax({
		data:{
            id:session,
            turn:turn,
            searching:searching,
            username:username
        },
		type:'POST',
		url: 'stream.php',
		dataType:'json',
		success: 
	function(payload){
		console.log('longpoll success!' + payload.debug);
        if (payload.status == "results" || payload.status == "no-results"){
			if (payload.status == "results"){
				console.log(JSON.stringify(payload));
                if (payload.gamedata != null) {
                    $("#gamestatus").html("Current opponent: " + payload.gamedata.opponent);
                    searching = false;
                    console.log("Gote some gamedata");
                    turn = payload.gamedata.turn;
                    
                    $.each(JSON.parse(payload.gamedata.board), function (i, arr) {
                        $.each(arr, function (j, val){
                            //console.log("x: " + i + " :y " + j + " : " + val);
                            
                            $("#board tbody tr:nth-child("+(parseInt(j)+1)+") td:nth-child(" + (parseInt(i)+1) + ") button").html(val);
                            
                        })
                    })
                    
                }
                if (payload.gameended != null && payload.gameended == true) {
                    searching = true;
                    turn = -1;
                    $("#gamestatus").html("Searching for opponent...");
                    $("#board button").html("");
                }
            }
        }
        t = setTimeout(longPoll,100);
    },
        error: 
    function(e){
		errorText = e.responseText;
		console.log('longpoll error!' + $(errorText).text());
    }

    });

}

