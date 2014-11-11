<%@ page import="com.grolier.common.AppEnvironment" %>
<%
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
                                url += "/<%= productName%>/results.jsp";
                                url += "?editfield1=" + form.editfield1.value;
                                url += "&boolean1=" + form.boolean1.value;
                                url += "&editfield2=" + form.editfield2.value;
                                url += "&boolean2=" + form.boolean2.value;
                                url += "&editfield3=" + form.editfield3.value;

                                for (i=0; i < form.fieldname.length; i++) {
                                        /* loop through the radio buttons for fieldname */
                                        if (form.fieldname[i].checked) {
                                                url += "&fieldname=" + form.fieldname[i].value;
                                        }
                                }

                                for (i=0; i < form.setchoice1.length; i++) {
                                        /* loop through the radio buttons for setchoice1 */
                                        if (form.setchoice1[i].checked) {
                                                url += "&setchoice1=" + form.setchoice1[i].value;
                                        }
                                }

                                thePopup.loadWindowByName(url, "mainframe");
                                window.close();
                                return false;
                        }
