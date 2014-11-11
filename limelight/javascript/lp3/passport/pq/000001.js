
 // all the captions
var captions = new Array(6);

captions[1] = "<p>The two-headed eagle was a popular symbol in the Byzantine Empire, of which Albania was once a part. The eagle may also have been chosen by Albanians because their name for Albania (<i>Shqiperi</i>) means &quot;land of the eagle.&quot; (MapQuest.com, Inc.)</p>";
captions[2] = "<p>The cross is a typical Nordic flag symbol. The colors probably come from the arms of Sweden--three gold crowns on blue and a gold lion on a background of white and blue stripes. The flag dates from the 1600s. (MapQuest.com, Inc.)</p>";
captions[3] = "<p>In 1785 traditional colors were combined in the striped flag of Spain still used today. The coat of arms dates from 1981, although it contains emblems from Spanish history over 700 years old. (MapQuest.com, Inc.)</p>";
captions[4] = "<p>At the 1936 Olympic Games, Liechtenstein discovered that its blue-red banner was also being used as a national flag by Haiti. Thus the following year, a crown--a symbol of the ruling prince of Liechtenstein--was added. (MapQuest.com, Inc.)</p>";
captions[5] = "<p>White for snow and blue for Finnish lakes were colors proposed in the mid-1800s for the flag of Finland. The Nordic cross bears the 400-year-old shield of Finland--a lion with a sword, symbolizing national resistance to Russian rule. (MapQuest.com, Inc.)</p>";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "What country does this flag represent?";
questionText[2] = "What country does this flag represent?";
questionText[3] = "What country does this flag represent?";
questionText[4] = "What country does this flag represent?";
questionText[5] = "What country does this flag represent?";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "Albania";
questionAnswers[12] = "Andorra";
questionAnswers[13] = "Austria";
questionAnswers[14] = "Belgium";
questionAnswers[21] = "Estonia";
questionAnswers[22] = "Finland";
questionAnswers[23] = "Denmark";
questionAnswers[24] = "Sweden";
questionAnswers[31] = "Slovakia";
questionAnswers[32] = "Slovenia";
questionAnswers[33] = "Spain";
questionAnswers[34] = "Switzerland";
questionAnswers[41] = "Liechtenstein";
questionAnswers[42] = "Germany";
questionAnswers[43] = "France";
questionAnswers[44] = "Italy";
questionAnswers[51] = "Bulgaria";
questionAnswers[52] = "Croatia";
questionAnswers[53] = "Finland";
questionAnswers[54] = "Greece";

//all the correct choices    
var question = new Array(6);
if (1 == 1)
	question[1] = 1;
else if (0 == 1)
	question[1] = 2;
else if (0 == 1)
	question[1] = 3;
else if(0 == 1)
	question[1] = 4;	


if (0 == 1)
	question[2] = 1;
else if (0 == 1)
	question[2] = 2;
else if (0 == 1)
	question[2] = 3;
else if (1 == 1)
	question[2] = 4;	

if (0 == 1)
	question[3] = 1;
else if (0 == 1)
	question[3] = 2;
else if (1 == 1)
	question[3] = 3;
else if (0 == 1)
	question[3] = 4;	

if (1 == 1)
	question[4] = 1;
else if (0 == 1)
	question[4] = 2;
else if (0 == 1)
	question[4] = 3;
else if (0 == 1)
	question[4] = 4;	

if (0 == 1)
	question[5] = 1;
else if (0 == 1)
	question[5] = 2;
else if (1 == 1)
	question[5] = 3;
else  if(0 == 1)
	question[5] = 4;	


/* currentQuestion will be used to determine which one we need to process as current */ 

var GameSeq="000001";
var TotalQuestions = "5";
