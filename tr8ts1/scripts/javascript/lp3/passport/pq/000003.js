
 // all the captions
var captions = new Array(6);

captions[1] = "<p>It is not surprising that this flag resembles the American Stars and Stripes: Liberia was settled by American ex-slaves in the early 1800s. The eleven stripes are for the eleven signers of the Liberian Declaration of Independence. The star is for freedom. (MapQuest.com, Inc.)</p>";
captions[2] = "<p>For many years, Tunisia was under the rule of Turkey, which used a red flag bearing a red star and white crescent. The Tunisian flag was patterned after the Turkish flag, but it is different enough to be easily recognizable. (MapQuest.com, Inc.)</p>";
captions[3] = "<p>Many former French colonies adopted the simple vertical stripes of the French tricolor when they designed their own flags. In 1959 Chad chose blue for the sky, yellow for the sun, and red for progress and unity. (MapQuest.com, Inc.)</p>";
captions[4] = "<p>Since water in any form is a promise of life for this extremely dry country, blue was chosen for the Botswana flag in 1966. Blacks and whites working together to develop their country are symbolized by the stripes. (MapQuest.com, Inc.)</p>";
captions[5] = "<p>The horizontal bands of color on the Rwandan flag, which were adopted on December 31, 2001, symbolize hope for prosperity (green), economic development (yellow), and happiness and peace (blue). The Sun and its rays, at top right, represent enlightenment and the fight against ignorance. (MapQuest.com, Inc.)</p>";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "What country does this flag represent?";
questionText[2] = "What country does this flag represent?";
questionText[3] = "What country does this flag represent?";
questionText[4] = "What country does this flag represent?";
questionText[5] = "What country does this flag represent?";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "Liberia";
questionAnswers[12] = "Togo";
questionAnswers[13] = "Zimbabwe";
questionAnswers[14] = "Uganda";
questionAnswers[21] = "Nigeria";
questionAnswers[22] = "Somalia";
questionAnswers[23] = "Benin";
questionAnswers[24] = "Tunisia";
questionAnswers[31] = "Kenya";
questionAnswers[32] = "Malawi";
questionAnswers[33] = "Chad";
questionAnswers[34] = "Ghana";
questionAnswers[41] = "Botswana";
questionAnswers[42] = "Lesotho";
questionAnswers[43] = "Namibia";
questionAnswers[44] = "Angola";
questionAnswers[51] = "Madagascar";
questionAnswers[52] = "Rwanda";
questionAnswers[53] = "Libya";
questionAnswers[54] = "Niger";

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
else if (1 == 1)
	question[5] = 2;
else if (0 == 1)
	question[5] = 3;
else  if(0 == 1)
	question[5] = 4;	


/* currentQuestion will be used to determine which one we need to process as current */ 

var GameSeq="000003";
var TotalQuestions = "5";
