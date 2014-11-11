<?php
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/article/GI_TransText.php');

$_REQUEST['mp3_filename'] = 'ts_song_conv_in';
$_REQUEST['lyrics_pdf_slpid'] = 'tsk_song_conv_ly';
$_REQUEST['lyrics_slpid'] = 'ts_song_conv_ly';

if(empty($_REQUEST['mp3_filename']) || empty($_REQUEST['lyrics_pdf_slpid']))
{
	echo "Missing Filename!";
	exit;
}
else 
{
	
	//echo $_REQUEST['mp3_filename']."----->".$_REQUEST['lyrics_pdf_slpid'];
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
		<title>Scholastic Audio Player</title>
			<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
			
			<script language="JavaScript">
				function get_audio_path(){
					return "/limelight/";
				}
			</script>
			<script language="JavaScript">
				function get_audio_name(){
					return "<?php echo $_REQUEST['mp3_filename'].".mp3";?>";
				}
			</script>
			<script type="text/javascript" src="/javascript/tr8ts1/audio_player/swfobject.js"></script>
			<script type="text/javascript">
					var flashvars = {};
					var params = {base:".", allowFullScreen:"true"};            
					var attributes = {};
					swfobject.embedSWF("/flash/audio_player/AudioPlayer.swf", "flashContent", "280", "60", "10.0.0", "swf/expressInstall.swf", flashvars, params, attributes);
			</script>
			
			
	<style>	
	#audio_player_div h1 {
	color: #000000;
	font-size: 36px;
	font-weight: bold;
	margin-left: 40px;
	padding-top: 12px;
	line-height: 110%;
	}	
	#audio_player_div p{
	text-align: left;
	margin-left: 40px;
	line-height: 100%;
	float:right;
	}
	#flashDiv{
	text-align:left;	
	}	
	#pdfContent{
	text-align:right;	
	}	
	#cboxClose {    
    display: none;   
	}
	</style>			
	</head>
	<body>
	
<div id="audio_player_div">
	<div id="flashDiv">
		<div id="flashContent">
		    <h1>Alternate content</h1>
			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
		</div>				
		<p><a href="javascript:launchPDF('<?php echo $_REQUEST['lyrics_pdf_slpid'];?>');"><img src="/images/PDF_icon.png" class="right" alt="PDF icon" width="80" height="80"></a></p>
	</div>
<?php
$type = '0tam';
$slpid = $_REQUEST['lyrics_slpid'];
$textAsset = new GI_TransText(array (NGO_PRODUCTID => $_SERVER['AUTH_PCODE'],
						CS_GTYPE => $type,
						CS_PRODUCTID => $_SERVER['AUTH_PCODE'],
						NGO_GTYPE => $type,
						GI_ASSETID => $slpid));
$theOutput = $textAsset->output();
echo $theOutput;
?>
		
		
		<a id="page" href="#" onclick="javascript:parent.$.fn.colorbox.close();">Close</a>
</div>						
	</body>
</html> 

