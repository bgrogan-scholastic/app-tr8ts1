  var myDomain = ".grolier.com";
  var common_image_dir="images-common/";
  var image_dir="/games/ws/images/";
  var mac_ie=0;
  var two = new Array(0,0,0);
  var picknum = 3;
  var words_found = 0;
  var num_words=20;

// keep track of words found
  var wordsfound = new Array(0,0,0,0,0
			,0,0,0,0,0
			,0,0,0,0,0
			,0,0,0,0,0
			,0,0,0,0,0);
// the dimensions of the grid
  var grid_width=15;
  var grid_height=15;
  var grid_size=grid_width*grid_height;
 
  var hit = new Array(grid_size*6);

///////////////////////////////////////////
//			ACTIONS	           //
///////////////////////////////////////////
  Is();
  initializeHit();
//////////////////////////////////////////
//	name:	choice(index)		    
//	purpose: do 3 last clicks start word
//	input: square of grid clicked	
//////////////////////////////////////////
function choice(index)
  {
  index++;
  if ( picknum < 4 )
      two[picknum-1] = index;
  else
    {
    two[0]=two[1];
    two[1]=two[2];
    two[2]=index;
    }
  picknum +=1;
// Are these the first 3 letters of a word ?
  for(i=1;i<(num_words+1);i++) 
    if (eval("((word"+i+"[0]==two[0])&&(word"+i+"[1]==two[1])&&(word"+i+"[2]==two[2]))"))
     eval("pick("+i+");");
  }
//////////////////////////////////////////
//	name:	pick(place)
//	purpose: change color of word
//	input: which placen needs changing
//////////////////////////////////////////
function pick(place)
  {

      wordsfound[place]=1;
      if (mac_ie==1)
        eval("this.check"+place+".src=\""+image_dir+"smchk_yl.gif\""); 
      if (mac_ie==0)
        eval("document.check"+place+".src=\""+image_dir+"smchk_yl.gif\""); 
    eval("var img=new Array(word"+place+".length)");
    for (var i = 0; i < eval("word"+place+".length"); i++)
      hit[((eval("word"+place+"[i]-1"))*6+direction[place])-1]="1";   
    for (var i = 0; i < eval("word"+place+".length"); i++)
      {
      img[i]="/games/ws/Alphabet.giff/"+(eval("letter"+place+"[0].charAt(i)"))+(eval("letter"+place+"[0].charAt(i)"))+"/"+(eval("letter"+place+"[0].charAt(i)"));
	for (var j = 0; j < 4;j++)
         img[i]+= hit[((eval("word"+place+"[i]-1"))*6+j)]
      img[i] += ".gif";
      }
// for length of word, using word(place) for number
// assign to next elt of image array
   for(var i=0;i<eval("word"+place+".length");i++) {
      if (mac_ie==1)
        eval("this.pick"+eval("word"+place+"["+i+"]")+".src=img[i]");
      if (mac_ie==0)
        eval("document.pick"+eval("word"+place+"["+i+"]")+".src=img[i]");
    }
}



//////////////////////////////////////////
//	name:	initializeHit()
//	purpose: set all hit elts to "0"
//////////////////////////////////////////
function initializeHit()
  { 
  for(var i=0;i<(grid_size*6);i++)
    hit[i]="0";
  } 



function solve()
  {
  for(var w=1;w<num_words;w++)
    wordsfound[i]=1;

  // Initialize Hit to all hits
  for(var w=1;w<=num_words;w++){
    for(var i=0;i<eval("word"+w+".length");i++)
      hit[((eval("word"+w+"[i]-1"))*6+direction[w])-1]="1";   
    }   
  // Assign all images
  for(var w=1;w<=num_words;w++){
    eval("var img=new Array(word"+w+".length)");
    for (var i=0;i<eval("word"+w+".length");i++)
      {
      img[i]="/games/ws/Alphabet.giff/"+(eval("letter"+w+"[0].charAt(i)"))+(eval("letter"+w+"[0].charAt(i)"))+"/"+(eval("letter"+w+"[0].charAt(i)"));
	for (var j = 0; j < 4;j++)
         img[i]+= hit[((eval("word"+w+"[i]-1"))*6+j)]
      img[i] += ".gif";
      }
    for(var i=0;i<eval("word"+w+".length");i++){
      if(mac_ie==0)
        eval("document.pick"+eval("word"+w+"["+i+"]")+".src=img[i]");
      if(mac_ie==1)
        eval("this.pick"+eval("word"+w+"["+i+"]")+".src=img[i]");
      }
    }

  }
function Is(){if((navigator.appVersion.indexOf("Mac")!=-1)&&(navigator.userAgent.indexOf("MSIE")!=-1))mac_ie=1;}
// 	TIMER ACTION

function Timer(action) {
  if (action == "on") Up();
  else clearTimeout(up);

}


function reLoad() {
   location = location;
}


function doGrid() {
var abc_dir = "/games/ws/Alphabet.giff"
var o="";
 var index = 0;
  for (var r = 0; r < grid_height; r++)
    {
    for (var c = 0; c < grid_width; c++,index++)
      {
      o+="<a href=\"Javascript: choice(";
      o+=index;
      o+=")\">"; 
      o+="<img border=\"0\" name=\"pick";
      o+=(index+1);
      o+="\" src=\""+abc_dir+"/";
      o+=grid[1].charAt(index);
      o+=grid[1].charAt(index);
      o+="/";
      o+=grid[1].charAt(index);
      o+="0000.gif\"";
      o+= " width=22 height=22>";
      }
      o+="<br>";
    }
  return o;
}

function doShowWords(){
var o=" ";
for (var c=1;c<=(num_words);c++)
  {
  o+="<center><img  src=\"";
  o+="/images/common/spacer.gif\" width=\"10\" height=\"10\" name=\"check";
  o+=c;
  o+="\">";
  o+="<img  src=\"";
  o+="/images/common/spacer.gif\" width=\"1\" height=\"10\">";
  o+="<font size=\"2\">";
  for(var i=0;i< eval("showword"+c+".length");i++)
    o+=eval("showword"+c+"[i]");
  o+="</font>";
  o+="<img  src=\"";
  o+="/images/common/spacer.gif\" width=\"1\" height=\"10\">";
  o+="</center>";
  }
return o;
}

function openInstruct(){
    OpenBlurbWindow('/games/ws/popup/instructions.html',450,450, "off");
}

// 	TIMER ACTION

function Timer(action) {
  if (action == "on") Up();
  else clearTimeout(up);

}




