<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>Scholastic Video Player</title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			<script src="/javascript/tr8ts1/colorbox/jquery.min.js"></script>
			<script language="JavaScript">

				function get_preloader_path()
				{

					return "/flash/video_player/Preloader.swf";
				}

				function get_asset_title(){
					var str = "<?php echo urldecode($_REQUEST['title']); ?>";											
					return str;
				}

				function get_server_name()
				{

					return "scholastic.fcod.llnwd.net";					
				}

				function get_app_name(){					

					return "a1122/o16";
				}

				function get_video_name(){
					

					return "<?php echo $_SERVER['LIMELIGHT_APP'].$_REQUEST['filename'].".flv"; ?>";
					//return "/limelight/<?php echo $_REQUEST['filename'].".flv"; ?>";
					
					//return "xbooks/dev/10000914van.flv";
				}
			</script>

			<script type="text/javascript" src="/javascript/tr8ts1/video_player/swfobject.js"></script>
			<script type="text/javascript">
					var flashvars = {};
					var params = {base:".", allowFullScreen:"true", allowScriptAccess:"always", wmode:"transparent" };            
					var attributes = {};
					swfobject.embedSWF("/flash/video_player/VideoPlayer.swf", "flashContent", "788", "608", "10.0.0", "swf/expressInstall.swf", flashvars, params, attributes);
			</script>
	<style>	
	#cboxLoadedContent {
	    background: none;
	}
		
	body
	{
		background-color:transparent;
		border: 0px solid red;
		text-align: center;
		padding-top: 36px;
		margin: auto;
	}	
	</style>
	</head>

	<body>

<?php

//echo $_SERVER['LIMELIGHT_APP'].$_REQUEST['filename'];

if(empty($_REQUEST['filename']) || empty($_REQUEST['title']))
{
	echo "Sorry! An Internal Error has occured!";	
	exit;	
}
?>	
		<div id="flashContent">
	    <h1>Alternate content</h1>
			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="" alt="Get Adobe Flash player" /></a></p>
		</div>
	</body>
</html> 