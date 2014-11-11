<!DOCTYPE html>
<html lang="en">
	<head>
	<meta charset=utf-8 />
	<title>ColorBox Examples</title>
	<style type="text/css">
		body{font:12px/1.2 Verdana, sans-serif; padding:0 10px;}
		a:link, a:visited{text-decoration:none; color:#416CE5; border-bottom:1px solid #416CE5;}
		h2{font-size:13px; margin:15px 0 0 0;}
	</style>
	<link media="screen" rel="stylesheet" href="/css/colorbox.css" />
	<script src="/javascript/tr8ts1/colorbox/jquery.min.js"></script>
	<script src="/javascript/tr8ts1/colorbox/jquery.colorbox.js"></script>
	<script>
		$(document).ready(function(){
			//Examples of how to assign the ColorBox event to elements
			$(".example8").colorbox({width:"50%", inline:true, href:"#inline_example1"});
			$(".example9").colorbox({
				width:"80%", height:"80%"
				//onOpen:function(){ alert('onOpen: colorbox is about to open'); },
				//onLoad:function(){ alert('onLoad: colorbox has started to load the targeted content'); },
				//onComplete:function(){ alert('onComplete: colorbox has displayed the loaded content'); },
				//onCleanup:function(){ alert('onCleanup: colorbox has begun the close process'); },
				//onClosed:function(){ alert('onClosed: colorbox has completely closed'); }
			});			
			
		});
	</script>
</head>
<body>
	<p><a class='example8' href="#">Inline HTML</a></p>	
	<!-- This contains the hidden content for inline calls -->
	<div style='display:none'>
		<div id='inline_example1' style='padding:10px; background:#fff;'>
		<?php 
			$_REQUEST['mp3_filename'] = 'ts_song_conv_in.mp3';
			include($_SERVER['TEMPLATE_HOME']."/audioplayer_test/audio_test.php" );
		?>
		</div>
	</div>
	
		<h2>Demonstration of using callbacks</h2>
		<p><a class='example9' href="/folder/popup_audio.php?mp3_filename=ts_song_conv_in">Example with alerts1</a>. Callbacks and event-hooks allow users to extend functionality without having to rewrite parts of the plugin.</p>
		<p><a class='example9' href="/templates/audioplayer_test/test.php">IE.</a></p>
</body>
</html>