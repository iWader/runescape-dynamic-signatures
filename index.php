<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head><title>Wader's RS Sigs</title></head>
<body>
	<script type="text/javascript"> 
		function bgPreview(bgimage) {
			var bgpreview_img = document.getElementById('bgpreview');
			bgpreview_img.src = 'loading.gif';
			bgpreview_img.src = 'backgrounds/' + bgimage + '.png';
			linkUpdate();
		}
		
		function fcPreview(fontcolour) {
			var fcpreview_img = document.getElementById('fcpreview');
			fcpreview_img.src = 'loading.gif';
			fcpreview_img.src = 'fontcolours/' + fontcolour + '.png';
			linkUpdate();
		}
	</script>
								<form name="form" action="" method="post">
									<b>1.<b> Enter your Runescape Name: <input id="username" type="text" name="username" size="12"/><br /><br /><br />
									<b>2.</b> Select a background image from the list below:<br /><br />
									<select id="background" style="right: -10%;" width="100px" name="background" size="7" onchange="javascript:bgPreview(this.value);"> 
										<option value="0" selected="selected">Default</option> 
										<option value="1">New Dawn</option> 
										<option value="2">Red Balloon</option>
										<option value="3">Mr. BlueSky</option>
										<option value="4">Asteroid Belt</option> 
										<option value="5">Red Mist</option>
										<option value="6">James Bond</option> 
										<option value="7">Earth and Moon I</option> 
										<option value="8">Pacman</option>
										<option value="9">Hulk</option>
										<option value="10">Deep Space</option> 
										<option value="11">Alienspace</option> 
										<option value="12">Mass Effect</option>
										<option value="13">The Pit</option> 
										<option value="14">Jungle</option> 
										<option value="15">Dragon's Flight</option> 
										<option value="16">Shaka</option>
										<option value="17">Radiohead</option> 
										<option value="18">Golden Forest</option> 
										<option value="19">Storm Brewing</option> 
										<option value="20">Adventurescape</option> 
										<option value="21">Desert Oasis</option> 
										<option value="22">Taverley</option> 
										<option value="23">Falador Pond</option> 
										<option value="24">Elven Forest</option> 
										<option value="25">Coral Reef</option> 
										<option value="26">Dark mage</option> 
										<option value="27">Cosmic Altar</option> 
										<option value="28">Boneyard</option> 
										<option value="29">Snowy Beacon</option> 
										<option value="30">Chaos Elemental</option>
										<option value="31">Distant Planet</option>
										<option value="32">Vortex</option>
										<option value="33">Solar Flare</option>
										<option value="34">Luminescence</option>
										<option value="35">Tornado</option> 
										<option value="36">Earth and Moon II</option>
										<option value="37">Molten Landscape</option>
										<option value="38">Heaven's Gate</option>
										<option value="39">Aurora</option>
									</select> 
									<div style="float: right;"><img id="bgpreview" src="backgrounds/0.png" width="350px" height="150px" /></div><br /><br /><br />
									<b>3.</b> Select font colour from the list below:<br /><br />
									<select id="fontcolour" style="right: -10%;" width="100px" name="fontcolour" size="7" onchange="javascript:fcPreview(this.value);">
										<option value="0" selected="selected">White</option>
										<option value="1">Black</option>
										<option value="2">Red</option>
										<option value="3">Green</option>
										<option value="4">Blue</option>
										<option value="5">Yellow</option>
										<option value="6">Cyan</option>
										<option value="7">Magenta</option>
										<option value="8">Grey</option>
									</select>
									<div style="float: right;"><img id="fcpreview" src="fontcolours/0.png" width="32px" height="32px" /></div><br /><br />
									<input type="submit" value="submit" /><br /><br />
									<?php
										if (isset($_POST['username']) && isset($_POST['fontcolour']) && isset($_POST['background'])) {
											$link = "http://www.iwader.co.uk/sigs/" . $_POST['fontcolour'] . "/" . $_POST['background'] . "/" . $_POST['username'] . ".png";
											$html = '<a href="http://www.iwader.co.uk/sigs/"><img src="' . $link . '" ></a>';
											echo 'Forum: <input id="forumcode" type="text" size="50" value="[url=http://www.iwader.co.uk/sigs/][img]' . $link . '[/img][/url]" /><br /><br />';
											echo 'Direct Link: <input id="dlcode" type="text" size="50" value="' . $link . '" /><br /><br />';
											echo '<img src="' . $link . '" />';
										}
									?>
								</form>
</body>
</html>