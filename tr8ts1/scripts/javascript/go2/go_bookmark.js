<!-- begin:go_bookmark.js --> 
// usageHome variable must be defined before you include this file
// cookies.js must be included for this to work.
function addBookmark() { 
  // get user info and convert to lower case for ease of use  
  var agt = navigator.userAgent.toLowerCase();  
  // display direction popup flag 
  var display = 0;     
  // if pc 
  if (agt.indexOf("win") != -1) { 
    // if ie, execute javascript function  
    if (navigator.appVersion.toLowerCase().indexOf('msie') != -1) { 
    	theURL = theCookie.GetCookie("pfeurl");
	if (theURL == "") {
		theURL = theCookie.GetCookie("clhref");
	}
      window.external.AddFavorite(theURL, theCookie.GetCookie("cltitle")); 
    } else { display = 1; } 
  } else if ( agt.indexOf("mac") != -1 ) { display = 1; } 
  // Display bookmarking directions     
  if (display) {
    bookWin = window.open(usageHome + "/rd\?feature=/static/bookmark.php&title=" + escape(theCookie.GetCookie("cltitle")), 'bookmark', 'height=250,width=350,resizable=no,menubar=no,status=yes,toolbar=no,locationbar=no'); 
    bookWin.focus();
  }
}  
<!-- end:go_bookmark.js --> 