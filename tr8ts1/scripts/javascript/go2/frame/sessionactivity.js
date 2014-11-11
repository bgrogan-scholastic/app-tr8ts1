<!-- begin:sessionactivity.js --> 
//Must include querystring.js for randomizing the url
function reloadThisFrame() {
  var rand = (Math.round(Math.random()*1000));
  thePair = "&rand=" + theQueryString.extractValue(document.location.href,"rand=");
  newurl = theQueryString.removeNvPair(document.location.href,thePair,"&");
  newurl = newurl + "&rand=" + rand;
  document.location.href = newurl;
}
/* functions for capturing session statistics */
function updateSystemTimeClock(mychoice){
  /* set the current timestamp value to the current date/time */
  var myDate = new Date();
  /* this returns the current time as the # of milliseconds since Jan.1 1970 */
  myDate = myDate.getTime();
  currentTimeStamp = myDate;
  if(mychoice != kNoFlag)
  {
    /* recursively call myself every 2 seconds */
    setTimeout("updateSystemTimeClock(kYesFlag)", 2000);
  }
}
function checkForActivity() {
  //alert("GO Logo checking for new activity");
  if (theCookie.GetCookie("clhref") != previousCLHref) {
    //for pfe
    previousCLHref = theCookie.GetCookie("clhref");
    if ( (currentTimeStamp - last_req_ts) >= kDeltaTimeout) {
      //alert("5 minutes of inactivity, record a new session");
      last_req_ts = currentTimeStamp;
      /* set a cookie which will trigger a recording of a session statistic */
      theCookie.SetCookie("rec_ses", "yes", null, "/", ".grolier.com", null);
      theCookie.SetCookie(kLastRequestTimeStampCookie, last_req_ts, null, "/", ".grolier.com", null);
      reloadThisFrame();
    }
    last_req_ts = currentTimeStamp;	    
    theCookie.SetCookie(kLastRequestTimeStampCookie, last_req_ts, null, "/", ".grolier.com", null);
  }
  /* recursively check for new activity */
  setTimeout("checkForActivity()", 1000);	
}
/* incorporate the session statistics code */
var kNoFlag = "n";
var kYesFlag = "y";
var kLastRequestTimeStampCookie = "last_req_ts";

/* set the inactivity timer to 5 minutes or 300000 milliseconds */
var kDeltaTimeout = 300000;
//var kDeltaTimeout = 50000; //for testing
var previousCLHref = theCookie.GetCookie("clhref");
/* this variable contains the current time in milli-seconds from Jan 1, 1970 */
var currentTimeStamp = null;
/* get the current last request timestamp */
var last_req_ts = theCookie.GetCookie(kLastRequestTimeStampCookie);
/* initialize the system clock , just once, this will set the currentTimeStamp value */
updateSystemTimeClock(kNoFlag);
/* keep the system timeclock up to date from now on */
updateSystemTimeClock(kYesFlag);
if (last_req_ts == null) {
  /* initialize the last request timestamp to now */
  last_req_ts = currentTimeStamp;
  theCookie.SetCookie(kLastRequestTimeStampCookie, last_req_ts, null, "/", ".grolier.com", null);
}
/* always check for new activity based on the clhref cookie */
setTimeout("checkForActivity()", 1000);
<!-- end:sessionactivity.js --> 
