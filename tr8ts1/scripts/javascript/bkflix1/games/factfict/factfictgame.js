// Question Function
//This function holds the information for a specific question
function Question(inStatement, inNarration, inTruthiness){
	
    this._statement = inStatement;
    this._narration = inNarration;
	this._truthiness = inTruthiness;

}

//Fact or Fiction Game 'class'
function FactFictGame(inID, inX, inY, factImg, factCredit, fictionImg, fictionCredit, inLang){

    this._lang = inLang;
    this._interface_l = "";
    this._listenAlt = "Listen!";

    this._ffPrompt = "Fact or Fiction";

    this._prompt1 = "Read the sentence below.  Is it fact or fiction?";
    this._prompt2 = "Click on a button to give your answer.";

    this._factAlt = "Fact";
    this._fictionAlt = "Fiction";

    this._hintHTML = '<td><img src="/images/spacer.gif" width="10" height="1" /><a href="javascript:'+inID+'.playHint();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'hint1\',\'\',\'/images/btn_hint_over.gif\',1)"><img src="/images/btn_hint_on.gif" alt="Hint" name="hint1" width="62" height="78" border="0"></a></td>' + "\n";

    this._beaconDanceFile = "/media/games/beacon_dance.swf";
    this._niceWorkFile = "/media/games/factfict/nice_work.swf";
    this._oopsFile = "/media/games/factfict/oops.swf";


    if (inLang) {
        this._interface_l = "bd/" + inLang +"/";
        this._hintHTML = '<td><img src="/images/spacer.gif" width="10" height="1" /><img src="/images/spacer.gif" width="62" height="78" border="0"></td>' + "\n";
        if (inLang == 'es') {
            this._listenAlt = "Oir";

            this._ffPrompt = "Real o inventado";

            this._prompt1 = "Oye la oraci&oacute;n.  &iquest;Dice algo real o inventado?";
            this._prompt2 = "Aprieta el bot&oacute;n de tu respuesta.";

            this._factAlt = "Real";
            this._fictionAlt = "Inventado";

            this._beaconDanceFile = "/media/games/es/beacon_dance.swf";
            this._niceWorkFile = "/media/games/factfict/es/nice_work.swf";
            this._oopsFile = "/media/games/factfict/es/oops.swf";
        }
        else {
            this._ffPrompt = "Real or Make Believe";
            this._prompt1 = "Listen to the sentence below.  Is it real or make believe?";

            this._factAlt = "Real";
            this._fictionAlt = "Make Believe";

            this._beaconDanceFile = "/media/games/en/beacon_dance.swf";
            this._niceWorkFile = "/media/games/factfict/en/nice_work.swf";
            this._oopsFile = "/media/games/factfict/en/oops.swf";
        }
    }

	this._id = inID;
    this._xbase = inX;
    this._xpos = inX;
    this._ypos = inY;
    this._questionsTemp = new Array();
    this._questions = new Array();
    this._asked = new Array();
    this._questionNumber = -1;
    this._quesNum;
    this._completeFlag = false;
    this._tatimeout = null;
    this._factIMG = factImg
    this._factCredit = factCredit
    this._fictionIMG = fictionImg
    this._fictionCredit = fictionCredit  
    this._rewardSound = null;
    this._correctSound = null;       
	this._wrongSound = null;
	this._promptSound = null;
	this._insSound = null;
	this._hintSound = null;
	this._insSoundFirstTime = null;
    this._FoFSound = null;
    this._FoFSoundFirstTime = null;
    this._CorrectFlashMovieID = null;
    this._timeDelay = 3000;
    
}//end function

//set the reward sound
FactFictGame.prototype.setRewardSound = function(inSound) {
	
	this._rewardSound = inSound;

	
	
}//end function

//set the wrong sound
FactFictGame.prototype.setWrongSound = function(inSound) {
	
	this._wrongSound = inSound;
	
}//end function


//set the correct sound
FactFictGame.prototype.setCorrectSound = function(inSound) {
	
	this._correctSound = inSound;

	
	
}//end function

//function to add a question to the array of questions
FactFictGame.prototype.addQuestion = function(inQuestion) {


    this._questionsTemp.push(inQuestion);

}

//function to randomize the order of questions
FactFictGame.prototype.randomizeQuestions = function() {

	var isIn = false;
	
	//while the length of the real array does not equal the length of the temp array
	while(this._questionsTemp.length != this._questions.length){

		//generate a random number 
 		var tileNum = Math.floor(Math.random()*this._questionsTemp.length);

 		isIn = false;
 		
 		//grab the value of that spot in the temp array
 		var theValue = this._questionsTemp[tileNum];
 		
 		//check to see if that value is already in the second array
 		
 		//go through the second array
 		for(var i = 0; i<this._questions.length; i++){
 			if(this._questions[i] == theValue){
 			
 				isIn = true;
 			
 			}//end if
 		}//end for
 		
 		//if the value we randomly picked it not already in the array then add it to it
 		if(isIn == false)
 		{
 			this._questions.push(theValue);
 		}//end if
	}//end while
}//end function

//function to finish the game
FactFictGame.prototype.finishGame = function() 
{
   		
		var playAgainString = "";
		playAgainString = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="210" height="105" id="visualReward" align="middle" style="position: absolute; left:210px; top: 125px;">'+"\n";
		playAgainString += '<param name="allowScriptAccess" value="always" />'+"\n";
		playAgainString += '<param name="movie" value="' + this._beaconDanceFile + '" />' + "\n";
		playAgainString += '<param name="quality" value="high" />' + "\n";
		playAgainString += '<param name="bgcolor" value="#FFFFFF" />' + "\n";
		playAgainString += '<param name="wmode" value="transparent"> ' + "\n";
		playAgainString += '<embed src="' + this._beaconDanceFile + '" quality="high" bgcolor="#FFFFFF" width="210" height="105" name="visualReward" align="middle" allowScriptAccess="always" wmode="transparent" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"/>' + "\n";
		playAgainString += '</object>' + "\n";
		
		var outString = '<center><a href="' + document.URL + '"><img src="/images/spacer.gif" width="110" height="105" style="border: solid black 1px; z-index:99; position: absolute; left:250px; top: 125px; border:0;"/></a>' + playAgainString + "</center>\n";
		
		var e = document.getElementById("gameDiv");
		e.innerHTML = "";
			
		var e = document.getElementById("playAgainDiv");
		e.innerHTML = outString;
		e.style.visibility="visible";
		
}//end function

FactFictGame.prototype.nextQuestion = function() {
	
	var displayCorrectResponse = false;
	//check to see if we have reached the end of the questions
	
	if(this._questionNumber >= this._questions.length-1){
		
		//if we have then finish the game
		this.finishGame();
		return;
		
	}//end if
	
	if(this._correctSound && (this._questionNumber < (this._questions.length-1)) && this._questionNumber > -1)
	{
		displayCorrectResponse = true;	
	}//end if
	//add 1 to the question number we're on
	this._questionNumber += 1;	

	//call the function that displays the question to the screen
	var theHtml = this.displayQuestion();
	
	//set the results to the game div (display the results on the screen)
	var f = document.getElementById("FoFClue");
	f.innerHTML = theHtml;
	
	
	
	if(displayCorrectResponse )
	{
		
		//this._correctSound.play();
		var outString = "";
		outString = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="226" height="110" id="visualResponse" align="middle">'+"\n";
		outString += '<param name="allowScriptAccess" value="always" />'+"\n";
		outString += '<param name="movie" value="' + this._niceWorkFile + '" />' + "\n";
		outString += '<param name="quality" value="high" />' + "\n";
		outString += '<param name="bgcolor" value="#FFFFFF" />' + "\n";
		outString += '<embed src="' + this._niceWorkFile + '" quality="high" bgcolor="#FFFFFF" width="226" height="110" name="visualResponse" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />' + "\n";
		outString += '</object>' + "\n";	
		var e = document.getElementById('visualResponseID');
		e.innerHTML = outString;	

		this._CorrectFlashMovieID = setInterval(this._id + '.checkMovieStatus()', 250);		
	}
		
	this._promptSound = new GI_Sound(this._id + 'Promptsound', '/media/games/factfict/' + this._questions[this._questionNumber]._narration);
    document.getElementById(this._id + 'Promptsound').innerHTML = this._promptSound.getHTML();  
    
}//end function

FactFictGame.prototype.getFlashMovieObject = function(inMovieName)
{
	var retVal = "";

	var isIE = navigator.appName.indexOf("Microsoft") != -1;
    retVal = (isIE) ? window[inMovieName] : document[inMovieName];

	if(retVal)
	{
		return retVal;
	}
	else
	{
		alert('Can\'t find the Flash movie');
	}
}

FactFictGame.prototype.getMovieStatus = function(inMovieName) 
{
	return eval(this._id + '.getFlashMovieObject(inMovieName).IsPlaying()');
}

FactFictGame.prototype.checkMovieStatus = function() 
{
	if(eval(this._id + '.getMovieStatus("visualResponse") == false'))
	{
		clearInterval(this._CorrectFlashMovieID );
		eval(this._id + '.playFoF()');
	    //alert("getMovieStatus = " + eval(this._id + '.getMovieStatus("visualResponse")'));
	}
}

//function to stop all sounds playing
FactFictGame.prototype.stopSounds = function() {
	
	if(this._wrongSound)
	{
		this._wrongSound.stop();
	}
	
	if(this._correctSound)
	{
		this._correctSound.stop();
	}
	if(this._rewardSound)
	{
		this._rewardSound.stop();
	}		

	if(this._promptSound)
	{
		this._promptSound.stop();
	}
	
	if(this._insSound)
	{
		this._insSound.stop();
	}
	
	if(this._hintSound)
	{
		this._hintSound.stop();
	}
	
	if (this._FoFSound) 
	{			
		this._FoFSound.stop();
	}
	
	if (this._FoFSoundFirstTime) 
	{			
		this._FoFSoundFirstTime.stop();
	}
		
	if (this._insSoundFirstTime) 
	{
        this._insSoundFirstTime.stop();
    }
    
}//end function

FactFictGame.prototype.playIns = function(){
    this.stopSounds();
	if (this._insSound) {
        this._insSound.play();
    }
}

//Function to play the Fact or Fiction Sound
FactFictGame.prototype.playFoF = function(inID, inStatus)
{
	this.stopSounds();
	if (this._FoFSound) 
	{
		this._FoFSound.play();
	}
}

FactFictGame.prototype.playPrompt = function(inID, inStatus)
{

	if (inStatus == 'done') 
	{
		this.stopSounds();
    	if (this._promptSound) 
    	{
	        this._promptSound.play();
    	}
	}
}

FactFictGame.prototype.playHint = function()
{
    this.stopSounds();
	if (this._hintSound) 
	{
        this._hintSound.play();
    }
}

//Function to play the instruction on load
FactFictGame.prototype.playInsFirstTime = function(){
    //this.stopSounds();
	if (this._insSoundFirstTime) 
	{
		var counterForLoop = 0;
		while(this._insSoundFirstTime.getStatus() != "ready" && counterForLoop <  this._timeDelay)
		{
			//wait
			counterForLoop++;
		}
		
		if(counterForLoop < this._timeDelay)
		{
			this._insSoundFirstTime.play();
		}
    }
}

//Function to play the Fact or Fiction Sound after the instruction
FactFictGame.prototype.playFoFFirstTime = function(inID, inStatus)
{
	if (inStatus == 'done') 
	{
		this.stopSounds();
		if (this._FoFSoundFirstTime) 
		{
			this._FoFSoundFirstTime.play();
		}
	}
}

//function to check to see if the user clicked on the correct anwser
FactFictGame.prototype.checkAnwser = function(anwserGuessed) {
	
	this.stopSounds();
	clearInterval(this._CorrectFlashMovieID );

	//if the user anwsered correctly....
	if(anwserGuessed == this._questions[this._questionNumber]._truthiness)
	{
		this.nextQuestion();	


		
	//if the user was incorrect...	
	}
	else
	{	
		/**
		if(this._wrongSound)
		{
			this._wrongSound.play();
		}//end if
		*/
		var outString = "";
		outString = '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0" width="226" height="110" id="visualResponse2" align="middle">'+"\n";
		outString += '<param name="allowScriptAccess" value="always" />'+"\n";
		outString += '<param name="movie" value="' + this._oopsFile + '" />' + "\n";
		outString += '<param name="quality" value="high" />' + "\n";
		outString += '<param name="bgcolor" value="#FFFFFF" />' + "\n";
		outString += '<embed src="' + this._oopsFile + '" quality="high" bgcolor="#FFFFFF" width="226" height="110" name="visualResponse2" align="middle" allowScriptAccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />' + "\n";
		outString += '</object>' + "\n";
		var e = document.getElementById('visualResponseID');
		e.innerHTML = outString;	
		
	}//end if
		
}//end function

//this function creates the sound objects
FactFictGame.prototype.createSounds = function() 
{
    this._insSound = new GI_Sound(this._id + 'Inssound', '/sounds/games/' + this._interface_l + 'FF_instruction.mp3');
    document.getElementById(this._id + 'Inssound').innerHTML = this._insSound.getHTML();
    
    this._hintSound = new GI_Sound(this._id + 'Hintsound', '/sounds/games/FF_hint.mp3');
    document.getElementById(this._id + 'Hintsound').innerHTML = this._hintSound.getHTML();

    this._FoFSound = new GI_Sound(this._id + 'FoFsound', '/sounds/games/' + this._interface_l + 'FF_Fact_Fiction.mp3', false, "myFactFictGame.playPrompt");
    document.getElementById(this._id + 'FoFsound').innerHTML = this._FoFSound.getHTML();    

    //Need to create new sound objects to play these sounds onload.
    this._insSoundFirstTime = new GI_Sound(this._id + 'insSoundFirstTime', '/sounds/games/' + this._interface_l + 'FF_instruction.mp3', false, "myFactFictGame.playFoFFirstTime");
    document.getElementById(this._id + 'insSoundFirstTime').innerHTML = this._insSoundFirstTime.getHTML();

    this._FoFSoundFirstTime = new GI_Sound(this._id + 'FoFSoundFirstTime', '/sounds/games/' + this._interface_l + 'FF_Fact_Fiction.mp3', false, "myFactFictGame.playPrompt");
    document.getElementById(this._id + 'FoFSoundFirstTime').innerHTML = this._FoFSoundFirstTime.getHTML();  
}

//this function gets the next question
FactFictGame.prototype.soundHTML = function() {

	var outString = "";
	if(this._rewardSound){
		
		outString += this._rewardSound.getHTML();
	}

	if(this._correctSound){
		
		outString += this._correctSound.getHTML();
	}

	if(this._wrongSound){
		
		outString += this._wrongSound.getHTML();
	}	
	
	outString += '<div id="'+this._id+'Promptsound"></div>' + "\n";
	outString += '<div id="'+this._id+'Inssound"></div>' + "\n";
	outString += '<div id="'+this._id+'Hintsound"></div>' + "\n";
	outString += '<div id="'+this._id+'insSoundFirstTime"></div>' + "\n";
	outString += '<div id="'+this._id+'FoFsound"></div>' + "\n";
	outString += '<div id="'+this._id+'FoFSoundFirstTime"></div>' + "\n";
	
	return outString;
}//end function

//this function gets the next question
FactFictGame.prototype.displayQuestion = function() 
{
	
	var outString = this._ffPrompt + ': '+ this._questions[this._questionNumber]._statement;
	return outString;	
	
}//end function

FactFictGame.prototype.getHTML = function() {
	
	var outString = "";
	
	outString += '<table class="borderless" cellpadding="0" cellspacing="0">';
	outString += '<tr><td>' + "\n";
	outString += '<table class="borderless" cellpadding="0" cellspacing="0">' + "\n";
	outString += '<tr>' + "\n";
	outString += '<td align="left"><img src="/images/spacer.gif" width="30" height="1" /><a href="javascript:'+this._id+'.playIns();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Image37\',\'\',\'/images/btn_listen2_on.gif\',1)"><img src="/images/btn_listen2_off.gif" alt="' + this._listenAlt + '" name="Image37" width="42" height="40" border="0" align="absmiddle"></a></td>' + "\n";
	outString += '<td class="text15">' + this._prompt1 + '<br/>' + this._prompt2 + '</td>' + "\n";
	//outString += '<td><img src="/images/spacer.gif" width="10" height="1" /><a href="javascript:'+this._id+'.playHint();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'hint1\',\'\',\'/images/btn_hint_over.gif\',1)"><img src="/images/btn_hint_on.gif" alt="Hint" name="hint1" width="62" height="78" border="0"></a></td>' + "\n";
	outString += this._hintHTML;
	outString += '</tr>' + "\n";
	outString += '</table>' + "\n";
	outString += '</td>' + "\n";
	outString += '</tr>' + "\n";
	outString += '<tr>' + "\n";
	outString += '<td><img src="/images/spacer.gif" width="625" height="10" /></td>' + "\n";
	outString += '</tr>' + "\n";
	outString += '<tr>' + "\n";
	outString += '<td>' + "\n";
	outString += '<table class="borderless" cellpadding="0" cellspacing="0">' + "\n";
	outString += '<tr valign="top">' + "\n";
	outString += '<td align="left"><img src="/images/spacer.gif" width="30" height="1" /><a href="javascript:'+this._id+'.playFoF();" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage(\'Image40\',\'\',\'/images/btn_listen2_on.gif\',1)"><img src="/images/btn_listen2_off.gif" alt="' + this._listenAlt + '" name="Image40" width="42" height="40" border="0"></a></td>' + "\n";
	outString += '<td class="text16"><div id="FoFClue"></div></td>' + "\n";
	outString += '</tr>' + "\n";
	outString += '</table>' + "\n";
	outString += '</td>' + "\n";
	outString += '</tr>' + "\n";
	outString += '<tr>' + "\n";
	outString += '<td><img src="/images/spacer.gif" width="625" height="21" /></td>' + "\n";
	outString += '</tr>' + "\n";
	outString += '<tr>' + "\n";
	outString += '<td>' + "\n";
	outString += '<table border="0" cellpadding="0" cellspacing="0">' + "\n";
	outString += '<tr>' + "\n";
	outString += '<td rowspan="3"><img src="/media/games/factfict/'+this._factIMG+'" width="193" height="268" alt="" /></td>' + "\n";
	outString += '<td colspan="3"><img src="/images/spacer.gif" width="227" height="9" alt="" /></td>' + "\n";
	outString += '<td rowspan="3"><img src="/media/games/factfict/'+this._fictionIMG+'" width="193" height="268" alt="" /></td>' + "\n";
	outString += '</tr>' + "\n";
	outString += '<tr valign="middle">' + "\n";
	outString += '<td><img src="/images/spacer.gif" width="3" height="93" alt="" /><a href="javascript: myFactFictGame.checkAnwser(\'Fact\');" onMouseOver="MM_swapImage(\'fact1\',\'\',\'/images/' + this._interface_l + 'btn_fact2_over.gif\',1)" onMouseOut="MM_swapImgRestore()"><img src="/images/' + this._interface_l + 'btn_fact2.gif" name="fact1" border="0" id="fact1" alt="' + this._factAlt + '" /></a></td>' + "\n";
	outString += '<td width="35" align="center" class="text18">or<br/><img src="/images/spacer.gif" width="32" height="1" alt="" /></td>' + "\n";
	outString += '<td><a href="javascript: myFactFictGame.checkAnwser(\'Fiction\');" onMouseOver="MM_swapImage(\'fiction1\',\'\',\'/images/' + this._interface_l + 'btn_fiction_over.gif\',1)" onMouseOut="MM_swapImgRestore()"><img src="/images/' + this._interface_l + 'btn_fiction.gif" name="fiction1" width="93" height="93" border="0" id="fiction1" alt="' + this._fictionAlt + '" /></a><img src="/images/spacer.gif" width="3" height="93" /></td>' + "\n";
	outString += '</tr>' + "\n";
	outString += '<tr>' + "\n";
	//outString += '<td colspan="3"><img src="/images/spacer.gif" width="226" height="138" /></td>' + "\n";
	outString += '<td colspan="3"><div id="visualResponseID">';
	
	outString += '<img src="/images/spacer.gif" width="226" height="110" />';
	
	outString += '</div></td>';
	outString += '</tr>' + "\n";
	outString += '<tr>' + "\n";
	outString += '<td class="text19">'+this._factCredit+'</td>' + "\n";
	outString += '<td colspan="3"><img src="/images/spacer.gif" width="227" height="3" alt="" /></td>' + "\n";
	outString += '<td class="text19">'+this._fictionCredit+'</td>' + "\n";
	outString += '</tr>' + "\n";
	outString += '</table></td></tr></table>' + "\n";


	return outString;
	
	
	
}//end function
