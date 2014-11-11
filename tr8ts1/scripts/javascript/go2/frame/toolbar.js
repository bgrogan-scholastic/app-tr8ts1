<!-- begin cookies.js -->

function Cookie() {
	this.getCookieVal = function(offset) {
		var endstr = document.cookie.indexOf (";", offset);
		if (endstr == -1) {
			endstr = document.cookie.length;
		}
		return unescape(document.cookie.substring(offset, endstr));
	}
	this.GetCookie = function(name) {
		var arg = name + "=";
		var alen = arg.length;
		var clen = document.cookie.length;
		var i = 0;
		while (i < clen) {
			var j = i + alen;
			if (document.cookie.substring(i, j) == arg) {
				return this.getCookieVal (j);
			}
		        i = document.cookie.indexOf(" ", i) + 1;
			if (i == 0) break; 
		}
		return null;
	}
	this.SetCookie = function(name,value,expires,path,domain,secure) {
			document.cookie = name + "=" + escape (value) +
			((expires) ? "; expires=" + expires.toGMTString() : "") +
			((path) ? "; path=" + path : "") +
			((domain) ? "; domain=" + domain : "") +
			((secure) ? "; secure" : "");
	}
	this.SetCookieNoEscape = function(name,value,expires,path,domain,secure) {
		document.cookie = name + "=" + value +
			((expires) ? "; expires=" + expires.toGMTString() : "") +
			((path) ? "; path=" + path : "") +
			((domain) ? "; domain=" + domain : "") +
			((secure) ? "; secure" : "");
	}
	this.DeleteCookie = function(name,path,domain) {
		if (this.GetCookie(name)) {
			document.cookie = name + "=" +
				((path) ? "; path=" + path : "") +
				((domain) ? "; domain=" + domain : "") +
				"; expires=Thu, 01-Jan-70 00:00:01 GMT";
		}
	}
}

theCookie = new Cookie();
//This is needed for window control.
theCookie.SetCookie("clhref", window.location.href, null, "/", ".grolier.com", null);
//for printer-frendly email
theLocation = window.location.href;

if ( (theLocation.indexOf("jsp") >= 0) && (top != self) ) {
	pfeurl = "donotprintthissearchresultspage";
   	theCookie.SetCookie("pfeurl" , pfeurl, null, "/", ".grolier.com", null);
   	theCookie.SetCookie("new_page" , "yes", null, "/", ".grolier.com", null);
}
else if ((top != self) || (theLocation.indexOf ("ada") >= 0)){
	//remove docKey from url.
	i = theLocation.indexOf("&docKey");
	if (i > 1) {
		pfeurl = theLocation.substring(0,theLocation.indexOf("&docKey"));
	}
	else {
		pfeurl = theLocation;
	}
   	theCookie.SetCookie("pfeurl" , pfeurl, null, "/", ".grolier.com", null);
	//for frame bookmarking
	theCookie.SetCookie("cltitle", document.title, null, "/", ".grolier.com", null);
	theCookie.SetCookie("new_page" , "yes", null, "/", ".grolier.com", null);
}
else {
   theCookie.SetCookie("new_page" , "no", null, "/", ".grolier.com", null);	
}
<!-- end cookies.js -->









/* The Toolbar
	Implemented Using Design Pattern:	Subject/Observer

	When the user navigates to a new page, two cookies may
	or may not be affected.  (1) the new_page cookies is
	set to yes and the pfeurl cookie is updated to contain
	the url to be used for generating the citation information
	and deciding whether or not the page change would affect
	the toolbar (print/email/lexile).
	
	The cookies are monitored through a "checkForActivity" 
	function in javascript and a call to update all the observers
	(email, printfull printsections, lexile and bookmark).
	
*/	

// this is the definition for the subject
// it contains the data and methods the observers
// look at
function Subject() {
	// put constructor stuff here so the rest of the object
	// is defined when it's constructed
	this.data = new Array();
	this.observers = new Array();
	// initialize the array as we always have a bookmark
	this.data["lexile"] = true;
	this.data["full"] = true;
	this.data["section"] = true;
	this.data["email"] = true;
}
// define some 'constants' for the class
Subject.prototype.LEXILE = "lexile";
Subject.prototype.FULL = "full";
Subject.prototype.SECTION = "section";
Subject.prototype.EMAIL = "email";

// this method handles changes to the data by
// checking for a new_page cookie being set to yes.
Subject.prototype.dataChanged = function(checkbox) {
	switch(checkbox.name) {
		case "articleFull":
			this.data[subject.FULL] = checkbox.checked;
			break;
		case "articleSection":
			this.data[subject.SECTION] = checkbox.checked;
			break;
		case "articleEmail":
			this.data[subject.EMAIL] = checkbox.checked;
			break;
		case "articleBookmark":
			this.data[subject.BOOKMARK] = checkbox.checked;
			break;
	}
	// set the cookie value
	this.setCookie();
}
// this method 'attaches' an observer to the subject
// so it can be notified of changes to the data
Subject.prototype.attach = function(observer) {
	// insert an obsever into the list to notify
	this.observers.push(observer);
}
// this method calls the update() method of all
// the registered observers
Subject.prototype.notify = function() {
	// iterate through list of observers
	for(var i in this.observers) {
		//tell each observer to 
		this.observers[i].update();
	}
}

//This is not necessary -- misunderstanding by Doug as to what
//the cookie is about.  However, I may need this type of functionality
//for something else.  I'll keep a little longer.
Subject.prototype.setCookie = function() {
	var cookieArray = new Array();
	if(this.data[subject.FULL]) {
		cookieArray.push(subject.FULL);
	}
	if(this.data[subject.SECTION]) {
		cookieArray.push(subject.SECTION);
	}
	if(this.data[subject.EMAIL]) {
		cookieArray.push(subject.EMAIL);
	}
//	if(this.data[subject.BOOKMARK]) {
		cookieArray.push(subject.BOOKMARK);	//always on.
//	}
	theCookie.SetCookie("toolbar", cookieArray.join("|"));
	// notify the observers of the change
	this.notify();
}
Subject.prototype.getData = function(key) {
	retval = null;
	try {
		retval = this.data[key];
	} catch(e) {
		alert("The key " + key + " doesn't exist in data");
	}
	return retval;
}

// this is the parent class for all observers
function Observer() {
	// initialize the Observer data
	this.oldData = null;
}

// this is an actual observer, it defines the specific update method
function FullObserver(subject) {
	this.subject = subject;
	this.oldData = this.subject.getData(this.subject.FULL);
}
FullObserver.prototype = new Observer();
FullObserver.prototype.constructor = FullObserver;
FullObserver.prototype.update = function() {
	debug("calling FullObserver.update");
	// is the current data different from the old data?
	newData = this.subject.getData(this.subject.FULL);
	debug("newData = " + newData + "\nthis.oldData = " + this.oldData);
	if(newData != this.oldData) {
		// save current data state
		this.oldData = newData;
		// should we add or del the print full button?
		newData ? this.addButton() : this.delButton();
	}
}
FullObserver.prototype.addButton = function() {
	// create span element
	var span = document.createElement("span");
	span.setAttribute("id", "ArticleFull");
	// create the href link
	var a = document.createElement("a");
	a.setAttribute("href", "javascript:thePopup.newWindow('http://gme.grolier.com/page?tn=/printemail/p_see_article.html&id=0139020-0&text=full',popupWidth, popupHeight,'Print','yes','yes','yes','yes','yes','yes');");
	a.setAttribute("class", "ibttnface");
	// create the text node
	var text = document.createTextNode("Print full article");
	a.appendChild(text);
	span.appendChild(a);
	// create spacers
	var spacers = document.createTextNode('\u00a0\u00a0\u00a0|\u00a0\u00a0\u00a0');
	span.appendChild(spacers);
	// get a reference to the toolbar	
	var toolbar = document.getElementById("toolbarSpan");
	// do we have childnodes?
	if(toolbar.hasChildNodes()) {
		// iterate over the nodes and position new span
		for(var node = toolbar.firstChild; node != null; node = node.nextSibling) {
			// should we insert our node here? 
			if(node.id == "ArticleSection" || node.id == "ArticleEmail" || node.id == "ArticleBookmark") {
				toolbar.insertBefore(span, node);
				break;
			}
		}
	// otheriwse, just append this node
	} else {
		toolbar.appendChild(span);
	}
}
FullObserver.prototype.delButton = function() {
	// get a reference to the toolbar	
	var toolbar = document.getElementById("toolbarSpan");
	toolbar.removeChild(document.getElementById("ArticleFull"));
}

// this is an actual observer, it defines the specific update methodfunction SectionObserver(subject) {
	this.subject = subject;
	this.oldData = this.subject.getData(this.subject.SECTION)
}
SectionObserver.prototype = new Observer();
SectionObserver.prototype.constructor = SectionObserver;
SectionObserver.prototype.update = function() {
	debug("calling SectionObserver.update");
	// is the current data different from the old data?
	newData = this.subject.getData(subject.SECTION);
	debug("newData = " + newData + "\nthis.oldData = " + this.oldData);
	if(newData != this.oldData) {
		debug("adding/deleting a section");
		// save current data state
		this.oldData = newData
		// should we add or del the print full button?
		newData ? this.addButton() : this.delButton();
	}
}
SectionObserver.prototype.addButton = function() {
	// create span element
	var span = document.createElement("span");
	span.setAttribute("id", "ArticleSection");
	// create the href link
	var a = document.createElement("a");
	a.setAttribute("href", "javascript:thePopup.newWindow('http://gme.grolier.com/page?tn=/printemail/p_see_article.html&id=0139020-0&text=sections',popupWidth, popupHeight,'Print','yes','yes','yes','yes','yes','yes');");
	a.setAttribute("class", "ibttnface");
	// create the text node
	var text = document.createTextNode("Print sections");
	a.appendChild(text);
	span.appendChild(a);
	// create spacers
	var spacers = document.createTextNode('\u00a0\u00a0\u00a0|\u00a0\u00a0\u00a0');
	span.appendChild(spacers);
	// get a reference to the toolbar	
	var toolbar = document.getElementById("toolbarSpan");
	// do we have childnodes?
	if(toolbar.hasChildNodes()) {
		// iterate over the nodes and position new span
		for(var node = toolbar.firstChild; node != null; node = node.nextSibling) {
			// should we insert our node here? 
			if(node.id == "ArticleEmail" || node.id == "ArticleBookmark") {
				toolbar.insertBefore(span, node);
				break;
			}
		}
	// otherwise, just append this node
	} else {
		toolbar.appendChild(span);
	}
}
SectionObserver.prototype.delButton = function() {
	// get a reference to the toolbar	
	var toolbar = document.getElementById("toolbarSpan");
	toolbar.removeChild(document.getElementById("ArticleSection"));
}

// this is an actual observer, it defines the specific update methodfunction EmailObserver(subject) {
	this.subject = subject;
	this.oldData = this.subject.getData(this.subject.EMAIL)
}
EmailObserver.prototype = new Observer();
EmailObserver.prototype.constructor = EmailObserver;
EmailObserver.prototype.update = function() {
	debug("calling EmailObserver.update");
	// is the current data different from the old data?
	newData = this.subject.getData(subject.EMAIL);
	debug("newData = " + newData + "\nthis.oldData = " + this.oldData);
	if(newData != this.oldData) {
		debug("adding/deleting an email");
		// save current data state
		this.oldData = newData
		// should we add or del the print Email button?
		newData ? this.addButton() : this.delButton();
	}
}
EmailObserver.prototype.addButton = function() {
	// create span element
	var span = document.createElement("span");
	span.setAttribute("id", "ArticleEmail");
	// create the href link
	var a = document.createElement("a");
	a.setAttribute("href", "javascript:thePopup.newWindow('http://gme.grolier.com/page?tn=/printemail/p_email_popup.html&id=0139020-0&text=full',popupWidth, popupHeight,'Print','yes','yes','yes','yes','yes','yes');");
	a.setAttribute("class", "ibttnface");
	// create the text node
	var text = document.createTextNode("E-mail article");
	a.appendChild(text);
	span.appendChild(a);
	// create spacers
	var spacers = document.createTextNode('\u00a0\u00a0\u00a0|\u00a0\u00a0\u00a0');
	span.appendChild(spacers);
	// get a reference to the toolbar	
	var toolbar = document.getElementById("toolbarSpan");
	// are there any childnodes?
	if(toolbar.hasChildNodes()) {
		// iterate over the nodes and position new span
		for(var node = toolbar.firstChild; node != null; node = node.nextSibling) {
			// should we insert our node here? 
			if(node.id == "ArticleBookmark") {
				toolbar.insertBefore(span, node);
				break;
			}
		}
	// otherwise, just append this node
	} else {
		toolbar.appendChild(span);
	}
}
EmailObserver.prototype.delButton = function() {
	// get a reference to the toolbar	
	var toolbar = document.getElementById("toolbarSpan");
	toolbar.removeChild(document.getElementById("ArticleEmail"));
}

// this is an actual observer, it defines the specific update methodfunction BookmarkObserver(subject) {
	this.subject = subject;
	this.oldData = this.subject.getData(this.subject.BOOKMARK)
}
BookmarkObserver.prototype = new Observer();
BookmarkObserver.prototype.constructor = BookmarkObserver;
BookmarkObserver.prototype.update = function() {
	debug("calling BookmarkObserver.update");
	//the bookmark is always on so no change will ever be done
	//by this observer.  In fact, I think this observer should
	//go bye-bye.  I'll see later.  - dyl.
	// is the current data different from the old data?
/*	newData = this.subject.getData(subject.BOOKMARK);
	if(newData != this.oldData) {
		debug("adding/deleting a bookmark");
		// save current data state
		this.oldData = newData
		// should we add or del the print full button?
		newData ? this.addButton() : this.delButton();
	} */
}
BookmarkObserver.prototype.addButton = function() {
	// create span element
	var span = document.createElement("span");
	span.setAttribute("id", "ArticleBookmark");
	// create the href link
	var a = document.createElement("a");
	a.setAttribute("href", "javascript:addBookmark();");
	a.setAttribute("class", "ibttnface");
	// create the text node
	var text = document.createTextNode("Bookmark Article");
	a.appendChild(text);
	span.appendChild(a);
	// create spacers
	var spacers = document.createTextNode('\u00a0\u00a0\u00a0');
	span.appendChild(spacers);
	// get a reference to the toolbar	
	var toolbar = document.getElementById("toolbarSpan");
	toolbar.appendChild(span);
}
BookmarkObserver.prototype.delButton = function() {
	// get a reference to the toolbar	
	var toolbar = document.getElementById("toolbarSpan");
	toolbar.removeChild(document.getElementById("ArticleBookmark"));
}

// build our subject/observer hierarchy
var subject = new Subject();
subject.attach(new FullObserver(subject));
subject.attach(new SectionObserver(subject));
subject.attach(new EmailObserver(subject));
subject.attach(new BookmarkObserver(subject));


//***************** From the old frame
var kCurrentProduct = "CurrentProduct";
var kPreviousProduct = "PrevProduct";
var kCLHref = "clhref";
var in_check_currentproduct_function = false;
var initState = "";
var kCurrState = "stateId";
/* set up the clhref / previous clhref cookies */
//var clhref_current = theCookie.GetCookie(kCLHref);
var clhref_current = theCookie.GetCookie("pfeurl");
var clhref_previous = "";

function triggerUpdate(newurl) {
	theCookie.SetCookie("new_page","yes",null,"/",".grolier.com",null);
	theCookie.SetCookie("clhref",newurl,null,"/",".grolier.com",null);
	theCookie.SetCookie("pfeurl",newurl,null,"/",".grolier.com",null);
}

function checkForActivity() {
//	alert("checkForActivity");
//not defined	checkForProductChange();

	clhref_current = theCookie.GetCookie(kCLHref);

	/* Now we have to update the toolbar if there's a page change ...
	   ignore popup pages or pages that already have new_page set to no */
	if ( (clhref_current.indexOf("popup") < 0) && (theCookie.GetCookie("new_page") != "no") ) {

		/* this is a new page */
		if (clhref_current != clhref_previous) {
			clhref_previous = clhref_current;
			updateToolbar();
		}
	}
	else {
		/* in a popup */
		clhref_previous = clhref_current;
	}

  /* recursively check for new activity */
  setTimeout("checkForActivity()", 1000);	
}
function checkForProductChange() {
  //alert("checking for product switching");
  previousProduct = theCookie.GetCookie(kPreviousProduct);
  currentProduct = theCookie.GetCookie(kCurrentProduct);
  if (previousProduct != currentProduct) {
    //alert("new product visited, reloading frame & resetting cookies");
    theCookie.SetCookie(kPreviousProduct, currentProduct, null, "/", ".grolier.com", null);
  }
  if (currentProduct == "atb.grolier.com") {
    checkForATBState();
  }
}
function checkForATBState() {
  // for ATB only, determine whether to display search by state radio button
  if (theCookie.GetCookie(kCurrentProduct) == "atb.grolier.com") {
    if (typeof atbStateCookie != "undefined") {
      var currState = atbStateCookie.getSingleValue(kCurrState);
      if (initState != currState) {
        // refresh search frame to display change in ATB search form
        reloadThisFrame();
      }
      else if (initState == 'Y' && currState == 'Y') {
        // check if we switched from one state to another directly
        CLHref = theCookie.GetCookie(kCLHref);
        var CLHrefStateId = getStateIdInHref(CLHref);
        var initLHrefStateId = getStateIdInHref(initLHref);
        if (CLHrefStateId.length > 0 && initLHrefStateId.length > 0 && initLHrefStateId != CLHrefStateId) {
          // refresh search frame to display change in ATB search form
          reloadThisFrame();
        }
      }
    }
  }
}
function updateToolbar() {
	//time to refresh the toolbar.
	alert("updateToolbar");
	theCookie.SetCookie("new_page","no",null,"/",".grolier.com",null);
	
}
// set up some event handlers here
// I took this over from the <input type='checkbox' onClick=''> system in HTML 
function buildHandlers() {
	theCookie.SetCookie("new_page" , "yes", null, "/", ".grolier.com", null);
	setTimeout( "checkForActivity()", 1000 );
}
// make sure our event handlers are initialized after the Email page is loaded
onloadOriginal = window.onload;
window.onload = buildHandlers;

