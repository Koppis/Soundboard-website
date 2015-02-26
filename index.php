<!DOCTYPE html>
<?php
#include "shoutstream.php";
?>

<html>                                                                                   
<head>
    <meta charset="UTF-8">
    <link id="dynamic-favicon" rel="shortcut icon" href="/kappa.png?v=1" />

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/themes/smoothness/jquery-ui.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

	<link rel="stylesheet" media="(max-device-width: 800px)" type="text/css" href="css/index_mobile.css?1">
	<link rel="stylesheet" media="(min-device-width: 800px)" type="text/css" href="css/index.css?4">

    <link rel="stylesheet" href="css/jquery.raty.css">
    <script src="scripts/lib/jquery.raty.js"></script>

    <script src="scripts/lib/jquery.cookie.js"></script>

    <script src="scripts/lib/jscolor.js"></script>



</head>

<body style="margin: 0px; padding: 0px; display:none;">

    <table id="pagelayout" style="height: 100%;width: 100%;" 
	cellpadding="3" cellspacing="0" border="0">
		<!--<tr>
			<td colspan="2" style="height: 100px;" bgcolor="#FAFAFA" >
				<h1>Eeron eeppinen nettisivudf</h1>
			</td>
		</tr>-->
		<tr>
            <td style="word-break:break-word;" rowspan="1" valign="top" bgcolor="#FAFAFA">
				<button class="stop">Stop music</button>
				<button class="stop_youtube">Stop youtube</button>
                <a href="game/index.html">Peli</a><br>
                <input id="play_through_web" type="checkbox">Music through website</input>
				<p><input type="text" style="word-break: normal;width:10em" class="textarea youtube"
						alt="Youtube-linkki" value="Youtube-linkki">
                        <button class="youtube_submit">Submit</button>
				

					<br>
					<div id="processes"></div> 

					<div id="tjt"></div>
                    <button style="padding:2px;min-width:20px;" id="enlargeyoutube">++</button>
                    <button style="padding:2px;min-width:20px;" id="hideyoutube">-</button>
                    <!--<div id="youtube"></div>-->
                    <br />
                    <div id="teamspeak"></div> 

			</td>
			<td colspan="1" width="80%" valign="top">
				<div id="tabs">
					<ul>
						<li><a href="#frag-1">Chat</a></li>
						<li><a href="#frag-2">Soundboard</a></li>
						<li><a href="#frag-3">Recordings</a></li>
						<li><a href="#frag-4">Vitsit</a></li>
						<li><a href="#frag-5">Emoticons</a></li>
						<li><a href="#frag-6">todo</a></li>
						<li><a href="#frag-7">Teamspeak</a></li>
						<li><a href="#frag-8">Stream</a></li>
						<li><a href="#frag-9">Memet</a></li>

					</ul>
                    <div id="frag-1">
                        <div id="chatstuff">
						<input type="text" style="width:10em" class="textarea" id="username" 
						alt="Username" value="Username"></input>
						<input type='text' class=
						"color {onImmediateChange:'updatecolor(this);'}" onchange="sendcolor(this)" id="usercolor" size="8" value="#FFFFFF"
						></input>
						<input type="text" size="33" class="textarea" id="tts" 
						alt="Text-to-speech" value="Text-to-speech"></input>
						<button id="sendmsg">Send</button>
						<select id="kieli">
							<option value="fi">Suomi</option>
							<option value="sv">Ruotsi</option>
							<option value="en-us">Englanti US</option>
							<option value="en-uk">Englanti UK</option>
							<option value="de">Saksa</option>
							<option value="el">Kreikka</option>
							<option value="ru">Venäjä</option>
							<option value="ja">Japani</option>
							<option value="es">Espanja</option>
						</select>



			            
                        <p><div id="users">Paikalla: <span>mie</span>, <span>sie</span></div>
						<button style="padding:2px;min-width:40px;display:none;" id="hideemos">+</button>
						<div id="emoticons"></div>
						<div id="shoutbox">
							<table><colgroup>
								<col width="20px">
								<col width="25px">
								<col width="100px"></colgroup>
							<thead><tr><td>Date</td><td>User</td><td>Message</td></tr></thead>
							<tbody></tbody>
							</table>
						</div>
						<br><button id="moreshouts">More</button>
                        </div>
					</div>
					
					<div id="frag-2">
						<input type="text" style="width:20em" class="textarea youtube"
						alt="Youtube-linkki" value="Youtube-linkki">
						<div id="napit">
						<div class="not_online" style="display:none"><span style="
							top: 20px;
							position: relative;
						">Jukebox ei ole käynnissä Eeron koneella :(</span><p></p></div>
<div id="sounds_rowcount" value="285"></div>
			<br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="Music">Music<br>
			<button class="sbutton" value="sounds\Music\Alcohol is Free.mp3">Alcohol is Free</button>
			<button class="sbutton" value="sounds\Music\Assburger.mp3">Assburger</button>
			<button class="sbutton" value="sounds\Music\Banelings.mp3">Banelings</button>
			<button class="sbutton" value="sounds\Music\boink bonk.mp3">boink bonk</button>
			<button class="sbutton" value="sounds\Music\Game Of Thrones.mp3">Game Of Thrones</button>
			<button class="sbutton" value="sounds\Music\Green Pastures.mp3">Green Pastures</button>
			<button class="sbutton" value="sounds\Music\Heart_Of_Courage.mp3">Heart_Of_Courage</button>
			<button class="sbutton" value="sounds\Music\I should go.mp3">I should go</button>
            <button class="sbutton" value="sounds\Music\Lassistorm.wav">Lassistorm</button>
			<button class="sbutton" value="sounds\Music\Matias - #Dissaa.mp3">Matias - #Dissaa</button>
			<button class="sbutton" value="sounds\Music\mememon.mp3">Mememon</button>
			<button class="sbutton" value="sounds\Music\Mmph the Way You Mmph.mp3">Mmph the Way You Mmph</button>
			<button class="sbutton" value="sounds\Music\Moskau.mp3">Moskau</button>
			<button class="sbutton" value="sounds\Music\memeja.mp3">Memejä</button>
			<button class="sbutton" value="sounds\Music\My Heart Will Go On.mp3">My Heart Will Go On</button>
			<button class="sbutton" value="sounds\Music\My_Horse_is_Amazing.mp3">My_Horse_is_Amazing</button>
			<button class="sbutton" value="sounds\Music\Oh my dauym.mp3">Oh my dauym</button>
			<button class="sbutton" value="sounds\Music\Painis Island.mp3">Painis Island</button>
			<button class="sbutton" value="sounds\Music\Rick Roll.mp3">Rick Roll</button>
			<button class="sbutton" value="sounds\Music\Robin - Frontside Ollie.mp3">Robin - Frontside Ollie</button>
			<button class="sbutton" value="sounds\Music\SAMPOSTA SAA RAHAAlol.mp3">SAMPOSTA SAA RAHAAlol</button>
			<button class="sbutton" value="sounds\Music\Scientist Salarian.mp3">Scientist Salarian</button>
			<button class="sbutton" value="sounds\Music\Show Me Your Genitals.mp3">Show Me Your Genitals</button>
			<button class="sbutton" value="sounds\Music\Sparta.mp3">Sparta</button>
			<button class="sbutton" value="sounds\Music\Super Ponybeat Cupcakes.mp3">Super Ponybeat Cupcakes</button>
			<button class="sbutton" value="sounds\Music\Taakse jää.mp3">Taakse jää</button>
			<button class="sbutton" value="sounds\Music\Taakse eero.mp3">Taakse eero</button>
			<button class="sbutton" value="sounds\Music\The Blanks-Guy Love.mp3">The Blanks-Guy Love</button>
			<button class="sbutton" value="sounds\Music\Trololo... .mp3">Trololo... </button>
			<button class="sbutton" value="sounds\Music\Vitun ruma neekeri.mp3">Vitun ruma neekeri</button>
			<button class="sbutton" value="sounds\Music\What_Is_Love.mp3">What_Is_Love</button>
			<button class="sbutton" value="sounds\Music\asdasdasdasd.mp3">asdasdasdasd</button>
			<button class="sbutton" value="sounds\Music\dududududududu.mp3">dududududududu</button>
			<button class="sbutton" value="sounds\Music\funfunfunfun.mp3">funfunfunfun</button>
			<button class="sbutton" value="sounds\Music\missionEarth.mp3">missionEarth</button>
			<button class="sbutton" value="sounds\Music\spazzmaticapolka.mp3">spazzmaticapolka</button>
			<button class="sbutton" value="sounds\Music\sunshine.mp3">sunshine</button>
			<button class="sbutton" value="sounds\Music\tf2_who_touched_my_gun.mp3">tf2_who_touched_my_gun</button>
			<button class="sbutton" value="sounds\Music\theme of sanic hegehog.mp3">theme of sanic hegehog</button>
			<button class="sbutton" value="sounds\Music\wonkamix.mp3">wonkamix</button>
			<button class="sbutton" value="sounds\Music\Scout_needdispenser01.wav">Scout_needdispenser01</button>
			<button class="sbutton" value="sounds\Music\bennyhill.wav">bennyhill</button>
			<button class="sbutton" value="sounds\Music\bennyhills.wav">bennyhills</button>
			<button class="sbutton" value="sounds\Music\epic sax.wav">epic sax</button>
			<button class="sbutton" value="sounds\Music\macgyver2.wav">macgyver2</button>
			<button class="sbutton" value="sounds\Music\racersaasdasdas.wav">racersaasdasdas</button>
			<button class="sbutton" value="sounds\Music\shinshines.wav">shinshines</button>
			<button class="sbutton" value="sounds\Music\X-Files-theme-song.mp3">X-Files-theme-song</button>
			<button class="sbutton" value="sounds\Music\Zack Hemsey  - Mind Heist.mp3">Zack Hemsey  - Mind Heist</button>
			<button class="sbutton" value="sounds\Music\Whatcha say.mp3">Whatcha say</button>
            </div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="ayes">mlg<br>
            <button class="sbutton" value="sounds/mlg/SPOOKY.mp3">SPOOKY</button>
			<button class="sbutton" value="sounds/mlg/2SAD4ME.mp3">2SAD4ME</button>
            <button class="sbutton" value="sounds/mlg/2SED4AIRHORN.mp3">2SED4AIRHORN</button>
            <button class="sbutton" value="sounds/mlg/AIRHORN SONATA.mp3">AIRHORN SONATA</button>
            <button class="sbutton" value="sounds/mlg/AIRHORN.mp3">AIRHORN</button>
            <button class="sbutton" value="sounds/mlg/AIRPORN.mp3">AIRPORN</button>
            <button class="sbutton" value="sounds/mlg/DAMN SON WHERED YOU FIND THIS.mp3">DAMN SON WHERED YOU FIND THIS</button>
            <button class="sbutton" value="sounds/mlg/DAMN SON WOW.mp3">DAMN SON WOW</button>
            <button class="sbutton" value="sounds/mlg/DEDOTADED WAM.mp3">DEDOTADED WAM</button>
            <button class="sbutton" value="sounds/mlg/Darude - Dankstorm.mp3">Darude - Dankstorm</button>
            <button class="sbutton" value="sounds/mlg/GET NOSCOPED.mp3">GET NOSCOPED</button>
            <button class="sbutton" value="sounds/mlg/HITMARKER.mp3">HITMARKER</button>
            <button class="sbutton" value="sounds/mlg/inception.mp3">Inception</button>
            <button class="sbutton" value="sounds/mlg/MOM GET THE CAMERA.mp3">MOM GET THE CAMERA</button>
            <button class="sbutton" value="sounds/mlg/NEVER DONE THAT.mp3">NEVER DONE THAT</button>
            <button class="sbutton" value="sounds/mlg/OMG TRICKSHOT CHILD.mp3">OMG TRICKSHOT CHILD</button>
            <button class="sbutton" value="sounds/mlg/OOOOOOOOHMYGOOOOD.mp3">OOOOOOOOHMYGOOOOD</button>
            <button class="sbutton" value="sounds/mlg/Oh Baby A Triple.mp3">Oh Baby A Triple</button>
            <button class="sbutton" value="sounds/mlg/SANIC.mp3">SANIC</button>
            <button class="sbutton" value="sounds/mlg/SHOTS FIRED.mp3">SHOTS FIRED</button>
            <button class="sbutton" value="sounds/mlg/SKRILLEX Scary.mp3">SKRILLEX Scary</button>
            <button class="sbutton" value="sounds/mlg/SMOKE WEEK EVERYDAY.mp3">SMOKE WEEK EVERYDAY</button>
            <button class="sbutton" value="sounds/mlg/WOMBO COMBO.mp3">WOMBO COMBO</button>
            <button class="sbutton" value="sounds/mlg/Whatcha Say.mp3">Whatcha Say</button>
            <button class="sbutton" value="sounds/mlg/intervention 420.mp3">intervention 420</button>
            <button class="sbutton" value="sounds/mlg/tactical nuke.mp3">tactical nuke</button>
            <button class="sbutton" value="sounds/mlg/wow.mp3">wow</button>
            </div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="ayes">ayes<br>
			<button class="sbutton" value="sounds\ayes\Cricket.mp3">Cricket</button>
			<button class="sbutton" value="sounds\ayes\HEY BABY2.mp3">HEY BABY2</button>
			<button class="sbutton" value="sounds\ayes\Its only a game.mp3">Its only a game</button>
			<button class="sbutton" value="sounds\ayes\en tunne kipua.mp3">en tunne kipua</button>
			<button class="sbutton" value="sounds\ayes\have a banana.mp3">have a banana</button>
			<button class="sbutton" value="sounds\ayes\laughtrack.mp3">laughtrack</button>
			<button class="sbutton" value="sounds\ayes\studio_audience_applause_sound.mp3">studio_audience_applause_sound</button>
			<button class="sbutton" value="sounds\ayes\never asked for this.mp3">never asked for this</button>
			<button class="sbutton" value="sounds\ayes\wow hehe.mp3">wow hehe</button>
			<button class="sbutton" value="sounds\ayes\Ishouldgo.wav">Ishouldgo</button>
			<button class="sbutton" value="sounds\ayes\TERMINATED.wav">TERMINATED</button>
			<button class="sbutton" value="sounds\ayes\YEEAAAAH!.wav">YEEAAAAH!</button>
			<button class="sbutton" value="sounds\ayes\YES! YES!.wav">YES! YES!</button>
			<button class="sbutton" value="sounds\ayes\birth_control.wav">birth_control</button>
			<button class="sbutton" value="sounds\ayes\blow_it_x.wav">blow_it_x</button>
			<button class="sbutton" value="sounds\ayes\fanfare.wav">fanfare</button>
			<button class="sbutton" value="sounds\ayes\fuckyeah.wav">fuckyeah</button>
			<button class="sbutton" value="sounds\ayes\kyrpa perseessa jaykistyy.wav">kyrpa perseessa jaykistyy</button>
			<button class="sbutton" value="sounds\ayes\macgyver.wav">macgyver</button>
			<button class="sbutton" value="sounds\ayes\oneandonly.wav">oneandonly</button>
			<button class="sbutton" value="sounds\ayes\sad.wav">sad</button>
			<button class="sbutton" value="sounds\ayes\yes.wav">yes</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="dukenukem">dukenukem<br>
			<button class="sbutton" value="sounds\dukenukem\Assuming control.mp3">Assuming control</button>
			<button class="sbutton" value="sounds\dukenukem\come_get_some_x.wav">come_get_some_x</button>
			<button class="sbutton" value="sounds\dukenukem\fanfares.wav">fanfares</button>
			<button class="sbutton" value="sounds\dukenukem\good.wav">good</button>
			<button class="sbutton" value="sounds\dukenukem\hurts_2bu.wav">hurts_2bu</button>
			<button class="sbutton" value="sounds\dukenukem\out_of_gum_x.wav">out_of_gum_x</button>
			<button class="sbutton" value="sounds\dukenukem\thishurtsyou.wav">thishurtsyou</button>
            <button class="sbutton" value="sounds\dukenukem\youcannotresist.wav">youcannotresist</button>
            </div>
        <br>
        <button style="padding:2px;min-width:20px;" class="hidecat">-</button>
        <div style="display:inline" class="cat" id="gaben">
            gaben
            <br>
			<button class="sbutton" value="sounds\gaben\1.mp3">1</button>
			<button class="sbutton" value="sounds\gaben\2.mp3">2</button>
			<button class="sbutton" value="sounds\gaben\3.mp3">3</button>
			<button class="sbutton" value="sounds\gaben\Worth the weight.mp3">Worth the weight</button>
			<button class="sbutton" value="sounds\gaben\after9yearsindevelopment.mp3">after9yearsindevelopment</button>
			<button class="sbutton" value="sounds\gaben\andhavefun.mp3">andhavefun</button>
			<button class="sbutton" value="sounds\gaben\cs.mp3">cs</button>
			<button class="sbutton" value="sounds\gaben\ep3.mp3">ep3</button>
			<button class="sbutton" value="sounds\gaben\errr.mp3">errr</button>
			<button class="sbutton" value="sounds\gaben\gaben.mp3">gaben</button>
			<button class="sbutton" value="sounds\gaben\hi.mp3">hi</button>
			<button class="sbutton" value="sounds\gaben\iworkatvalve.mp3">iworkatvalve</button>
			<button class="sbutton" value="sounds\gaben\letmeknowwhatyouthink.mp3">letmeknowwhatyouthink</button>
			<button class="sbutton" value="sounds\gaben\myfavoriteclassisthespy.mp3">myfavoriteclassisthespy</button>
			<button class="sbutton" value="sounds\gaben\nope.mp3">nope</button>
			<button class="sbutton" value="sounds\gaben\ourlatestinstallment.mp3">ourlatestinstallment</button>
			<button class="sbutton" value="sounds\gaben\please.mp3">please</button>
			<button class="sbutton" value="sounds\gaben\stog.mp3">stog</button>
			<button class="sbutton" value="sounds\gaben\thanks.mp3">thanks</button>
			<button class="sbutton" value="sounds\gaben\thanksforlistening.mp3">thanksforlistening</button>
			<button class="sbutton" value="sounds\gaben\thatswhatiget.mp3">thatswhatiget</button>
			<button class="sbutton" value="sounds\gaben\therewego.mp3">therewego</button>
			<button class="sbutton" value="sounds\gaben\thishasbeenanexperiment.mp3">thishasbeenanexperiment</button>
			<button class="sbutton" value="sounds\gaben\thisisntworking.mp3">thisisntworking</button>
			<button class="sbutton" value="sounds\gaben\welcometo.mp3">welcometo</button>
			<button class="sbutton" value="sounds\gaben\welcometotf2.mp3">welcometotf2</button>
			<button class="sbutton" value="sounds\gaben\whatsnottolike.mp3">whatsnottolike</button>
			<button class="sbutton" value="sounds\gaben\yes.mp3">yes</button>
			<button class="sbutton" value="sounds\gaben\yesido.mp3">yesido</button>
			<button class="sbutton" value="sounds\gaben\GABE OVER.wav">GABE OVER</button>
			<button class="sbutton" value="sounds\gaben\Im drunk.wav">Im drunk</button>
			<button class="sbutton" value="sounds\gaben\after10000yearsindevelopment.wav">after10000yearsindevelopment</button>
			<button class="sbutton" value="sounds\gaben\consumers.wav">consumers</button>
			<button class="sbutton" value="sounds\gaben\gaben.wav">gaben</button>
			<button class="sbutton" value="sounds\gaben\goodluckfiguringitout.wav">goodluckfiguringitout</button>
			<button class="sbutton" value="sounds\gaben\itsjustmegabenewell.wav">itsjustmegabenewell</button>
			<button class="sbutton" value="sounds\gaben\letsusethis.wav">letsusethis</button>
			<button class="sbutton" value="sounds\gaben\nope.wav">nope</button>
			<button class="sbutton" value="sounds\gaben\seemslikesciencefiction.wav">seemslikesciencefiction</button>
            <button class="sbutton" value="sounds\gaben\wehavelotsamoney.wav">wehavelotsamoney</button>
            </div>
        <br>
        <button style="padding:2px;min-width:20px;" class="hidecat">-</button>
        <div style="display:inline" class="cat" id="tf2">
            tf2
            <br>
			<button class="sbutton" value="sounds\tf2\SpyObese.wav">SpyObese</button>
			<button class="sbutton" value="sounds\tf2\boink.wav">boink</button>
			<button class="sbutton" value="sounds\tf2\bottleofscrumpy.wav">bottleofscrumpy</button>
			<button class="sbutton" value="sounds\tf2\bulletproof.wav">bulletproof</button>
			<button class="sbutton" value="sounds\tf2\cornishgamehen.wav">cornishgamehen</button>
			<button class="sbutton" value="sounds\tf2\dummpkaufs.wav">dummpkaufs</button>
			<button class="sbutton" value="sounds\tf2\dunpkoffeest.wav">dunpkoffeest</button>
			<button class="sbutton" value="sounds\tf2\freedoom.wav">freedoom</button>
			<button class="sbutton" value="sounds\tf2\goodtimes.wav">goodtimes</button>
			<button class="sbutton" value="sounds\tf2\gottam.wav">gottam</button>
			<button class="sbutton" value="sounds\tf2\headsbenedict.wav">headsbenedict</button>
			<button class="sbutton" value="sounds\tf2\idontrememberthis.wav">idontrememberthis</button>
			<button class="sbutton" value="sounds\tf2\imagine if i.wav">imagine if i</button>
			<button class="sbutton" value="sounds\tf2\itsjustham.wav">itsjustham</button>
			<button class="sbutton" value="sounds\tf2\kaboom.wav">kaboom</button>
			<button class="sbutton" value="sounds\tf2\layweaponsdown.wav">layweaponsdown</button>
			<button class="sbutton" value="sounds\tf2\letsdooittt.wav">letsdooittt</button>
			<button class="sbutton" value="sounds\tf2\littlecart.wav">littlecart</button>
			<button class="sbutton" value="sounds\tf2\maggotds.wav">maggotds</button>
			<button class="sbutton" value="sounds\tf2\medic_scherivenhunds.wav">medic_scherivenhunds</button>
			<button class="sbutton" value="sounds\tf2\medicmacigghosts.wav">medicmacigghosts</button>
			<button class="sbutton" value="sounds\tf2\melting.wav">melting</button>
			<button class="sbutton" value="sounds\tf2\mostdangerousman.wav">mostdangerousman</button>
			<button class="sbutton" value="sounds\tf2\neveronyourside.wav">neveronyourside</button>
			<button class="sbutton" value="sounds\tf2\nicejob.wav">nicejob</button>
			<button class="sbutton" value="sounds\tf2\nuuweponn.wav">nuuweponn</button>
			<button class="sbutton" value="sounds\tf2\oktoberfeest.wav">oktoberfeest</button>
			<button class="sbutton" value="sounds\tf2\pain is.wav">pain is</button>
			<button class="sbutton" value="sounds\tf2\pleading.wav">pleading</button>
			<button class="sbutton" value="sounds\tf2\pootis.wav">pootis</button>
			<button class="sbutton" value="sounds\tf2\saandviich.wav">saandviich</button>
			<button class="sbutton" value="sounds\tf2\sandvich and me gonna.wav">sandvich and me gonna</button>
			<button class="sbutton" value="sounds\tf2\slpasmeonthekbee.wav">slpasmeonthekbee</button>
			<button class="sbutton" value="sounds\tf2\teamisbabies.wav">teamisbabies</button>
			<button class="sbutton" value="sounds\tf2\thats the stuff.wav">thats the stuff</button>
			<button class="sbutton" value="sounds\tf2\thats what I'm talking about.wav">thats what I'm talking about</button>
			<button class="sbutton" value="sounds\tf2\waaawhaaa.wav">waaawhaaa</button>
			<button class="sbutton" value="sounds\tf2\wanananana.wav">wanananana</button>
			<button class="sbutton" value="sounds\tf2\wannaplayhuh.wav">wannaplayhuh</button>
			<button class="sbutton" value="sounds\tf2\whatareyoudoing.wav">whatareyoudoing</button>
			<button class="sbutton" value="sounds\tf2\whooo.wav">whooo</button>
			<button class="sbutton" value="sounds\tf2\wohohooo.wav">wohohooo</button>
			<button class="sbutton" value="sounds\tf2\yatyataaa.wav">yatyataaa</button>
			<button class="sbutton" value="sounds\tf2\yourmother.wav">yourmother</button>
			<button class="sbutton" value="sounds\tf2\zatwasnotMedicine.wav">zatwasnotMedicine</button>
			<button class="sbutton" value="sounds\tf2\zeubermen.wav">zeubermen</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="tohtori pavel">tohtori pavel<br>
			<button class="sbutton" value="sounds\tohtori pavel\aaaaaaaaaaaahahaha.mp3">aaaaaaaaaaaahahaha</button>
			<button class="sbutton" value="sounds\tohtori pavel\ai.mp3">ai</button>
			<button class="sbutton" value="sounds\tohtori pavel\aii.mp3">aii</button>
			<button class="sbutton" value="sounds\tohtori pavel\aikapaljonuskollisuutta.mp3">aikapaljonuskollisuutta</button>
			<button class="sbutton" value="sounds\tohtori pavel\ainakin osaat puhua.mp3">ainakin osaat puhua</button>
			<button class="sbutton" value="sounds\tohtori pavel\asdahaha.mp3">asdahaha</button>
			<button class="sbutton" value="sounds\tohtori pavel\asperger viimeinkin.mp3">asperger viimeinkin</button>
			<button class="sbutton" value="sounds\tohtori pavel\bäng.mp3">bäng</button>
			<button class="sbutton" value="sounds\tohtori pavel\chh.mp3">chh</button>
			<button class="sbutton" value="sounds\tohtori pavel\dr pavel olen cia.mp3">dr pavel olen cia</button>
			<button class="sbutton" value="sounds\tohtori pavel\dr pavel.mp3">dr pavel</button>
			<button class="sbutton" value="sounds\tohtori pavel\ehkä hän miettii.mp3">ehkä hän miettii</button>
			<button class="sbutton" value="sounds\tohtori pavel\ei ole väliä keitä.mp3">ei ole väliä keitä</button>
			<button class="sbutton" value="sounds\tohtori pavel\eimaksua.mp3">eimaksua</button>
			<button class="sbutton" value="sounds\tohtori pavel\eimaksua0.mp3">eimaksua0</button>
			<button class="sbutton" value="sounds\tohtori pavel\eimaksua2.mp3">eimaksua2</button>
			<button class="sbutton" value="sounds\tohtori pavel\eiyhdenpitää.mp3">eiyhdenpitää</button>
			<button class="sbutton" value="sounds\tohtori pavel\ensanonut.mp3">ensanonut</button>
			<button class="sbutton" value="sounds\tohtori pavel\ensimmäinenjokapuhuu.mp3">ensimmäinenjokapuhuu</button>
			<button class="sbutton" value="sounds\tohtori pavel\ensimmäinenjokapuhuu2.mp3">ensimmäinenjokapuhuu2</button>
			<button class="sbutton" value="sounds\tohtori pavel\etvoi.mp3">etvoi</button>
			<button class="sbutton" value="sounds\tohtori pavel\etvoi2.mp3">etvoi2</button>
			<button class="sbutton" value="sounds\tohtori pavel\gnhgn.mp3">gnhgn</button>
			<button class="sbutton" value="sounds\tohtori pavel\he työsk.mp3">he työsk</button>
			<button class="sbutton" value="sounds\tohtori pavel\heeivät.mp3">heeivät</button>
			<button class="sbutton" value="sounds\tohtori pavel\heyrittivät.mp3">heyrittivät</button>
			<button class="sbutton" value="sounds\tohtori pavel\hhhhh.mp3">hhhhh</button>
			<button class="sbutton" value="sounds\tohtori pavel\huoh.mp3">huoh</button>
			<button class="sbutton" value="sounds\tohtori pavel\häneilentänyt.mp3">häneilentänyt</button>
			<button class="sbutton" value="sounds\tohtori pavel\häneiollut.mp3">häneiollut</button>
			<button class="sbutton" value="sounds\tohtori pavel\ilman selviintyjiä.mp3">ilman selviintyjiä</button>
			<button class="sbutton" value="sounds\tohtori pavel\jamiksi.mp3">jamiksi</button>
			<button class="sbutton" value="sounds\tohtori pavel\jos riisun.mp3">jos riisun</button>
			<button class="sbutton" value="sounds\tohtori pavel\jos riisun2.mp3">jos riisun2</button>
			<button class="sbutton" value="sounds\tohtori pavel\kerrominulle.mp3">kerrominulle</button>
			<button class="sbutton" value="sounds\tohtori pavel\klik.mp3">klik</button>
			<button class="sbutton" value="sounds\tohtori pavel\kolikoli.mp3">kolikoli</button>
			<button class="sbutton" value="sounds\tohtori pavel\kolikoli2.mp3">kolikoli2</button>
			<button class="sbutton" value="sounds\tohtori pavel\kukaan ei välittänyt.mp3">kukaan ei välittänyt</button>
			<button class="sbutton" value="sounds\tohtori pavel\kukahaluaa.mp3">kukahaluaa</button>
			<button class="sbutton" value="sounds\tohtori pavel\kukamaksoi.mp3">kukamaksoi</button>
			<button class="sbutton" value="sounds\tohtori pavel\lentosuunnitelma.mp3">lentosuunnitelma</button>
			<button class="sbutton" value="sounds\tohtori pavel\lentosuunnitelma2.mp3">lentosuunnitelma2</button>
			<button class="sbutton" value="sounds\tohtori pavel\lentosuunnitelma3.mp3">lentosuunnitelma3</button>
			<button class="sbutton" value="sounds\tohtori pavel\mayday.mp3">mayday</button>
			<button class="sbutton" value="sounds\tohtori pavel\meidänpitisaada.mp3">meidänpitisaada</button>
			<button class="sbutton" value="sounds\tohtori pavel\meidänpitisaada2.mp3">meidänpitisaada2</button>
			<button class="sbutton" value="sounds\tohtori pavel\miksihänpitääyllään.mp3">miksihänpitääyllään</button>
			<button class="sbutton" value="sounds\tohtori pavel\nnnnnnng.mp3">nnnnnnng</button>
			<button class="sbutton" value="sounds\tohtori pavel\nnnnnpikkuisokone.mp3">nnnnnpikkuisokone</button>
			<button class="sbutton" value="sounds\tohtori pavel\nööööö.mp3">nööööö</button>
			<button class="sbutton" value="sounds\tohtori pavel\nööööö2.mp3">nööööö2</button>
			<button class="sbutton" value="sounds\tohtori pavel\olemmekosytyttäneet.mp3">olemmekosytyttäneet</button>
			<button class="sbutton" value="sounds\tohtori pavel\olemmekosytyttäneet2.mp3">olemmekosytyttäneet2</button>
			<button class="sbutton" value="sounds\tohtori pavel\olen cia.mp3">olen cia</button>
			<button class="sbutton" value="sounds\tohtori pavel\olen cia2.mp3">olen cia2</button>
			<button class="sbutton" value="sounds\tohtori pavel\olet iso.mp3">olet iso</button>
			<button class="sbutton" value="sounds\tohtori pavel\oliko kiinnijääminen.mp3">oliko kiinnijääminen</button>
			<button class="sbutton" value="sounds\tohtori pavel\onnittelutjäitte.mp3">onnittelutjäitte</button>
			<button class="sbutton" value="sounds\tohtori pavel\ottakaaheidät.mp3">ottakaaheidät</button>
			<button class="sbutton" value="sounds\tohtori pavel\ovenavaus.mp3">ovenavaus</button>
			<button class="sbutton" value="sounds\tohtori pavel\ovenavaus2.mp3">ovenavaus2</button>
			<button class="sbutton" value="sounds\tohtori pavel\pampampam.mp3">pampampam</button>
			<button class="sbutton" value="sounds\tohtori pavel\pampampam2.mp3">pampampam2</button>
			<button class="sbutton" value="sounds\tohtori pavel\pum.mp3">pum</button>
			<button class="sbutton" value="sounds\tohtori pavel\pum2.mp3">pum2</button>
			<button class="sbutton" value="sounds\tohtori pavel\rauhoitu tohtori.mp3">rauhoitu tohtori</button>
			<button class="sbutton" value="sounds\tohtori pavel\se olisi erittäin kivulista.mp3">se olisi erittäin kivulista</button>
			<button class="sbutton" value="sounds\tohtori pavel\sinulle.mp3">sinulle</button>
			<button class="sbutton" value="sounds\tohtori pavel\smäk.mp3">smäk</button>
			<button class="sbutton" value="sounds\tohtori pavel\thump.mp3">thump</button>
			<button class="sbutton" value="sounds\tohtori pavel\tietenkin.mp3">tietenkin</button>
			<button class="sbutton" value="sounds\tohtori pavel\tohtoripavelkieltä.mp3">tohtoripavelkieltä</button>
			<button class="sbutton" value="sounds\tohtori pavel\tohtoripavelkieltä2.mp3">tohtoripavelkieltä2</button>
			<button class="sbutton" value="sounds\tohtori pavel\tohtoripavelkieltä3.mp3">tohtoripavelkieltä3</button>
			<button class="sbutton" value="sounds\tohtori pavel\tulinousee.mp3">tulinousee</button>
			<button class="sbutton" value="sounds\tohtori pavel\turmiolle.mp3">turmiolle</button>
			<button class="sbutton" value="sounds\tohtori pavel\tämänkoneenpudottaminen.mp3">tämänkoneenpudottaminen</button>
			<button class="sbutton" value="sounds\tohtori pavel\vaikeinkohta.mp3">vaikeinkohta</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="LegendLeague">LegendLeague<br>
			<button class="sbutton" value="sounds\LegendLeague\Hut234.ogg">Hut234</button>
			<button class="sbutton" value="sounds\LegendLeague\I'llscoutahead.ogg">I'llscoutahead</button>
			<button class="sbutton" value="sounds\LegendLeague\NeverUnderestimate.ogg">NeverUnderestimate</button>
			<button class="sbutton" value="sounds\LegendLeague\TEEMOsizedoenstmean.ogg">TEEMOsizedoenstmean</button>
			<button class="sbutton" value="sounds\LegendLeague\Teemo.laugh1.ogg">Teemo.laugh1</button>
			<button class="sbutton" value="sounds\LegendLeague\Teemo.laugh2.ogg">Teemo.laugh2</button>
			<button class="sbutton" value="sounds\LegendLeague\Teemo.laugh3.ogg">Teemo.laugh3</button>
			<button class="sbutton" value="sounds\LegendLeague\ThatsGottaSting.ogg">ThatsGottaSting</button>
			<button class="sbutton" value="sounds\LegendLeague\armedandready.ogg">armedandready</button>
			<button class="sbutton" value="sounds\LegendLeague\reportingin!.ogg">reportingin!</button>
			<button class="sbutton" value="sounds\LegendLeague\swiftly!.ogg">swiftly!</button>
			<button class="sbutton" value="sounds\LegendLeague\yesSir!.ogg">yesSir!</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="sounds">sounds<br>
			<button class="sbutton" value="sounds\asperger viimeinkin.mp3">asperger viimeinkin</button>
			<button class="sbutton" value="sounds\badumtss.mp3">badumtss</button>
			<button class="sbutton" value="sounds\nooo.mp3">nooo</button>
			<button class="sbutton" value="sounds\nope.avi.mp3">nope.avi</button>
			<button class="sbutton" value="sounds\nope.mp3">nope</button>
			<button class="sbutton" value="sounds\texttospeech.mp3">texttospeech</button>
			<button class="sbutton" value="sounds\GlobalWarming.wav">GlobalWarming</button>
			<button class="sbutton" value="sounds\Leeroy Jenkins.wav">Leeroy Jenkins</button>
			<button class="sbutton" value="sounds\MyHeart Will Go On.wav">MyHeart Will Go On</button>
			<button class="sbutton" value="sounds\UnitGifted.wav">UnitGifted</button>
			<button class="sbutton" value="sounds\VIRUS.wav">VIRUS</button>
			<button class="sbutton" value="sounds\aeiou.wav">aeiou</button>
			<button class="sbutton" value="sounds\at least i got chicken.wav">at least i got chicken</button>
			<button class="sbutton" value="sounds\badumtshh.wav">badumtshh</button>
			<button class="sbutton" value="sounds\bitch.wav">bitch</button>
			<button class="sbutton" value="sounds\dramatic.wav">dramatic</button>
			<button class="sbutton" value="sounds\easy peasy.wav">easy peasy</button>
			<button class="sbutton" value="sounds\endless series.wav">endless series</button>
			<button class="sbutton" value="sounds\exxellent.wav">exxellent</button>
			<button class="sbutton" value="sounds\fap.wav">fap</button>
			<button class="sbutton" value="sounds\firing squad.wav">firing squad</button>
			<button class="sbutton" value="sounds\frontside.wav">frontside</button>
			<button class="sbutton" value="sounds\gayyy.wav">gayyy</button>
			<button class="sbutton" value="sounds\hah-gayyyy.wav">hah-gayyyy</button>
			<button class="sbutton" value="sounds\heyoo.wav">heyoo</button>
			<button class="sbutton" value="sounds\iPhone bitch.wav">iPhone bitch</button>
			<button class="sbutton" value="sounds\kaikkikiusaa.wav">kaikkikiusaa</button>
			<button class="sbutton" value="sounds\luxmacia.wav">luxmacia</button>
			<button class="sbutton" value="sounds\netti kiinni.wav">netti kiinni</button>
			<button class="sbutton" value="sounds\nyt saastan rahaa.wav">nyt saastan rahaa</button>
			<button class="sbutton" value="sounds\runfuckingrun.wav">runfuckingrun</button>
			<button class="sbutton" value="sounds\shepard.wav">shepard</button>
			<button class="sbutton" value="sounds\shitjust.wav">shitjust</button>
			<button class="sbutton" value="sounds\taking the hobbits to isengard.wav">taking the hobbits to isengard</button>
			<button class="sbutton" value="sounds\wrex.wav">wrex</button>
			<button class="sbutton" value="sounds\wujustyle.wav">wujustyle</button>
			<button class="sbutton" value="sounds\yousuck.wav">yousuck</button></div>
					</div>
					</div>
                    <div id="frag-3">
                    <div class="not_online" style="display:none"><span style="
							top: 20px;
							position: relative;
						">Jukebox ei ole käynnissä Eeron koneella :(</span><p></p></div>
                    <br><button id="recordbutton" class="recordbutton">Record</button>
                    <button id="newrcategory">New category</button>
                    <button id="makedraggable">Make draggable</button>
                    <br />
                    <!--<button id="deleterecording">Delete Recording</button>-->
                    <p><div id="recordings">

                    </div></P>
					</div>
					<div id="frag-4">
						<input style="width:30em" type="text" class="textarea" 
						id="addjoke" alt="Lisää vitsi" value="Lisää vitsi" />
						<button id="kerrovitsi">Kerro vitsi</button>
						<div id="vitsit">

						</div>
					</div>
					<div id="frag-5">
						<input id="addemoticon_sana" type="text" style="width:10em" class="textarea" name="sana"
						alt="Sana" value="Sana">
						<input id="addemoticon_linkki" type="text" style="width:20em" class="textarea" name="linkki"
						alt="Linkki" value="Linkki">
						<button id="addemoticon" >Add emoticon</button>
						<div id="emoticons_tab">
							
						</div>
					</div>
					
					<div id="frag-6">
						<h2>Todo</h2>
						<ul>
							<li style="text-decoration:line-through">Emoticon sivusta yhtä hyvä kun vitsit</li>
							<li style="text-decoration:line-through"><strong>Tee silleen että kaikki päivittyy vaan jos tarvii</strong> </li>
							<li style="text-decoration:line-through">Poista siirtotoiminto</li>
							<li  style="text-decoration:line-through">Semmonen juttu mistä näkee kaikki tällä hetkellä soivat äänet ja ne voi erikseen sulkea.</li>
							<li  style="text-decoration:line-through">Youtube hq</li>
							<li >hienompi todo</li>
							<li>Upload toiminto</li>
						<ul>
					</div>
                    <div id="frag-7">
                    <div id="teamspeak2"></div> 
                    </div>
                    <div id="frag-8">
                    <table><tr>
                        <td><div id="streamchat"></div></td>
                    </tr></table>
                    </div>

                    <div id="frag-9">
                        <div id="memet"></div>
                    </div>
                    
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" height="20" bgcolor="#777d6a">
				Made by Eero - version <?php echo mt_rand(); ?> 
			</td>
		</tr>
	</table>


	<script src="main.js"></script>
</body>
</html>


