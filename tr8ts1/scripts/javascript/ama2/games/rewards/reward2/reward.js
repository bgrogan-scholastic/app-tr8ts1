// reward module 3

// reward image class
function rewardImage(inID, inZ, inRootDir){
    this.id = inID;
    this.Z = inZ;
    this.rootDir = inRootDir;
    this.iWidth = 60;
    this.iHeight = 51;
    //this.sound = new sound(this.id+'sound', this.rootDir+'/pop.wav');

    this.moving=false;

    // Good for now.
    this.xPos = 10;
    this.yPos = 10;

}

rewardImage.prototype.getHTML = function(){
    return '<img id="' + this.id + '" src="' + this.rootDir
    + '/reward2.gif" style="position: absolute; left: '
    + this.xPos + 'px; top: ' + this.yPos + 'px; z-index: ' + this.Z
    + '; visibility: hidden;" />' + "\n";

}

rewardImage.prototype.init = function(){
    this.xPos = Math.floor(Math.random()*(getWindowSize('width')-this.iWidth-20));
    this.yPos = getWindowSize('height') + getScrollPosition('y') - this.iHeight;
    this.vY = 0-(Math.floor(Math.random()*10)+2);
}

rewardImage.prototype.move = function(inYScroll){
    if (!this.moving) {
        return;
    }

    if (this.yPos < (inYScroll-this.iHeight)) {
        this.stop();
        return;
    }
    this.yPos += this.vY;

    var e = document.getElementById(this.id);
    e.style.left = this.xPos+'px';
    e.style.top = this.yPos+'px';
}

rewardImage.prototype.start = function(){
    if (this.moving) {
        return;
    }
    this.init();
    this.show();
    this.moving = true;
    //this.sound.play(false);
}

rewardImage.prototype.stop = function(){
    if (!this.moving) {
        return;
    }
    this.hide();
    this.moving=false;
}

rewardImage.prototype.hide = function(){
    document.getElementById(this.id).style.visibility = "hidden"
}

rewardImage.prototype.show = function(){
    document.getElementById(this.id).style.visibility = "visible"
}


// reward 'class'
function reward(inID, inName, inRootDir){
    this.id = inID;
    this.name = inName;
    this.rootDir = inRootDir;
    this.imageCount = 20;
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
    for (var i=0; i<this.imageCount; i++) {
        this.images[i].init();
    }        
}

reward.prototype.animate = function(){
    var inum = Math.floor(Math.random()*this.imageCount);
    var yScroll = getScrollPosition('y');
    this.images[inum].start();
    for (var i=0; i<this.imageCount; i++) {
        this.images[i].move(yScroll);
    }
}

reward.prototype.play = function(){
    //for (var i=0; i<this.imageCount; i++) {
    //    this.images[i].start();
    //}
    if (this.animationTask == null) {
        this.animationTask = setInterval(this.name+".animate()", 1000/60);
    }
}

reward.prototype.stop = function(){
    for (var i=0; i<this.imageCount; i++) {
        this.images[i].stop();
    }
    if (this.animationTask != null) {
        clearInterval(this.animationTask);
        this.animationTask = null;
    }
}

