// GI_Sound 'class', version 2.0
function GI_Sound(inID, inURL, inLoopFlag, inCallback){
    this._id = inID;
    this._URL = inURL;

    this.flashLoc = "/flash/";
//    this.flashLoc = "";
    this.movieString = this.flashLoc + 'playmp3-2.swf?id=' + this._id + '&url=' + this._URL;
    if (inLoopFlag) {
        this.movieString += '&loopflag=y';
    }
    if (inCallback) {
        this.movieString += '&callback=' + inCallback;
    }

}


GI_Sound.prototype.getFlashMovie = function(movieName) {
    var isIE = navigator.appName.indexOf("Microsoft") != -1;
    return (isIE) ? window[movieName] : document[movieName];
}

GI_Sound.prototype.getHTML = function() {
    var outString = "";
    outString += '<object id="'+this._id+'objembd" classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
    outString += 'codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" ';
    outString += 'width="0" height="0" align="left">';
    outString += '<param name="allowScriptAccess" value="always" />';
    outString += '<param name="movie" value="' + this.movieString + '" />';
    outString += '<param name="hidden" value="true" />';
    outString += '<param name="quality" value="high" />';
    outString += '<param name="bgcolor" value="#ffffff" />';
    outString += '<param name="wmode" value="transparent" />';
    outString += '<embed id="'+this._id+'objembd" name="'+this._id+'objembd" src="' + this.movieString + '" quality="high" bgcolor="#ffffff" width="0" height="0" hidden="true" ';
    outString += 'align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />';
    outString += '</object>';
    return outString;
}

GI_Sound.prototype.play = function() {
    this.getFlashMovie(this._id + 'objembd').playSound();
}


GI_Sound.prototype.stop = function() {
    this.getFlashMovie(this._id+'objembd').stopSound();
}

GI_Sound.prototype.pause = function() {
    this.getFlashMovie(this._id+'objembd').pauseSound();
}

GI_Sound.prototype.getPosition = function() {
    return this.getFlashMovie(this._id+'objembd').getPosition();
}


GI_Sound.prototype.getStatus = function() {
    return this.getFlashMovie(this._id+'objembd').getStatus();
}

GI_Sound.prototype.setURL = function(inURL) {
    this.getFlashMovie(this._id + 'objembd').setURL(inURL);
}

GI_Sound.prototype.setSoundVolume = function(numVal) {
    this.getFlashMovie(this._id + 'objembd').setSoundVolume(numVal);
}
