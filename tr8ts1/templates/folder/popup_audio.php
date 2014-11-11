<?php
require_once($_SERVER['INCLUDE_HOME'].'/js_include.php');
require_once($_SERVER['PHP_INCLUDE_HOME'] . 'common/article/GI_TransText.php');

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

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link href="/css/popup_audio.css" rel="stylesheet" type="text/css" />
	<!--[if IE 7]>
		<link href="/css/popup_audio_ie7.css" rel="stylesheet" type="text/css" />
	<![endif]-->
		
		<title>Scholastic Audio Player</title>
			
			
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

	</style>			
	</head>
	<body>
	
<div id="audio_player_div">
	<div id="flashDiv">
		<div id="flashContent">
		    <h1>Alternate content</h1>
			<p><a href="http://www.adobe.com/go/getflashplayer"><img src="" alt="Get Adobe Flash player" /></a></p>
		</div>
		<?php
			//$formatedPdfFileName = addslashes($_REQUEST['lyrics_pdf_title']);
			$formatedPdfFileName = base64_encode($_REQUEST['lyrics_pdf_title']);
			//print $formatedPdfFileName;
		?>	
		<p class="pdfButton"><a href="javascript:launchPDF('<?php echo $_REQUEST['lyrics_pdf_slpid'];?>','<?php echo $formatedPdfFileName;?>','download');"><img src="/images/PDF_icon.png" class="right" alt="PDF icon" width="80" height="80" BORDER=0></a></p>
<br clear="all" />	
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
</div>	
		<div class="closeButton"><a id="page" href="#" onclick="javascript:parent.$.fn.colorbox.close();">Close</a></div>
						
	</body>
</html> 

