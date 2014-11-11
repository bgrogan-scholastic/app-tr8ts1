<!-- begin: common.js -->
	    //var top_dd = document.domain;
//document.domain = "grolier.com";
var myDomain = ".grolier.com";
<!-- ##INCLUDE#TemplateName=/javascript/common/sniffer.js# -->
<!-- ##INCLUDE#TemplateName=/javascript/common/cookies.js# -->
<!-- ##INCLUDE#TemplateName=/javascript/common/browsercheck.js# -->
<!-- ##INCLUDE#TemplateName=/javascript/graphical/popup.js# -->
<!-- ##INCLUDE#TemplateName=/javascript/common/back.js# -->

 //var bottom_dd = document.domain;
//alert("GO:\nWindow Name: " + window.name + "\nTop of page, document.domain: " + top_dd + "\nBottom of page: " + bottom_dd);

//alert("In common.js\nwindow.name = " + window.name + "\ndocument.domain = " + document.domain);


if (!is_mac) {
  window.focus();
  }
<!-- end: common.js -->
