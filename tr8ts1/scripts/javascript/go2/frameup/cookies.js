//****************************************************************
// Cookies -- Yum!
//****************************************************************

   //NS4 = (document.layers) ? true : false;
  //NS45 = NS4 && (navigator.userAgent.indexOf("4.5")!=-1) ? true : false;
   // IE = (document.all) ? true : false;

//if (IE) document.domain = "grolier.com"; 

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

  var newExpires = null;

  if (expires != null) {

	newExpires = new Date(expires);
  }

  document.cookie = name + "=" + (value) +
    ((newExpires) ? "; expires=" + newExpires.toGMTString() : "") +
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

function checkAuthCookies()
{
	
	/* check to see if the auid cookie and the auth-pass cookie are not null */
	if ( (GetCookie(kAuidStrings) !=null) && (GetCookie(kAuthPass) != null) )
	{

		/* check to see if the auid cookies have no value or the auth-pass cookie is not present */
		if ( (GetCookie(kAuidStrings).length < 1) || (GetCookie(kAuthPass).length < 1) )
		{
			redirectToAuth = true;
			alert("Auids Cookies bad: " + GetCookie(kAuidStrings));
			alert("Auth Pass Cookie bad: " + GetCookie(kAuthPass));
		}
	}
	else
	{
		/* we got here because either the auid string was null and the auth pass cookie was null) */
		alert("Auth pass or Auids cookie null");
		alert(GetCookie("auth-pass"));
		alert(GetCookie("auids"));
		redirectToAuth = true;
	}
	
	if(redirectToAuth == true)
	{

		//alert("The RedirectoToAuth Value is: " + redirectToAuth);
		//I dont see any reason to set this at this point
		//SetCookie("rap", "<serversrc src="{GO_CONFIG_DIR}/gohostport.html"></serversrc>/dyno_go.html", null, "/", myDomain, null);
		
		self.location.href = "<serversrc src=\"{GO_CONFIG_DIR}/authserver-basehref.html\"></serversrc>/cgi-bin/authV2?bffs=Y";		
		
	}

	//else alert('you appear to be authorized! \n\n' + GetCookie("auids"));
	
}
