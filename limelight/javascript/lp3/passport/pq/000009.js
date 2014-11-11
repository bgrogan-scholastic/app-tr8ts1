
 // all the captions
var captions = new Array(6);

captions[1] = "<p>The emblem of Taiwan was chosen by Dr. Sun Yat-sen, provisional president of the 1912 Chinese republic. Blue stands for liberty, justice, and democracy; white for equality, brightness, and the people's livelihood; red for fraternity, sacrifice, and nationalism. (MapQuest.com, Inc.)</p>";
captions[2] = "<p>The &quot;Land Of The Rising Sun&quot; not surprisingly has the red disk of the sun in the center of its flag. The white background is for contrast. Each of the prefectures, or provinces, of Japan has a flag of its own. (MapQuest.com, Inc.)</p>";
captions[3] = "<p>Red is a symbol of Communism, but also of the Chinese people. The guiding role of the Communist party and the leading economic classes of China are suggested by the large star and the four small ones. (MapQuest.com, Inc.)</p>";
captions[4] = "<p>The red stripe reminds people of the struggle to end Japanese rule in Korea; the red star is for self-help and Communism. The white circle and stripes stand for the ancient history and culture of Korea, while the blue stripes are a symbol of peace. The flag was adopted in 1948, when the Korean Democratic People's Republic was proclaimed. (MapQuest.com, Inc.)</p>";
captions[5] = "<p>The red and blue yin-yang means all the opposites that make up the whole universe--dark and light, summer and winter, good and evil, female and male, etc. The <i>kwae</i> (lines) are for the seasons; the four cardinal directions; and the sun, moon, earth, and heaven. (MapQuest.com, Inc.)</p>";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "What country does this flag represent?";
questionText[2] = "What country does this flag represent?";
questionText[3] = "What country does this flag represent?";
questionText[4] = "What country does this flag represent?";
questionText[5] = "What country does this flag represent?";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "China";
questionAnswers[12] = "Japan";
questionAnswers[13] = "North Korea";
questionAnswers[14] = "Taiwan";
questionAnswers[21] = "Japan";
questionAnswers[22] = "South Korea";
questionAnswers[23] = "North Korea";
questionAnswers[24] = "China";
questionAnswers[31] = "North Korea";
questionAnswers[32] = "Taiwan";
questionAnswers[33] = "China";
questionAnswers[34] = "South Korea";
questionAnswers[41] = "Japan";
questionAnswers[42] = "Taiwan";
questionAnswers[43] = "North Korea";
questionAnswers[44] = "South Korea";
questionAnswers[51] = "South Korea";
questionAnswers[52] = "Taiwan";
questionAnswers[53] = "Japan";
questionAnswers[54] = "China";

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

if (0 == 1)
	question[4] = 1;
else if (0 == 1)
	question[4] = 2;
else if (1 == 1)
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

var GameSeq="000009";
var TotalQuestions = "5";
