<!-- search.js begin -->

function GISearch() {

        var searchUrl = "";

        this.setSearchImage = function(imagename) {
                document.searchimg.src=imagename;
        }

        // All of these functions are used by the next and previous buttons from PLWeb
        this.addState = function(urlText) {
                if (urlText == "") {
                                return;
                }
                var currentURL = window.location.href;
                
                //remove the domain name portion
                currentURL = currentURL.substr(currentURL.indexOf("?")+1);
                removeValue = "starthit=" + extractValue(currentURL,"starthit=","&");
                currentURL = removeNvPair(currentURL,removeValue,"&");
                currentURL = currentURL + "&starthit="+extractValue(urlText,"starthit=","&")
                if (extractValue(currentURL,"state_id=","&") == "") {
                                currentURL = currentURL + "&state_id="+extractValue(urlText,"state_id=","&")
                }
                location = "/cgi-bin/dosearch?" + currentURL;
        }
                                
        this.addStateNS45 = function(urlText,locationText) {
                alert("The location is "+locationText); 
        }

        this.initializeVariables = function() { 
                this.searchUrl = "/cgi-bin/dosearch?";
                theURLObject.appendUrl(new URLObject("tn","/search/search.html"));
                theURLObject.appendUrl(new URLObject("sorting","BYRELEVANCE"));
                theURLObject.appendUrl(new URLObject("numpassfields","1"));
                theURLObject.appendUrl(new URLObject("numtextfields","1"));
                theURLObject.appendUrl(new URLObject("fieldname","TITLE"));
                theURLObject.appendUrl(new URLObject("headword","ON"));
        }

        this.checkSelection = function() {
                for (var i=0; i<document.searchform.fieldname.length; i++) {
                        if (document.searchform.fieldname[i].defaultChecked) {
                                if (!document.searchform.fieldname[i].checked) {
                                        this.triggerButtonEvent();
                                }
                        }
                }
        }

        this.triggerButtonEvent = function() {
                for (var i=0; i<document.searchform.fieldname.length; i++) {
                        if (document.searchform.fieldname[i].checked) {
                                document.searchform.fieldname[i].click();
                        }
                }
        }

        this.submitRequest = function() {
                this.checkSelection();  //for back button problems        
                document.searchform.submit();
                return true;
        }

        this.toArticle = function(basehref, viewname, dbname, query, docid, assetid, popup) { 
                vv = "&viewname=";
                dv = "&dbname=";
                qv = "&query=";
                div = "&docid=";
                locationStr = "";
                if (query.indexOf("TEXT") >= 0) {
                        //this is a fulltext search.  Must send hitword highlighting data
                        locationStr = basehref+assetid+div+docid+qv+query+dv+dbname+vv+viewname;
                        locationStr = theURLEncode.urlEncode(locationStr);
                } else {
                        locationStr = basehref+assetid;
                }
                if (popup == 'yes') {
                        thePopup.blurbWindow(locationStr, 550, 450, 'searchlink', 'yes')
                } else {
                        document.location = locationStr;
                }

        }
}
theGISearch = new GISearch();
theGISearch.initializeVariables();
<!-- search.js end -->

