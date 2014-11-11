<!-- begin: common.jsp-->
var myDomain = ".grolier.com";
<jsp:include page="/javascript/common/cookies.js"/>
<jsp:include page="/javascript/common/sniffer.js"/>
<jsp:include page="/javascript/common/browsercheck.js"/>
<jsp:include page="/javascript/graphical/popup.js"/>
<jsp:include page="/javascript/common/back.js"/>

 //var bottom_dd = document.domain;
//alert("GO:\nWindow Name: " + window.name + "\nTop of page, document.domain: " + top_dd + "\nBottom of page: " + bottom_dd);

//alert("In common.js\nwindow.name = " + window.name + "\ndocument.domain = " + document.domain);

if (!is_mac) {
  if (typeof(disableFocusFlag) == "undefined" || (!disableFocusFlag) ) {
    window.focus();
  }
}

<!-- end: common.jsp -->
