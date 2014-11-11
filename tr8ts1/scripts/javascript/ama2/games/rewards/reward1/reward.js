// reward module 1

// reward 'class'
function reward(inID, inName, inRootDir){
    this.id = inID;
    this.name = inName;
    this.rootDir = inRootDir;
    this.xPos = 80;
    this.yPos = 100;
    this.vX = 10;
    this.vY = 10;
    this.iWidth = 210;
    this.iHeight = 60;
    this.animationTask = null;

}

reward.prototype.getHTML = function(){
    var outString = '<img id="' + this.id + 'image1" src="' + this.rootDir
                    + 'reward1.gif" style="position: absolute; left: ' + this.xPos
                    + 'px; top: ' + this.yPos + 'px; z-index: 1000; visibility: hidden;" />'
                    + "\n";
    return outString;
}

reward.prototype.init = function(){

}

reward.prototype.stopAnimation = function(){
    clearInterval(this.animationTask);
    this.animationTask=null;
}

reward.prototype.animate = function(){
    var e = document.getElementById(this.id+'image1');
    this.xPos += this.vX;
    this.yPos += this.vY;
    if (this.xPos >= getWindowSize('width') - this.iWidth - 20) {
        this.vX = 0-this.vX;
        this.xPos += this.vX;
    } else if (this.xPos <= 0) {
        this.vX = 0-this.vX;
        this.xPos += this.vX;
    }
    if (this.yPos >= getWindowSize('height') + getScrollPosition('y') - this.iHeight) {
        this.vY = 0-this.vY;
        this.yPos += this.vY;
    } else if (this.yPos <= getScrollPosition('y')) {
        this.vY = 0-this.vY;
        this.yPos += this.vY;
    }


    e.style.left = this.xPos+'px';
    e.style.top = this.yPos+'px';
}

reward.prototype.play = function(){
    this.yPos = 100 + getScrollPosition('y');
    var e = document.getElementById(this.id+'image1');
    e.style.top = this.yPos+'px';
    e.style.visibility = 'visible';
    if (this.animationTask == null) {
        this.animationTask = setInterval(this.name+".animate()", 1000/60);
    }
}

reward.prototype.stop = function(){
    this.stopAnimation();
    var e = document.getElementById(this.id+'image1');
    e.style.visibility = 'hidden';
}

