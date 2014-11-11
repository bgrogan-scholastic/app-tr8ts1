
 // all the captions
var captions = new Array(6);

captions[1] = "<p>This flag, including the state arms with its view of rural Vermont, was adopted in 1923. (MapQuest.com, Inc.)</p>";
captions[2] = "<p>Illinois once had two official state flags. The adoption of a new flag in 1970 ended the confusion. The design features the state seal and the name Illinois. (MapQuest.com, Inc.)</p>";
captions[3] = "<p>The third national flag of the Republic of Texas, adopted in 1839, continues to be used as the state flag. The red, white, and blue are for bravery, purity, and loyalty. (MapQuest.com, Inc.)</p>";
captions[4] = "<p>In 1901 the traditional military flag of New York was made the official flag of the state. The state coat of arms is in the center. (MapQuest.com, Inc.)</p>";
captions[5] = "<p>A Hawaiian king of the early 1800s combined British and American flags to create the flag that has been used by Hawaii ever since. The eight stripes symbolize the main islands. (MapQuest.com, Inc.)</p>";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "What state does this flag represent?";
questionText[2] = "What state does this flag represent?";
questionText[3] = "What state does this flag represent?";
questionText[4] = "What state does this flag represent?";
questionText[5] = "What state does this flag represent?";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "Maine";
questionAnswers[12] = "New Hampshire";
questionAnswers[13] = "Vermont";
questionAnswers[14] = "Massachusetts";
questionAnswers[21] = "Ohio";
questionAnswers[22] = "Michigan";
questionAnswers[23] = "Indiana";
questionAnswers[24] = "Illinois";
questionAnswers[31] = "Montana";
questionAnswers[32] = "Arizona";
questionAnswers[33] = "Texas";
questionAnswers[34] = "Utah";
questionAnswers[41] = "New York";
questionAnswers[42] = "New Hampshire";
questionAnswers[43] = "North Dakota";
questionAnswers[44] = "South Carolina";
questionAnswers[51] = "Alaska";
questionAnswers[52] = "Hawaii";
questionAnswers[53] = "Connecticut";
questionAnswers[54] = "Wyoming";

//all the correct choices    
var question = new Array(6);
if (0 == 1)
	question[1] = 1;
else if (0 == 1)
	question[1] = 2;
else if (1 == 1)
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

var GameSeq="000002";
var TotalQuestions = "5";
