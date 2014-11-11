// Common JavaScript classes

// sound 'class'
function sound(inID, inURL){
    this.id = inID;
    this.soundURL = inURL;

}

sound.prototype.getHTML = function(){
    return '<span id="' + this.id + '"><embed width="0" height="0" /></span>'+"\n";
}

sound.prototype.play = function(loopFlag){
    var embedString = '<embed id="'+this.id+'embed" src="' + this.soundURL
        + '" width="0" height="0" autostart="true" loop="';
    if (loopFlag) {
        embedString += 'true';
    } else {
        embedString += 'false';
    }
    embedString += '" />'+"\n";
    document.getElementById(this.id).innerHTML= embedString;

}

sound.prototype.stop = function(){
    document.getElementById(this.id).innerHTML= '';
}


// Generic global methods
function getWindowSize(inAxis){
    if(window.innerWidth != null) {
        if (inAxis.toLowerCase() == 'width') {
            return window.innerWidth;
        } else if (inAxis.toLowerCase() == 'height') {
            return window.innerHeight;
        } else {
            return -1;
        }
    } else {
        if (inAxis.toLowerCase() == 'width') {
            return document.documentElement.clientWidth;
        } else if (inAxis.toLowerCase() == 'height') {
            return document.documentElement.clientHeight;
        } else {
            return -1;
        }
    }
}

function getScrollPosition(inAxis){      
    if (document.all) {
        if (inAxis.toLowerCase() == 'x') {
            if (!document.documentElement.scrollLeft)
                return document.body.scrollLeft;
            else
                return document.documentElement.scrollLeft;
        } else if (inAxis.toLowerCase() == 'y') {
            if (!document.documentElement.scrollTop)
                return document.body.scrollTop;
            else
                return document.documentElement.scrollTop;
        } else {
            return -1;
        }
    } else {
        if (inAxis.toLowerCase() == 'x') {    
            return window.pageXOffset;
        } else if (inAxis.toLowerCase() == 'y') {
            return window.pageYOffset;
        } else {
            return -1;
        }
    }
}


