
 // all the captions
var captions = new Array(6);

captions[1] = "Almost as big as Texas, Myanmar is the largest nation in mainland Southeast Asia. On a map, it resembles a diamond-shaped kite complete with its tail.";
captions[2] = "Laos is situated in the rugged mountainous interior of the Indochina peninsula, an extension of the vast Asian landmass to the north.";
captions[3] = "Located in the extreme southeast corner of the great Asian landmass, Vietnam is a coastal country with about 2,150 mi. (3,450 km.) of shoreline.";
captions[4] = "Indonesia is an archipelago consisting of more than 13,500 islands and tiny islets. More than 6,000 of these islands are inhabited.";
captions[5] = "Cambodia, along with Thailand and Myanmar to its west, is the historic rice bowl of mainland Southeast Asia.";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "This country was once called Burma.";
questionText[2] = "This country's capital is Vientiane.";
questionText[3] = "This country is the world's third-largest exporter of rice.";
questionText[4] = "This country is an archipelago.";
questionText[5] = "This country is bordered by Thailand, Laos, Vietnam, and the Gulf of Thailand.";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "Thailand";
questionAnswers[12] = "Myanmar";
questionAnswers[13] = "Indonesia";
questionAnswers[14] = "China";
questionAnswers[21] = "Laos";
questionAnswers[22] = "Vietnam";
questionAnswers[23] = "Cambodia";
questionAnswers[24] = "Myanmar";
questionAnswers[31] = "Thailand";
questionAnswers[32] = "Vietnam";
questionAnswers[33] = "Laos";
questionAnswers[34] = "Cambodia";
questionAnswers[41] = "Malaysia";
questionAnswers[42] = "lndonesia";
questionAnswers[43] = "Vietnam";
questionAnswers[44] = "Laos";
questionAnswers[51] = "Philippines";
questionAnswers[52] = "Malaysia";
questionAnswers[53] = "Cambodia";
questionAnswers[54] = "Indonesia";

//all the correct choices    
var question = new Array(6);
if (0 == 1)
	question[1] = 1;
else if (1 == 1)
	question[1] = 2;
else if (0 == 1)
	question[1] = 3;
else if(0 == 1)
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
else if (1 == 1)
	question[3] = 2;
else if (0 == 1)
	question[3] = 3;
else if (0 == 1)
	question[3] = 4;	

if (0 == 1)
	question[4] = 1;
else if (1 == 1)
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

var GameSeq="000002";
var TotalQuestions = "5";
