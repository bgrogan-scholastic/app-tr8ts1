
 // all the captions
var captions = new Array(6);

captions[1] = "<p>The blue ocean separating the golden wealth of the New World from Spain, and the blood people were willing to shed for independence, make up the colors of the flag of Ecuador. A condor appears at the top of the coat of arms. (MapQuest.com, Inc.)</p>";
captions[2] = "<p>In 1810 when the first steps to Argentine independence from Spain were taken, people wore ribbons of blue and white. The flag was created two years later, and in 1818 the &quot;Sun of May&quot; was added in the center. (MapQuest.com, Inc.)</p>";
captions[3] = "<p>The star is for unity and a golden future, red for love and progress. White symbolizes justice and freedom, while green is for hope and the green land of Suriname. (MapQuest.com, Inc.)</p>";
captions[4] = "<p>Francisco Miranda and Simon Bolivar used yellow-blue-red flags when they struggled to free Colombia from Spanish rule in the early 1800s. The flags of Ecuador and Venezuela were also influenced by this design. (MapQuest.com, Inc.)</p>";
captions[5] = "<p>The seven original provinces of Venezuela are represented by the stars, while the coat of arms contains emblems of freedom, prosperity, and victory. (MapQuest.com, Inc.)</p>";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "What country does this flag represent?";
questionText[2] = "What country does this flag represent?";
questionText[3] = "What country does this flag represent?";
questionText[4] = "What country does this flag represent?";
questionText[5] = "What country does this flag represent?";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "Ecuador";
questionAnswers[12] = "Venezuela";
questionAnswers[13] = "Colombia";
questionAnswers[14] = "Suriname";
questionAnswers[21] = "Venezuela";
questionAnswers[22] = "Argentina";
questionAnswers[23] = "Guyana";
questionAnswers[24] = "Peru";
questionAnswers[31] = "Bolivia";
questionAnswers[32] = "Suriname";
questionAnswers[33] = "Paraguay";
questionAnswers[34] = "Chile";
questionAnswers[41] = "Chile";
questionAnswers[42] = "Guyana";
questionAnswers[43] = "Colombia";
questionAnswers[44] = "Paraguay";
questionAnswers[51] = "Uruguay";
questionAnswers[52] = "Peru";
questionAnswers[53] = "Brazil";
questionAnswers[54] = "Venezuela";

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
else if (1 == 1)
	question[2] = 2;
else if (0 == 1)
	question[2] = 3;
else if (0 == 1)
	question[2] = 4;	

if (0 == 1)
	question[3] = 1;
else if (1 == 1)
	question[3] = 2;
else if (0 == 1)
	question[3] = 3;
else if (0 == 1)
	question[3] = 4;	

if (0 == 1)
	question[4] = 1;
else if (0 == 1)
	question[4] = 2;
else if (1 == 1)
	question[4] = 3;
else if (0 == 1)
	question[4] = 4;	

if (0 == 1)
	question[5] = 1;
else if (0 == 1)
	question[5] = 2;
else if (0 == 1)
	question[5] = 3;
else  if(1 == 1)
	question[5] = 4;	


/* currentQuestion will be used to determine which one we need to process as current */ 

var GameSeq="000005";
var TotalQuestions = "5";
