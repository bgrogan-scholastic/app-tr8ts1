
 // all the captions
var captions = new Array(6);

captions[1] = "The shaded area above is the Canadian province of Newfoundland and Labrador. St. John’s, its capital and largest city, is one of the oldest settlements in North America. It has been an important center of shipping for hundreds of years.";
captions[2] = "Nunavut makes up nearly one-fifth the area of Canada. It was created on April 1, 1999, when the Northwest Territories was divided into a western part (still known as the Northwest Territories) and an eastern part (Nunavut).";
captions[3] = "New Brunswick is bounded on the north by Quebec, to the west by the state of Maine, to the south by the Bay of Fundy, and to the east by the Gulf of St. Lawrence.";
captions[4] = "Many of Nova Scotia's inhabitants proudly display their Scottish heritage with bagpipes and tartans during the world-famous Antigonish Highland Games and other festive occasions.";
captions[5] = "The shaded area above is the Canadian province of Ontario. Its capital, Ottawa, is reputed to be one of the coldest national capitals in the world, with a mean temperature of 42&deg; F.";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "This province's capital is St. John's.";
questionText[2] = "This is the largest and most northern Canadian territory.";
questionText[3] = "The Bay of Fundy separates Nova Scotia from this other Canadian province.";
questionText[4] = "The name of this province is Latin for \"New Scotland.\"";
questionText[5] = "Ottawa, Canada's capital, lies in the northeastern section of this province.";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "Newfoundland and Labrador";
questionAnswers[12] = "Manitoba";
questionAnswers[13] = "Nunavut";
questionAnswers[14] = "Ontario";
questionAnswers[21] = "Northwest Territories";
questionAnswers[22] = "Yukon Territory";
questionAnswers[23] = "Nunavut";
questionAnswers[24] = "Alberta";
questionAnswers[31] = "Prince Edward Island";
questionAnswers[32] = "Manitoba";
questionAnswers[33] = "Nunavut";
questionAnswers[34] = "New Brunswick";
questionAnswers[41] = "Nunavut";
questionAnswers[42] = "Nova Scotia";
questionAnswers[43] = "Quebec";
questionAnswers[44] = "Saskatchewan";
questionAnswers[51] = "Ontario";
questionAnswers[52] = "Saskatchewan";
questionAnswers[53] = "Quebec";
questionAnswers[54] = "Manitoba";

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
else if (1 == 1)
	question[2] = 3;
else if (0 == 1)
	question[2] = 4;	

if (0 == 1)
	question[3] = 1;
else if (0 == 1)
	question[3] = 2;
else if (0 == 1)
	question[3] = 3;
else if (1 == 1)
	question[3] = 4;	

if (0 == 1)
	question[4] = 1;
else if (1 == 1)
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

var GameSeq="000003";
var TotalQuestions = "5";
