
<!-- sound.js:begin -->


// class 
function Timer() {
  date = new Date();
  this._starttime = date.getTime();

  this.elapsed = function() {
    date = new Date();
    timenow = date.getTime();
    elapsed = (timenow - this._starttime) / 1000;
    return elapsed;
  }
}

var mysound = "";

function playIE4(file) { 
  eval("document." + file + ".Run()");
}

function getSoundName(soundFile) {
  soundName = soundFile.substr(soundFile.lastIndexOf("/") + 1, soundFile.length); 
  soundName = soundName.substr(0, this.soundName.indexOf('.')); 
  return soundName;
}

// this is the soundError function... not sure what this does really....
function soundError() {
  location.href = mysound;
  return true;
}

// the default sound object type
function defaultSound(soundFile) {
  <!-- Create the sound link -->
  this.createSoundLink = function() {
    <!-- Use whatever program the user has linked to that file type -->
    location.href = soundFile; 
  }
} 

// the IE5 sound object type
function ie5Sound(soundFile) {
  this.soundFile = soundFile;
  this.soundName = getSoundName(soundFile);
  useIE5Object  = false;

  this.soundName = "wav1";

  // test for type of object
  if (navigator.appVersion.indexOf("Mac") == -1) {
    if (Browser.ACTIVEX == 205) {
      useIE5Object = true;
    }
  }
  // Create the object tag -->
  if (useIE5Object) { 
    document.write('<object id="' + this.soundName + '" classid="CLSID:22d6f312-b0f6-11d0-94ab-0080c74c7e95" type="application/x-oleobject" height="1" width="1"><param name="FileName" value="' + soundFile + '"><param name="AllowChangeDisplaySize" value="0"><param name="AutoSize" value="0"><param name="AutoStart" value="0"><param name="ClickToPlay" value="0"><param name="EnableContextMenu" value="0"><param name="ShowCaptioning" value="0"><param name="ShowControls" value="0"><param name="ShowDisplay" value="0"><param name="ShowGotoBar" value="0"><param name="ShowStatusBar" value="0"></object>');
  }
  // Play the sound file requested -->
  this.playDefferedSound = function() {
    eval("document." + this.soundName + ".Play()");
  }
  // Create the sound link -->
  this.createSoundLink = function() {
    if (useIE5Object) { 
      this.playDefferedSound(); 
    } else {
      location.href = this.soundFile;
    } 
  } 
}

// sound object for IE4
function ie4Sound(soundFile) {
  this.soundName = getSoundName(soundFile);
  useIE4Object  = false;
	
  // test for object type
  if (navigator.appVersion.indexOf("Mac") == -1) {
    if (navigator.appVersion.indexOf("MSIE 4") >= 0) {
      if (Browser.ACTIVEX == 204) {
        useIE4Object = true;
      }
    }
  }
  // Create the object tag -->
  if (useIE4Object) { 
    document.write('<object id="' + this.soundName + '" classid="CLSID:05589FA1-C356-11CE-BF01-00AA0055595A" type="application/x-oleobject" height="1" width="1"><param name="FileName" value="' + soundFile + '"><param name="AllowChangeDisplaySize" value="0"><param name="AutoSize" value="0"><param name="AutoStart" value="0"><param name="ClickToPlay" value="0"><param name="EnableContextMenu" value="0"><param name="ShowCaptioning" value="0"><param name="ShowControls" value="0"><param name="ShowDisplay" value="0"><param name="ShowGotoBar" value="0"><param name="ShowStatusBar" value="0"></object>'); 
  }
  // Play the sound file requested -->
  this.playDefferedSound = function() {
    if (navigator.appVersion.indexOf("MSIE 4") >= 0) {
      setTimeout("playIE4('" + this.soundName + "')", 1);
    }
  }
  // Create the sound link -->
  this.createSoundLink = function() {
    if (useIE4Object) { 
      this.playDefferedSound(); 
    } else {
      location.href = soundFile;
    } 
  } 
}


// sound object for Netscape 5
function ns5Sound(soundFile) {
  this.soundName = getSoundName(soundFile);
  useRealPlayer = false;
 
  mime_type = "audio/x-pn-realaudio-plugin";
  for (i = 0;; i++) {
    if (i >= navigator.mimeTypes.length)
      break;

    if (navigator.mimeTypes[i].type == mime_type && navigator.mimeTypes[i].enabledPlugin != null) {
      useRealPlayer = true;
      break;
    } 
  }
  // Create object tag -->
  if (useRealPlayer) { 
    document.write('<EMBED NAME="' + this.soundName + '" TYPE="audio/x-pn-realaudio-plugin" SRC="' + soundFile + '" HEIGHT="1" WIDTH="1" HIDDEN="true" controls=console autostart="false">'); 
  }
  // Play the sound file requested -->
  this.playDefferedSound = function() {
    if (useRealPlayer) {	
      window.onerror = soundError;
      eval("document." + this.soundName + ".DoPlay()");
      window.onerror = null;
    } 
  }
  // Create the sound link -->
  this.createSoundLink = function() {
    mysound = soundFile;
    if (useRealPlayer) { 
      this.playDefferedSound();
    } else {
      location.href = soundFile;
    }
  }
} 


// sound object for Netscape 4
function ns4Sound(soundFile) {
  this.soundName = getSoundName(soundFile);
  useLiveAudio  = false;

  var mime_type = "audio/x-wav";
  for (i = 0;; i++) {
    if (i >= navigator.mimeTypes.length)
      break;

    if (navigator.mimeTypes[i].type == mime_type && navigator.mimeTypes[i].enabledPlugin != null && navigator.mimeTypes[i].enabledPlugin.name == "LiveAudio") {
      useLiveAudio = true;
      break;
    } 
  }
  if (useLiveAudio) { 
    document.write('<EMBED NAME="' + this.soundName + '" TYPE="audio/x-wav" SRC="' + soundFile + '" MASTERSOUND HEIGHT="1" WIDTH="1" HIDDEN="true" controls=console autostart="false">');  
  }
  // Play the sound file requested -->
  this.playDefferedSound = function() {
    if (useLiveAudio)
      eval("document." + this.soundName + ".play(false)");         
  }
  // Create the sound link -->
  this.createSoundLink = function() {
    if (useLiveAudio) {
      this.playDefferedSound();
    } else {
      location.href = soundFile; 	
    }
  } 
}


// sound object for Netscape 3
function ns3Sound(soundFile) {
  // Create the sound link -->
  this.createSoundLink = function() {
    location.href = soundFile;
  }
} 


// this is the 'singleton' browser object. It figures out
// what browser is being used and every instance of Sound uses
// it to save load time.
function Browser() {
  // determine the type of browser the user is running 
  // netscape = offset 100 + version number
  // ie       = offset 200 + version number
  if(navigator.userAgent.indexOf("MSIE") == -1) {
    this._type = 100;
    if (navigator.appVersion.indexOf("5.") == 0) {
      this._type += 5;
    }
    if (navigator.appVersion.indexOf("4.") == 0) {
      this._type += 4;
    }
    if (navigator.appVersion.indexOf("3.") == 0) {
      this._type += 3;
    }
    // otherwise, using IE
  } 
  else {
    this._type = 200;
    if (navigator.appVersion.indexOf("MSIE 4") >= 0) {
      this._type += 4;
      if (navigator.appVersion.indexOf("Mac") == -1) {
	TestActiveX("AMOVIE.ActiveMovieControl.2");
      }
      this._activeX = this._type;
    } 
    else {
      this._type += 5;
      if (navigator.appVersion.indexOf("Mac") == -1) {
	TestActiveX("MediaPlayer.MediaPlayer.1");
      }
      this._activeX = this._type;
      }
  }

  // this is an 'accessor' function to get the browser type
  this.type = function() {
    return this._type;
  }
  // this is an 'accessor' function to get the activeX setup correctly
  this.activeX = function() {
    return this._activeX;
  }
}

// this is an instance of the Browser object, created so the
// 'constructor' gets called
browser = new Browser();

// this is a 'class' variable for the Browser class
Browser.TYPE = browser.type();

// this is a 'class' variable for the Browser class
Browser.ACTIVEX = browser.activeX();


function Sound(soundFile) {
  this.soundFile = soundFile;

  // create the correct sound object
  switch(Browser.TYPE) {
    case 105:
      this.object = new ns5Sound(this.soundFile)
      break;
    case 104:
      this.object = new ns4Sound(this.soundFile)
      break;
    case 103:
      this.object = new ns3Sound(this.soundFile)
      break;
    case 205:
      this.object = new ie5Sound(this.soundFile)
      break;
    case 204:
      this.object = new ie4Sound(this.soundFile)
      break;
    default:
      this.object = new defaultSound(this.soundFile);
  }

  // create the link to the underlying sound object
  this.createSoundLink = function() {
    this.object.createSoundLink()
  }
}



<!-- sound.js:end -->
