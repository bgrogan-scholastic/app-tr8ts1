var isNS = false;
var isIE = false; 
var isSafari = false;

// Determine the type of browser the user is running
if (navigator.userAgent.indexOf("MSIE") != -1) {
  isIE = true;
} else {
  isNS = true; 
}

// Determine what the user is capable of doing
var useEmbed      = false;
var useIE4Object  = false;
var useIE5Object  = false;
var useNS79Object = false;
var useNS64Object  = false;  
 
var ddnav = navigator.userAgent;

if (isNS && (ddnav.indexOf("Netscape6") == -1 && 
         ddnav.indexOf("Mozilla/4") == -1 &&
	 ddnav.indexOf("Netscape/7.0") == -1)) {
  var wmp7or9;
  var wmp64;

  if (window.GeckoActiveXObject) {
    wmp7or9 = createGeckoWMPObject("{6BF52A52-394A-11d3-B153-00C04F79FAA6}"); 
    if (!wmp7or9) 
      wmp64 = createGeckoWMPObject("{22D6F312-B0F6-11D0-94AB-0080C74C7E95}");
      if (wmp64) 
        useNS64Object = true;
    else 
      useNS79Object = true;
  }

  else if (navigator.appVersion.indexOf("3.0 ") == -1) {
    var mime_type = "audio/x-wav";
    for (i = 0;; i++) {
      if (i >= navigator.mimeTypes.length)
        break;

      if (navigator.mimeTypes[i].type == mime_type && navigator.mimeTypes[i].enabledPlugin != null && navigator.mimeTypes[i].enabledPlugin.name == "LiveAudio") {
        useEmbed = true;
        break;
      } 
    }
  }
} else if (isIE) {
  if (navigator.appVersion.indexOf("Mac") == -1) {
    if (navigator.appVersion.indexOf("MSIE 4") >= 0) {
      if (TestActiveX("AMOVIE.ActiveMovieControl.2")) {
        useIE4Object = true;
      }
    } else {
      if (TestActiveX("MediaPlayer.MediaPlayer.1")) {    
        useIE5Object = true;
      }
    }
  }
}

var ie4File = "";

function createGeckoWMPObject(clid)
{
  //  var player = null;
  // can't try/catch this b/c ns4 doesn't like it, even though it isn't 
  //executing the code	
  //  player = new GeckoActiveXObject(clid);

  return new GeckoActiveXObject(clid);
}

// Play the sound file requested
function playDefferedSound(filename) {
  if (isNS) {
    if (useNS79Object || useNS64Object) {
      eval("document." + filename + ".controls.play()");
    } else {	
      eval("document." + filename + ".play(false)");         
    }
  } else {     
    if (navigator.appVersion.indexOf("MSIE 4") >= 0) {
      ie4File = filename;
      setTimeout("playIE4()", 1);
    } else {
      eval("document." + filename + ".Play()");
    }
  } 
}

// A special little function to play the sound in IE4
function playIE4() {
  eval("document." + ie4File + ".Run()");
}
