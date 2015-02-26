

function memerate_handler(rating, evt) {

    if (isNaN(parseInt(rating))) rating = 0;
    
    console.log("rec : "+$(this).prev().attr('title'));
    console.log("rating : "+(parseInt(rating)*2));
    console.log("myrating : "+(parseInt($(this).attr("data-myscore"))));

    if (rating == (parseInt($(this).attr("data-myscore")))) return;
    $(this).css('background-color','');    
    $.ajax({
    type: 'POST',
    url: 'ratememe.php',
    data: {
    rec:$(this).parent().attr('rec'),
    rating: (parseInt(rating)*2),
    user:session
    },
    success: function(data) {
    console.log(data);
    },
    error: function(data) {
    console.log(data);
    }


    });
}
function vitstirating_handler(score){
        vitsi = $(this).prev().attr('title');
            $.ajax({
                url:'ratememe.php',
                type:'POST',
                data:{rating:score*2,
                    user:session,
                    vitsi:vitsi},
                success:function(data){
                console.log(data);
                }})
    }

function handle_payload_memes (payload_memes){
    memes_revision = payload_memes.shift().rating;
    payload_memes.sort(function(a,b) {return (b.rating) - parseFloat(a.rating)})
    //if ($('#memet').text() == "") {
        newmemes = "";
        $.each(payload_memes, function (i,e) {
            if (e.rec != null) {
                //b = $('.recording[title='+e.rec+']').first();
                style = (e.myrating == null ? 'style="background-color:#FF0000;"' : "");
                meme = '<div style="display:inline-block;margin:10px" rec="'+e.rec+
                '"><button class="sbutton" '+style+' title="'+e.rec+'" value="sounds\\recorded\\' + e.rec + '.wav">'+
                e.recname+'</button>'+(e.myrating != null ? e.myrating/2 : "")+
                '<div data-myscore="'+(e.myrating != null ? e.myrating/2 : -1)+
                '" class="memerating" data-score="'+(e.rating/2)+'"></div></div>';
            } else if (e.vitsi != null) {
                /*v = $('#vitsit li[data-rowid='+e.vitsi+']').first();
                teksti = v.contents().filter(function(){ 
                      return this.nodeType == 3; 
                    })[0].nodeValue
               */ 
                meme = '<div style="display:inline-block;margin:10px" vitsi="'+e.vitsi+
                '"><button class="sbutton"  title="'+e.vitsi+'" value="vitsi'+e.vitsitext+'">'+
                e.vitsitext+'</button>'+(e.myrating != null ? e.myrating/2 : "")+
                '<div data-myscore="'+(e.myrating != null ? e.myrating/2 : -1)+
                '" class="vitsi_memerating" data-score="'+(e.rating/2)+'"></div></div>';
                
            }
            newmemes += meme;
        })
        $('#memet').html(newmemes);

        $('.vitsi_memerating').raty({numberMax:10,
                    score:function() {return parseFloat($(this).attr('data-score'))},
                    path:'images/raty',
                    cancel: true,
                    click: vitstirating_handler
        });

        $('.memerating').raty({numberMax:10,
                    score:function() {return parseFloat($(this).attr('data-score'))},
                    path:'images/raty',
                    cancel: true,
                    click: memerate_handler
                    });
   /* } else {
        memearray = $('#memet > div')
        memearray.each(function(i) {
            e = $(this);
            meme = payload_memes[i]
            if (meme.vitsi != null) {
                if (meme.vitsi != e.attr('vitsi')) {
                    if (meme.vitsi != e.next().attr('vitsi')) {
                    v = $('#vitsit li[data-rowid='+meme.vitsi+']').first();
                    teksti = v.contents().filter(function(){
                          return this.nodeType == 3; 
                        })[0].nodeValue
                    e.before('<div style="display:inline-block;margin:10px" vitsi="'+meme.vitsi+
                    '"><button class="sbutton" title="'+meme.vitsi+'" value="vitsi'+teksti+'">'+
                    teksti+'</button>'+(meme.myrating != null ? meme.myrating/2 : "")+
                    '<div data-myscore="'+(meme.myrating != null ? meme.myrating/2 : -1)+
                    '" class="vitsi_memerating" data-score="'+(meme.rating/2)+'"></div></div>');
                    } else {
                        e.remove();
                    }
                }
            } else if (meme.rec != null) {
                if (meme.rec != e.attr('rec')) {
                    if (meme.rec != e.next().attr('rec')) {
                    b = $('.recording[title='+meme.rec+']').first();
                    e.before( '<div style="display:inline-block;margin:10px" rec="'+meme.rec+
                    '"><button class="sbutton" title="'+meme.rec+'" value="'+b.val()+'">'+
                    b.html()+'</button>'+(meme.myrating != null ? meme.myrating/2 : "")+
                    '<div data-myscore="'+(meme.myrating != null ? meme.myrating/2 : -1)+
                    '" class="memerating" data-score="'+(meme.rating/2)+'"></div></div>');
                    } else {
                        e.remove();
                    }
                }
            }
        })
    }*/
}
