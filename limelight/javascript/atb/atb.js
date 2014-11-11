//ALL Products cookie domain name
//this will enable all products under grolier.com to see/modify this cookie.
var myDomain = ".grolier.com";

//statistics
// BEGIN cookiemanager.JS

	var kPreferenceEmail = "EM";
	var kPreferencePlugins = "PL";
	var kPreferenceCustomLogo = "CL";
	var kPreferenceAudio = "AU";
	var kPreferenceFrameless = "FL";
	var kPreferenceAdvertising = "AD";
	var kPreferenceToggle = "TO";
	var kPreferenceCurrentHome = "GH";
	var kPreferenceAppToggle = "ATO";
	var kPreferenceAppCurrentHome = "AGH";

	var kPREFSCookie = "prefs";
	var kGOLDomain = "grolier.com";
	var nameValueSeparator = ">";
	var CookieSeparator = "|";
	var MAX_COOKIE_LENGTH  = "3950";
	
	var kPreferenceValueKids = "K";
	var kPreferenceValueClassic = "C";
	var kPreferenceValuePassport = "P";
	var kPreferenceValueYes = "Y";
	var kPreferenceValueNo = "N";
	
function cookiemanager(cookieName) {
  var myCookieName = kPREFSCookie;

  if (arguments.length == 1) {
    myCookieName = cookieName;
  }
  
	/* STATIC VARIABLES */

	/* Store all of the current cookies into array so we can access them. */
	var cookie        = "";
	var index         = 0;
	var tmpcookie     = "";
	var kDefaultPath ="/";

	this.clear = function() {
		DeleteCookie(myCookieName, kDefaultPath, kGOLDomain);	
	}

	this.stripTrailingPipe = function(cookieString) {
		if (cookieString.charAt(cookieString.length - 1) == CookieSeparator) {
			cookieString = cookieString.substr(0, cookieString.length - 1);
		}	
		return cookieString;
	}	
	
	/* This function is deprecated, here for backwards compatibility */
	this.getSinglePrefValue = function(keyName) {
	  return this.getSingleValue(keyName);
	}


this.getSingleValue = function(keyName) {
	/* Specify a single key and I shall return you null or a value. */
	nullValue = null;
	var existingCookieString = GetCookie(myCookieName);
	
	if (existingCookieString == null || keyName == null) {
		return nullValue;	
	}	
	
	existingCookieString = this.stripTrailingPipe(existingCookieString);
	/* Get the entire array and split them by individual setting, then key/val */
	settingsArray = existingCookieString.split(CookieSeparator);
	var settingSize = settingsArray.length;
	for (index = 0; index < settingSize; index++) {
		thisSetting = settingsArray[index].split(nameValueSeparator);
		if (thisSetting[0] == keyName) {
			return thisSetting[1];	
		}
	}
	return nullValue;
}	

this.set = function(yourKey, yourValue)
{

	concatString = yourKey + nameValueSeparator + yourValue + CookieSeparator;
	//alert(concatString);
	var existingCookieString = GetCookie(myCookieName);
	//alert(existingCookieString);
	var cookieToSet = "";
	var settingSize;
	var index = 0;
	
	if (existingCookieString != null)
	{
		/* Get the string passed in, look for the key */
		prefToSet = concatString.substr(0, concatString.indexOf(nameValueSeparator));
		
		existingCookieString = this.stripTrailingPipe(existingCookieString);
		/* Get the entire settings array and split them by individual setting, then key/val */
		settingsArray = existingCookieString.split(CookieSeparator);
		
		settingSize = settingsArray.length;
		var keyFound = -1;
		for (index = 0; index< settingSize && keyFound == -1; index++) {
			/* split to look for this setting's key/value */
			thisSetting = settingsArray[index].split(nameValueSeparator);
			
			if(thisSetting[0] != null) {
				/* if this preference is the one we're looking to set, discard the old value */
				if (thisSetting[0] == prefToSet) {
					keyFound = index;
				}			
			}
			
		}
		
		if (keyFound == -1) {
			cookieToSet = existingCookieString + CookieSeparator + concatString;	
		}
		else {
			for (index = 0; index < settingSize; index ++) {
				if (index == keyFound) {
					cookieToSet = cookieToSet + concatString;	
				}	
				else {
					cookieToSet = cookieToSet + settingsArray[index] + CookieSeparator;
				}	
			}
		}
		SetCookieNoEscape(myCookieName, cookieToSet, null, kDefaultPath, kGOLDomain);			
		
	}
	else
	{
		SetCookieNoEscape(myCookieName, concatString, null, kDefaultPath, kGOLDomain);	
	}
		
	
}

}


// END cookiemanager.js
//****************************************************************
// Cookies -- Yum!
//****************************************************************

function getCookieVal (offset) {
  var endstr = document.cookie.indexOf (";", offset);
  if (endstr == -1)
    endstr = document.cookie.length;
  return unescape(document.cookie.substring(offset, endstr));
}
function FixCookieDate (date) {
  var base = new Date(0);
  var skew = base.getTime(); // dawn of (Unix) time - should be 0
  if (skew > 0)  // Except on the Mac - ahead of its time
    date.setTime (date.getTime() - skew);
}
function GetCookie (name) {
  var arg = name + "=";
  var alen = arg.length;
  var clen = document.cookie.length;
  var i = 0;
  while (i < clen) {
    var j = i + alen;
    if (document.cookie.substring(i, j) == arg)
      return getCookieVal (j);
        i = document.cookie.indexOf(" ", i) + 1;
    if (i == 0) break; 
  }
  return null;
}
function SetCookie (name,value,expires,path,domain,secure) {
  document.cookie = name + "=" + escape (value) +
    ((expires) ? "; expires=" + expires.toGMTString() : "") +
    ((path) ? "; path=" + path : "") +
    ((domain) ? "; domain=" + domain : "") +
    ((secure) ? "; secure" : "");
}

function DeleteCookie (name,path,domain) {
  if (GetCookie(name)) {
    document.cookie = name + "=" +
      ((path) ? "; path=" + path : "") +
      ((domain) ? "; domain=" + domain : "") +
      "; expires=Thu, 01-Jan-70 00:00:01 GMT";
  }
}

function SetCookieNoEscape (name,value,expires,path,domain,secure) {
	document.cookie = name + "=" + value +
            ((expires) ? "; expires=" + expires.toGMTString() : "") +
            ((path) ? "; path=" + path : "") +
            ((domain) ? "; domain=" + domain : "") +
            ((secure) ? "; secure" : "");
}


//for bookmarking
SetCookie("cltitle", document.title, null, "/", ".grolier.com", null);
//for printer-frendly email
theLocation = window.location.href;
if ((top != self) || (theLocation.indexOf ("ada") >= 0)){
	//remove docKey from url.
	i = theLocation.indexOf("&docKey");
	if (i > 1) {
		pfeurl = theLocation.substring(0,theLocation.indexOf("&docKey"));
	}
	else {
		pfeurl = theLocation;
	}
   SetCookie("pfeurl" , pfeurl, null, "/", ".grolier.com", null);
   SetCookie("new_page" , "yes", null, "/", ".grolier.com", null);
}
else {
   SetCookie("new_page" , "no", null, "/", ".grolier.com", null);
}
   
/* this is used to track the location of the main frame window, to determine when
   a user has changed from one page to another in the GO Frameset.
*/

var statsDomain = ".grolier.com";
SetCookie("clhref", window.location.href, null, "/", statsDomain, null);   

//this is used by the go dictionary to allow the user to double click on a word and have it automatically searched on.

//  This will capture all double events that hit the document object
//  and will call the getUserSelection method everytime a double click occurs

if (window.Event)
  document.captureEvents(Event.DBLCLICK);
  document.ondblclick = getUserSelection;

function getUserSelection() {

	//  The getSelection method is valid for IE5 but is not used, instead IE4 and IE5
	//  support the ability to create an invisible text range and to grab the users selection
	//  from that object
	
	//  Netscape 4.x suppors the getSelection method
	
	//  Because IE5 appears to accept the getSelection method as valid and it really doesn't work
	//  we need to check to see if the range selection is valid first, otherwise the selection
	//  would never be gotten
	
	if (document.selection && document.selection.createRange)
	{
      		var range = document.selection.createRange();
      		var str = range.text;
      		SetCookie("wordlookup", str, null , "/", myDomain);
	}	
	else if (window.getSelection )
	{
      		var str = window.getSelection();
      		SetCookie("wordlookup", str, null , "/", myDomain);
   	}	

}

<!-- hide JavaScript from non-JavaScript browsers -->
<!-- end browsercheck.js -->


//if (IE) {
//  document.domain = "grolier.com";
//}

<!-- begin nsdd623.70.js -->

if (!IE) {
//alert(navigator.userAgent);

var ddnav = navigator.userAgent;

//Netscape 6.2.x and Netscape 7.0 have problems loading goatlas 
//information in the main frame, so I am going to set the document.domain
//to grolier.com so these browsers can exchange information without causing 
//potential security flaws.  

if (ddnav.indexOf("Netscape6/6.2") != -1 || ddnav.indexOf("Netscape/7.0") != -1) {
  document.domain = "grolier.com";
}

if (ddnav.indexOf("Firefox") != -1) {
	document.domain = "grolier.com";
}
}

<!-- end nsdd623.70.js -->



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



stateCookie = new cookiemanager("atbOptions");  // create cookie

parseQueryString();

page = "";
page = getQueryParameterValue('tp');


if (page.indexOf('state.html') == 0 || page.indexOf('/state.html') == 0)
{
	//alert('state.html will set cookie');
	stateCookie.set("stateId", "Y");			  // set cookie
}
else
{
	if (page.indexOf('/encyc/map.html') == 0 || page.indexOf('/encyc/medialist_popup.html') == 0 || document.location.href.indexOf('popup/states.html') != -1 || document.location.href.indexOf('pp_email') != -1 || document.location.href.indexOf('cat') != -1)
	{
		//alert('will not change cookie');
	}
	else
	{
		//alert('cookie will be deleted');
		stateCookie.set("stateId", "N");
	}
	
}

   //statistics

<!-- this variable is needed by search when searching by this state only -->
var StateID = "atb044"
var Feature = "";

var gBlurbWindow;
var SearchWindow;

function OpenBlurbWindow(inContentURL, inWidth, inHeight, inWindowName, inResize)
{
    if ((inResize == "on") || (inResize == "yes"))
	gBlurbWindow = window.open(inContentURL,inWindowName,"height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=yes,resizable=yes,status=yes")
    else
        gBlurbWindow = window.open(inContentURL, inWindowName, "height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=yes")
    gBlurbWindow.opener = window
}

/* This window doesn't have location or menu bars */
function OpenBoxWindow(inContentURL, inWidth, inHeight, inWindowName, inResize)
{
	
    if ((inResize == "on") || (inResize == "yes"))
	gBlurbWindow = window.open(inContentURL,inWindowName,"height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=no,resizable=yes")
    else
        gBlurbWindow = window.open(inContentURL, inWindowName, "height="+inHeight+",width="+inWidth+",status=yes,scrollbars=yes,menubar=no")
    gBlurbWindow.opener = window
}

/* This window doesn't have location or menu bars or status bars*/
function OpenBoxWindowNoStatus(inContentURL, inWidth, inHeight, inWindowName, inResize)
{
    if ((inResize == "on") || (inResize == "yes"))
	gBlurbWindow = window.open(inContentURL,inWindowName,"height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=no,resizable=yes")
    else
        gBlurbWindow = window.open(inContentURL, inWindowName, "height="+inHeight+",width="+inWidth+",status=no,scrollbars=yes,menubar=no")
    gBlurbWindow.opener = window
}


function OpenWindowText(inContentText, inWidth, inHeight, inWindowName, inResize, theOpener)
{
    if (inContentText == "") {
	inContentText = windowContents;   //a variable set outside of this file
    }

    if ((inResize == "on") || (inResize == "yes"))
	gBlurbWindow = window.open("",inWindowName,"height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=yes,resizable=yes")
    else
        gBlurbWindow = window.open("",inWindowName,"height="+inHeight+",width="+inWidth+",scrollbars=yes,menubar=yes")

    if (theOpener) gBlurbWindow.opener = theOpener;
    else gBlurbWindow.opener = window;

   gBlurbWindow.document.write("\<script language=javascript\>\n");
   gBlurbWindow.document.write("function loadParent(newLocation) {window.opener.location = newLocation;}\n\<\/script\>");

   gBlurbWindow.document.write(inContentText);
   gBlurbWindow.document.close();
}

function OpenATBSearchWindow() {

  ContentURL = "http://csdev.grolier.com:2200/atb/advanced_search.jsp";

  SearchWindow = window.open(ContentURL, "advSearch", "height=450,width=450,scrollbars=yes,menubar=yes,resizable=yes");
  SearchWindow.opener = window;

}

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

// START OF TOP_ROLLOVERS.JS
/* This file is used by the article page.  This is the only 
 	way to get these rollovers to work with Netscape 3.x
 	All the simpler ways to do this work fine with Netscape 4.1+
 	*/

var Feature;

var feature_names= new Array("topics","almanac","games","timelines","profiles","bulletin","");
var numFeatures=feature_names.length;
var imgDirectory="images/btn_";

var topLevelIndex = getIndexFor(Feature);

/* The following section creates the 3 different button types.  The base color (blue), the 
	rollover color (red) and the active color (gray/brown).
	Upon demand these will be changed. */
	
var offImgArray = new Array(numFeatures);  //these buttons are blue
var onImgArray = new Array(numFeatures);   //these buttons are red
var activeImgArray = new Array(numFeatures); //these buttons are brown
var imagesLoaded = "no";

function loadImages() {
	var i;
	//create the off images (onMouseOut)
	for(i=0;i<numFeatures;i++){
		offImgArray[i] = new Image();
		offImgArray[i].src = imgDirectory+feature_names[i]+"_u.gif";
	}

	//create the on images (onMouseOver)
	for(i=0;i<numFeatures;i++){
		onImgArray[i] = new Image();
		onImgArray[i].src = imgDirectory+feature_names[i]+"_d.gif";
	}

	//create the active images (whichever is the topmost ancestor of current article)
	for(i=0;i<numFeatures;i++){
		activeImgArray[i] = new Image();
		activeImgArray[i].src = imgDirectory+feature_names[i]+"_d.gif";
	}
	imagesLoaded = "yes";
}
//--------------------------------------------------------------------
// * doMouseOverButton
//--------------------------------------------------------------------
function doMouseOverButton(theName){
	if (imagesLoaded != "yes") loadImages();
	thisIndex = getIndexFor(theName);
   if (thisIndex == topLevelIndex) {
   	document.images[theName].src = activeImgArray[thisIndex].src
   }
   else {
		document.images[theName].src = onImgArray[thisIndex].src
	}
  }

//--------------------------------------------------------------------
// * doMouseOutButton
//--------------------------------------------------------------------
function doMouseOutButton(theName){
   thisIndex = getIndexFor(theName);
   if (thisIndex == topLevelIndex) {
   	document.images[theName].src = activeImgArray[thisIndex].src
   }
   else {
   	document.images[theName].src = offImgArray[thisIndex].src
   }
}

//--------------------------------------------------------------------
// * doActiveImage
//--------------------------------------------------------------------
function doActiveImage() {

	if (Feature == "") return;
	loadImages(); 
	topLevelIndex = getIndexFor(Feature);
	//	alert("Feature " + Feature + "\ntopLevelIndex " + topLevelIndex);

		theName = feature_names[topLevelIndex];
		document.images[theName].src = activeImgArray[topLevelIndex].src;
}

function getIndexFor(item) {
	
  var i;
  for (i=0; i<numFeatures; i++) {
    if (item == feature_names[i]) return i;
  }
  return -1;	//not found

}

// END OF TOP_ROLLOVERS.JS
// START OF ROLLOVERS_ENCYC.JS
/* This file is used by the article page.  This is the only 
 	way to get these rollovers to work with Netscape 3.x
 	All the simpler ways to do this work fine with Netscape 4.1+
 	*/
parseQueryString();
var toplevel = getQueryParameterValue("cat");
var button_names= new Array("ti", "tf", "th", "tl","te","tr","tg","tc","h-","b-");

var numButtons=button_names.length;

/* The article page builder will put the top level article id in the toplevel variable.
	This array is then searched to obtain the index number to then obtain the corresponding
	button name.  The button_names array and article_names array must be in the same order
	or this doesn't work. */

var topBrowseLevelIndex = getBrowseIndexFor(toplevel);
var imgBrowseDirectory="images/browse/nav_";

/* The following section creates the 3 different button types.  The base color (blue), the 
	rollover color (red) and the active color (gray/brown).
	Upon demand these will be changed. */
	
var offBrowseImgArray = new Array(numButtons);  //these buttons are blue
var onBrowseImgArray = new Array(numButtons);   //these buttons are red
var activeBrowseImgArray = new Array(numButtons); //these buttons are brown

var i;

function loadBrowseImages() {
	//create the off images (onMouseOut)
	for(i=0;i<numButtons;i++){
		offBrowseImgArray[i] = new Image();
		offBrowseImgArray[i].src = imgBrowseDirectory+button_names[i]+"_a.gif";
	}

	//create the on images (onMouseOver)
	for(i=0;i<numButtons;i++){
		onBrowseImgArray[i] = new Image();
		onBrowseImgArray[i].src = imgBrowseDirectory+button_names[i]+"_b.gif";
	}

	//create the active images (whichever is the topmost ancestor of current article)
	for(i=0;i<numButtons;i++){
		activeBrowseImgArray[i] = new Image();
		activeBrowseImgArray[i].src = imgBrowseDirectory+button_names[i]+"_b.gif";
	}
}
//--------------------------------------------------------------------
// * doBrowseMouseOverButton
//--------------------------------------------------------------------
function doBrowseMouseOverButton(theName){
   thisIndex = getBrowseIndexFor(theName);
   if (thisIndex == topBrowseLevelIndex) {
   	document.images[theName].src = activeBrowseImgArray[thisIndex].src
   }
   else {
		document.images[theName].src = onBrowseImgArray[thisIndex].src
	}
  }

//--------------------------------------------------------------------
// * doBrowseMouseOutButton
//--------------------------------------------------------------------
function doBrowseMouseOutButton(theName){
   thisIndex = getBrowseIndexFor(theName);
   if (thisIndex == topBrowseLevelIndex) {
   	document.images[theName].src = activeBrowseImgArray[thisIndex].src
   }
   else {
   	document.images[theName].src = offBrowseImgArray[thisIndex].src
   }
}

//--------------------------------------------------------------------
// * doActiveBrowseImage
//--------------------------------------------------------------------
function doActiveBrowseImage() {
		loadBrowseImages();
		theName = button_names[topBrowseLevelIndex];
		document.images[theName].src = activeBrowseImgArray[topBrowseLevelIndex].src;
}

function getBrowseIndexFor(item) {
	
  var i;
  for (i=0; i<numButtons; i++) {
    if (item == button_names[i]) return i;
  }
  return -1;	//not found

}

// END OF ROLLOVERS_ENCYC.J
<!-- begin:bookmark.js --> 

// usageHome variable must be defined before you include this file

function addBookmark() { 
 
  // get user info and convert to lower case for ease of use  
  var agt = navigator.userAgent.toLowerCase();  
 
  // display direction popup flag 
  var display = 0;     
 
  // if pc 
  if ( agt.indexOf("win") != -1 ) { 
    // if ie, execute javascript function  
    if (navigator.appVersion.toLowerCase().indexOf('msie') != -1) { 
      window.external.AddFavorite(location.href, document.title); 
    } else { 
      display = 1; 
    } 
  } else if ( agt.indexOf("mac") != -1 ) { 
    display = 1; 
  } 

  // Display bookmarking directions     
  if ( display ) {
    bookWin = window.open(usageHome + "/rd\?feature=/static/bookmark.php&title=" + escape(document.title), 'bookmark', 'height=250,width=350,resizable=no,menubar=no,status=yes,toolbar=no,locationbar=no'); 
    bookWin.focus();
  }
}  


<!-- end:bookmark.js --> 
 
/* Used by the */
var usageHome = "http://qadev.grolier.com:2004";