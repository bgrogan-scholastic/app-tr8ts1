var curr_page;

//parseQueryString();
var queryParams = new Array();

function queryString(name, value) {
  this.name  = name;
  this.value = value;
}

function parseQueryString() {
  var query    = location.search;
  query        = query.substring(1);
  var tmpQuery = query.split("&");
  var name     = "";
  var value    = "";
  var index    = 0;

  for (i = 0; i < tmpQuery.length; i++) {
    index          = tmpQuery[i].indexOf("=");
    name           = tmpQuery[i].substring(0, index);
    value          = tmpQuery[i].substring(index+1);
    queryParams[i] = new queryString(name, value);
  }
}

function getQueryParameterValue(param) {
  for (i = 0; i < queryParams.length; i++) {
    if (queryParams[i].name == param)
      return queryParams[i].value;
  }
  return "";
}

parseQueryString();
setcurrentpage();
var n = curr_page;

function makeGuess(i)
 {

 if(i== answer)
  {
 alert("Correct!");

    OpenBlurbWindow('/games/sbs/popup/popup.php?gameid='+gameid,430,665);
  }
 else 
    alert("Sorry, that's not the right answer. Try again!"); 
 }


function setcurrentpage() {

 var curr_pageStr = getQueryParameterValue("curr_page");
 if (curr_pageStr == "") {
	curr_page = 1;
	}
 else {
	curr_page = curr_pageStr;
	}
  }


function solve()
 {

	curr_page++;
 	document.location="/ncpage?tn=/games/sbs.html&gameid=" + gameid + "&gametype=sbs&templatename=/passport/stepbystep.html&curr_page=" + curr_page;

}

function guess(i)
 {

 if (curr_page == ans[i-1]) // put code to go to next page
  {
	curr_page++;
 	alert("Correct!");

 
	document.location="/ncpage?tn=/games/sbs.html&gameid=" + gameid + "&gametype=sbs&curr_page=" + curr_page;
 
	



}
else
  alert("Sorry, that's not the right answer. Try again!");  // put the right message here
 }



function openInstruct(){
OpenBlurbWindow('/games/sbs/popup/instructions.html',450,520);
}

function writeGrid() {
  var o=" ";
  var w=new Array("133","133","134");
  var h="87";
  var m=1;
  var x=0;
  if (curr_page == 10) {
	o+= "<img src = \"/games/sbs/images/";
	o+= gameid;
	o+= ".jpg\">";
	}
	
   else {


  for(var j=0;j<3;j++){
    for(var i=0;i<3;i++,m++){
      x=m-1;
      o+="<a href=\"Javascript: guess(";
      o+=m;
      o+=")\">";
      o+="<img src=\"/games/sbs/images/";
      o+=gameid;
      o+="_"; 
      if(n > ans[x])  
        {   
        o+=m;
	o+= ".jpg\" width=\"";
        }   
      else
        { 
        o+=m;              
        o+="_";              
	o+=ans[m-1];
        o+=".gif\" width=\"";
        }   
      o+=w[i];
      o+="\" height=\"";
      o+=h;
      o+="\">";
      }
  }
    o+="<br>"
    }
return o;
}


