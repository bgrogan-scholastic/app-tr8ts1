function visitGO() {


        var authpass = GetCookie("auth-pass");
        //alert(authpass);
        if (authpass != null) {
			   //dynamic to server. this page will prob have to convert to php, 
			   //unless you want to use that hack from feature showcase...
               document.location.href="http://currdev.grolier.com:2004/";
        }
        else {
                document.location.href='http://auth.grolier.com/cgi-bin/authV2';
        }


}

function setPreferences(thisform) {
  var startpage = "";
  var toggling = "";
  var cookieValue = "";
  
  for (i=0; i<thisform.startpage.length; i++) {
    if (thisform.startpage[i].checked) {
      startpage = thisform.startpage[i].value;
    }	
  }
  
  if (thisform.toggling.checked) {
    toggling = "N";
  }
  else {
    toggling = "Y";
  }
  
  var ToggleCookie = "TO";
  var CurrentHomeCookie = "CH";
  var endOfTime  = "Sun, 17 Jan 2038 19:14:07 GMT";

  if (startpage != "" && toggling!= "") {
    SetCookie(ToggleCookie, toggling, endOfTime, "/", ".grolier.com");
    SetCookie(CurrentHomeCookie, startpage, endOfTime, "/", ".grolier.com");
    if (theprefCookie.getSinglePrefValue(kPreferenceAppCurrentHome) != null) {
		theprefCookie.setPrefCookies(kPreferenceAppCurrentHome, startpage);
	}
    if (theprefCookie.getSinglePrefValue(kPreferenceAppToggle) != null) {
		theprefCookie.setPrefCookies(kPreferenceAppToggle, toggling);
	}
    alert("Your preferences have been saved.");    
    return true;
  }	
  else {
    alert("Please choose either Grolier Online Kids or Grolier Online Passport as your default home page.");
    return false;
  }
}

function readPreferences() {
	prefsCookie = GetCookie(kPREFSCookie);
	alert(prefsCookie);
}


