// Term 'class'
function Term(inText, inTextNarration, inNarration, inDefText, inDefNarration){
    this._text = inText;
    this._textNarration = inTextNarration;
    this._narration = inNarration;
    this._defText = inDefText;
    this._defNarration = inDefNarration;
    this.fileBase = inText.replace(" ", "");
}


// Word Match game 'class'
function WordMatchGame(inID, inX, inY, inLang){

    this._lang = inLang;
    this._interface_l = "";
    this._listenAlt = "Listen!";
    this._beaconDanceFile = "/media/games/beacon_dance.swf";

    if (inLang) {
        this._interface_l = "bd/" + inLang +"/";
        if (inLang == 'es') {
            this._listenAlt = "Oir";
            this._beaconDanceFile = "/media/games/es/beacon_dance.swf";
        }
        else {
            this._beaconDanceFile = "/media/games/en/beacon_dance.swf";
        }
    }

    this._id = inID;
    this._xbase = inX;
    this._xpos = inX;
    this._ypos = inY;
    this._rewardImage = null;
    this._correctSound = null;
    this._wrongSound = null;
    this._promptSound = null;
    this._insSound = null;
	this._clueSound = null;
	this._insSoundFirstTime = null;
	this._clueSoundFirstTime = null;
	this._termSounds = new Array(null, null, null, null, null, null);
    this._terms = new Array(null, null, null, null, null, null);
    this._asked = new Array(0, 0, 0, 0, 0, 0);
    this._questionNumber = 0;
    this._termNum;
    this._completeFlag = false;
    this._tatimeout = null;
    this._tilecolors = new Array('#66CCFF', '#FF9933', '#FFFF66', '#99FF99', '#99CC00', '#FF99FF');    
    this._timeDelay = 3000;
}

WordMatchGame.prototype._pageWidth = 800;

WordMatchGame.prototype.setRewardImage = function(inImage){
    this._rewardImage = inImage;
}

WordMatchGame.prototype.setCorrectSound = function(inSound){
    this._correctSound = inSound;
}

WordMatchGame.prototype.setWrongSound = function(inSound){
    this._wrongSound = inSound;
}

WordMatchGame.prototype.addTerm = function(inTerm) {
// Insert the term into a random empty slot.
    var tileNum = Math.floor(Math.random()*6);
    while (this._terms[tileNum] != null) {
        tileNum = Math.floor(Math.random()*6);
    }
    this._terms[tileNum] = inTerm;
    
	var termSound = new GI_Sound(this._id + 'Termsound' + tileNum, '/media/games/wordmatch/' + this._terms[tileNum]._textNarration);
	document.getElementById(this._id + 'Termsound' + tileNum).innerHTML = termSound.getHTML();    
    this.addTermSound( termSound , tileNum);

}

WordMatchGame.prototype.addTermSound = function(inTermSound, inPosition)
{
	this._termSounds[inPosition] = inTermSound;
}

WordMatchGame.prototype.getHTML = function(){

    outString = "";
    styleHeight = "";

    outString = '<center><div id="' + this._id + 'PromptDiv"></div></center>' + "\n";

    outString += '<div id="' + this._id + 'tryagain" style="position: absolute; left: '+(this._xpos + 150)+'px; top: '+(this._ypos + 60)+'px; z-index: 1000; visibility: hidden; background: white; border-style: solid;"><h1>Please Try Again!</h1></div>'+"\n";
	
    outString += '<img id="' + this._id + 'Reward" style="position: absolute; left: ' + this._xpos + 'px; top: ' + this._ypos + 'px; z-index: 1; visibility: hidden;" src="' + this._rewardImage + '" />' + "\n";

    outString += '<TABLE id="' + this._id + 'Board" BORDER="0" CELLSPACING="0" CELLPADDING="0" WIDTH="542px" HEIGHT="265px" style="position: absolute; left: ' + this._xpos + 'px; top: ' + this._ypos + 'px; z-index: 1; visibility: hidden;">' + "\n";
    
    for (var tileNum=0; tileNum<6; tileNum++) 
    {
		if (tileNum%2 == 0)
		{
		  outString += '<TR>' + "\n"; 	
		}
		
		textfortile = this._terms[tileNum]._text;
			
		//table cell font HTML.
		fontSizeHTML = '';
		
		//table cell font. if fontSize is 0 then we use default size(36px);
		fontSize = 36;
	
		//CREATE TEMP ELEMENTS TO GET THE WIDTH OF A WORD.
		var h = document.getElementsByTagName("BODY")[0];
		var d = document.createElement("DIV");
		var s = document.createElement("SPAN");
		
		//SPLIT TERM BY SPACES
		var wordsArray = textfortile.split(" ");
		
		//LOOP through the words
		for(i = 0; i < wordsArray.length; i++)
		{
			var defaultWidth = 275;
			//LOOP through the words
			while(defaultWidth > 270 && fontSize != 0)
			{
				d.appendChild(s);
				d.style.fontFamily = "Verdana";
				s.style.fontFamily = "Verdana";
				s.style.fontSize   = fontSize + "px";
				s.style.fontWeight   = "700";
				s.innerHTML = wordsArray[i];	
				h.appendChild(d);
				defaultWidth = s.offsetWidth;
				h.removeChild(d);
				//Check to see if we are greater than the table cell
				if(defaultWidth > 270)
				{				
					//if so lower the font size
					fontSize--;
				}			
			}	
		}
		
		if(fontSize < 36)
		{
			fontSizeHTML = "font-size:" + fontSize + "px;";
		}
		
		outString += '<TD id="' + this._id + "tile" + tileNum + '" onMouseOut="' + this._id + '._stopTermSound(' + tileNum + ')" onMouseOver="' + this._id + '.playTermSound(' + tileNum + ')" onClick="' + this._id + '.tileClicked(\'' + tileNum + '\')"  style="background-color:' + this._tilecolors[tileNum] + '; ' + fontSizeHTML +'">' + textfortile + '</TD>' + "\n";    	
    	
		if (tileNum%2)
		{
		  outString += '</TR>' + "\n"; 	
		}       
    }
	
    outString += '</TABLE>' + "\n";

    return outString;
}

//this function creates the sound objects
WordMatchGame.prototype.createSounds = function() 
{
    this._insSound = new GI_Sound(this._id + 'Inssound', '/sounds/games/' + this._interface_l + 'WM_instruction.mp3');
    document.getElementById(this._id + 'Inssound').innerHTML = this._insSound.getHTML();
    
    this._clueSound = new GI_Sound(this._id + 'ClueSound', '/sounds/games/' + this._interface_l + 'WM_Clue.mp3', false, this._id + ".playPrompt");
    document.getElementById(this._id + 'ClueSound').innerHTML = this._clueSound.getHTML();

    this._insSoundFirstTime = new GI_Sound(this._id + 'insSoundFirstTime', '/sounds/games/' + this._interface_l + 'WM_instruction.mp3', false, this._id + ".playClueFirstTime");
    document.getElementById(this._id + 'insSoundFirstTime').innerHTML = this._insSoundFirstTime.getHTML();    

    this._clueSoundFirstTime = new GI_Sound(this._id + 'clueSoundFirstTime', '/sounds/games/' + this._interface_l + 'WM_Clue.mp3', false, this._id + ".playPrompt");
    document.getElementById(this._id + 'clueSoundFirstTime').innerHTML = this._clueSoundFirstTime.getHTML();
}

//this function gets the next question
WordMatchGame.prototype.soundHTML = function() 
{
	var outString = "";

	if(this._correctSound)
	{	
		outString += this._correctSound.getHTML();
	}

	if(this._wrongSound)
	{
		outString += this._wrongSound.getHTML();
	}	
	
	outString += '<div id="'+this._id+'Promptsound"></div>' + "\n";
	outString += '<div id="'+this._id+'Termsound"></div>' + "\n";
	outString += '<div id="'+this._id+'Inssound"></div>' + "\n";
	outString += '<div id="'+this._id+'ClueSound"></div>' + "\n";
	outString += '<div id="'+this._id+'insSoundFirstTime"></div>' + "\n";
	outString += '<div id="'+this._id+'clueSoundFirstTime"></div>' + "\n";
	
	outString += '<div id="'+this._id+'Termsound'+'0"></div>' + "\n";
	outString += '<div id="'+this._id+'Termsound'+'1"></div>' + "\n";
	outString += '<div id="'+this._id+'Termsound'+'2"></div>' + "\n";
	outString += '<div id="'+this._id+'Termsound'+'3"></div>' + "\n";
	outString += '<div id="'+this._id+'Termsound'+'4"></div>' + "\n";
	outString += '<div id="'+this._id+'Termsound'+'5"></div>' + "\n";	
	
		
	return outString;
}//end function

WordMatchGame.prototype.setPromptHTML = function(inElementID){
    // 5/22/2007 - badly kludged to work around a ghastly Safari defect
    
    var e = document.getElementById('WordMatchGamepcell');
    if (e) {
        e.innerHTML = '<a href="javascript:'+this._id+'.playClue();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Image40\',\'\',\'/images/btn_listen2_on.gif\',1)" style="padding-left:10px;"><img src="/images/btn_listen2_off.gif" alt="' + this._listenAlt + '" name="Image40" width="42" height="40" border="0"></a>';
    }
}

WordMatchGame.prototype.center = function(){
    this._repositionElements( (((getWindowSize('width')-this._pageWidth)/2)+this._xbase) ,this._ypos);
}

WordMatchGame.prototype._repositionElements = function(newX, newY){

	if (newX == this._xpos && newY == this._ypos) 
	{
	    var e=document.getElementById(this._id+'Reward');
			if(e.style.visibility == "hidden")
			{
	    		e.style.visibility = "visible";
			}
		var e=document.getElementById(this._id+'Board');
			if(e.style.visibility == "hidden")
			{
	    		e.style.visibility = "visible";
			}		
        return;
    }
    
    this._xpos = newX;
    this._ypos = newY;

    // move the reward image
    var e=document.getElementById(this._id+'Reward');
    e.style.left = this._xpos+'px';
    e.style.top = this._ypos+'px';
    

    // move the tiles
    var e=document.getElementById(this._id+'Board');
    e.style.left = this._xpos+'px';
    e.style.top = this._ypos+'px';    

    // move the 'try again' response
    e = document.getElementById(this._id+'tryagain');
    e.style.left = (this._xpos + 150)+'px';
    e.style.top = (this._ypos + 60)+'px';
	
}

WordMatchGame.prototype.nextQuestion = function()
{
    if (this._questionNumber >= 6) 
    {
        this._finishGame();
        return;
    }
    
	if (this._correctSound && this._questionNumber < 6 && this._questionNumber > 0) 
	{
		this._promptSound = 0;
		this._correctSound.play();
	}

    this._questionNumber += 1;

    // Choose a random term
    this._termNum = Math.floor(Math.random()*6);
    while (this._asked[this._termNum] != 0) {
        this._termNum = Math.floor(Math.random()*6);
    }

    this._asked[this._termNum] = 1;

    var promptString = this._terms[this._termNum]._defText;

    // Safari bug kludge
    var e = document.getElementById('WordMatchGamePrompt');
    e.innerHTML = promptString;

    this._promptSound = new GI_Sound(this._id + 'Promptsound', '/media/games/wordmatch/' + this._terms[this._termNum]._defNarration);
  	document.getElementById(this._id + 'Promptsound').innerHTML = this._promptSound.getHTML();
  	  	
  	//this.playPrompt();
}

WordMatchGame.prototype._hideElement = function(inElementID){
    var e = document.getElementById(inElementID);
    if (e) {
        e.style.visibility = 'hidden';
    }
}

WordMatchGame.prototype._hideTryAgain = function(){
    this._hideElement(this._id+"tryagain");
    clearTimeout(this._tatimeout);
    this._tatimeout = null;
}

WordMatchGame.prototype._showElement = function(inElementID){
    var e = document.getElementById(inElementID);
    if (e) {
        e.style.visibility = 'visible';
    }
}

WordMatchGame.prototype._finishGame = function(){
    this._completeFlag = true;
    
    		var playAgainString = "";
		playAgainString = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="210" height="105" id="visualReward" align="middle" style="position: absolute; left:210px; top: 0px;">'+"\n";
		playAgainString += '<param name="allowScriptAccess" value="always" />'+"\n";
		playAgainString += '<param name="movie" value="' + this._beaconDanceFile + '" />' + "\n";
		playAgainString += '<param name="quality" value="high" />' + "\n";
		playAgainString += '<param name="bgcolor" value="#FFFFFF" />' + "\n";
		playAgainString += '<param name="wmode" value="transparent"> ' + "\n";
		playAgainString += '<embed src="' + this._beaconDanceFile + '" quality="high" bgcolor="#FFFFFF" width="210" height="105" name="visualReward" align="middle" allowScriptAccess="always" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>' + "\n";
		playAgainString += '</object>' + "\n";
		
		var outString = '<center><a href="' + document.URL + '"><img src="/images/spacer.gif" width="110" height="105" style="border: solid black 1px; z-index:99; position: absolute; left:250px; top: 0px; border:0;"/></a>' + playAgainString + "</center>\n";
		var e = document.getElementById("playAgainDiv");
		e.innerHTML = '';
		e.style.width = '';
		e.innerHTML = outString;
		e.style.visibility="visible";

		e = document.getElementById('WordMatchGamepcell');
	    e.innerHTML = '';
	    e.style.width = '';
	    
	    e = document.getElementById('WordMatchGameccell');
	    e.innerHTML = '';
	    e.style.width = '';
	
	    e = document.getElementById('icell');
	    e.innerHTML = '';
	    e.style.width = '';
	    
	    e = document.getElementById('incell');
	    e.innerHTML = '';
	    e.style.width = '';
	    
	    e = document.getElementById('WordMatchGamePrompt');
	    e.innerHTML = '';
	    e.style.width = '';
}

WordMatchGame.prototype._stopTermSound = function(inPosition)
{
		this._termSounds[inPosition].stop();
}

WordMatchGame.prototype._stopSounds = function(){

	if (this._wrongSound) 
    {
        this._wrongSound.stop();
    }
    if (this._correctSound) 
    {
        this._correctSound.stop();
    }

    if (this._insSound) 
	{
        this._insSound.stop();
    }
	if (this._clueSound) 
	{
		this._clueSound.stop();
	}    
	 
	if (this._promptSound) 
    {
        this._promptSound.stop();
    }	
  
    if (this._insSoundFirstTime) 
	{
        this._insSoundFirstTime.stop();
    }
   
	if (this._clueSoundFirstTime) 
	{
		this._clueSoundFirstTime.stop();
	}
	
	for(var i=0; i < this._termSounds.length; i++) 
	{
		this._termSounds[i].stop();
	}
	
}

WordMatchGame.prototype.playTermSound = function(inPosition)
{
	
    this._stopSounds();
	if (this._termSounds[inPosition]) 
	{
        this._termSounds[inPosition].play();
    }
    
}

WordMatchGame.prototype.playIns = function(){
    this._stopSounds();
	if (this._insSound) 
	{
        this._insSound.play();
    }
}

//Function to play the Fact or Fiction Sound
WordMatchGame.prototype.playClue = function()
{
	this._stopSounds();
	if (this._clueSound) 
	{
		this._clueSound.play();
	}
}

WordMatchGame.prototype.playPrompt = function(inID, inStatus)
{
   	if (inStatus == 'done') 
	{ 
		if (this._promptSound) 
	    {
	        this._promptSound.play();
	    }
	}
}

//Function to play the instruction on load
WordMatchGame.prototype.playInsFirstTime = function()
{
    //this._stopSounds();

	if (this._insSoundFirstTime) 
	{
		var counterForLoop = 0;
		while(this._insSoundFirstTime.getStatus() != "ready" && counterForLoop <  this._timeDelay)
		{
			//wait
			//alert(this._insSoundFirstTime.getStatus() + ' , ' + counterForLoop);
			counterForLoop++;
		}
		
		if(counterForLoop < this._timeDelay)
		{
			this._insSoundFirstTime.play();
		}
    }
}

//Function to play the Fact or Fiction Sound after the instruction
WordMatchGame.prototype.playClueFirstTime = function(inID, inStatus)
{
	if (inStatus == 'done') 
	{
		this._stopSounds();
		if (this._clueSoundFirstTime) 
		{
			this._clueSoundFirstTime.play();
		}
	}
}

WordMatchGame.prototype.tileClicked = function(inTileNum){
    if (this._completeFlag) {
        return;
    }

    this._hideElement(this._id+'tryagain');

    this._stopSounds();

    if (inTileNum == this._termNum) 
    {
        this._showElement(this._id+'Reward');
        this._hideElement(this._id+'tile'+inTileNum);
        this.nextQuestion();
    }
    else {
        clearTimeout(this._tatimeout);
        //this._showElement(this._id+'tryagain');
        if (this._wrongSound) {
            this._wrongSound.play();
        }
        this._tatimeout = setTimeout(this._id+"._hideTryAgain()", 5000);
    }
}
