<!-- javascript used by the rollover images on this page -->

//this file contains all the image directories used for rollovers
/* these are the possible paths for NBK3 rollovers */

var alphbrw_imgDirectory = new Array("/images/nbk3/browse/alpha/");
var home_imgDirectory= new Array("/images/nbk3/home/");
var subjbrw_imgDirectory = new Array("/images/nbk3/browse/subject/"); 
var encycarticle_imgDirectory = new Array("/images/nbk3/encyc/");
var timelines_imgDirectory = new Array("/images/nbk3/timelines/");
var games_imgDirectory = new Array("/images/nbk3/games/home/");
var homework_imgDirectory = new Array("/images/nbk3/homework/");
var gamemadmixup_imgDirectory = new Array("/games/madmixup/images/nbk3/");
var newsarchive_imgDirectory = new Array("/images/nbk3/common-news/");
var news_imgDirectory = new Array("/images/nbk3/news/");

			
			//this file preloads all the rollover images for this page
			
/* all of these are for the home images */

var home_button_names= new Array("nbkol-ab", "nbkol-sb", "nbkol-wq", "nbkol-ls","nbkol-pe",
                                "nbkol-tl","nbkol-hh","nbkol-bb","nbkol-h",
                                "nbkol-t", "nbkol-a", "nbkol-feat", "nbkol-qod",
                                "nbkol-n", "nbkol-sl", "nbkol-wf");

/* this will load the images used on this page into memory */
var home_numButtons=home_button_names.length;

var home_offImgArray = new Array(home_numButtons);
var home_onImgArray = new Array(home_numButtons);

/* load the actual images into the images array */

var home_i_rollover;
//create the off images (onMouseOut)

for(home_i_rollover=0;home_i_rollover<home_numButtons;home_i_rollover++){
	home_offImgArray[home_i_rollover] = new Image();
	
	home_offImgArray[home_i_rollover].src = home_imgDirectory+home_button_names[home_i_rollover]+"-d.gif";
}

for(home_i_rollover=0;home_i_rollover<home_numButtons;home_i_rollover++){
	home_onImgArray[home_i_rollover] = new Image();
	home_onImgArray[home_i_rollover].src = home_imgDirectory+home_button_names[home_i_rollover]+"-u.gif";
}
			
			<!-- this is generic javascript code for use in any product -->
			//--------------------------------------------------------------------
// These are the necessary rollover functions common to any
// javascript rollover, not page dependent.
//--------------------------------------------------------------------


//--------------------------------------------------------------------
// * doMouseOverButton
//--------------------------------------------------------------------
function doMouseOverButton(imgRootName, theName){
   thisIndex = getIndexFor(imgRootName, theName);
	//eval("document.images[theName].src = " + imgRootName + "_onImgArray[thisIndex].src");

	//get the image filename
	var imgFile = getOnImageFilename(imgRootName, theName);
	document.images[theName].src = imgFile;
}


//--------------------------------------------------------------------
// * doMouseOutButton
//--------------------------------------------------------------------
function doMouseOutButton(imgRootName, theName){
   thisIndex = getIndexFor(imgRootName, theName);
	//eval("document.images[theName].src = " + imgRootName + "_offImgArray[thisIndex].src");
	
	//get the image filename
	var imgFile = getOffImageFilename(imgRootName, theName);
	document.images[theName].src = imgFile;

}

//--------------------------------------------------------------------
// * getIndexFor
//--------------------------------------------------------------------
function getIndexFor(imgRootName, item) {

  var i_rolloveridx = 0;
  //var numButtons = eval(imgRootName + "_numButtons");
  //var button_names = eval(imgRootName + "_button_names");

  	var numButtons;
	var button_names;

	if(imgRootName == "home") {
		numButtons = home_numButtons;
		button_names = home_button_names;
	}
	else if(imgRootName == "alphbrw") {
		numButtons = alphbrw_numButtons;
		button_names = alphbrw_button_names;
	}
	else if(imgRootName == "subjbrw") {
		numButtons = subjbrw_numButtons;
		button_names = subjbrw_button_names;
	} 
	else if(imgRootName == "encycarticle") {
		numButtons = encycarticle_numButtons;
		button_names = encycarticle_button_names;
	}
	else if(imgRootName == "timelines") {
		numButtons = timelines_numButtons;
		button_names = timelines_button_names;
	}
	else if(imgRootName == "games") {
		numButtons = games_numButtons;
		button_names = games_button_names;
	}
	else if(imgRootName == "homework") {
		numButtons = homework_numButtons;
		button_names = homework_button_names;
	}
	else if(imgRootName == "gamemadmixup") {
		numButtons = gamemadmixup_numButtons;
		button_names = gamemadmixup_button_names;
	}
	else if(imgRootName == "newsarchive") {
		numButtons = newsarchive_numButtons;
		button_names = newsarchive_button_names;
	}
	else if(imgRootName == "news") {
		numButtons = news_numButtons;
		button_names = news_button_names;
	}

  for (i_rolloveridx=0; i_rolloveridx<numButtons; i_rolloveridx++) {
    if (item == button_names[i_rolloveridx]) return i_rolloveridx;
  }

  return -1;

}

function getOnImageFilename(imgRootName, imgname) {
	var thisindex = getIndexFor(imgRootName, imgname);
	if(imgRootName == "home") {
		return  home_onImgArray[thisindex].src;
	}
	else if(imgRootName == "alphbrw") {
		return  alphbrw_onImgArray[thisindex].src;
	}
        else if(imgRootName == "subjbrw") {
                return  subjbrw_onImgArray[thisindex].src;
        } 
	else if(imgRootName == "encycarticle") {
                return  encycarticle_onImgArray[thisindex].src;
        }
        else if(imgRootName == "timelines") {
                return  timelines_onImgArray[thisindex].src;
        }
        else if(imgRootName == "games") {
                return  games_onImgArray[thisindex].src;
        }
        else if(imgRootName == "homework") {
                return  homework_onImgArray[thisindex].src;
        }
        else if(imgRootName == "gamemadmixup") {
                return  gamemadmixup_onImgArray[thisindex].src;
        }
        else if(imgRootName == "newsarchive") {
                return  newsarchive_onImgArray[thisindex].src;
        }
        else if(imgRootName == "news") {
                return  news_onImgArray[thisindex].src;
        }

}

function getOffImageFilename(imgRootName, imgname) {
	var thisindex = getIndexFor(imgRootName, imgname);
	if(imgRootName == "home") {
		return  home_offImgArray[thisindex].src;
	}
	else if(imgRootName == "alphbrw") {
		return  alphbrw_offImgArray[thisindex].src;
	}
        else if(imgRootName == "subjbrw") {
                return  subjbrw_offImgArray[thisindex].src;
        } 
	else if(imgRootName == "encycarticle") {
                return  encycarticle_offImgArray[thisindex].src;
        }
        else if(imgRootName == "timelines") {
                return  timelines_offImgArray[thisindex].src;
        }
        else if(imgRootName == "games") {
                return  games_offImgArray[thisindex].src;
        }
        else if(imgRootName == "homework") {
                return  homework_offImgArray[thisindex].src;
        }
        else if(imgRootName == "gamemadmixup") {
                return  gamemadmixup_offImgArray[thisindex].src;
        }
        else if(imgRootName == "newsarchive") {
                return  newsarchive_offImgArray[thisindex].src;
        }
        else if(imgRootName == "news") {
                return  news_offImgArray[thisindex].src;
        }
}
