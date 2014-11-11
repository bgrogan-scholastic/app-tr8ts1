
 // all the captions
var captions = new Array(6);

captions[1] = "Half of France's total border is formed by coastline, with the Mediterranean on the southeast and the Atlantic and the English Channel on the west and northwest.";
captions[2] = "Since about one third of Finland lies north of the Arctic Circle, the Finns live in one of the most northerly nations in Europe (and the world).";
captions[3] = "Bulgaria is divided into two main agricultural regions by the Balkan Mountains. In the north is the Danubian Plateau, where wheat and other grains, sugar beets, and sunflowers are grown.";
captions[4] = "Wales is a broad peninsula jutting out of the English Midlands, with an irregular coastline, indented by numerous bays, the largest of which is Cardigan Bay.";
captions[5] = "Greece is located in southeastern Europe at the southernmost tip of the Balkan Peninsula and encompasses hundreds of islands scattered through the eastern end of the Mediterranean Sea.";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "This country's chief port is Marseilles.";
questionText[2] = "There are more than 60,000 lakes in this country.";
questionText[3] = "The capital of this country is Sofia.";
questionText[4] = "Coal is this principality's most valuable resource.";
questionText[5] = "This country is home to the world-famous Parthenon.";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "France";
questionAnswers[12] = "Belgium";
questionAnswers[13] = "Germany";
questionAnswers[14] = "Spain";
questionAnswers[21] = "Sweden";
questionAnswers[22] = "Norway";
questionAnswers[23] = "Denmark";
questionAnswers[24] = "Finland";
questionAnswers[31] = "Hungary";
questionAnswers[32] = "Bulgaria";
questionAnswers[33] = "Poland";
questionAnswers[34] = "Romania";
questionAnswers[41] = "England";
questionAnswers[42] = "Scotland";
questionAnswers[43] = "Wales";
questionAnswers[44] = "Iceland";
questionAnswers[51] = "Russia";
questionAnswers[52] = "Estonia";
questionAnswers[53] = "Greece";
questionAnswers[54] = "Ukraine";

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
else if (1 == 1)
	question[5] = 3;
else  if(0 == 1)
	question[5] = 4;	


/* currentQuestion will be used to determine which one we need to process as current */ 

var GameSeq="000001";
var TotalQuestions = "5";
