<%@ page import="com.grolier.common.AppEnvironment" %>
<%
	AppEnvironment myAppEnv = (AppEnvironment)application.getAttribute("appenv");
	String productName = application.getServletContextName();
%>
<!-- begin toggle.jsp -->

<%-- requires querystring.jsp --%>

function SearchToggle() {
    this.toggle = function () {
	tempString = document.location.href;

	/* is this a graphical or ada page? */
	if (tempString.indexOf('<%= productName %>/ada') == -1 ) {
		/* graphical page going to the ada page */
		newUrl = tempString.replace('<%= productName %>', '<%= productName %>/ada');
            	top.window.location = newUrl;
	}
	else {
		/* ada page going to graphical page */
		newUrl = tempString.replace('<%= productName %>/ada', '<%= productName %>');
		/* make sure to remove the http:// as the rap cookie doesn't like it */
		newUrl = newUrl.replace("http://", "");
      		theCookie.SetCookieNoEscape("rap", newUrl, null, "/", ".grolier.com", null);
        	top.window.location = "<%= myAppEnv.getValue("go", "basehref") %>";
	}
    } 
}

var theSearchToggle = new SearchToggle();
<!-- end querystring.jsp -->
