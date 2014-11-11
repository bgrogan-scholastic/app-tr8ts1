var myDomain = ".grolier.com";

image_dir ="/games/wh/images/alpha_images/";
spacer_image_dir ="/images/common/";

var my_width=new Array("24", "25", "23", "23", "17", "18", "23", "23", "14", "15", "21", "18", "27", "25", "26", "19", "25", "22", "17", "18", "22", "21", "31", "19", "19", "24");
var alpha=new Array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z");

var i;
for(i=0;i<26;i++){
   eval("var abc_"+alpha[i]+"=new Image;");
   eval("abc_"+alpha[i]+".src=\""+image_dir+"green_small_"+alpha[i]+".gif\";");
   }
for(i=0;i<26;i++){
   eval("var un_"+alpha[i]+"=new Image;");
   eval("un_"+alpha[i]+".src=\""+image_dir+"grey_small_"+alpha[i]+".gif\";");
   }

var curr_word=0;
var n_words=6;
var n_right=0;
var n_wrong=0;
var gotonext = 0;	//0 = false, 1 = true
var maxlen = 12;

function writeLetterHolders()
{

var len = Words[curr_word].length;
for (var i=0;i<len;i++){
		var o = "<td width=\"32\" height=\"45\"><img name=\"let" + i + "\" height=\"44\" width=\"32\" src=\"/games/wh/images/alpha_images/alpha_plain.gif\"></td>";
	o+= "<td width=\"4\" height=\"45\"></td>";
	document.write(o);
}
	
for ( var j = len ; j < maxlen;j++)
{
	var o = "<td width=\"32\" height=\"45\"><img name=\"let" + j + "\" height=\"44\" width=\"32\" src=\"/images/common/spacer.gif\"></td>";
	o+= "<td width=\"4\" height=\"45\"></td>";
	document.write(o);
}
  
}

function writeAlphabet()
{

  for(var i=0;i<26;i++)
  {

    var o;
    o = "";
    o+="<td width=\"24\"><a href=\"javascript: choice('";
    o+=alpha[i];
    o+="')\" id=\""+alpha[i]+"\"><img name=\"abc_";
    o+=alpha[i];
    o+="\" border=\"0\"   width=\"";
    o+=my_width[i];
    o+="\" height=\"25\" src=\"";
    o+=eval("abc_"+alpha[i]+".src");
    o+="\"></a></td>";
    document.write(o);
    }
}

function alreadyclicked(){
	alert("You already tried this one!");	
}
	
function choice(i)
  {
  
  if (curr_word > (n_words -1 ) )
  {
  	alert("Game has been already completed!")
  }
  else
  {
	if ( gotonext == 1 )
	{
		alert("This word has been solved, please click the nextword button");
	}
	else
	{
		  var f=0;
		
		 //	GREY OUT LETTER WHEN IT'S SELECTED
		
		  len=(eval("Words["+curr_word+"].length"));
		  eval("document.images['abc_"+i+"'].src=un_"+i+".src");
			
		 //DISABLE LINK
		 document.getElementById(i).href="javascript:alreadyclicked();"
		  
		  
		//	CHECK IF LETTER QUESSED IS IN THE WORD
		
		  for(var j=0;j<len;j++){
		          
		    var letter=(eval("Words["+curr_word+"].charAt(j).toLowerCase()"));
		    if (i==letter){
		      f=1;n_right+=1;
		      eval("document.images['let"+j+"'].src=\""+image_dir+"alpha_"+i+".gif\"");
		      if(n_right==eval("Words["+curr_word+"].length"))
		        {
		        if(curr_word!= n_words)
		          {
		          	SetCookie("wh-word", Words[curr_word] ,null, "/", ".grolier.com" , null);
		          	eval("OpenBlurbWindow('/games/wh/popup/congrads.html',475,500,'','off');");
		          	gotonext = 1;
		           }
		         } 
		       }
		     }
		  if (f==0){    
		    n_wrong+=1;
		    
		    if(n_wrong == 7)
		      {
		      	eval("OpenBlurbWindow('/games/wh/popup/ohno.php',475,625,'','off');");
		      	gotonext = 1;
		      } 
		    //up to 6 wrong choices
		    if(n_wrong < 7) 
		      {  
		//Switches monkey images
		      SetCookie("wh-word", Words[curr_word] ,null, "/", ".grolier.com" , null);
		      
		      if (n_wrong == 1)
		      {
		      	document.images['monkey1'].src="/games/wh/images/monkey_1.gif";
		      }

		      if (n_wrong == 2)
		      {
		      	document.images['monkey1'].src="/games/wh/images/no_monkey_1.gif";
		      	document.images['monkey2'].src="/games/wh/images/monkey_2.gif";
		      }

		      if (n_wrong == 3)
		      {
		      	document.images['monkey2'].src="/games/wh/images/no_monkey_2.gif";
		      	document.images['monkey3'].src="/games/wh/images/monkey_3.gif";
		      }

		      if (n_wrong == 4)
		      {
		      	document.images['monkey3'].src="/games/wh/images/no_monkey_3.gif";
		      	document.images['monkey4'].src="/games/wh/images/monkey_4.gif";
		      }

		      if (n_wrong == 5)
		      {
		      	document.images['monkey4'].src="/games/wh/images/no_monkey_4.gif";
		      	document.images['monkey5'].src="/games/wh/images/monkey_5.gif";
		      }
		      

		      if (n_wrong == 6)
		      {
		      	document.images['monkey5'].src="/games/wh/images/no_monkey_5.gif";
		      	document.images['monkey6'].src="/games/wh/images/monkey_6.gif";
		      }

		      if (n_wrong == 7)
		      {
		      	document.images['monkey5'].src="/games/wh/images/no_monkey_6.gif";
		      	document.images['monkey7'].src="/games/wh/images/monkey_7.gif";
		      }
		      
		      }
		    }
		  }
	}
}


function solve(){
  //set a cookie indicating the word was solved and the user should move onto the next word
  
  gotonext = 1;
  
  var len=eval("Words["+curr_word+"].length");
  for(var j=0;j<len;j++){
     var letter=(eval("Words["+curr_word+"].charAt(j).toLowerCase()"));
     eval("document.images['let"+j+"'].src=\""+image_dir+"alpha_"+letter+".gif\"");
     }
  }

function Timer(action) {
   if (action == "on") Up();
   else  clearTimeout(up);

}


function nextWord()
{
	//remove the ct-nextword cookie
	gotonext = 0;
	
	//replace all the links
	 for(var i=0;i<26;i++)
  	{
	     document.getElementById(alpha[i]).href="javascript:choice('"+alpha[i]+"');"
    }
    
    
	if (curr_word < n_words - 1)
	{
		//darken all the letters of the alphabet.
		for (var i=0;i<26;i++){
		  eval("document.images['abc_" + alpha[i] + "'].src=\"" + image_dir + "green_small_" + alpha[i] + ".gif\";");
	}
	
	
for (var i=0;i < maxlen ; i++){
	eval("document.images['let" + i + "'].src=\"" + spacer_image_dir + "spacer.gif\"");
	}

//reset unused to spacer
for (var i=0;i < Words[curr_word + 1].length ; i++){
	eval("document.images['let" + i + "'].src=\"" + image_dir + "alpha_plain.gif\";");
	}

//put all monkeys back into original state
		      	document.images['monkey1'].src="/games/wh/images/no_monkey_1.gif";
		      	document.images['monkey2'].src="/games/wh/images/no_monkey_2.gif";
		      	document.images['monkey3'].src="/games/wh/images/no_monkey_3.gif";
		      	document.images['monkey4'].src="/games/wh/images/no_monkey_4.gif";
		      	document.images['monkey5'].src="/games/wh/images/no_monkey_5.gif";
		      	document.images['monkey6'].src="/games/wh/images/no_monkey_6.gif";

		
		//increment current word count
		curr_word++;

		SetCookie("wh-word", Words[curr_word] ,null, "/", ".grolier.com" , null);		
		
		
		//reset wrong / right letter count
		n_right=0;
		n_wrong=0;

		if (curr_word > n_words - 2)
		{
			document.images['nextWord'].src = spacer_image_dir + "spacer.gif";
		}	
	}
	else
	{
		alert("No more words to solve");
	}
	
}	
 

	
