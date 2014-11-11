
// This is the new prototype code.

// toss in a reward
var numRewards = 3;
var rewardNum = Math.floor(Math.random()*numRewards)+1;
//rewardNum = 3;
var rewardPath = '/ama2/games/rewards/reward'+rewardNum+'/';
var rewardMediaPath = '/images/games/rewards/reward'+rewardNum+'/';
document.write('<scr'+'ipt src="'+rewardPath+'reward.js"></scr'+'ipt>'+"\n");

// tile 'class'
function tile(inID, inImage, inX, inY, inPuzzleName, inH, inV, inZ){
    this.id = inID;
    this.image = inImage;
    this.xpos = inX;
    this.ypos = inY;
    this.homeX = inX;
    this.homeY = inY;
    this.newx = inX;
    this.newY = inY;
    this.puzzleName = inPuzzleName;
    this.hPos = inH;
    this.vPos = inV;
    this.movingFlag = false;
    this.Z = inZ
}

tile.prototype.getHTML = function(){
    var outString = '<img id="' + this.id
                + '" style="position: absolute; left: ' + this.xpos
                + 'px; top: ' + this.ypos + 'px; zIndex: '+this.Z+';" src="/images/games/scramble/' + this.image
                + '" onclick="javascript:'+this.puzzleName+'.clickTile('
                + this.hPos + ',' + this.vPos + ');" border="0" />';
    return outString;
}

tile.prototype.move = function(){
    var speed=7;
    if (this.xpos == this.newx && this.ypos == this.newy) {
        if (this.movingFlag) {
            var e = document.getElementById(this.id);
            e.style.zIndex = this.Z;
        }
        this.movingFlag = false;
        return;
    }
    this.movingFlag = true;

    if (this.xpos < this.newx) {
        if (this.newx-this.xpos < speed) {
            this.xpos = this.newx;
        } else {
            this.xpos = this.xpos+speed;
        }
    } else if (this.xpos > this.newx) {
        if (this.xpos - this.newx < speed) {
            this.xpos = this.xpos-speed;
        } else {
            this.xpos = this.xpos-speed;
        }
    }

    if (this.ypos < this.newy) {
        if (this.newy-this.ypos < speed) {
            this.ypos = this.newy;
        } else {
            this.ypos = this.ypos+speed;
        }
    } else if (this.ypos > this.newy) {
        if (this.ypos - this.newy < speed) {
            this.ypos = this.ypos-speed;
        } else {
            this.ypos = this.ypos-speed;
        }
    }

    var e = document.getElementById(this.id);
    e.style.left = this.xpos+'px';
    e.style.top = this.ypos+'px';
}
// end of tile 'class'

// puzzle 'class'
function puzzle(inID, inName, inX, inY, inWidth, inHeight,
                    inCWidth, inCHeight, imageroot){
    this.id = inID;
    this.name = inName;
    this.xpos = inX;
    this.ypos = inY
    this.width = inWidth;
    this.height = inHeight
    this.cellWidth = inCWidth;
    this.cellHeight = inCHeight;
    this.imageroot = imageroot;
    this.reward = null;
    this.music=null;

    this.animationTask = null;

    this.choice1 = null;

    this.tiles = new Array();


    var x,y,z;

    // create the tiles
    z = 1;
    for (x=0; x<this.width; x++) {
        this.tiles[x] = new Array();
        for (y=0; y<this.height; y++) {
            this.tiles[x][y] = new tile(this.id+'x'+x+'y'+y,
                this.imageroot + '/' + this.id+'-' + (((y)*this.width)+x+1) + '.jpg',
                x*this.cellWidth, y*this.cellHeight, this.name, x, y, z);
            z++
        }
    }

    // create the field
    this.spaces = new Array();
    for (x=0; x< this.width; x++) {
        this.spaces[x] = new Array();
        for (y=0; y<this.height; y++) {
            this.spaces[x][y] = '';
        }
    }

}

puzzle.prototype.init = function(){
    this.reward.init();
}

puzzle.prototype.appendHTML = function(inObject) {
    if (inObject == null) {
        return "\n";
    }
    return inObject.getHTML();
}

puzzle.prototype.playASound = function(inSound, inLoopFlag){
    if (inSound != null) {
        inSound.play(inLoopFlag);
    }
}

puzzle.prototype.stopASound = function(inSound){
    if (inSound != null) {
        inSound.stop();
    }
}

puzzle.prototype.getHTML = function(){
    var outString = '<div style="position: absolute; left: ' + this.xpos
        + 'px; top: ' + this.ypos+'px;">'+"\n";

    for (var y=0; y<this.height; y++) {
        for (var x=0; x<this.width; x++) {
            outString += this.tiles[x][y].getHTML();
        }
    }

    outString += '<img onclick="javascript:' + this.name + '.clearCursor();" id="'
                    + this.id
                    + 'cursor" src="/images/games/scramble/cursor0.gif" style="position: absolute; left: 0; top: 0; visibility: hidden; z-index: '
                    +((this.width*this.height)+5)+';" />'+"\n";

    outString += "</div>\n";

    outString += this.appendHTML(this.solvedSound) + this.appendHTML(this.cheatSound)
                    + this.appendHTML(this.music) + this.appendHTML(this.reward);

    return outString;
}

puzzle.prototype.playMusic = function(inLoopFlag){
    this.playASound(this.music, inLoopFlag);
}

puzzle.prototype.stopMusic = function(){
    this.stopASound(this.music);
}

puzzle.prototype.checkSolved = function(){
    var x,y;
    for (x=0; x<this.width; x++) {
        for (y=0; y<this.height; y++) {
            if (this.tiles[x][y].xpos != this.tiles[x][y].homeX
                    || this.tiles[x][y].ypos != this.tiles[x][y].homeY) {
                return;
            }
        }
    }
    if (this.reward != null) {
        this.reward.play();
    } else {
        this.playSound(this.solvedSound, false);
        alert('Puzzle solved!');
    }
}

puzzle.prototype.animateTiles = function(){
    var stopFlag = true;

    for (var x=0; x<this.width; x++) {
        for (var y=0; y<this.height; y++) {
            this.tiles[x][y].move();
            if (this.tiles[x][y].movingFlag) {
                stopFlag = false;
            }
        }
    }

    if (stopFlag) {
        clearInterval(this.animationTask);
        this.animationTask=null;
        this.checkSolved();
    }
}

puzzle.prototype.stop = function(){

    if (this.animationTask != null) {
        clearInterval(this.animationTask);
        this.animationTask=null;
    }

    this.stopReward();
}

puzzle.prototype.scramble = function(){
    var x,y,x2,y2;

    if (this.animationTask != null) {
        return;
    }

    this.stopReward();
    this.clearCursor();

    // clear the field
    for (x=0; x<this.width; x++) {
        for (y=0; y<this.height; y++) {
            this.spaces[x][y] = "";
        }
    }

    // randomize the tiles
    for (x=0; x < this.width; x++) {
        for (y=0; y<this.height; y++) {
            do {
                x2 = Math.floor(Math.random()*this.width);
                y2 = Math.floor(Math.random()*this.height);
            } while (this.spaces[x2][y2] != "");
            this.tiles[x][y].newx = x2*this.cellWidth;
            this.tiles[x][y].newy = y2*this.cellHeight;
            this.spaces[x2][y2]=this.tiles[x][y].id;
        }
    }

    this.animationTask = setInterval(this.name+".animateTiles()", 1000/60);
}

puzzle.prototype.solve = function(){
    var x,y;

    if (this.animationTask != null) {
        return;
    }

    this.clearCursor();

    if (this.cheatSound != null) {
        this.playASound(this.cheatSound, false);
    }

    for (x=0; x<this.width; x++) {
        for (y=0; y<this.height; y++) {
            this.tiles[x][y].newx = this.tiles[x][y].homeX;
            this.tiles[x][y].newy = this.tiles[x][y].homeY;
        }
    }

    this.animationTask = setInterval(this.name+".animateTiles()", 1000/25);
}

puzzle.prototype.clickTile = function(inX, inY){
    if (this.animationTask != null) {
        return;
    }
    var clickedTile = this.tiles[inX][inY];
    var cursor = document.getElementById(this.id+'cursor');
    if (this.choice1 == null) {
        this.choice1 = clickedTile;
        cursor.style.left = (clickedTile.xpos-2) + 'px';
        cursor.style.top = (clickedTile.ypos-2)+'px';
        cursor.style.visibility = "visible";
    } else {
        cursor.style.visibility = "hidden";
        var e = document.getElementById(this.choice1.id);
        e.style.zIndex = ((this.width*this.height)+1);
        e = document.getElementById(clickedTile.id);
        e.style.zIndex = ((this.width*this.height)+2);
        this.choice1.newx = clickedTile.xpos;
        this.choice1.newy = clickedTile.ypos;
        clickedTile.newx = this.choice1.xpos;
        clickedTile.newy = this.choice1.ypos;
        this.choice1 = null;
        this.animationTask = setInterval(this.name+".animateTiles()", 1000/60);
    }

}

puzzle.prototype.clearCursor = function(){
    this.choice1 = null;
    var cursor = document.getElementById(this.id+'cursor');
    cursor.style.visibility = "hidden";
}

puzzle.prototype.stopReward = function(){
    if (this.reward != null) {
        this.reward.stop();
    }
}

// end of puzzle 'class'


