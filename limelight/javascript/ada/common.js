<!-- begin: common.js -->

var myDomain = ".grolier.com";

<!-- ##INCLUDE#TemplateName=/javascript/common/querystring.js# -->
<!-- ##INCLUDE#TemplateName=/javascript/common/cookies.js# -->
<!-- ##INCLUDE#TemplateName=/javascript/common/sniffer.js# -->
<!-- ##INCLUDE#TemplateName=/javascript/common/browsercheck.js# -->
<!-- ##INCLUDE#TemplateName=/javascript/common/grabselection.js# -->

// change the 'action' item of the search form to go to student or cumbre
function submitSearch() {
	// is the cumbre radio button checked?
	if(document.searchform.setchoice1[0].checked == true) {
		document.search.action = "<!-- ##INCLUDE#TemplateName=/basehref_search.html&ALT_INCLUDE_HOME=NEC2_CONFIG# -->/nec2/ada/cumbre/results.jsp";
	// otherwise, must be the student
	} else {
		document.search.action = "<!-- ##INCLUDE#TemplateName=/basehref_search.html&ALT_INCLUDE_HOME=NEC2_CONFIG# -->/nec2/ada/student/results.jsp";
	}
	return true;
}
<!-- end: common.js -->

