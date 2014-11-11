<%@ page import="com.grolier.common.AppEnvironment" %>
<% 
	AppEnvironment myAppEnv = (AppEnvironment)application.getAttribute("appenv");
%>
var searchDomain = "<%= myAppEnv.getValue("search", "cookiedomain") %>";

if ((theQueryString.value("newsearch") != null) && (theQueryString.value("newsearch").length > 0)) {
	theCookie.DeleteCookie("searchresults", "/", searchDomain);
}

function submitSearchTheResults() {
	if (document.searchform.searchresults != null) {
		/* if the cookie currently exists and has a value, append the new search term onto it. */
		if ((theCookie.GetCookie("searchresults") != null) && (theCookie.GetCookie("searchresults").length > 0)) {
			/* make sure each time the user searches the search results an <AND> gets interjected */
			theCookie.SetCookie("searchresults", theCookie.GetCookie("searchresults") + " <AND> " + document.searchform.searchresults.value, null, "/", searchDomain, null);
		}
		else {
			/* if this is the first time the user searched the search results just set the cookie */
			theCookie.SetCookie("searchresults", document.searchform.searchresults.value, null, "/", searchDomain, null);
		}
	}
	return true;
}
