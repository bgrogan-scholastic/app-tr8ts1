<?php
    require_once($_SERVER['PHP_INCLUDE_HOME'].'common/utils/GI_BrowserDetect.php');
?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Scholastic Online -- Browser technology check</title>
<link href="/techcheck/browser_check.css" rel="stylesheet" type="text/css">
<meta http-equiv=Content-Type content="text/html; charset=UTF-8"> 
<meta http-equiv="Content-Script-Type" Content="text/javascript">
 <style type="text/css">
 
body {
background-color: #FFFFFF;
}
 
</style>
 
<script>
    <?php echo output_js(); 
    
  
    ?>
</script>

<script src="/javascript/utils/GI_Sound.js"></script>
<script src="/javascript/graphical/popup.js"></script>
<script type="text/JavaScript">


var flashVersion = '<span style="color:red; font-weight:bolder;">Your version of Flash cannot be detected. The version may be too old to detect. Please use the link below to upgrade to the latest version of Flash. <br> <a href="http://www.macromedia.com/go/getflashplayer">http://www.macromedia.com/go/getflashplayer</a></span>';

function setFlashVersion(inVersion){


    // Check that we have an adequate version.
    var minVersion = <?php echo $_SERVER['MIN_FLASH_VERSION']; ?>;
    var pattern=/(\w+) (\d+),(\d+),(\d+),(\d+)/;
    var result = inVersion.match(pattern);

    if (result != null) {
        e = document.getElementById('flashverstring');
        if (e) {
            if (result[2] < minVersion) {
                e.innerHTML = '<span style="color:red; font-weight:bolder;">You have the incorrect version of Flash.<br> Required version: <?php echo $_SERVER['MIN_FLASH_VERSION']; ?> or higher.<br> Your version: ('+inVersion+'):<br /> Please use the link below to upgrade to the latest version of Flash.<br>(<a href="http://www.macromedia.com/go/getflashplayer">http://www.macromedia.com/go/getflashplayer</a>)</span>.';
                }
            else {
                e.innerHTML = '<span style="color:green; font-weight:bolder;">Yes, the version of Flash installed on your computer is the one required for this site.</span>';
            	
            }
        }
    }

}

function gotoFeaturePair(){
    alert("Flash script access is working.");
}

// This is the plugin detection module.
// initialize global variables
var detectableWithVB = false;
var pluginFound = false;

function detectFlash() {
    pluginFound = detectPlugin('Shockwave','Flash');
    // if not found, try to detect with VisualBasic
    if(!pluginFound && detectableWithVB) {
    	pluginFound = detectActiveXControl('ShockwaveFlash.ShockwaveFlash.1');
    }
    return pluginFound;
}

function detectQuickTime() {
    pluginFound = detectPlugin('QuickTime');
    // if not found, try to detect with VisualBasic
    if(!pluginFound && detectableWithVB) {
	pluginFound = detectQuickTimeActiveXControl();
    }
    return pluginFound;
}

function detectWindowsMedia(redirectURL, redirectIfFound) {
    pluginFound = detectPlugin('Windows Media');
    // if not found, try to detect with VisualBasic
    if(!pluginFound && detectableWithVB) {
	pluginFound = detectActiveXControl('MediaPlayer.MediaPlayer.1');
    }
    return pluginFound;
}

function detectPlugin() {
    // allow for multiple checks in a single pass
    var daPlugins = detectPlugin.arguments;
    // consider pluginFound to be false until proven true
    var pluginFound = false;
    // if plugins array is there and not fake
    if (navigator.plugins && navigator.plugins.length > 0) {
	var pluginsArrayLength = navigator.plugins.length;
	// for each plugin...
	for (pluginsArrayCounter=0; pluginsArrayCounter < pluginsArrayLength; pluginsArrayCounter++ ) {
	    // loop through all desired names and check each against the current plugin name
	    var numFound = 0;
	    for(namesCounter=0; namesCounter < daPlugins.length; namesCounter++) {
		// if desired plugin name is found in either plugin name or description
		if( (navigator.plugins[pluginsArrayCounter].name.indexOf(daPlugins[namesCounter]) >= 0) || 
		    (navigator.plugins[pluginsArrayCounter].description.indexOf(daPlugins[namesCounter]) >= 0) ) {
		    // this name was found
		    numFound++;
		}   
	    }
	    // now that we have checked all the required names against this one plugin,
	    // if the number we found matches the total number provided then we were successful
	    if(numFound == daPlugins.length) {
		pluginFound = true;
		// if we've found the plugin, we can stop looking through at the rest of the plugins
		break;
	    }
	}
    }
    return pluginFound;
} // detectPlugin


function getPluginDescription(){
    var daPlugins = getPluginDescription.arguments;
    var outDescription = 'Unable to retrieve plugin description.';

    if (navigator.plugins && navigator.plugins.length > 0) {

    	var pluginsArrayLength = navigator.plugins.length;

    	// for each plugin...
	    for (pluginsArrayCounter=0; pluginsArrayCounter < pluginsArrayLength; pluginsArrayCounter++ ) {
    	    // loop through all desired names and check each against the current plugin name
	        var numFound = 0;
	        for(namesCounter=0; namesCounter < daPlugins.length; namesCounter++) {
        		// if desired plugin name is found in either plugin name or description
	        	if( (navigator.plugins[pluginsArrayCounter].name.indexOf(daPlugins[namesCounter]) >= 0) || 
		            (navigator.plugins[pluginsArrayCounter].description.indexOf(daPlugins[namesCounter]) >= 0) ) {
		            // this name was found
    		        numFound++;
    	    	}   
	        }

	        // now that we have checked all the required names against this one plugin,
	        // if the number we found matches the total number provided then we were successful
    	    if(numFound == daPlugins.length) {
    		    outDescription = navigator.plugins[pluginsArrayCounter].description;
	        	// if we've found the plugin, we can stop looking through at the rest of the plugins
    	    	break;
    	    }
	    }
	}
  
    return outDescription;
}

function getPluginName(){
    var daPlugins = getPluginName.arguments;
    var outName = 'Unable to retrieve plugin name.';

    if (navigator.plugins && navigator.plugins.length > 0) {

    	var pluginsArrayLength = navigator.plugins.length;

    	// for each plugin...
	    for (pluginsArrayCounter=0; pluginsArrayCounter < pluginsArrayLength; pluginsArrayCounter++ ) {
    	    // loop through all desired names and check each against the current plugin name
	        var numFound = 0;
	        for(namesCounter=0; namesCounter < daPlugins.length; namesCounter++) {
        		// if desired plugin name is found in either plugin name or description
	        	if( (navigator.plugins[pluginsArrayCounter].name.indexOf(daPlugins[namesCounter]) >= 0) || 
		            (navigator.plugins[pluginsArrayCounter].description.indexOf(daPlugins[namesCounter]) >= 0) ) {
		            // this name was found
    		        numFound++;
    	    	}   
	        }

	        // now that we have checked all the required names against this one plugin,
	        // if the number we found matches the total number provided then we were successful
    	    if(numFound == daPlugins.length) {
    		    outName = navigator.plugins[pluginsArrayCounter].name;
	        	// if we've found the plugin, we can stop looking through at the rest of the plugins
    	    	break;
    	    }
	    }
	}
  
    return outName;
}

function setJS(){
	jsElement = document.getElementById("jsdiv");
	jsElement.innerHTML = 'Yes, you have JavaScript enabled.';
	jsElement.style.color='green';	
}//end function

var mp3testsound = new GI_Sound('mp3testsound', '/techcheck/smallcheer.mp3');
</script>

</head>

<body class="bg6">

<?php if($is_ie): ?>

<script language="VBscript">

'do a one-time test for a version of VBScript that can handle this code
detectableWithVB = False
If ScriptEngineMajorVersion >= 2 then
  detectableWithVB = True
End If

'this next function will detect most plugins
Function detectActiveXControl(activeXControlName)
  on error resume next
  detectActiveXControl = False
  If detectableWithVB Then
     detectActiveXControl = IsObject(CreateObject(activeXControlName))
  End If
End Function

'and the following function handles QuickTime
Function detectQuickTimeActiveXControl()
  on error resume next
  detectQuickTimeActiveXControl = False
  If detectableWithVB Then
    detectQuickTimeActiveXControl = False
    hasQuickTimeChecker = false
    Set hasQuickTimeChecker = CreateObject("QuickTimeCheckObject.QuickTimeCheck.1")
    If IsObject(hasQuickTimeChecker) Then
      If hasQuickTimeChecker.IsQuickTimeAvailable(0) Then 
        detectQuickTimeActiveXControl = True
      End If
    End If
  End If
End Function

</script>

<?php endif; ?>


<table class="borderless" cellpadding="0" cellspacing="0" width="300">
<div style="width:575px;">

	<!-- FLASH VERSION CHECK -->

	<tr>
		<td colspan="2"><img src="images/spacer.gif" width="1" height="5" /></td>
	</tr>
	<tr>
		<td colspan="2"><b>1. Do you have the correct version of Flash?</b></td>
	</tr>
	<tr>
		<td class="text21" colspan="2">
		
		<script>
			//if the user has flash ...
		    if (detectFlash()) {
                document.writeln("<span id=\"flashverstring\">" + flashVersion + "</span><br \>\n");
            //if he doesnt
		    }else{
            	document.writeln("<span id=\"flashverstring\"><span style=\"color:red; font-weight:bolder;\">You do not have Flash installed.  Please use the link below to install the latest version of Flash.<br><a href=\"http://www.macromedia.com/go/getflashplayer\">http://www.macromedia.com/go/getflashplayer</a></span></span><br \>\n");
            }//end if
            document.write(mp3testsound.getHTML());
        </script>
		
        </td>
    </tr>

	

	<tr>
		<td colspan="2"><img src="images/spacer.gif" width="1" height="5" /></td>
	</tr>
	<tr valign="top">
		<td align="left" colspan="2">
			<table class="borderless" cellpadding="0" cellspacing="0">

				<tr>
					<td colspan="2"><img src="images/spacer.gif" width="1" height="5" /></td>
				</tr>
				<tr>
					<td colspan="2"><b>2.  Can you hear the audio on our site?</b></td>
				</tr>
				<tr>
					<td class="text21" align="center"><a href="javascript:mp3testsound.play()"><img src="/images/btn_listen2_off.gif" alt="Play test sound" name="Play test sound" border="0" height="40" width="42"></a></td>
					<td class="text21">&nbsp;Click on this icon to determine if your browser can play an MP3 file.</td>
				</tr>
				<tr>
					<td colspan="2" class="text21">If you cannot hear the audio, try the following:<br>
					<ul>
					<li>Make sure your speakers\headset are properly plugged in.</li>
					<li>Make sure your volume is turned up to an audible level.</li>	
					<li>See #1 to make sure Flash is enabled.</li>				
					</ul>
					</td>
				</tr>


			</table>
		</td>
	</tr>

<tr valign="top">
		<td align="left" colspan="2">
			<table class="borderless" cellpadding="0" cellspacing="0">

				<tr>
					<td colspan="2"><b>3. Can you see the image displayed below?</b></td>
				</tr>
				<tr>
					<td colspan="2" class="text21" align="left"><div style="width:240px; height:66; border: 1px solid black;">
<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" height="66" width="240">
<param name="movie" value="/techcheck/streaming_check_flash.swf">
<param name="quality" value="high">
<embed src="/techcheck/streaming_check_flash.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" height="66" width="240">
</object>
	<?php 				


/*
old code to streamn from limelight server for now iam gonna stream from techcheck folder

<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" height="66" width="240">
<param name="movie" value="/limelight/bkcat03b.swf">
<param name="quality" value="high">
<embed src="/limelight/bkcat03b.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" height="66" width="240">
</object>
*/
?>
</div></div>
</td>
				</tr>
				<tr>
					<td colspan="2" class="text21">
					<div style="width:575px;">If you cannot see the image, your computer may be blocking a Web site location that is necessary for this application. Please see your system adminstrator to add the Web site location <u>scholastic.vo.llnwd.net</u> to your list of permitted Web sites. Once this is done please re-run this page to verify that the image loads properly.</div>
					</td>
				</tr>
				<tr>
					<td colspan="2"><img src="images/spacer.gif" width="1" height="5" /></td>
				</tr>

			</table>
		</td>
	</tr>
	<tr>
		<td colspan="2"><img src="images/spacer.gif" width="1" height="5" /></td>
	</tr>
	<tr>
		<td colspan="2"><b>4. Do you have JavaScript enabled?</b></td>
	</tr>	
	<tr>
		<td class="text21" colspan="2">
		
		<div style="color:red;" id="jsdiv" onclick="setJS()">
		You do not have JavaScript enabled. In order to properly view <i>Scholastic Online</i>, please go into your browser settings and enable JavaScript.
		</div>
		
        </td>
    </tr>
	<tr>
		<td colspan="2"><img src="images/spacer.gif" width="1" height="5" /></td>
	</tr>    
	<tr>
		<td colspan="2"><b>5.  What is your bandwidth?</b></td>
	</tr>
	<tr>
		<td colspan="2">
		<a href="javascript:thePopup.blurbWindow('/techcheck/meter1.php', 550, 405, 'Bandwitdh_Test', 'on');">Check out your Bandwidth</a><br>

	
		</td>
	</tr>	

<br>

		
<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="FeaturedFlashIntro" align="middle" height="0" width="0">
<param name="allowScriptAccess" value="always">
<param name="movie" value="/techcheck/flashrat.swf">
<param name="quality" value="high">
<param name="bgcolor" value="#ffffff">
<param name="hidden" value="true">
<embed src="/techcheck/flashrat.swf" hidden="true" quality="high" bgcolor="#FFFFFF" name="FeaturedFlashIntro" allowscriptaccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" align="middle" height="0" width="0">
</object>

 

<td align="left">

<!-- Flash player to test port 80 -->
	<tr>
		<td colspan="2" align="left"><br><b>6. Do you have Port 80 open?</b></td>
	</tr>
		<tr>
					<td colspan="2" class="text21">
					<div style="width:575px;">If you can see the Flash video in the box below, then Port 80 is open. Streaming will play through port 80 (which is the standard Web port).</div>
					<br></td>
				</tr>


<table border ="2"  cellpadding="0" cellspacing="0">
<td>
<!-- BODY -->
<tr valign="top">
<td align="left">
 
<div id="videoDiv2" style="width:500px;" align="center">
 <center>
<?php
  
require_once($_SERVER['MOVIE_PLAYER_HOME'].'/test80/flashplayer_port80.js');

 
?><BR><div style="width:400px; padding-top:5px;">   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Click the Play Button to start the video. </div>
  </center>
</div>
</td>
</tr>
</table>

</table><BR>
<table width="575" border="0">
  <tr>
    <td><b>7. Do you have Port 1935 open?</b></td>
  </tr>
  <tr>
    <td><span style="width:575px;" class="text21">Port 1935 is the optimal port for streaming Scholastic Online videos.  Although not necessary for streaming, your performance may be improved if your network administrator opens this port.  If you see the image below, port 1935 is already open.
    <br><br> </td>
  
    
    
    </tr>
    
 <table border ="2"  cellpadding="0" cellspacing="0">
<td>
<!-- BODY -->
<tr valign="top">
<td align="left">
 
<div id="videoDiv2" style="width:500px;">
 <center>
<?php
  
 
 require_once($_SERVER['MOVIE_PLAYER_HOME'].'/test1935/flashplayer_port1935.js');
 
?><BR><div style="width:400px; padding-top:5px;">   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Click the Play Button to start the video. </div>
  </center>
</div>
</td>
</tr>
</table>


 <table width="575" border="0" align="left">
      <tr>
        <td><b><BR><BR>If you have any questions or concerns please contact our tech support team at 888-326-6546.</b></td>
      </tr>
    </table></td>
  </tr><BR><BR><BR><BR><BR><BR><BR><BR><BR><BR>
</table>
</body>


<script type="text/JavaScript">
setJS();
</script>

</html>
