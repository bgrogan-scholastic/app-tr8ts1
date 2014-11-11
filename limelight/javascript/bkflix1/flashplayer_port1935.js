
<script type="text/javascript">
<!--
function AlertNow(p){
 alert("called   "+p)
 }
function openFull()
	{
	
	var fs = window.open( "<?php echo ($_SERVER['MOVIE_PLAYER_HOME']); ?>/index2.htm" , "FullScreenVideo", "toolbar=no,width=" + 800  + ",height=" + 620  + ",status=no,resizable=yes,fullscreen=yes,scrollbars=no");
	 fs.focus();
	}
	function videoSize(p_w, p_h) {
		if(document.all && !document.getElementById) {
			document.all['videoDiv'].style.pixelWidth = p_w;
			document.all['videoDiv'].style.pixelHeight = p_h;
		} else {
			document.getElementById('videoDiv').style.width = p_w;
			document.getElementById('videoDiv').style.height = p_h;
		}
	}

	function appendParameter(p_args, p_name, p_value) {
		if (p_args == "")
			return p_name+"="+escape(p_value);
		else
			return p_args+"&"+p_name+"="+escape(p_value);
	}

	var isInternetExplorer = navigator.appName.indexOf("Microsoft") != -1;
	// Handle all the FSCommand messages in a Flash movie.
	function FLVPlayer_DoFSCommand(command, args) {
		var FLVPlayerObj = isInternetExplorer ? document.all.FLVPlayer : document.FLVPlayer;
		//
		// Place your code here.
		//
		switch (command) {
			case "videoSize":
				var a = args.split(",");
				videoSize(a[0], a[1]);
				window.document.myForm.myText.value = window.document.myForm.myText.value + "\nvideoSize("+a[0]+","+a[1]+")";
				break;
			case "done":
				window.document.myForm.myText.value = window.document.myForm.myText.value + "\nDone Playing";
				break;
			case "log":
				window.document.myForm.myText.value = window.document.myForm.myText.value + "\n" + args;
				break;
			//Add custom events here
			default:
				window.document.myForm.myText.value = window.document.myForm.myText.value + "\n" + command+"("+args+")";
		}

	}
	// Hook for Internet Explorer.
	if (navigator.appName && navigator.appName.indexOf("Microsoft") != -1 && navigator.userAgent.indexOf("Windows") != -1 && navigator.userAgent.indexOf("Windows 3.1") == -1) {
		document.write('<script language=\"VBScript\"\>\n');
		document.write('On Error Resume Next\n');
		document.write('Sub FLVPlayer_FSCommand(ByVal command, ByVal args)\n');
		document.write('	Call FLVPlayer_DoFSCommand(command, args)\n');
		document.write('End Sub\n');
		document.write('</script\>\n');
	}

	var args = "";

	args = appendParameter(args, "configFile", "<?php echo ($_SERVER['MOVIE_PLAYER_HOME']); ?>/getmovie.php'?id=v000sve&streamenv=dev");
	args = appendParameter(args, "autoPlay", "false");
	args = appendParameter(args, "skinName", "<?php echo ($_SERVER['MOVIE_PLAYER_HOME']); ?>/haloSkin_3");

	document.write('<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="400" height="300" id="FLVPlayer" align="" /> ');
	document.write('<param name="movie" value="<?php echo ($_SERVER['MOVIE_PLAYER_HOME']); ?>/FLVPlayer.swf?'+args+'" /> ');
	document.write('<param name="salign" value="lt" /> ');
	document.write('<param name="quality" value="high" /> ');
	document.write('<param name="scale" value="noscale" /> ');
	document.write('<param name="bgcolor" value="#ffffff" /> ');
	document.write('<embed src="<?php echo ($_SERVER['MOVIE_PLAYER_HOME']); ?>/FLVPlayer.swf?'+args+'" quality="high" scale="noscale" bgcolor="#ffffff"  width="400" height="300" name="FLVPlayer" salign="LT" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /> ');
	document.write('</object>');
//-->
</script>


