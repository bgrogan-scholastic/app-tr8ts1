<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>Scholastic Audio Player</title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<script language="JavaScript">
				function get_audio_path(){
					return "http://scholastic.vo.llnwd.net/o16/tr8ts1/dev/";
				}
			</script>
			<script language="JavaScript">
				function get_audio_name(){
					return "ts_song_conv_in.mp3";
				}
			</script>
			<script type="text/javascript" src="/javascript/tr8ts1/audio_player/swfobject.js"></script>
			<script type="text/javascript">
					var flashvars = {};
					var params = {base:".", allowFullScreen:"true"};            
					var attributes = {};
					swfobject.embedSWF("/flash/audio_player/AudioPlayer.swf", "flashContent", "280", "60", "10.0.0", "swf/expressInstall.swf", flashvars, params, attributes);
			</script>
	</head>
	<body>
		<div id="flashContent">
	    <h1>Alternate content</h1>
			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="" alt="Get Adobe Flash player" /></a></p>
		</div>
	</body>
</html> 

