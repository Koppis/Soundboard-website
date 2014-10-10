<DOCTYPE html>
<html>                                                                                   
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="jquery-ui/jquery-ui.min.css">
	<link rel="stylesheet" media="(max-device-width: 800px)" type="text/css" href="index_mobile.css">
	<meta name="viewport" content="width=device-width" />
	<!--<link rel="stylesheet" media="(min-width: 800px)" type="text/css" href="index_tablet.css">-->
	<link rel="stylesheet" media="(min-device-width: 800px)" type="text/css" href="index.css">

	<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
	<script src="jquery-ui/jquery-ui.js"></script>
	<script src="jquery.cookie.js"></script>
	<script type="text/javascript" src="soundboard.js"></script>
	<script type="text/javascript" src="jscolor/jscolor.js"></script>
</head>

<body style="margin: 0px; padding: 0px; display:none;">
	
	<table id="pagelayout" style="height: 100%;" 
	cellpadding="3" cellspacing="0" border="0">
		<!--<tr>
			<td colspan="2" style="height: 100px;" bgcolor="#FAFAFA" >
				<h1>Eeron eeppinen nettisivudf</h1>
			</td>
		</tr>-->
		<tr>
			<td style="word-break:break-all;" rowspan="1" width="15%" valign="top" bgcolor="#FAFAFA">
				<p>Sidebar</p>
				<button class="stop">Stop</button>
				<p><a href="game/index.html">Peli</a></p>
				<p><div id="slider"></div></p>
				<p><input type="text" style="width:10em" class="textarea youtube"
						alt="Youtube-linkki" value="Youtube-linkki">
				

					<br>
					<div id="processes"></div>
					<div id="tjt"></div>
                    <br><button id="recordbutton" class="recordbutton">Record</button>
                    <div id="recordings"></div>
                    <br />
                    <button id="deleterecording">Delete Recording</button>
			</td>
			<td colspan="1" width="85%" valign="top">
				<div id="tabs">
					<ul>
						<li><a href="#frag-1">Chat</a></li>
						<li><a href="#frag-2">Soundboard</a></li>
						<li><a href="#frag-3">Vitsit</a></li>
						<li><a href="#frag-4">Emoticons</a></li>
						<li><a href="#frag-5">todo</a></li>
					</ul>
					<div id="frag-1">
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
							<option value="en-us">Englanti US</option>
							<option value="en-uk">Englanti UK</option>
							<option value="de">Saksa</option>
							<option value="el">Kreikka</option>
							<option value="ru">Venäjä</option>
							<option value="ja">Japani</option>
						</select>
						                                                         
				
						<p><div id="users">Paikalla: <span>mie</span>, <span>sie</span></div>
						<button style="padding:2px;min-width:40px;display:none;" id="hideemos">+</button>
						<div id="emoticons"></div>
						<div id="shoutbox">
							<table><colgroup>
								<col width="20px">
								<col width="15px">
								<col width="100px"></colgroup>
							<thead><tr><td>Date</td><td>User</td><td>Message</td></tr></thead>
							<tbody></tbody>
							</table>
						</div>
						<br><button id="moreshouts">More</button>
					</div>
					
					<div id="frag-2">
						<input type="text" style="width:20em" class="textarea youtube"
						alt="Youtube-linkki" value="Youtube-linkki">
						<div id="napit">
						<div id="not_online" style="display:none"><span style="
							top: 20px;
							position: relative;
						">Jukebox ei ole käynnissä Eeron koneella :(</span><p></p></div>
<div id="sounds_rowcount" value="285"></div>
<br><button id="recordbutton" class="recordbutton">Record</button>
<button class="sbutton recorded" id="sounds\recorded.wav" value="sounds\recorded.wav">Play recorded</button>
			<br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="Music">Music<br>
			<button class="sbutton" id="sounds\Music\Alcohol is Free.mp3" value="sounds\Music\Alcohol is Free.mp3">Alcohol is Free</button>
			<button class="sbutton" id="sounds\Music\Assburger.mp3" value="sounds\Music\Assburger.mp3">Assburger</button>
			<button class="sbutton" id="sounds\Music\Banelings.mp3" value="sounds\Music\Banelings.mp3">Banelings</button>
			<button class="sbutton" id="sounds\Music\Game Of Thrones.mp3" value="sounds\Music\Game Of Thrones.mp3">Game Of Thrones</button>
			<button class="sbutton" id="sounds\Music\Green Pastures.mp3" value="sounds\Music\Green Pastures.mp3">Green Pastures</button>
			<button class="sbutton" id="sounds\Music\Heart_Of_Courage.mp3" value="sounds\Music\Heart_Of_Courage.mp3">Heart_Of_Courage</button>
			<button class="sbutton" id="sounds\Music\I should go.mp3" value="sounds\Music\I should go.mp3">I should go</button>
			<button class="sbutton" id="sounds\Music\Matias - #Dissaa.mp3" value="sounds\Music\Matias - #Dissaa.mp3">Matias - #Dissaa</button>
			<button class="sbutton" id="sounds\Music\Mmph the Way You Mmph.mp3" value="sounds\Music\Mmph the Way You Mmph.mp3">Mmph the Way You Mmph</button>
			<button class="sbutton" id="sounds\Music\Moskau.mp3" value="sounds\Music\Moskau.mp3">Moskau</button>
			<button class="sbutton" id="sounds\Music\My Heart Will Go On.mp3" value="sounds\Music\My Heart Will Go On.mp3">My Heart Will Go On</button>
			<button class="sbutton" id="sounds\Music\My_Horse_is_Amazing.mp3" value="sounds\Music\My_Horse_is_Amazing.mp3">My_Horse_is_Amazing</button>
			<button class="sbutton" id="sounds\Music\Oh my dauym.mp3" value="sounds\Music\Oh my dauym.mp3">Oh my dauym</button>
			<button class="sbutton" id="sounds\Music\Painis Island.mp3" value="sounds\Music\Painis Island.mp3">Painis Island</button>
			<button class="sbutton" id="sounds\Music\Rick Roll.mp3" value="sounds\Music\Rick Roll.mp3">Rick Roll</button>
			<button class="sbutton" id="sounds\Music\Robin - Frontside Ollie.mp3" value="sounds\Music\Robin - Frontside Ollie.mp3">Robin - Frontside Ollie</button>
			<button class="sbutton" id="sounds\Music\SAMPOSTA SAA RAHAAlol.mp3" value="sounds\Music\SAMPOSTA SAA RAHAAlol.mp3">SAMPOSTA SAA RAHAAlol</button>
			<button class="sbutton" id="sounds\Music\Scientist Salarian.mp3" value="sounds\Music\Scientist Salarian.mp3">Scientist Salarian</button>
			<button class="sbutton" id="sounds\Music\Show Me Your Genitals.mp3" value="sounds\Music\Show Me Your Genitals.mp3">Show Me Your Genitals</button>
			<button class="sbutton" id="sounds\Music\Sparta.mp3" value="sounds\Music\Sparta.mp3">Sparta</button>
			<button class="sbutton" id="sounds\Music\Super Ponybeat Cupcakes.mp3" value="sounds\Music\Super Ponybeat Cupcakes.mp3">Super Ponybeat Cupcakes</button>
			<button class="sbutton" id="sounds\Music\Taakse jää.mp3" value="sounds\Music\Taakse jää.mp3">Taakse jää</button>
			<button class="sbutton" id="sounds\Music\The Blanks-Guy Love.mp3" value="sounds\Music\The Blanks-Guy Love.mp3">The Blanks-Guy Love</button>
			<button class="sbutton" id="sounds\Music\Trololo... .mp3" value="sounds\Music\Trololo... .mp3">Trololo... </button>
			<button class="sbutton" id="sounds\Music\Vitun ruma neekeri.mp3" value="sounds\Music\Vitun ruma neekeri.mp3">Vitun ruma neekeri</button>
			<button class="sbutton" id="sounds\Music\What_Is_Love.mp3" value="sounds\Music\What_Is_Love.mp3">What_Is_Love</button>
			<button class="sbutton" id="sounds\Music\asdasdasdasd.mp3" value="sounds\Music\asdasdasdasd.mp3">asdasdasdasd</button>
			<button class="sbutton" id="sounds\Music\dududududududu.mp3" value="sounds\Music\dududududududu.mp3">dududududududu</button>
			<button class="sbutton" id="sounds\Music\funfunfunfun.mp3" value="sounds\Music\funfunfunfun.mp3">funfunfunfun</button>
			<button class="sbutton" id="sounds\Music\missionEarth.mp3" value="sounds\Music\missionEarth.mp3">missionEarth</button>
			<button class="sbutton" id="sounds\Music\spazzmaticapolka.mp3" value="sounds\Music\spazzmaticapolka.mp3">spazzmaticapolka</button>
			<button class="sbutton" id="sounds\Music\sunshine.mp3" value="sounds\Music\sunshine.mp3">sunshine</button>
			<button class="sbutton" id="sounds\Music\tf2_who_touched_my_gun.mp3" value="sounds\Music\tf2_who_touched_my_gun.mp3">tf2_who_touched_my_gun</button>
			<button class="sbutton" id="sounds\Music\theme of sanic hegehog.mp3" value="sounds\Music\theme of sanic hegehog.mp3">theme of sanic hegehog</button>
			<button class="sbutton" id="sounds\Music\wonkamix.mp3" value="sounds\Music\wonkamix.mp3">wonkamix</button>
			<button class="sbutton" id="sounds\Music\Scout_needdispenser01.wav" value="sounds\Music\Scout_needdispenser01.wav">Scout_needdispenser01</button>
			<button class="sbutton" id="sounds\Music\bennyhill.wav" value="sounds\Music\bennyhill.wav">bennyhill</button>
			<button class="sbutton" id="sounds\Music\bennyhills.wav" value="sounds\Music\bennyhills.wav">bennyhills</button>
			<button class="sbutton" id="sounds\Music\epic sax.wav" value="sounds\Music\epic sax.wav">epic sax</button>
			<button class="sbutton" id="sounds\Music\macgyver2.wav" value="sounds\Music\macgyver2.wav">macgyver2</button>
			<button class="sbutton" id="sounds\Music\racersaasdasdas.wav" value="sounds\Music\racersaasdasdas.wav">racersaasdasdas</button>
			<button class="sbutton" id="sounds\Music\shinshines.wav" value="sounds\Music\shinshines.wav">shinshines</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="ayes">ayes<br>
			<button class="sbutton" id="sounds\ayes\Cricket.mp3" value="sounds\ayes\Cricket.mp3">Cricket</button>
			<button class="sbutton" id="sounds\ayes\HEY BABY2.mp3" value="sounds\ayes\HEY BABY2.mp3">HEY BABY2</button>
			<button class="sbutton" id="sounds\ayes\Its only a game.mp3" value="sounds\ayes\Its only a game.mp3">Its only a game</button>
			<button class="sbutton" id="sounds\ayes\en tunne kipua.mp3" value="sounds\ayes\en tunne kipua.mp3">en tunne kipua</button>
			<button class="sbutton" id="sounds\ayes\have a banana.mp3" value="sounds\ayes\have a banana.mp3">have a banana</button>
			<button class="sbutton" id="sounds\ayes\laughtrack.mp3" value="sounds\ayes\laughtrack.mp3">laughtrack</button>
			<button class="sbutton" id="sounds\ayes\studio_audience_applause_sound.mp3" value="sounds\ayes\studio_audience_applause_sound.mp3">studio_audience_applause_sound</button>
			<button class="sbutton" id="sounds\ayes\never asked for this.mp3" value="sounds\ayes\never asked for this.mp3">never asked for this</button>
			<button class="sbutton" id="sounds\ayes\wow hehe.mp3" value="sounds\ayes\wow hehe.mp3">wow hehe</button>
			<button class="sbutton" id="sounds\ayes\Ishouldgo.wav" value="sounds\ayes\Ishouldgo.wav">Ishouldgo</button>
			<button class="sbutton" id="sounds\ayes\TERMINATED.wav" value="sounds\ayes\TERMINATED.wav">TERMINATED</button>
			<button class="sbutton" id="sounds\ayes\YEEAAAAH!.wav" value="sounds\ayes\YEEAAAAH!.wav">YEEAAAAH!</button>
			<button class="sbutton" id="sounds\ayes\YES! YES!.wav" value="sounds\ayes\YES! YES!.wav">YES! YES!</button>
			<button class="sbutton" id="sounds\ayes\birth_control.wav" value="sounds\ayes\birth_control.wav">birth_control</button>
			<button class="sbutton" id="sounds\ayes\blow_it_x.wav" value="sounds\ayes\blow_it_x.wav">blow_it_x</button>
			<button class="sbutton" id="sounds\ayes\fanfare.wav" value="sounds\ayes\fanfare.wav">fanfare</button>
			<button class="sbutton" id="sounds\ayes\fuckyeah.wav" value="sounds\ayes\fuckyeah.wav">fuckyeah</button>
			<button class="sbutton" id="sounds\ayes\kyrpa perseessa jaykistyy.wav" value="sounds\ayes\kyrpa perseessa jaykistyy.wav">kyrpa perseessa jaykistyy</button>
			<button class="sbutton" id="sounds\ayes\macgyver.wav" value="sounds\ayes\macgyver.wav">macgyver</button>
			<button class="sbutton" id="sounds\ayes\oneandonly.wav" value="sounds\ayes\oneandonly.wav">oneandonly</button>
			<button class="sbutton" id="sounds\ayes\sad.wav" value="sounds\ayes\sad.wav">sad</button>
			<button class="sbutton" id="sounds\ayes\yes.wav" value="sounds\ayes\yes.wav">yes</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="dukenukem">dukenukem<br>
			<button class="sbutton" id="sounds\dukenukem\Assuming control.mp3" value="sounds\dukenukem\Assuming control.mp3">Assuming control</button>
			<button class="sbutton" id="sounds\dukenukem\come_get_some_x.wav" value="sounds\dukenukem\come_get_some_x.wav">come_get_some_x</button>
			<button class="sbutton" id="sounds\dukenukem\fanfares.wav" value="sounds\dukenukem\fanfares.wav">fanfares</button>
			<button class="sbutton" id="sounds\dukenukem\good.wav" value="sounds\dukenukem\good.wav">good</button>
			<button class="sbutton" id="sounds\dukenukem\hurts_2bu.wav" value="sounds\dukenukem\hurts_2bu.wav">hurts_2bu</button>
			<button class="sbutton" id="sounds\dukenukem\out_of_gum_x.wav" value="sounds\dukenukem\out_of_gum_x.wav">out_of_gum_x</button>
			<button class="sbutton" id="sounds\dukenukem\thishurtsyou.wav" value="sounds\dukenukem\thishurtsyou.wav">thishurtsyou</button>
			<button class="sbutton" id="sounds\dukenukem\youcannotresist.wav" value="sounds\dukenukem\youcannotresist.wav">youcannotresist</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="gaben">gaben<br>
			<button class="sbutton" id="sounds\gaben\1.mp3" value="sounds\gaben\1.mp3">1</button>
			<button class="sbutton" id="sounds\gaben\2.mp3" value="sounds\gaben\2.mp3">2</button>
			<button class="sbutton" id="sounds\gaben\3.mp3" value="sounds\gaben\3.mp3">3</button>
			<button class="sbutton" id="sounds\gaben\Worth the weight.mp3" value="sounds\gaben\Worth the weight.mp3">Worth the weight</button>
			<button class="sbutton" id="sounds\gaben\after9yearsindevelopment.mp3" value="sounds\gaben\after9yearsindevelopment.mp3">after9yearsindevelopment</button>
			<button class="sbutton" id="sounds\gaben\andhavefun.mp3" value="sounds\gaben\andhavefun.mp3">andhavefun</button>
			<button class="sbutton" id="sounds\gaben\cs.mp3" value="sounds\gaben\cs.mp3">cs</button>
			<button class="sbutton" id="sounds\gaben\ep3.mp3" value="sounds\gaben\ep3.mp3">ep3</button>
			<button class="sbutton" id="sounds\gaben\errr.mp3" value="sounds\gaben\errr.mp3">errr</button>
			<button class="sbutton" id="sounds\gaben\gaben.mp3" value="sounds\gaben\gaben.mp3">gaben</button>
			<button class="sbutton" id="sounds\gaben\hi.mp3" value="sounds\gaben\hi.mp3">hi</button>
			<button class="sbutton" id="sounds\gaben\iworkatvalve.mp3" value="sounds\gaben\iworkatvalve.mp3">iworkatvalve</button>
			<button class="sbutton" id="sounds\gaben\letmeknowwhatyouthink.mp3" value="sounds\gaben\letmeknowwhatyouthink.mp3">letmeknowwhatyouthink</button>
			<button class="sbutton" id="sounds\gaben\myfavoriteclassisthespy.mp3" value="sounds\gaben\myfavoriteclassisthespy.mp3">myfavoriteclassisthespy</button>
			<button class="sbutton" id="sounds\gaben\nope.mp3" value="sounds\gaben\nope.mp3">nope</button>
			<button class="sbutton" id="sounds\gaben\ourlatestinstallment.mp3" value="sounds\gaben\ourlatestinstallment.mp3">ourlatestinstallment</button>
			<button class="sbutton" id="sounds\gaben\please.mp3" value="sounds\gaben\please.mp3">please</button>
			<button class="sbutton" id="sounds\gaben\stog.mp3" value="sounds\gaben\stog.mp3">stog</button>
			<button class="sbutton" id="sounds\gaben\thanks.mp3" value="sounds\gaben\thanks.mp3">thanks</button>
			<button class="sbutton" id="sounds\gaben\thanksforlistening.mp3" value="sounds\gaben\thanksforlistening.mp3">thanksforlistening</button>
			<button class="sbutton" id="sounds\gaben\thatswhatiget.mp3" value="sounds\gaben\thatswhatiget.mp3">thatswhatiget</button>
			<button class="sbutton" id="sounds\gaben\therewego.mp3" value="sounds\gaben\therewego.mp3">therewego</button>
			<button class="sbutton" id="sounds\gaben\thishasbeenanexperiment.mp3" value="sounds\gaben\thishasbeenanexperiment.mp3">thishasbeenanexperiment</button>
			<button class="sbutton" id="sounds\gaben\thisisntworking.mp3" value="sounds\gaben\thisisntworking.mp3">thisisntworking</button>
			<button class="sbutton" id="sounds\gaben\welcometo.mp3" value="sounds\gaben\welcometo.mp3">welcometo</button>
			<button class="sbutton" id="sounds\gaben\welcometotf2.mp3" value="sounds\gaben\welcometotf2.mp3">welcometotf2</button>
			<button class="sbutton" id="sounds\gaben\whatsnottolike.mp3" value="sounds\gaben\whatsnottolike.mp3">whatsnottolike</button>
			<button class="sbutton" id="sounds\gaben\yes.mp3" value="sounds\gaben\yes.mp3">yes</button>
			<button class="sbutton" id="sounds\gaben\yesido.mp3" value="sounds\gaben\yesido.mp3">yesido</button>
			<button class="sbutton" id="sounds\gaben\GABE OVER.wav" value="sounds\gaben\GABE OVER.wav">GABE OVER</button>
			<button class="sbutton" id="sounds\gaben\Im drunk.wav" value="sounds\gaben\Im drunk.wav">Im drunk</button>
			<button class="sbutton" id="sounds\gaben\after10000yearsindevelopment.wav" value="sounds\gaben\after10000yearsindevelopment.wav">after10000yearsindevelopment</button>
			<button class="sbutton" id="sounds\gaben\consumers.wav" value="sounds\gaben\consumers.wav">consumers</button>
			<button class="sbutton" id="sounds\gaben\gaben.wav" value="sounds\gaben\gaben.wav">gaben</button>
			<button class="sbutton" id="sounds\gaben\goodluckfiguringitout.wav" value="sounds\gaben\goodluckfiguringitout.wav">goodluckfiguringitout</button>
			<button class="sbutton" id="sounds\gaben\itsjustmegabenewell.wav" value="sounds\gaben\itsjustmegabenewell.wav">itsjustmegabenewell</button>
			<button class="sbutton" id="sounds\gaben\letsusethis.wav" value="sounds\gaben\letsusethis.wav">letsusethis</button>
			<button class="sbutton" id="sounds\gaben\nope.wav" value="sounds\gaben\nope.wav">nope</button>
			<button class="sbutton" id="sounds\gaben\seemslikesciencefiction.wav" value="sounds\gaben\seemslikesciencefiction.wav">seemslikesciencefiction</button>
			<button class="sbutton" id="sounds\gaben\wehavelotsamoney.wav" value="sounds\gaben\wehavelotsamoney.wav">wehavelotsamoney</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="tf2">tf2<br>
			<button class="sbutton" id="sounds\tf2\boink bonk.mp3" value="sounds\tf2\boink bonk.mp3">boink bonk</button>
			<button class="sbutton" id="sounds\tf2\SpyObese.wav" value="sounds\tf2\SpyObese.wav">SpyObese</button>
			<button class="sbutton" id="sounds\tf2\boink.wav" value="sounds\tf2\boink.wav">boink</button>
			<button class="sbutton" id="sounds\tf2\bottleofscrumpy.wav" value="sounds\tf2\bottleofscrumpy.wav">bottleofscrumpy</button>
			<button class="sbutton" id="sounds\tf2\bulletproof.wav" value="sounds\tf2\bulletproof.wav">bulletproof</button>
			<button class="sbutton" id="sounds\tf2\cornishgamehen.wav" value="sounds\tf2\cornishgamehen.wav">cornishgamehen</button>
			<button class="sbutton" id="sounds\tf2\dummpkaufs.wav" value="sounds\tf2\dummpkaufs.wav">dummpkaufs</button>
			<button class="sbutton" id="sounds\tf2\dunpkoffeest.wav" value="sounds\tf2\dunpkoffeest.wav">dunpkoffeest</button>
			<button class="sbutton" id="sounds\tf2\freedoom.wav" value="sounds\tf2\freedoom.wav">freedoom</button>
			<button class="sbutton" id="sounds\tf2\goodtimes.wav" value="sounds\tf2\goodtimes.wav">goodtimes</button>
			<button class="sbutton" id="sounds\tf2\gottam.wav" value="sounds\tf2\gottam.wav">gottam</button>
			<button class="sbutton" id="sounds\tf2\headsbenedict.wav" value="sounds\tf2\headsbenedict.wav">headsbenedict</button>
			<button class="sbutton" id="sounds\tf2\idontrememberthis.wav" value="sounds\tf2\idontrememberthis.wav">idontrememberthis</button>
			<button class="sbutton" id="sounds\tf2\imagine if i.wav" value="sounds\tf2\imagine if i.wav">imagine if i</button>
			<button class="sbutton" id="sounds\tf2\itsjustham.wav" value="sounds\tf2\itsjustham.wav">itsjustham</button>
			<button class="sbutton" id="sounds\tf2\kaboom.wav" value="sounds\tf2\kaboom.wav">kaboom</button>
			<button class="sbutton" id="sounds\tf2\layweaponsdown.wav" value="sounds\tf2\layweaponsdown.wav">layweaponsdown</button>
			<button class="sbutton" id="sounds\tf2\letsdooittt.wav" value="sounds\tf2\letsdooittt.wav">letsdooittt</button>
			<button class="sbutton" id="sounds\tf2\littlecart.wav" value="sounds\tf2\littlecart.wav">littlecart</button>
			<button class="sbutton" id="sounds\tf2\maggotds.wav" value="sounds\tf2\maggotds.wav">maggotds</button>
			<button class="sbutton" id="sounds\tf2\medic_scherivenhunds.wav" value="sounds\tf2\medic_scherivenhunds.wav">medic_scherivenhunds</button>
			<button class="sbutton" id="sounds\tf2\medicmacigghosts.wav" value="sounds\tf2\medicmacigghosts.wav">medicmacigghosts</button>
			<button class="sbutton" id="sounds\tf2\melting.wav" value="sounds\tf2\melting.wav">melting</button>
			<button class="sbutton" id="sounds\tf2\mostdangerousman.wav" value="sounds\tf2\mostdangerousman.wav">mostdangerousman</button>
			<button class="sbutton" id="sounds\tf2\neveronyourside.wav" value="sounds\tf2\neveronyourside.wav">neveronyourside</button>
			<button class="sbutton" id="sounds\tf2\nicejob.wav" value="sounds\tf2\nicejob.wav">nicejob</button>
			<button class="sbutton" id="sounds\tf2\nuuweponn.wav" value="sounds\tf2\nuuweponn.wav">nuuweponn</button>
			<button class="sbutton" id="sounds\tf2\oktoberfeest.wav" value="sounds\tf2\oktoberfeest.wav">oktoberfeest</button>
			<button class="sbutton" id="sounds\tf2\pain is.wav" value="sounds\tf2\pain is.wav">pain is</button>
			<button class="sbutton" id="sounds\tf2\pleading.wav" value="sounds\tf2\pleading.wav">pleading</button>
			<button class="sbutton" id="sounds\tf2\pootis.wav" value="sounds\tf2\pootis.wav">pootis</button>
			<button class="sbutton" id="sounds\tf2\saandviich.wav" value="sounds\tf2\saandviich.wav">saandviich</button>
			<button class="sbutton" id="sounds\tf2\sandvich and me gonna.wav" value="sounds\tf2\sandvich and me gonna.wav">sandvich and me gonna</button>
			<button class="sbutton" id="sounds\tf2\slpasmeonthekbee.wav" value="sounds\tf2\slpasmeonthekbee.wav">slpasmeonthekbee</button>
			<button class="sbutton" id="sounds\tf2\teamisbabies.wav" value="sounds\tf2\teamisbabies.wav">teamisbabies</button>
			<button class="sbutton" id="sounds\tf2\thats the stuff.wav" value="sounds\tf2\thats the stuff.wav">thats the stuff</button>
			<button class="sbutton" id="sounds\tf2\thats what I'm talking about.wav" value="sounds\tf2\thats what I'm talking about.wav">thats what I'm talking about</button>
			<button class="sbutton" id="sounds\tf2\waaawhaaa.wav" value="sounds\tf2\waaawhaaa.wav">waaawhaaa</button>
			<button class="sbutton" id="sounds\tf2\wanananana.wav" value="sounds\tf2\wanananana.wav">wanananana</button>
			<button class="sbutton" id="sounds\tf2\wannaplayhuh.wav" value="sounds\tf2\wannaplayhuh.wav">wannaplayhuh</button>
			<button class="sbutton" id="sounds\tf2\whatareyoudoing.wav" value="sounds\tf2\whatareyoudoing.wav">whatareyoudoing</button>
			<button class="sbutton" id="sounds\tf2\whooo.wav" value="sounds\tf2\whooo.wav">whooo</button>
			<button class="sbutton" id="sounds\tf2\wohohooo.wav" value="sounds\tf2\wohohooo.wav">wohohooo</button>
			<button class="sbutton" id="sounds\tf2\yatyataaa.wav" value="sounds\tf2\yatyataaa.wav">yatyataaa</button>
			<button class="sbutton" id="sounds\tf2\yourmother.wav" value="sounds\tf2\yourmother.wav">yourmother</button>
			<button class="sbutton" id="sounds\tf2\zatwasnotMedicine.wav" value="sounds\tf2\zatwasnotMedicine.wav">zatwasnotMedicine</button>
			<button class="sbutton" id="sounds\tf2\zeubermen.wav" value="sounds\tf2\zeubermen.wav">zeubermen</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="tohtori pavel">tohtori pavel<br>
			<button class="sbutton" id="sounds\tohtori pavel\aaaaaaaaaaaahahaha.mp3" value="sounds\tohtori pavel\aaaaaaaaaaaahahaha.mp3">aaaaaaaaaaaahahaha</button>
			<button class="sbutton" id="sounds\tohtori pavel\ai.mp3" value="sounds\tohtori pavel\ai.mp3">ai</button>
			<button class="sbutton" id="sounds\tohtori pavel\aii.mp3" value="sounds\tohtori pavel\aii.mp3">aii</button>
			<button class="sbutton" id="sounds\tohtori pavel\aikapaljonuskollisuutta.mp3" value="sounds\tohtori pavel\aikapaljonuskollisuutta.mp3">aikapaljonuskollisuutta</button>
			<button class="sbutton" id="sounds\tohtori pavel\ainakin osaat puhua.mp3" value="sounds\tohtori pavel\ainakin osaat puhua.mp3">ainakin osaat puhua</button>
			<button class="sbutton" id="sounds\tohtori pavel\asdahaha.mp3" value="sounds\tohtori pavel\asdahaha.mp3">asdahaha</button>
			<button class="sbutton" id="sounds\tohtori pavel\asperger viimeinkin.mp3" value="sounds\tohtori pavel\asperger viimeinkin.mp3">asperger viimeinkin</button>
			<button class="sbutton" id="sounds\tohtori pavel\bäng.mp3" value="sounds\tohtori pavel\bäng.mp3">bäng</button>
			<button class="sbutton" id="sounds\tohtori pavel\chh.mp3" value="sounds\tohtori pavel\chh.mp3">chh</button>
			<button class="sbutton" id="sounds\tohtori pavel\dr pavel olen cia.mp3" value="sounds\tohtori pavel\dr pavel olen cia.mp3">dr pavel olen cia</button>
			<button class="sbutton" id="sounds\tohtori pavel\dr pavel.mp3" value="sounds\tohtori pavel\dr pavel.mp3">dr pavel</button>
			<button class="sbutton" id="sounds\tohtori pavel\ehkä hän miettii.mp3" value="sounds\tohtori pavel\ehkä hän miettii.mp3">ehkä hän miettii</button>
			<button class="sbutton" id="sounds\tohtori pavel\ei ole väliä keitä.mp3" value="sounds\tohtori pavel\ei ole väliä keitä.mp3">ei ole väliä keitä</button>
			<button class="sbutton" id="sounds\tohtori pavel\eimaksua.mp3" value="sounds\tohtori pavel\eimaksua.mp3">eimaksua</button>
			<button class="sbutton" id="sounds\tohtori pavel\eimaksua0.mp3" value="sounds\tohtori pavel\eimaksua0.mp3">eimaksua0</button>
			<button class="sbutton" id="sounds\tohtori pavel\eimaksua2.mp3" value="sounds\tohtori pavel\eimaksua2.mp3">eimaksua2</button>
			<button class="sbutton" id="sounds\tohtori pavel\eiyhdenpitää.mp3" value="sounds\tohtori pavel\eiyhdenpitää.mp3">eiyhdenpitää</button>
			<button class="sbutton" id="sounds\tohtori pavel\ensanonut.mp3" value="sounds\tohtori pavel\ensanonut.mp3">ensanonut</button>
			<button class="sbutton" id="sounds\tohtori pavel\ensimmäinenjokapuhuu.mp3" value="sounds\tohtori pavel\ensimmäinenjokapuhuu.mp3">ensimmäinenjokapuhuu</button>
			<button class="sbutton" id="sounds\tohtori pavel\ensimmäinenjokapuhuu2.mp3" value="sounds\tohtori pavel\ensimmäinenjokapuhuu2.mp3">ensimmäinenjokapuhuu2</button>
			<button class="sbutton" id="sounds\tohtori pavel\etvoi.mp3" value="sounds\tohtori pavel\etvoi.mp3">etvoi</button>
			<button class="sbutton" id="sounds\tohtori pavel\etvoi2.mp3" value="sounds\tohtori pavel\etvoi2.mp3">etvoi2</button>
			<button class="sbutton" id="sounds\tohtori pavel\gnhgn.mp3" value="sounds\tohtori pavel\gnhgn.mp3">gnhgn</button>
			<button class="sbutton" id="sounds\tohtori pavel\he työsk.mp3" value="sounds\tohtori pavel\he työsk.mp3">he työsk</button>
			<button class="sbutton" id="sounds\tohtori pavel\heeivät.mp3" value="sounds\tohtori pavel\heeivät.mp3">heeivät</button>
			<button class="sbutton" id="sounds\tohtori pavel\heyrittivät.mp3" value="sounds\tohtori pavel\heyrittivät.mp3">heyrittivät</button>
			<button class="sbutton" id="sounds\tohtori pavel\hhhhh.mp3" value="sounds\tohtori pavel\hhhhh.mp3">hhhhh</button>
			<button class="sbutton" id="sounds\tohtori pavel\huoh.mp3" value="sounds\tohtori pavel\huoh.mp3">huoh</button>
			<button class="sbutton" id="sounds\tohtori pavel\häneilentänyt.mp3" value="sounds\tohtori pavel\häneilentänyt.mp3">häneilentänyt</button>
			<button class="sbutton" id="sounds\tohtori pavel\häneiollut.mp3" value="sounds\tohtori pavel\häneiollut.mp3">häneiollut</button>
			<button class="sbutton" id="sounds\tohtori pavel\ilman selviintyjiä.mp3" value="sounds\tohtori pavel\ilman selviintyjiä.mp3">ilman selviintyjiä</button>
			<button class="sbutton" id="sounds\tohtori pavel\jamiksi.mp3" value="sounds\tohtori pavel\jamiksi.mp3">jamiksi</button>
			<button class="sbutton" id="sounds\tohtori pavel\jos riisun.mp3" value="sounds\tohtori pavel\jos riisun.mp3">jos riisun</button>
			<button class="sbutton" id="sounds\tohtori pavel\jos riisun2.mp3" value="sounds\tohtori pavel\jos riisun2.mp3">jos riisun2</button>
			<button class="sbutton" id="sounds\tohtori pavel\kerrominulle.mp3" value="sounds\tohtori pavel\kerrominulle.mp3">kerrominulle</button>
			<button class="sbutton" id="sounds\tohtori pavel\klik.mp3" value="sounds\tohtori pavel\klik.mp3">klik</button>
			<button class="sbutton" id="sounds\tohtori pavel\kolikoli.mp3" value="sounds\tohtori pavel\kolikoli.mp3">kolikoli</button>
			<button class="sbutton" id="sounds\tohtori pavel\kolikoli2.mp3" value="sounds\tohtori pavel\kolikoli2.mp3">kolikoli2</button>
			<button class="sbutton" id="sounds\tohtori pavel\kukaan ei välittänyt.mp3" value="sounds\tohtori pavel\kukaan ei välittänyt.mp3">kukaan ei välittänyt</button>
			<button class="sbutton" id="sounds\tohtori pavel\kukahaluaa.mp3" value="sounds\tohtori pavel\kukahaluaa.mp3">kukahaluaa</button>
			<button class="sbutton" id="sounds\tohtori pavel\kukamaksoi.mp3" value="sounds\tohtori pavel\kukamaksoi.mp3">kukamaksoi</button>
			<button class="sbutton" id="sounds\tohtori pavel\lentosuunnitelma.mp3" value="sounds\tohtori pavel\lentosuunnitelma.mp3">lentosuunnitelma</button>
			<button class="sbutton" id="sounds\tohtori pavel\lentosuunnitelma2.mp3" value="sounds\tohtori pavel\lentosuunnitelma2.mp3">lentosuunnitelma2</button>
			<button class="sbutton" id="sounds\tohtori pavel\lentosuunnitelma3.mp3" value="sounds\tohtori pavel\lentosuunnitelma3.mp3">lentosuunnitelma3</button>
			<button class="sbutton" id="sounds\tohtori pavel\mayday.mp3" value="sounds\tohtori pavel\mayday.mp3">mayday</button>
			<button class="sbutton" id="sounds\tohtori pavel\meidänpitisaada.mp3" value="sounds\tohtori pavel\meidänpitisaada.mp3">meidänpitisaada</button>
			<button class="sbutton" id="sounds\tohtori pavel\meidänpitisaada2.mp3" value="sounds\tohtori pavel\meidänpitisaada2.mp3">meidänpitisaada2</button>
			<button class="sbutton" id="sounds\tohtori pavel\miksihänpitääyllään.mp3" value="sounds\tohtori pavel\miksihänpitääyllään.mp3">miksihänpitääyllään</button>
			<button class="sbutton" id="sounds\tohtori pavel\nnnnnnng.mp3" value="sounds\tohtori pavel\nnnnnnng.mp3">nnnnnnng</button>
			<button class="sbutton" id="sounds\tohtori pavel\nnnnnpikkuisokone.mp3" value="sounds\tohtori pavel\nnnnnpikkuisokone.mp3">nnnnnpikkuisokone</button>
			<button class="sbutton" id="sounds\tohtori pavel\nööööö.mp3" value="sounds\tohtori pavel\nööööö.mp3">nööööö</button>
			<button class="sbutton" id="sounds\tohtori pavel\nööööö2.mp3" value="sounds\tohtori pavel\nööööö2.mp3">nööööö2</button>
			<button class="sbutton" id="sounds\tohtori pavel\olemmekosytyttäneet.mp3" value="sounds\tohtori pavel\olemmekosytyttäneet.mp3">olemmekosytyttäneet</button>
			<button class="sbutton" id="sounds\tohtori pavel\olemmekosytyttäneet2.mp3" value="sounds\tohtori pavel\olemmekosytyttäneet2.mp3">olemmekosytyttäneet2</button>
			<button class="sbutton" id="sounds\tohtori pavel\olen cia.mp3" value="sounds\tohtori pavel\olen cia.mp3">olen cia</button>
			<button class="sbutton" id="sounds\tohtori pavel\olen cia2.mp3" value="sounds\tohtori pavel\olen cia2.mp3">olen cia2</button>
			<button class="sbutton" id="sounds\tohtori pavel\olet iso.mp3" value="sounds\tohtori pavel\olet iso.mp3">olet iso</button>
			<button class="sbutton" id="sounds\tohtori pavel\oliko kiinnijääminen.mp3" value="sounds\tohtori pavel\oliko kiinnijääminen.mp3">oliko kiinnijääminen</button>
			<button class="sbutton" id="sounds\tohtori pavel\onnittelutjäitte.mp3" value="sounds\tohtori pavel\onnittelutjäitte.mp3">onnittelutjäitte</button>
			<button class="sbutton" id="sounds\tohtori pavel\ottakaaheidät.mp3" value="sounds\tohtori pavel\ottakaaheidät.mp3">ottakaaheidät</button>
			<button class="sbutton" id="sounds\tohtori pavel\ovenavaus.mp3" value="sounds\tohtori pavel\ovenavaus.mp3">ovenavaus</button>
			<button class="sbutton" id="sounds\tohtori pavel\ovenavaus2.mp3" value="sounds\tohtori pavel\ovenavaus2.mp3">ovenavaus2</button>
			<button class="sbutton" id="sounds\tohtori pavel\pampampam.mp3" value="sounds\tohtori pavel\pampampam.mp3">pampampam</button>
			<button class="sbutton" id="sounds\tohtori pavel\pampampam2.mp3" value="sounds\tohtori pavel\pampampam2.mp3">pampampam2</button>
			<button class="sbutton" id="sounds\tohtori pavel\pum.mp3" value="sounds\tohtori pavel\pum.mp3">pum</button>
			<button class="sbutton" id="sounds\tohtori pavel\pum2.mp3" value="sounds\tohtori pavel\pum2.mp3">pum2</button>
			<button class="sbutton" id="sounds\tohtori pavel\rauhoitu tohtori.mp3" value="sounds\tohtori pavel\rauhoitu tohtori.mp3">rauhoitu tohtori</button>
			<button class="sbutton" id="sounds\tohtori pavel\se olisi erittäin kivulista.mp3" value="sounds\tohtori pavel\se olisi erittäin kivulista.mp3">se olisi erittäin kivulista</button>
			<button class="sbutton" id="sounds\tohtori pavel\sinulle.mp3" value="sounds\tohtori pavel\sinulle.mp3">sinulle</button>
			<button class="sbutton" id="sounds\tohtori pavel\smäk.mp3" value="sounds\tohtori pavel\smäk.mp3">smäk</button>
			<button class="sbutton" id="sounds\tohtori pavel\thump.mp3" value="sounds\tohtori pavel\thump.mp3">thump</button>
			<button class="sbutton" id="sounds\tohtori pavel\tietenkin.mp3" value="sounds\tohtori pavel\tietenkin.mp3">tietenkin</button>
			<button class="sbutton" id="sounds\tohtori pavel\tohtoripavelkieltä.mp3" value="sounds\tohtori pavel\tohtoripavelkieltä.mp3">tohtoripavelkieltä</button>
			<button class="sbutton" id="sounds\tohtori pavel\tohtoripavelkieltä2.mp3" value="sounds\tohtori pavel\tohtoripavelkieltä2.mp3">tohtoripavelkieltä2</button>
			<button class="sbutton" id="sounds\tohtori pavel\tohtoripavelkieltä3.mp3" value="sounds\tohtori pavel\tohtoripavelkieltä3.mp3">tohtoripavelkieltä3</button>
			<button class="sbutton" id="sounds\tohtori pavel\tulinousee.mp3" value="sounds\tohtori pavel\tulinousee.mp3">tulinousee</button>
			<button class="sbutton" id="sounds\tohtori pavel\turmiolle.mp3" value="sounds\tohtori pavel\turmiolle.mp3">turmiolle</button>
			<button class="sbutton" id="sounds\tohtori pavel\tämänkoneenpudottaminen.mp3" value="sounds\tohtori pavel\tämänkoneenpudottaminen.mp3">tämänkoneenpudottaminen</button>
			<button class="sbutton" id="sounds\tohtori pavel\vaikeinkohta.mp3" value="sounds\tohtori pavel\vaikeinkohta.mp3">vaikeinkohta</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="LegendLeague">LegendLeague<br>
			<button class="sbutton" id="sounds\LegendLeague\Hut234.ogg" value="sounds\LegendLeague\Hut234.ogg">Hut234</button>
			<button class="sbutton" id="sounds\LegendLeague\I'llscoutahead.ogg" value="sounds\LegendLeague\I'llscoutahead.ogg">I'llscoutahead</button>
			<button class="sbutton" id="sounds\LegendLeague\NeverUnderestimate.ogg" value="sounds\LegendLeague\NeverUnderestimate.ogg">NeverUnderestimate</button>
			<button class="sbutton" id="sounds\LegendLeague\TEEMOsizedoenstmean.ogg" value="sounds\LegendLeague\TEEMOsizedoenstmean.ogg">TEEMOsizedoenstmean</button>
			<button class="sbutton" id="sounds\LegendLeague\Teemo.laugh1.ogg" value="sounds\LegendLeague\Teemo.laugh1.ogg">Teemo.laugh1</button>
			<button class="sbutton" id="sounds\LegendLeague\Teemo.laugh2.ogg" value="sounds\LegendLeague\Teemo.laugh2.ogg">Teemo.laugh2</button>
			<button class="sbutton" id="sounds\LegendLeague\Teemo.laugh3.ogg" value="sounds\LegendLeague\Teemo.laugh3.ogg">Teemo.laugh3</button>
			<button class="sbutton" id="sounds\LegendLeague\ThatsGottaSting.ogg" value="sounds\LegendLeague\ThatsGottaSting.ogg">ThatsGottaSting</button>
			<button class="sbutton" id="sounds\LegendLeague\armedandready.ogg" value="sounds\LegendLeague\armedandready.ogg">armedandready</button>
			<button class="sbutton" id="sounds\LegendLeague\reportingin!.ogg" value="sounds\LegendLeague\reportingin!.ogg">reportingin!</button>
			<button class="sbutton" id="sounds\LegendLeague\swiftly!.ogg" value="sounds\LegendLeague\swiftly!.ogg">swiftly!</button>
			<button class="sbutton" id="sounds\LegendLeague\yesSir!.ogg" value="sounds\LegendLeague\yesSir!.ogg">yesSir!</button></div><br><button style="padding:2px;min-width:20px;" class="hidecat">-</button><div style="display:inline" class="cat" id="sounds">sounds<br>
			<button class="sbutton" id="sounds\asperger viimeinkin.mp3" value="sounds\asperger viimeinkin.mp3">asperger viimeinkin</button>
			<button class="sbutton" id="sounds\badumtss.mp3" value="sounds\badumtss.mp3">badumtss</button>
			<button class="sbutton" id="sounds\nooo.mp3" value="sounds\nooo.mp3">nooo</button>
			<button class="sbutton" id="sounds\nope.avi.mp3" value="sounds\nope.avi.mp3">nope.avi</button>
			<button class="sbutton" id="sounds\nope.mp3" value="sounds\nope.mp3">nope</button>
			<button class="sbutton" id="sounds\texttospeech.mp3" value="sounds\texttospeech.mp3">texttospeech</button>
			<button class="sbutton" id="sounds\GlobalWarming.wav" value="sounds\GlobalWarming.wav">GlobalWarming</button>
			<button class="sbutton" id="sounds\Leeroy Jenkins.wav" value="sounds\Leeroy Jenkins.wav">Leeroy Jenkins</button>
			<button class="sbutton" id="sounds\MyHeart Will Go On.wav" value="sounds\MyHeart Will Go On.wav">MyHeart Will Go On</button>
			<button class="sbutton" id="sounds\UnitGifted.wav" value="sounds\UnitGifted.wav">UnitGifted</button>
			<button class="sbutton" id="sounds\VIRUS.wav" value="sounds\VIRUS.wav">VIRUS</button>
			<button class="sbutton" id="sounds\aeiou.wav" value="sounds\aeiou.wav">aeiou</button>
			<button class="sbutton" id="sounds\at least i got chicken.wav" value="sounds\at least i got chicken.wav">at least i got chicken</button>
			<button class="sbutton" id="sounds\badumtshh.wav" value="sounds\badumtshh.wav">badumtshh</button>
			<button class="sbutton" id="sounds\bitch.wav" value="sounds\bitch.wav">bitch</button>
			<button class="sbutton" id="sounds\dramatic.wav" value="sounds\dramatic.wav">dramatic</button>
			<button class="sbutton" id="sounds\easy peasy.wav" value="sounds\easy peasy.wav">easy peasy</button>
			<button class="sbutton" id="sounds\endless series.wav" value="sounds\endless series.wav">endless series</button>
			<button class="sbutton" id="sounds\exxellent.wav" value="sounds\exxellent.wav">exxellent</button>
			<button class="sbutton" id="sounds\fap.wav" value="sounds\fap.wav">fap</button>
			<button class="sbutton" id="sounds\firing squad.wav" value="sounds\firing squad.wav">firing squad</button>
			<button class="sbutton" id="sounds\frontside.wav" value="sounds\frontside.wav">frontside</button>
			<button class="sbutton" id="sounds\gayyy.wav" value="sounds\gayyy.wav">gayyy</button>
			<button class="sbutton" id="sounds\hah-gayyyy.wav" value="sounds\hah-gayyyy.wav">hah-gayyyy</button>
			<button class="sbutton" id="sounds\heyoo.wav" value="sounds\heyoo.wav">heyoo</button>
			<button class="sbutton" id="sounds\iPhone bitch.wav" value="sounds\iPhone bitch.wav">iPhone bitch</button>
			<button class="sbutton" id="sounds\kaikkikiusaa.wav" value="sounds\kaikkikiusaa.wav">kaikkikiusaa</button>
			<button class="sbutton" id="sounds\luxmacia.wav" value="sounds\luxmacia.wav">luxmacia</button>
			<button class="sbutton" id="sounds\netti kiinni.wav" value="sounds\netti kiinni.wav">netti kiinni</button>
			<button class="sbutton" id="sounds\nyt saastan rahaa.wav" value="sounds\nyt saastan rahaa.wav">nyt saastan rahaa</button>
			<button class="sbutton" id="sounds\runfuckingrun.wav" value="sounds\runfuckingrun.wav">runfuckingrun</button>
			<button class="sbutton" id="sounds\shepard.wav" value="sounds\shepard.wav">shepard</button>
			<button class="sbutton" id="sounds\shitjust.wav" value="sounds\shitjust.wav">shitjust</button>
			<button class="sbutton" id="sounds\taking the hobbits to isengard.wav" value="sounds\taking the hobbits to isengard.wav">taking the hobbits to isengard</button>
			<button class="sbutton" id="sounds\wrex.wav" value="sounds\wrex.wav">wrex</button>
			<button class="sbutton" id="sounds\wujustyle.wav" value="sounds\wujustyle.wav">wujustyle</button>
			<button class="sbutton" id="sounds\yousuck.wav" value="sounds\yousuck.wav">yousuck</button></div>
					</div>
					</div>
					<div id="frag-3">
						<input style="width:30em" type="text" class="textarea" 
						id="addjoke" alt="Lisää vitsi" value="Lisää vitsi" />
						<button id="kerrovitsi">Kerro vitsi</button>
						<div id="vitsit">

						</div>
					</div>
					<div id="frag-4">
						<input id="addemoticon_sana" type="text" style="width:10em" class="textarea" name="sana"
						alt="Sana" value="Sana">
						<input id="addemoticon_linkki" type="text" style="width:20em" class="textarea" name="linkki"
						alt="Linkki" value="Linkki">
						<button id="addemoticon" >Add emoticon</button>
						<div id="emoticons_tab">
							
						</div>
					</div>
					
					<div id="frag-5">
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
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2" align="center" height="20" bgcolor="#777d6a">
				Made by Eero - version <?php echo mt_rand(); ?> 
			</td>
		</tr>
	</table>



</body>
</html>


