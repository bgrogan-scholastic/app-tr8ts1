
<!-- sound_dictionary.js:begin -->

var mysound = "";
var loaded  = false;

function enableLinks() {
  if (isIE) {
    for (var i=0;i < document.links.length;i++) {
      document.links[i].onclick = "";  
    }
  }
}

function pageLoaded() {
  loaded = true;
  loadwindow.close();
} 

function playIE4(file) { 
  eval("document." + file + ".Run()");
}

function writeSoundLink(wavfile, wavid) {
  var output = ""; 
 
  var soundImage = '<img src="/images/student/audio_icon.gif" height="18" width="22" border=0>'; 
  wavfile = usageHome + '/' + wavfile;

    if (useIE4Object) { 
      output = '<object id="' + wavid + '" classid="CLSID:05589FA1-C356-11CE-BF01-00AA0055595A" type="application/x-oleobject" height="1" width="1"><param name="FileName" value="' + wavfile + '"><param name="AllowChangeDisplaySize" value="0"><param name="AutoSize" value="0"><param name="AutoStart" value="0"><param name="ClickToPlay" value="0"><param name="EnableContextMenu" value="0"><param name="ShowCaptioning" value="0"><param name="ShowControls" value="0"><param name="ShowDisplay" value="0"><param name="ShowGotoBar" value="0"><param name="ShowStatusBar" value="0"></object>';  
    } else if (useIE5Object || useNS64Object) { 
      output = '<object id="' + wavid + '" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" type="application/x-oleobject" height="1" width="1"><param name="FileName" value="' + wavfile + '"><param name="AllowChangeDisplaySize" value="0"><param name="AutoSize" value="0"><param name="AutoStart" value="0"><param name="ClickToPlay" value="0"><param name="EnableContextMenu" value="0"><param name="ShowCaptioning" value="0"><param name="ShowControls" value="0"><param name="ShowDisplay" value="0"><param name="ShowGotoBar" value="0"><param name="ShowStatusBar" value="0"></object>';  
    } else if (useNS79Object) { 
      output = '<object id="' + wavid + '" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" type="application/x-oleobject" height="1" width="1"><param name="FileName" value="' + wavfile + '"><param name="AllowChangeDisplaySize" value="0"><param name="AutoSize" value="0"><param name="AutoStart" value="0"><param name="ClickToPlay" value="0"><param name="EnableContextMenu" value="0"><param name="ShowCaptioning" value="0"><param name="ShowControls" value="0"><param name="ShowDisplay" value="0"><param name="ShowGotoBar" value="0"><param name="ShowStatusBar" value="0"><param name="URL" value="' + wavfile + '"></object>';  
    } else if (useEmbed) { 
      output = '<EMBED NAME="' + wavid + '" TYPE="audio/x-wav" SRC="' + wavfile + '" MASTERSOUND HEIGHT="1" WIDTH="1" HIDDEN="true" controls=console autostart="false">';  
    } 

    if (output == "") { 
      document.writeln('<a href="' + wavfile + '">' + soundImage + '</a>'); 
    } else { 
      document.write(output); 
      document.writeln("");
      if (isIE)
	document.writeln("<a href=\"javascript:playDefferedSound('" + wavid + "')\" onClick=\"return false;\">" + soundImage + "</a>");  
      else
        document.writeln("<a href=\"javascript:playDefferedSound('" + wavid + "')\">" + soundImage + "</a>");  
    } 
 
}


<!-- Pronunciation functions -->
var isNS = false;
var isIE = false; 

// Determine the type of browser the user is running
if (navigator.userAgent.indexOf("MSIE") == -1) {
  isNS = true;
} else {
  isIE = true;
}

// Determine what the user is capable of doing
var useEmbed      = false;
var useIE4Object  = false;
var useIE5Object  = false;
var useNS79Object = false;
var useNS64Object  = false;  
 
if (isNS) {
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

      if (navigator.mimeTypes[i].type == mime_type && navigator.mimeTypes[i].enabledPlugin != null && navigator.mimeTypes[i].enabledPlugin.name == "LiveAudio") 
	{
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
      //alert(useIE5Object);

    }
  }
}

var ie4File = "";

function createGeckoWMPObject(clid)
{
  var player = null;
  // can't do try/catch here b/c ns4 doesn't like it
  player = new GeckoActiveXObject(clid);
  return player;
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



<!-- sound_dictionary.js:end -->
