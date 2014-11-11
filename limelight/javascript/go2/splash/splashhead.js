<!-- splashhead.js -->
// This will identify the specific current domain for the page.
var FSDomain = "<?php echo $_SERVER['SERVER_NAME']; ?>";

var showcasePluginsFlag = -1;

var showcaseRerunFlag = 0;

function splashFocusHandler() {
// Here is where we set the FSV cookie to its initial value.
    var pluginVal = theCookie.GetCookie("Plugins");
    var FSV = "H";
    showcasePluginsFlag = 0;
    if (pluginVal != 'N' && detectFlash()) {
        if (detectQuickTime() && detectWindowsMedia()) {
            FSV="F";
            showcasePluginsFlag = 1;
        } else if (detectWindowsMedia()) {
            FSV="W";
            showcasePluginsFlag = 1;
        } else if (detectQuickTime()) {
            FSV="Q";
            showcasePluginsFlag = 1;
        }
    }
    document.cookie = "FSV="+FSV+"; path=/; domain="+FSDomain;

    var FSRRF = theCookie.GetCookie("FSRRF");
    if (FSRRF == 1 ) {
      showcaseRerunFlag = 1;
    }
}


var apBaseURL ='<?php echo GI_BaseHref('ap') ?>';

var eaBaseURL = "<?php echo GI_BaseHref('ea') ?>";
var eaAdaBaseURL = "<?php echo GI_BaseHref('ea-ada') ?>";

var gmeBaseURL = "<?php echo GI_BaseHref('gme') ?>";
var gmeAdaBaseURL = "<?php echo GI_BaseHref('gme-ada') ?>";

var nbkBaseURL = "<?php echo GI_BaseHref('nbk') ?>";
var nbkAdaBaseURL = "<?php echo GI_BaseHref('nbk-ada') ?>";

var necBaseURL = "<?php echo GI_BaseHref('nec') ?>";
var necAdaBaseURL = "<?php echo GI_BaseHref('nec-ada') ?>";

var nbpsBaseURL = "<?php echo GI_BaseHref('nbps') ?>";
var nbpsAdaBaseURL = "<?php echo GI_BaseHref('nbps-ada') ?>";

var atbBaseURL = "<?php echo GI_BaseHref('atb') ?>";

var lpBaseURL = "<?php echo GI_BaseHref('lp') ?>";

var easBaseURL = "<?php echo GI_BaseHref('eas') ?>";
var easAdaBaseURL = "<?php echo GI_BaseHref('eas-ada') ?>";

var goBaseURL = "<?php echo GI_BaseHref('go') ?>";

var Dictionary_BaseHref = "<?php echo GI_BaseHref('go') ?>";
<?php require_once($_SERVER['JAVASCRIPT_INCLUDE_HOME'].'go2/dictionary/launch.js'); ?>

// Make sure we don't think we're still in a product.
theCookie.DeleteCookie("CurrentProduct", "/", myDomain);

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
<!-- endof splashhead.js -->

