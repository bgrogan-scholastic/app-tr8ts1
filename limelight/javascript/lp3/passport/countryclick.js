/**********************************************
*  Define global variables for game
*
***********************************************/

 var CurrentQuestion;
 var TotalQuized;
 var TotalCorrect;
 var TotalIncorrect;
 var TotalToPlay;
 var AlreadyPlayed = new Array(); 

 setupGame();

/************************************************
*       function: setupGame()
*       purpose:  Initialize game variables
*		  set score board to 0's
*		  erase capitols from map
************************************************/


  function setupGame()
{
        var i = 0;
        for (i = 0; i < 10; i++) {
                AlreadyPlayed[i] = 0;
        }
 
        CurrentQuestion = -1;
        TotalQuized = 0;
        TotalCorrect = 0;
        TotalIncorrect = 0;
        TotalToPlay = 10;

}       


/************************************************
*       function: restartGame()
*       purpose:  Initialize game variables
*                 set score board to 0's
*                 erase capitols from map
************************************************/


  function restartGame()
{
        var i = 0;
        for (i = 0; i < 10; i++) {
                AlreadyPlayed[i] = 0;
        }

        CurrentQuestion = -1;
        TotalQuized = 0;
        TotalCorrect = 0;
        TotalIncorrect = 0;
        TotalToPlay = 10;
        NextQuestion();
    
        resetScore();
     
        eraseCapitals();
 
}


 function StateData(abbreviation, answer)
  {
    this.abbrev = abbreviation;
    this.answer = answer;

  }


/************************************************
*	function: function NextQuestion() 
*	purpose: Find a question we haven't done yet
*		randomly selected
*		Assign the image name based on random
*		select.
*		Keep track of what questions we've played
*		already
*
************************************************/
function NextQuestion()
{

  if (TotalToPlay > 0) {

    var rnd = Math.round(Math.random() * 9);    	

    while (AlreadyPlayed[rnd] == 1) {

      //Pick another number that one has been played

      rnd = Math.round(Math.random() * 9);

    }

	// Build the image name based on the random number
	

    var thesrc = "/games/cc/images/questions/" + gameid + "-" + rnd + ".gif";   
    eval("document.images[\"question\"].src = thesrc");

	// Save the random value for use accessing State Data

    CurrentQuestion = rnd;

    //Say we already played this question

    AlreadyPlayed[rnd] = 1;

  }

  TotalToPlay--;

}




function ShowCapital(capId)
{
 

  var thesrc = "/games/cc/images/stars/star-"+States[capId].abbrev+".gif";   

  eval("document.images[\"" + States[capId].abbrev + "\"].src = thesrc");

}
 
function eraseCapitals3()
{
  var i = 0;
  for (;i < 50;i++) {
 
  	alert(States[i].abbrev);
  	alert(States[i].gif);
	var thesrc = "/games/cc/images/stars/map-" + States[i].abbrev + ".gif"; 
 
 	eval("document.images[\"" + States[i].abbrev + "\"].src = thesrc");
		 
		}
} 

   
 
function eraseCapitals()
{
  var i = 0;
  for (;i < 50;i++) {
 
  	//MODIFIED on LP3 migration to fix the bug where image was failing a replace
 var errorExists=false;  
 		try
		  {
			var thesrc = "/games/cc/images/stars/map-" + States[i].abbrev + ".gif"; 
		  }
		catch(err)
		  {
			 var errorExists=true;  
		  }
		finally
		{
			if(!errorExists){ 
		 		eval("document.images[\"" + States[i].abbrev + "\"].src = thesrc");
			} 
		}
		 
 

		 
 
 
   
  }
}


function CheckAnswer(answer)
{

  if (TotalToPlay >= 0) {
    if (answer == States[CurrentQuestion].answer) {
      //Got the answer correct let them know
      //If this is the last question, change the alert message 

     if (TotalToPlay == 0) {
	alert ("That's correct!\nThat's the last question...\nClick New Game to play again.");

	}
     else {
	
     	alert("That's correct!\nHere comes the next question.");
	}
    
  SetScore(1);
    }
    else {

	if (TotalToPlay == 0) {
       	 alert ("That's incorrect!\nThe correct answer was " + States[CurrentQuestion].abbrev.toUpperCase() + ".\nThat's the last question...\nClick New Game to play again.");
        }


      alert("That's incorrect!\nThe correct answer was " + States[CurrentQuestion].abbrev.toUpperCase() + ".\nHere comes the next question.");
      SetScore(-1);
    }

    ShowCapital(CurrentQuestion);
    if (TotalToPlay > 0) {
      NextQuestion();  
    }
  }
}

/*********************************************************
*	
*	function: setScore(adder)
*	purpose: update the score board
*	input:  1 if answer is correct
*		0 if answer is incorrect
*********************************************************/
 
function SetScore(adder)
{
  if (adder==1) {
    TotalCorrect++;  
  }
  else {
    TotalIncorrect++;
  }
  var thesrc = "/games/cc/images/score/correct-" + TotalCorrect + ".gif";   
  eval("document.images[\"correctscore\"].src = thesrc");
  
  thesrc = "/games/cc/images/score/incorrect-" + TotalIncorrect + ".gif";   
  eval("document.images[\"incorrectscore\"].src = thesrc");

}


/*********************************************************
*	
*	function: resetScore()
*	purpose: reset the score board to all 0's
*
*********************************************************/
 function resetScore()
{
  var thesrc = "/games/cc/images/score/correct-0.gif";
  eval("document.images[\"correctscore\"].src = thesrc");
 
  thesrc = "/games/cc/images/score/incorrect-0.gif";
  eval("document.images[\"incorrectscore\"].src = thesrc");

}

/********************************************************
*
*	function: showHelp()
*	purpose: open popup window with instructions
*
********************************************************/
 
  function showHelp() 
    {
      OpenBlurbWindow('/games/cc/popup/instructions.html', 440, 440, 'Help');
    }
