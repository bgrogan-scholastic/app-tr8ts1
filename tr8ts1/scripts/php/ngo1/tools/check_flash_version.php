 <?php
 //set this to 10 if you would like to see the popup
 
 //$_SERVER['MIN_FLASH_VERSION']=1;
 
 	/**
	* 
	*
	* This is the FLASH detection include from home.php
	* 
	*
	* @author  Peter Kujawa PKujawa-consultant@Scholastic.com 
	* 
	* @access  to be included into home.php on expertspace
	* 
	* @DATE 	 10/31/2008
	* 
	* @param 	This code is to be included from home.php and it will detect FLASH 
	* 			if flash is not detected it will result in a popup window that is here
	* 			http://currdev.grolier.com:1120/php/ngo1/tools/badflash.php
	* 
	* 
	* 			Original code pulled from bookflix and written by Richard
	*/
 	
 	
 ?>
 
 
<script src="/javascript/common/flash/macromedia.js"></script>
<script src="/javascript/common/flash/Flash_Runactive.js"></script>
<script src="/javascript/common/flash/Flash_ActiveX.js"></script>
<script src="/javascript/graphical/popup.js"></script>
 

<script>
 // This is the plugin detection module.
// initialize global variables
var BFIF = "<?php echo $_COOKIE['BFIF']; ?>";

 


var detectableWithVB = false;
var pluginFound = false;
var flash_ver = "";
 
// Trying to build a psychic page...
var flashratFailed = true;


 
 
function detectFlash() {
     //alert("about to detect");
	 
	 pluginFound = detectPlugin('Shockwave','Flash');
    //alert("pluginFound = " + pluginFound);
    // if not found, try to detect with VisualBasic
     
    if(!pluginFound && detectableWithVB) {
    	
     
    	pluginFound = detectActiveXControl('ShockwaveFlash.ShockwaveFlash.1');
    }
	
	 
    return pluginFound;
}
 
function test(){

 alert("about to detect");
    pluginFound = detectPlugin('Shockwave','Flash');
   
     return pluginFound;
}
function detectPlugin() {
    // allow for multiple checks in a single pass
    var daPlugins = detectPlugin.arguments;

   //for(namesCounter=0; namesCounter < daPlugins.length; namesCounter++) {
   //    alert(daPlugins[namesCounter]);
   //}

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

		    // Force a check that 'Flash' is the correct version or higher...
		    var version = 1;
		    if(daPlugins[namesCounter] == 'Flash'){
               // alert("Check Flash\n" + navigator.plugins[pluginsArrayCounter].name + "\n" + navigator.plugins[pluginsArrayCounter].description + "\n" + "version = " + version);
                var pattern=/(.*?)Flash (\d+).(.*?)/;
                var result = navigator.plugins[pluginsArrayCounter].name.match(pattern);
                if(result != null){
                    version = result[2];
                }
                else {
                    result = navigator.plugins[pluginsArrayCounter].description.match(pattern);
                    if(result != null){
                        version = result[2];
                    }
                }
				//alert(version);
				flash_ver=version;
                if (version >= <?php echo $_SERVER['MIN_FLASH_VERSION']; ?>) {
                   numFound++
                }
		    }
		    else {
    		    // this name was found
	    	    numFound++;
		       // alert(navigator.plugins[pluginsArrayCounter].name + "\n" + navigator.plugins[pluginsArrayCounter].description);
		    }
		}   
	    }
	    // now that we have checked all the required names against this one plugin,
	    // if the number we found matches the total number provided then we were successful
	    if(numFound == daPlugins.length) {
		pluginFound = true;
		//alert("detectPlugin thinks it found Flash...");
		// if we've found the plugin, we can stop looking through at the rest of the plugins
		//break;
	    }
	}
    }
    //alert("FLASH VER:"+flash_ver);
    return pluginFound;
} // detectPlugin

 
function setFlashVersion(inVersion){
   //alert("flashrat sez: " + inVersion);

    flashratFailed = false;
    // Check that we have an adequate version.
    var minVersion = <?php echo $_SERVER['MIN_FLASH_VERSION']; ?>;

    var pattern=/(\w+) (\d+),(\d+),(\d+),(\d+)/;
    var result = inVersion.match(pattern);

 
    if (result != null) {
         if (result[2] < minVersion) {
            
         	 
         	badFlash();
         	
var BFIDomain = "<?php echo $_SERVER['SERVER_NAME']; ?>";
document.cookie = "BFIF=0; path=/; domain=" + BFIDomain; 

         } 
    }
}

function badFlash() {
 
    thePopup.boxWindowNoStatus('/badflash', 820, 615, 'badflash', 'on');
} 
 
</script>



 
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
 

<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" id="FeaturedFlashIntro" align="middle" height="0" width="0">
<param name="allowScriptAccess" value="always">
<param name="movie" value="/flash/flashrat.swf">
<param name="quality" value="high">
<param name="bgcolor" value="#ffffff">
<param name="hidden" value="true">
<embed src="/flash/flashrat.swf" hidden="true" quality="high" bgcolor="#FFFFFF" name="FeaturedFlashIntro" allowscriptaccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" align="middle" height="0" width="0">
</object>
 


<script>


 

    if (!detectFlash()) {
       
	    badFlash();
	  	 
    }else
    
    {
     
   //detected flash, set cookie
	 
var BFIDomain = "<?php echo $_SERVER['SERVER_NAME']; ?>";
document.cookie = "BFIF=1; path=/; domain=" + BFIDomain;
    
    }
    
   
   
</script> 
 