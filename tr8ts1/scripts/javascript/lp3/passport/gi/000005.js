
 // all the captions
var captions = new Array(6);

captions[1] = "The shaded area above is the state of Alaska. For nearly three straight months, from May through July, the Sun never sets at Barrow, Alaska's northernmost point.";
captions[2] = "In 1805, Kamehameha I, a Hawaiian warrior king, unified the Hawaiian island group into one kingdom. He established a dynasty that lasted for more than 100 years. Kamehameha is revered by Hawaiians because he brought peace and prosperity to the people.";
captions[3] = "The shaded area above is the state of Washington. Olympia, its capital, lies at the southern end of Puget Sound. First settled as a logging port in 1846, the residents chose the name Olympia in the 1850s, for the Olympic Mountains visible to the north.";
captions[4] = "California has by far the largest population of the 50 states. About 75 percent of its nearly 35 million residents live in the south, where the days are sunnier, warmer, and drier than in the north.";
captions[5] = "The shaded area above is the state of Oregon. Mount Hood, a beautiful snow-capped volcanic cone in northern Oregon, rises to 11,239 feet--the highest elevation in the state--making it popular with skiers and climbers.";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "This state, nicknamed \"Land of the Midnight Sun,\" receives more hours of sunlight in the summertime than any other state.";
questionText[2] = "This is the only state that was once a royal kingdom.";
questionText[3] = "Olympia is this state's capital city.";
questionText[4] = "This is the most populous of all the 50 states.";
questionText[5] = "Mt. Hood dominates this state's northern landscape.";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "Washington";
questionAnswers[12] = "Oregon";
questionAnswers[13] = "California";
questionAnswers[14] = "Alaska";
questionAnswers[21] = "Hawaii";
questionAnswers[22] = "Washington";
questionAnswers[23] = "Oregon";
questionAnswers[24] = "California";
questionAnswers[31] = "Alaska";
questionAnswers[32] = "Hawaii";
questionAnswers[33] = "Washington";
questionAnswers[34] = "Oregon";
questionAnswers[41] = "California";
questionAnswers[42] = "Alaska";
questionAnswers[43] = "Hawaii";
questionAnswers[44] = "Washington";
questionAnswers[51] = "Oregon";
questionAnswers[52] = "California";
questionAnswers[53] = "Alaska";
questionAnswers[54] = "Hawaii";

//all the correct choices    
var question = new Array(6);
if (0 == 1)
	question[1] = 1;
else if (0 == 1)
	question[1] = 2;
else if (0 == 1)
	question[1] = 3;
else if(1 == 1)
	question[1] = 4;	


if (1 == 1)
	question[2] = 1;
else if (0 == 1)
	question[2] = 2;
else if (0 == 1)
	question[2] = 3;
else if (0 == 1)
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

if (1 == 1)
	question[5] = 1;
else if (0 == 1)
	question[5] = 2;
else if (0 == 1)
	question[5] = 3;
else  if(0 == 1)
	question[5] = 4;	


/* currentQuestion will be used to determine which one we need to process as current */ 

var GameSeq="000005";
var TotalQuestions = "5";
