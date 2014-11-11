// reward module 3

// reward image class
function rewardImage(inID, inZ, inRootDir){
    this.id = inID;
    this.Z = inZ;
    this.rootDir = inRootDir;
    this.iWidth = 172;
    this.iHeight = 77;

    do {
        this.vX = 10-(Math.floor(Math.random()*5));
    } while (this.vX == 0);

    do {
        this.vY = 10-(Math.floor(Math.random()*5));
    } while (this.vY == 0);

    // Good for now.
    this.xPos = 10;
    this.yPos = 10;

}

rewardImage.prototype.getHTML = function(){
    return '<img id="' + this.id + '" src="' + this.rootDir
    + '/reward3.gif" style="position: absolute; left: '
    + this.xPos + 'px; top: ' + this.yPos + 'px; z-index: ' + this.Z
    + '; visibility: hidden;" />'+"\n";

}

// This is to handle a problem with IE
// You can't determine the size of the document before the document is
// complete, and this object gets instantiated before the object is complete.
rewardImage.prototype.init = function(){
    this.xPos = Math.floor(Math.random()*(getWindowSize('width')-this.iWidth-20));
    this.yPos = Math.floor(Math.random()*(getWindowSize('height')-this.iHeight))+getScrollPosition('y');
}

rewardImage.prototype.move = function(){
    var e = document.getElementById(this.id);
    this.xPos += this.vX;
    this.yPos += this.vY;
    if (this.xPos >= getWindowSize('width') - this.iWidth -20) {
        this.vX = 0-this.vX;
        this.xPos += this.vX;
    } else if (this.xPos <= 0) {
        this.vX = 0-this.vX;
        this.xPos += this.vX;
    }
    if (this.yPos >= getWindowSize('height') - this.iHeight + getScrollPosition('y')) {
        this.vY = 0-this.vY;
        this.yPos += this.vY;
    } else if (this.yPos <= getScrollPosition('y')) {
        this.vY = 0-this.vY;
        this.yPos += this.vY;
    }


    e.style.left = this.xPos+'px';
    e.style.top = this.yPos+'px';

}



// reward 'class'
function reward(inID, inName, inRootDir){
    this.id = inID;
    this.name = inName;
    this.rootDir = inRootDir;
    this.imageCount = 10;
    this.animationTask = null;

    this.images = new Array();

    for (var i=0; i<this.imageCount; i++) {
        this.images[i] = new rewardImage('rewardImage'+i, 1000+i, this.rootDir);
    }

}

reward.prototype.getHTML = function(){
    var outString = '';
    for (var i=0; i<this.imageCount; i++) {
        outString += this.images[i].getHTML();
    }

    return outString;
}

reward.prototype.init = function(){
}

reward.prototype.animate = function(){
    for (var i=0; i<this.imageCount; i++) {
        this.images[i].move();
    }
}

reward.prototype.play = function(){
    for (var i=0; i<this.imageCount; i++) {
        this.images[i].init();
        document.getElementById(this.images[i].id).style.visibility = "visible";
    }
    if (this.animationTask == null) {
        this.animationTask = setInterval(this.name+".animate()", 1000/60);
    }
}

reward.prototype.stop = function(){
    for (var i=0; i<this.imageCount; i++) {
        document.getElementById(this.images[i].id).style.visibility = "hidden";
    }
    if (this.animationTask != null) {
        clearInterval(this.animationTask);
        this.animationTask = null;
    }
}

