
 // all the captions
var captions = new Array(6);

captions[1] = "The name \"Congo\" comes from the European name for the ancient Kongo kingdom, which thrived along the lower course of the great Congo River. Once known as the Congo Free State, Mobutu Sese Seko, a military dictator, renamed the country Zaire in 1971.";
captions[2] = "The shaded area above is the Republic of Congo, one of the most highly developed countries in Central Africa. The capital, Brazzaville--a major port on the Congo River--is connected by rail to Pointe-Noire, the country's principal Atlantic seaport.";
captions[3] = "The Central African Republic is a vast plateau, largely covered by rolling grassland. In the southwest are tropical rain forests and in the northeast, barren hills.";
captions[4] = "The shaded area above is Cameroon. Cameroon Mountain, an occasionally active volcano, extends 14 miles inward from Cameroon’s coast on the Gulf of Guinea. Rainfall near the mountain averages 400 inches annually, making the area the wettest in Africa.";
captions[5] = "Most Chadians earn their living by farming, fishing, or raising livestock. The main cash crop is cotton; sugar and tobacco are cultivated for domestic use. Acacias are tapped for the export of gum arabic.";

// all the question text
var questionText = new Array(6);	//to avoid using index 0.
questionText[1] = "This country was called Zaire from 1971 to 1997.";
questionText[2] = "This country's capital and largest city is Brazzaville.";
questionText[3] = "About the size of Texas, this country was once one of four territories that made up the colony of French Equatorial Africa.";
questionText[4] = "The highest mountain in West Africa lies in this country.";
questionText[5] = "Cotton is by far the chief export of this fifth-largest nation of Africa.";
	 
// all the answers
var questionAnswers = new Array();
questionAnswers[11] = "Cameroon";
questionAnswers[12] = "Congo, Democratic Republic of";
questionAnswers[13] = "Central African Republic";
questionAnswers[14] = "Chad";
questionAnswers[21] = "Comoros";
questionAnswers[22] = "Congo, Democratic Republic of";
questionAnswers[23] = "Congo, Republic of";
questionAnswers[24] = "Cameroon";
questionAnswers[31] = "Cape Verde";
questionAnswers[32] = "Central African Republic";
questionAnswers[33] = "Chad";
questionAnswers[34] = "Comoros";
questionAnswers[41] = "Congo, Democratic Republic of";
questionAnswers[42] = "Congo, Republic of";
questionAnswers[43] = "Cameroon";
questionAnswers[44] = "Cape Verde";
questionAnswers[51] = "Central African Republic";
questionAnswers[52] = "Chad";
questionAnswers[53] = "Comoros";
questionAnswers[54] = "Congo, Democratic Republic of";

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
else if (1 == 1)
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
else if (1 == 1)
	question[5] = 2;
else if (0 == 1)
	question[5] = 3;
else  if(0 == 1)
	question[5] = 4;	


/* currentQuestion will be used to determine which one we need to process as current */ 

var GameSeq="000004";
var TotalQuestions = "5";
