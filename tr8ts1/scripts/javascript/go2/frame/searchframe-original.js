<!-- begin:searchframe.js --> 
var Dictionary_BaseHref = "<?php echo $goBaseHref ?>";
var splashURL = "<?php echo $frameBaseHref ?>";
var popupHeight = "<?php echo $_SERVER['DEFAULT_POPUP_HEIGHT'] ?>";
var popupWidth = "<?php echo $_SERVER['DEFAULT_POPUP_WIDTH'] ?>";
var kCurrentProduct = "<?php echo GI_AUTH_USER_CURRENTPRODUCT  ?>";
var kPreviousProduct = "<?php echo GI_AUTH_USER_PREVIOUSPRODUCT  ?>";
var kCLHref = "<?php echo GI_AUTH_USER_CURRENTHREF ?>";
var in_check_currentproduct_function = false;
var initState = "";
var kCurrState = "stateId";
var disableFocusFlag = true;

function noFrame(newURL) {
  if (top != self) {
    top.location.href = newURL;
  } else {
    self.location.href = newURL;
  }
}
//Must include querystring.js for randomizing the url
function reloadThisFrame() {
  var rand = (Math.round(Math.random()*1000));
  thePair = "&rand=" + theQueryString.extractValue(document.location.href,"rand=");
  newurl = theQueryString.removeNvPair(document.location.href,thePair,"&");
  newurl = newurl + "&rand=" + rand;
  //document.location.href = newurl;
  document.location.replace(newurl);
}
function getStateIdInHref(CLHref) {
  var stateNameIndex = CLHref.indexOf("stateid=");
  if (stateNameIndex >= 0) {
    // get stateid
    var subQueryString = CLHref.substring(stateNameIndex);
    if (subQueryString.length > 8) {
      var startIndex = subQueryString.indexOf("=") + 1;
      var endIndex = subQueryString.indexOf("&");
      if (endIndex == -1) {
        return subQueryString.substring(startIndex);
      } else {
        return subQueryString.substring(startIndex, endIndex);
      }
    }
    else {
      return "";
    }
  }
  else {
    return "";
  }
}
function checkForActivity() {
  if (theCookie.GetCookie("new_page") == "yes") {
  	checkForProductChange();
    theCookie.SetCookie("new_page","no", null, "/", ".grolier.com",null); 
  	reloadThisFrame();
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
setTimeout( "checkForActivity();", 1000 );
<!-- end:searchframe.js --> 
