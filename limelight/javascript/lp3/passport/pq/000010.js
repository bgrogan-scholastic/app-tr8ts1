
 // all the captions
var captions = new Array(6);

captions[1] = "<p>Just one degree below the equator is the little island of Nauru. Its flag combines symbols for the Pacific Ocean (blue field), the Equator (yellow line), and the island (a star with one point for each of the twelve tribes of Nauru). (MapQuest.com, Inc.)</p>";
captions[2] = "<p>The stars on the flag of the Pacific island nation of Micronesia stand for its constituent parts. The background of blue stands for the Pacific Ocean. Micronesia has been self-governing since 1986, in a compact of free association with the United States. (MapQuest.com, Inc.)</p>";
captions[3] = "<p>Many people in Kiribati keep frigate birds (like the one in the national flag) as pets. The sun and waves recall that Kiribati is a group of islands near the international date line, where each new day begins. The flag, based on the coat of arms, dates from 1979. (MapQuest.com, Inc.)</p>";
captions[4] = "<p>The 24 points on the star stand for the municipalities of the Marshall Islands. Adopted in 1979, the flag has a blue field for the Pacific Ocean, crossed by stripes of orange (for wealth and bravery) and white (for brightness). Since 1986 the islands have been self-governing in a compact of free association with the United States. (MapQuest.com, Inc.)</p>";
captions[5] = "<p>The moon, an important cultural symbol of the Pacific island nation of Palau, represents national unity, peace, love, and domestic tranquility on its flag. The United Nations blue in the background reflects Palau's years as a United Nations Trust Territory, before the country won self-government in 1994 in a compact of free association with the United States. (MapQuest.com, Inc.)</p>";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "What country does this flag represent?";
questionText[2] = "What country does this flag represent?";
questionText[3] = "What country does this flag represent?";
questionText[4] = "What country does this flag represent?";
questionText[5] = "What country does this flag represent?";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "Federated States of Micronesia";
questionAnswers[12] = "Nauru";
questionAnswers[13] = "Marshall Islands";
questionAnswers[14] = "Kiribati";
questionAnswers[21] = "Kiribati";
questionAnswers[22] = "Marshall Islands";
questionAnswers[23] = "Palau";
questionAnswers[24] = "Federated States of Micronesia";
questionAnswers[31] = "Nauru";
questionAnswers[32] = "Kiribati";
questionAnswers[33] = "Palau";
questionAnswers[34] = "Marshall Islands";
questionAnswers[41] = "Marshall Islands";
questionAnswers[42] = "Palau";
questionAnswers[43] = "Nauru";
questionAnswers[44] = "Federated States of Micronesia";
questionAnswers[51] = "Federated States of Micronesia";
questionAnswers[52] = "Palau";
questionAnswers[53] = "Nauru";
questionAnswers[54] = "Kiribati";

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

var GameSeq="000010";
var TotalQuestions = "5";
