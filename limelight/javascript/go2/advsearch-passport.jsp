<%@ page import="com.grolier.common.AppEnvironment" %>
<%@ page import="com.grolier.common.auth.*"%>
<%

GI_AuthPreferences userPreferences = new GI_AuthPreferences(request);
boolean customerHasLexiling = false;

String alexPreference = userPreferences.getPrefsValue("ALEX");

if ( (alexPreference != null) && (alexPreference.equals("Y") == true) ) {
	customerHasLexiling = true;
}

/* get a list of the search servers to use in case of errors */
AppEnvironment appEnv = (AppEnvironment)application.getAttribute("appenv");

String domainName  = appEnv.getValue("search", "basehref");
String productName = application.getServletContextName();
%>

                       // submit the request
                        function submitRequest_4() {
                                var url = "";
                                var form = document.searchform;
                                url  = "<%= domainName%>";
                                url += "/<%= productName%>/results_articles.jsp";
                                url += "?all=" + form.all.value;
                                url += "&any=" + form.any.value;
                                url += "&none=" + form.none.value;
                                url += "&exact=" + form.exact.value;
                                url += "&xwords=" + form.xwords.value;
				url += "&fieldname=TEXT";
				url += "&newsearch=yes";

				if (form.within != null) {
					/* what type of within search is this doing? */
					for (var i=0; i < form.within.length; i++) {
						/* loop through all of the radio button options */
						if (form.within[i].checked) {
							url += "&within=" + form.within[i].value;
						}
					}
				}


				<% if (customerHasLexiling == true) { %>
					/* Lexiling Changes -only displayed when lexiling preference is available*/
					lexilebegin = form.lexilebegin.value;
					lexileend = form.lexileend.value;

					/* check to see if lexilebegin has a value */
					if (lexilebegin != "") {
						if (lexileend == "") {
							/* lexile end does not have a value, use the lexile begin */
							lexileend = lexilebegin;
						}					
					}
					else {
						/* lexile begin has no value, see if lexile end has a value and use that */
						if (lexileend != "") {
							lexilebegin = lexileend;
						}
					}

	
					/* append the lexiling parameters on */
					if (lexilebegin != "") {
						url += "&lexilebegin=" + lexilebegin;
					}

					if (lexileend != "") {
						/* make sure to add 1 to the ending range as verity does not automatically encompass that */
						url += "&lexileend=" + ((lexileend*1) + 1);
					}
				<% } %>
				
				top.thePopup.loadWindowByName(url, "mainframe");
                                top.close();
                                return false;
                        }
