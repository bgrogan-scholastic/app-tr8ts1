// StoryImage 'class'
function StoryImage(inID, inImagePath, inSound)
{
    this._imagePath = inImagePath;
    this._id = inID;
    this._soundPath = inSound;
    this._correctFlag = false;
}


//Story Sequencing game 'class'
function StorySequenceGame(inID, inLang)
{
    this._lang = inLang;
    this._interface_l = "";
    this._listenAlt = "Listen!";
    this._imageAlt = "Image!";

	this._BOX_0_TEXT = "First";
	this._BOX_1_TEXT = "Next";
	this._BOX_2_TEXT = "Last";

	this._promptSize = "36px";

    this._beaconDanceFile = "/media/games/beacon_dance.swf";

    if (inLang) {
        this._interface_l = "bd/" + inLang +"/";
        if (inLang == 'es') {
            this._imageAlt = "Imagen";
            this._listenAlt = "Oir";
        	this._BOX_0_TEXT = "Primero";
        	this._BOX_1_TEXT = "Despu&eacute;s";
        	this._BOX_2_TEXT = "Al final";
        	this._promptSize = "32px";
            this._beaconDanceFile = "/media/games/es/beacon_dance.swf";
        }
        else {
            this._beaconDanceFile = "/media/games/en/beacon_dance.swf";
        }
    }

    this._id = inID;
    this._storyImages = new Array();
    this._storySequenceSolution = new Array();
    this._completeFlag = false;
    this._currentSequencePosition = 0;
    
    this._rewardSound = null;
    this._correctSound = null;
	this._wrongSound  = null;

	this._IDLE_BOX_BORDER_COLOR = "#999999";
	this._IDLE_BOX_BACKGROUND_COLOR = "#DFDFDF";
				
	this._BOX_0_BORDER_COLOR = "#ff9900";
	this._BOX_1_BORDER_COLOR = "#4d00cc";
	this._BOX_2_BORDER_COLOR = "#ff3300";

	this._BOX_0_BACKGROUND_COLOR = "#ffff99";
	this._BOX_1_BACKGROUND_COLOR = "#e2c9f4";
	this._BOX_2_BACKGROUND_COLOR = "#ffcc99";

	
	this._firstInstrSound = null;
	this._nextInstrSound = null;
	this._lastInstrSound = null;
	this._introSound = null;
	
		
	this._firstInstrText = "";
	this._nextInstrText = "";
	this._lastInstrText = "";	
	this._timeDelay = 3000;
}

StorySequenceGame.prototype._pageWidth = 800;


StorySequenceGame.prototype.nextSequencePosition = function()
{

	if(this._currentSequencePosition < 2)
	{
		nextBoxNum = this._currentSequencePosition + 1;
		var nextBox = document.getElementById("bx" + nextBoxNum);
		
		if(this._currentSequencePosition == 0)
		{
			nextBox.style.backgroundColor = this._BOX_1_BACKGROUND_COLOR;
			nextBox.style.borderColor = this._BOX_1_BORDER_COLOR;
		}
		else if(this._currentSequencePosition == 1)
		{
			nextBox.style.backgroundColor = this._BOX_2_BACKGROUND_COLOR;
			nextBox.style.borderColor = this._BOX_2_BORDER_COLOR;
		}

		var nextBoxText = document.getElementById("bxText" + nextBoxNum);
		nextBoxText.style.visibility = "visible";
		
		var outputHTML = document.getElementById("gameInstructions");
		outputHTML.innerHTML = this.getInstructionHTML(this._currentSequencePosition + 1);
		this.playCorrectSound();
		
		if(this._currentSequencePosition == 0)
		{
			var t=setTimeout(this._id +".playNextInstructionSound()",1000);
		}
		else if(this._currentSequencePosition == 1)
		{		
			var t=setTimeout(this._id +".playLastInstructionSound()",1000);
		}
		
		this._currentSequencePosition++;
		
	} 
	
}

StorySequenceGame.prototype.getInstructionHTML = function(instructionNumber)
{
    var outputTxt = "";

    var instrLink = "";
    var instrText = "";
    

	if(instructionNumber == 0)
	{
		instrLink = this._id +'.playFirstInstructionSound();';
		instrText = this._firstInstrText ;
	}
	else if(instructionNumber == 1)
	{
		instrLink = this._id +'.playNextInstructionSound();';
		instrText = this._nextInstrText ;

	}
	else if(instructionNumber == 2)
	{
		instrLink = this._id +'.playLastInstructionSound();';
		instrText = this._lastInstrText ;
	}
	outputTxt = '<table width="623" cellpadding="0" cellspacing="0" class="borderless">';
    outputTxt += "<tr>";
    outputTxt += '<td width="61" height="38"><div align="right"><img src="/images/spacer.gif" width="4" height="1" /><a href="javascript:' + instrLink + '" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Image37\',\'\',\'/images/btn_listen2_on.gif\',1)"><img src="/images/btn_listen2_off.gif" alt="' + this._listenAlt + '" name="Image37" width="33" height="31" border="0" align="absmiddle"></a></div></td>';
	outputTxt += '<td width="12" class="whitenav style2">&nbsp;</td>';
	outputTxt += '<td width="548" class="whitenav style2 style4">' + instrText + '</td>';
	outputTxt += '</tr>';
	outputTxt += '</table>';
												
	return outputTxt;	
}

StorySequenceGame.prototype.setWrongSound = function(inSound)
{
    this._wrongSound = inSound;
}

StorySequenceGame.prototype.setRewardSound = function(inSound)
{
    this._rewardSound = inSound;
}

StorySequenceGame.prototype.setCorrectSound = function(inSound)
{
    this._correctSound = inSound;
}

StorySequenceGame.prototype.setFirstInstrSound = function(inSound)
{
    this._firstInstrSound = inSound;
}

StorySequenceGame.prototype.setIntroSound = function(inSound)
{
    this._introSound = inSound;
}

StorySequenceGame.prototype.setNextInstrSound = function(inSound)
{
    this._nextInstrSound = inSound;
}

StorySequenceGame.prototype.setLastInstrSound = function(inSound)
{
    this._lastInstrSound = inSound;
}

StorySequenceGame.prototype.setFirstInstrText = function(inText)
{
    this._firstInstrText = inText;
}

StorySequenceGame.prototype.setNextInstrText = function(inText)
{
    this._nextInstrText = inText;
}

StorySequenceGame.prototype.setLastInstrText = function(inText)
{
    this._lastInstrText = inText;
}

StorySequenceGame.prototype.getCurrentSequencePosition = function()
{
    return this._currentSequencePosition;
}

//function to add a Story Image to the array of Story Images
StorySequenceGame.prototype.addStoryImage = function(inStoryImage) 
{
    this._storyImages.push(inStoryImage);
}

//function to add a Story Image ID to the Solution Array
StorySequenceGame.prototype.addStoryImageToSolution = function(inStoryImageID) 
{
    this._storySequenceSolution.push(inStoryImageID);
}

//function to add a Story Image ID to the Solution Array
StorySequenceGame.prototype.addStoryImageToSolutionByPosition = function(inStoryImageID, position) 
{
    this._storySequenceSolution[position] = inStoryImageID;
}

//function to randomize the order of story images
StorySequenceGame.prototype.randomizeStoryImages = function() 
{
	var tempStoryImages = new Array();
	
	for(var i = 0; i < this._storyImages.length; i++)
	{
		//generate a random number 
 		var randPosition = Math.floor(Math.random()*this._storyImages.length);
		var isIn = false;
		
		while(!isIn)
		{
			//check to see if that value is already in the second array
			if(tempStoryImages[randPosition] == null)
			{
				tempStoryImages[randPosition] = this._storyImages[i];
				isIn = true;
			}
			else
			{
				randPosition = Math.floor(Math.random()*this._storyImages.length);
			}
		}	
	}//end for
	
	this._storyImages = tempStoryImages;
	
}//end function


//function to check if the story image is in the correct sequence.
StorySequenceGame.prototype.checkAnswer = function(inStoryImageID, inSequenceBoxPosition) 
{
    	var retVal = false;
    	
	if(this._storySequenceSolution[inSequenceBoxPosition] == inStoryImageID && this._currentSequencePosition == inSequenceBoxPosition)
	{
		retVal = true;
	}		

	return retVal;
}

//function to check if the story image is in the correct sequence.
StorySequenceGame.prototype.setStoryImageCorrect = function(inStoryImageID) 
{
	var retVal = false;
	for(var i = 0; i < this._storyImages.length && !retVal; i++)
	{	
		if(this._storyImages[i]._id == inStoryImageID)
		{
			this._storyImages[i]._correctFlag = true;
			retVal = true;
		}			
	}

}

//function to check if the game is finished
StorySequenceGame.prototype.isFinished = function() 
{
    	var retVal = true;
    
	//Check to see if the 
	for(var i = 0; i < this._storyImages.length; i++)
	{
		if(!this._storyImages[i]._correctFlag)
		{
			retVal = false;
		}		
	}

	return retVal;
}
StorySequenceGame.prototype.getHTML = function()
{
	
	
	//outString = '<div id="playAgainDiv" style="position: relative; z-index:1; visibility: hidden;"><center><a href="' + document.URL + '" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'playAgainImage\',\'\',\'/images/playagain-dn.gif\',1)"><img src="/images/playagain-up.gif" border="0" name="playAgainImage" style="position: absolute; left:216px; top: 100px;" /></a></center></div>' + "\n";
	//outString = '<div id="playAgainDiv" style="position: relative; z-index:1; visibility: hidden;"></div>' + "\n";

		var outString = '<div id="playAgainDiv" style="position: relative; visibility: hidden;"></div>' + "\n";			
	
	
	outString += '<table border="0" cellpadding="0" cellspacing="0">' + "\n";
		outString += '<tr>' + "\n";			
			for(var i = 0; i < this._storyImages.length; i++)
			{
				divPadding = "";
				if(i == 0)
				{
					outString += '<td width="216">' + "\n";	
					divPadding = " margin-left:30px; padding:0;";
											
					
				}
				else if(i == 1)
				{
					outString += '<td width="185">' + "\n";
				}
				else if(i == 2)
				{
					outString += '<td width="224">' + "\n";
				}
				
					outString += '<div class="dragme" id="' + this._storyImages[i]._id + '" style="border: solid black 0px; width: 159px; height: 172px; cursor: pointer; ' + divPadding + '">' + "\n";
						outString += '<img style="position: absolute; left:0px; top: 0px; cursor: pointer;" src="/media/games/storyquiz/' + this._storyImages[i]._imagePath + '" alt="' + this._imageAlt + '" border="0" width="159" height="172"/>' + "\n";
						outString += '<img id="ear' + i +'"   style="position: absolute; left:1px; top: 99px; cursor: pointer;" src="/images/ear_ontile.gif" onMouseDown="myStorySequencingGame.playStoryImageSound(' + i + ')" onMouseOut="setOverEar(false); MM_swapImgRestore();" onMouseOver="setOverEar(true); MM_swapImage(\'earImage' + i + '\',\'\',\'/images/ear_ontile-rollover.gif\',1);" alt="' + this._listenAlt + '" name="earImage' + i + '" width="33" height="31" border="0"/>' + "\n";
						
					outString += '</div>' + "\n"; 
				outString += '</td>' + "\n";
			}	
		outString += '</tr>' + "\n";	

		//Check to see if we are in netscape.
		divWidth = "158";
		divHeight = "171";				
		if(nn6)
		{
			divWidth = "155";
			divHeight = "168";					
		}
		outString += '<tr>' + "\n";
			for(var i = 0; i < this._storyImages.length; i++)
			{
				divPadding = "";
				borderColor = this._IDLE_BOX_BORDER_COLOR ;
				backgroundColor = this._IDLE_BOX_BACKGROUND_COLOR;
				
				text = '<div id="bxText' + i + '"style="font-weight:700; font-size: ' + this._promptSize + '; margin-top:50px; visibility: hidden; font-family: Verdana, Arial, Helvetica, sans-serif;"><center>';
				if(i == 0)
				{
					outString += '<td>' + "\n";	
					divPadding = " margin-left:30px;";
					borderColor = this._BOX_0_BORDER_COLOR;;
					backgroundColor = this._BOX_0_BACKGROUND_COLOR;
					text = '<div id="bxText' + i + '"style="font-weight:700; font-size: ' + this._promptSize + '; margin-top:50px; visibility: visible; font-family: Verdana, Arial, Helvetica, sans-serif;"><center>';
					text += this._BOX_0_TEXT;
				}
				else if(i == 1)
				{
					outString += '<td>' + "\n";
					text += this._BOX_1_TEXT;
				}
				else if(i == 2)
				{
					outString += '<td>' + "\n";
					text += this._BOX_2_TEXT;
				}
				text += "</center></div>";
				outString += '<div id="bx' + i + '" style="width:' + divWidth + 'px; height:' + divHeight + 'px; border: solid ' + borderColor + ' 2px; background-color: ' + backgroundColor + ';' + divPadding + ' margin-top:10px;">' + text + '</div>' + "\n";
				outString += '</td>' + "\n";
			}		

		outString += '</tr>' + "\n";	
	outString += '</table>' + "\n";
	
		
		
	if (this._rewardSound) 
	{
		outString += this._rewardSound.getHTML();
	}
	
	if (this._wrongSound) 
	{
		outString += this._wrongSound.getHTML();
	}
	
	if (this._correctSound) 
	{
		outString += this._correctSound.getHTML();
	}

	if (this._firstInstrSound) 
	{
		outString += this._firstInstrSound.getHTML();
	}

	if (this._nextInstrSound) 
	{
		outString += this._nextInstrSound.getHTML();
	}	

	if (this._lastInstrSound) 
	{
		outString += this._lastInstrSound.getHTML();
	}
	
	if (this._introSound) 
	{
		outString += this._introSound.getHTML();
	}		
	
	for(var i = 0; i < this._storyImages.length; i++)
	{	
		if (this._storyImages[i]._soundPath) 
		{	
			outString += this._storyImages[i]._soundPath.getHTML();
		}
	}
	//outString += '<div id="'+this._id+'Promptsound"></div>' + "\n";
		
		return outString;
}

StorySequenceGame.prototype._finishGame = function()
{

		var playAgainString = "";
		playAgainString = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="240" height="125" id="visualReward" align="middle" style="position: absolute; left:180px; top: 10px;">'+"\n";
		playAgainString += '<param name="allowScriptAccess" value="always" />'+"\n";
		playAgainString += '<param name="movie" value="' + this._beaconDanceFile + '" />' + "\n";
		playAgainString += '<param name="quality" value="high" />' + "\n";
		playAgainString += '<param name="bgcolor" value="#FFFFFF" />' + "\n";
		playAgainString += '<param name="wmode" value="transparent"> ' + "\n";
		playAgainString += '<embed src="' + this._beaconDanceFile + '" quality="high" bgcolor="#FFFFFF" width="240" height="125" name="visualReward" align="middle" allowScriptAccess="always" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>' + "\n";
		playAgainString += '</object>' + "\n";
		
		var outString = '<center><a href="' + document.URL + '"><img src="/images/spacer.gif" width="240" height="125" style="z-index:99; position: absolute; left:180px; top: 10px; border:0;"/></a>' + playAgainString + '</center>' + "\n";
		var e = document.getElementById("playAgainDiv");
		e.innerHTML = outString;
		e.style.visibility="visible";
	
	var e = document.getElementById("gameInstructions");
	e.style.visibility="hidden";

	this._stopSounds();
    /**
	if (this._rewardSound) {
        this._rewardSound.play();
    }
    */
}

StorySequenceGame.prototype._stopSounds = function()
{
	
    if (this._wrongSound) 
    {
        this._wrongSound.stop();
    }
    
    if (this._correctSound) 
    {
        this._correctSound.stop();
    }
    
    if (this._rewardSound) 
    {
        this._rewardSound.stop();
    }
    
	if (this._firstInstrSound) 
	{
	    this._firstInstrSound.stop();
	}
	
	if (this._nextInstrSound) 
	{
	    this._nextInstrSound.stop();
	}
	
	if (this._lastInstrSound) 
	{
	    this._lastInstrSound.stop();
	}
	
	if (this._introSound) 
	{
	    this._introSound.stop();
	}	

	for(var i = 0; i < this._storyImages.length; i++)
	{		
		if (this._storyImages[i]._soundPath) 
		{
		    this._storyImages[i]._soundPath.stop();
		}		
	}
}

StorySequenceGame.prototype.playCorrectSound = function()
{

	this._stopSounds();
	if (this._correctSound) 
	{
	    this._correctSound.play();
	}
}

StorySequenceGame.prototype.playWrongSound = function()
{

	this._stopSounds();
	if (this._wrongSound) 
	{
	    this._wrongSound.play();
	}
}

StorySequenceGame.prototype.playFirstInstructionSoundFirstTime = function(inID, inStatus)
{
	if (inStatus == 'done') 
	{
		this._stopSounds();
		if (this._firstInstrSound) 
		{
	    	this._firstInstrSound.play();
		}
	}
}

StorySequenceGame.prototype.playFirstInstructionSound = function()
{
		this._stopSounds();
		if (this._firstInstrSound) 
		{
	    	this._firstInstrSound.play();
		}	
}


StorySequenceGame.prototype.playIntroTitleSound = function()
{
	if (this._introSound) 
	{
		var counterForLoop = 0;
		while(this._introSound.getStatus() != "ready" && counterForLoop <  this._timeDelay)
		{
			//wait
			counterForLoop++;
		}
		
		if(counterForLoop < this._timeDelay)
		{
			this._introSound.play();
		}
    }
}

StorySequenceGame.prototype.playNextInstructionSound = function()
{

	this._stopSounds();
	if (this._nextInstrSound) 
	{
	    this._nextInstrSound.play();
	}
}

StorySequenceGame.prototype.playLastInstructionSound = function()
{

	this._stopSounds();
	if (this._lastInstrSound) 
	{
	    this._lastInstrSound.play();
	}
}

StorySequenceGame.prototype.playStoryImageSound = function(position)
{
	this._stopSounds();
	if (this._storyImages[position]._soundPath) 
	{
	    this._storyImages[position]._soundPath.play();
	}
}

function movemouse(e)
{
  if (isdrag)
  {
    dobj.style.left = nn6 ? tx + e.clientX - x : tx + event.clientX - x;
    dobj.style.top  = nn6 ? ty + e.clientY - y : ty + event.clientY - y;
    return false;
  }
}

function selectmouse(e)
{
  var fobj       = nn6 ? e.target : event.srcElement;
  var topelement = nn6 ? "HTML" : "BODY";

  while (fobj.tagName != topelement && fobj.className != "dragme")
  {
    fobj = nn6 ? fobj.parentNode : fobj.parentElement;
  }

  if (fobj.className=="dragme" && overEar == false	)
  {
    isdrag = true;
    dobj = fobj;
    tx = parseInt(dobj.style.left+0);
    ty = parseInt(dobj.style.top+0);
    x = nn6 ? e.clientX : event.clientX;
    y = nn6 ? e.clientY : event.clientY;
    startX = getX(dobj);
    startY = getY(dobj);
    document.onmousemove=movemouse;
    return false;
  }
}

function MouseUP(e)
{
	if (isdrag)
	{
		x = nn6 ? e.pageX : event.clientX;
		y = nn6 ? e.pageY : event.clientY;
		
		//alert(x + " ," + y);
	
		if (nn6) 
		{
			x = e.clientX + window.scrollX;
			y = e.clientY + window.scrollY;
		}		
		else
		{
			x = window.event.clientX + document.documentElement.scrollLeft
			+ document.body.scrollLeft;
			y = window.event.clientY + document.documentElement.scrollTop
			+ document.body.scrollTop;
		}
      //alert(x + " ," + y);
		var isCorrect = false;
		var elem = document.getElementById("bx" + myStorySequencingGame.getCurrentSequencePosition());
		var boxX = getX(elem);
		var boxY = getY(elem);
		
		/**
			var text = "";
			text += ":::Box "+ i +":::\n";

			text += "Client Width =" + elem.clientWidth + "\n";
			text += "Client Height =" + elem.clientHeight + "\n";

			text += x + ">=" + boxX + "\n";

			var sum = boxX + elem.clientWidth;
			text += x + "<=" + sum + "\n";

			text += y + ">=" + boxY + "\n";

			var sum = boxY + elem.clientHeight;
			text += y + "<=" + sum + "\n\n";
		*/

		if(x >= boxX && x <= (boxX + elem.clientWidth) && y >= boxY && y <= (boxY + elem.clientHeight) )
		{

			//Check Answer
			if(myStorySequencingGame.checkAnswer(dobj.id, myStorySequencingGame.getCurrentSequencePosition()))
			{
				dobj.style.left = boxX - startX;
				dobj.style.top  = boxY - startY;
				dobj.className = "dontdragme";
				dobj.style.cursor = "default";

				myStorySequencingGame.setStoryImageCorrect(dobj.id);
				myStorySequencingGame.nextSequencePosition();
				isCorrect = true;
				
				if(myStorySequencingGame.isFinished())
				{
					myStorySequencingGame._finishGame();
				}
			}
			else
			{
				myStorySequencingGame.playWrongSound();
			}
		}
		
		if(!isCorrect)
		{
			dobj.style.left = 0;
			dobj.style.top  = 0;
		}

		isdrag=false;
	}

}

function getY( oElement )
{
	var iReturnValue = 0;
	while( oElement != null )
	{
		iReturnValue += oElement.offsetTop;
		oElement = oElement.offsetParent;
	}
	return iReturnValue;
}

function getX( oElement )
{
	var iReturnValue = 0;
	while( oElement != null )
	{
		iReturnValue += oElement.offsetLeft;
		oElement = oElement.offsetParent;
	}
	return iReturnValue;
}

function setOverEar(value)
{
	overEar = value;
}
