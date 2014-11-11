<!--Find It on the Map--Europe-->
 
  /* This is an attempt to put all questions into one file */
    var questioncookie = "question";
    currentQuestion = GetCookie(questioncookie);
    if (!currentQuestion) { 
    	currentQuestion = "1";
    	SetCookie(questioncookie,currentQuestion);
    }
  	if (currentQuestion == "5") DeleteCookie(questioncookie);
  	

 
	 // Return the relevant question text.	 	 	 	 
	 function getQuestion() {
	 	return questionText[currentQuestion];
	 }
	 
	 // Return the relevant answer 
	 function getAnswer(number) {
	 	thenum = new String(currentQuestion);
	 	thenum = (thenum*10)+number;
	 	return questionAnswers[thenum];
	 }
	 
    
    
   /* currentQuestion will be used to determine which one we need to process as current */ 

    var CorrectCaptionText = captions[currentQuestion];

	/* this function loads this question's title and map images 
		which are named using the game date, game sequence # and question # */
    function SetupGame()
    {
      var thesrc = "/games/gi/images/geoid-"+GameSeq +"-"+ currentQuestion + ".gif";   
      eval("document.images[\"TheMapImage\"].src = thesrc");
      thesrc = "/games/gi/images/geoid-"  +GameSeq+ "-title.gif";   
      eval("document.images[\"Headline\"].src = thesrc");
      
      //eliminate the Next Question button if this is the last question
      if (TotalQuestions == currentQuestion) {
        thesrc = "/images/common/spacer.gif";
        eval("document.images[\"NextButt\"].src = thesrc");
      }
    }
    
    function CheckAnswer(answer)
    {
      ClearAnswers();
      if (question[currentQuestion] == answer) {
        CorrectAnswer(answer);
      }
      else {
        IncorrectAnswer(answer);
      }
    }

    function ClearAnswers()
    {
      var thesrc = "/images/common/spacer.gif";
      for (var i = 1; i <= 4; i++) {
         var thelocation = "resp" + i;
         eval("document.images[\"" + thelocation + "\"].src = thesrc");
      }
    }
    
    function CorrectAnswer(answer)
    {
      var thesrc = "/games/images/congrats-button.gif";
      var thelocation = "resp" + answer;
      eval("document.images[\"" + thelocation + "\"].src = thesrc");
      ShowPopupCorrectAnswer();
    }

    function IncorrectAnswer(answer)
    {
      var thesrc = "/games/images/tryagain-button.gif";
      var thelocation = "resp" + answer;
      eval("document.images[\"" + thelocation + "\"].src = thesrc");
    } 

    function ShowPopupCorrectAnswer()
    {
      OpenBlurbWindow('/games/gi/popup/popup.html', 440, 500, 'Correct','no');
    }

    //Set the currentQuestion cookie to point to the NextQuestion # & reload.
    function NextQuestion()
    {
    	// if the last question was reached, start over by deleting the cookie.
      if (currentQuestion < TotalQuestions) 
      {
         anumber = parseInt(currentQuestion);
         anumber++;
	 SetCookie(questioncookie,anumber);
	 location = location;
	}
	else {
		DeleteCookie(questioncookie);
		alert("You've reached the end of the game!");
        }
    }

    function ShowHelp() 
    {
      OpenBlurbWindow('/games/gi/popup/instructions.html', 440, 440, 'Help','no');
    } 
