// All of these functions are used by the next and previous buttons
// from PLWeb
function addState(urlText) {

	if (urlText == "") return;
	var currentURL = window.location.href;

	//remove the domain name portion
	currentURL = currentURL.substr(currentURL.indexOf("?")+1);
	//get all name/value pairs from currentURL.  No need to recreate for
	//the next and/or previous buttons.

	var nvpairs = currentURL.split("&");

	for (var i=0; i<nvpairs.length; i++) {
		if (IE) {
			//IE likes to decode stuff that gets written to the URL from a form.
			//So I let it happen the first time (from the search entry form) and
			//then I put it back when we build the URL on the next or previous buttons.
			//This is only a problem with the DATE searches on the EA3 Journal because
			//This is the only time I actually enter encoded values directly.
			//Oh how life is grand in Microsoft land ...
			if (nvpairs[i] == "DATEchoiceop1==") nvpairs[i] = "DATEchoiceop1=%3D";
			else if (nvpairs[i] == "DATEchoiceop1=<=") nvpairs[i] = "DATEchoiceop1=%3C%3D";
			else if (nvpairs[i] == "DATEchoiceop2=>=") nvpairs[i] = "DATEchoiceop2=%3E%3D";
		}

		var nv = nvpairs[i].split("=");
		if ((nv[0] != "starthit") && (nv[0] != "state_id") && (nv[0] != "sorting")) {
			value = getValue(nv[0]);
			if ((value == "") || (value < 0)) {	appendUrl(new urlObject(nv[0],nv[1])); }
			else { replaceValue(nv[0],nv[1]); }
		}
		else {}
	}
	appendUrl(new urlObject("starthit", extractValue(urlText,"starthit=","&")));
	appendUrl(new urlObject("state_id", extractValue(urlText,"state_id=","&")));
	submitRequest();

}

function addStateNS45(urlText,locationText) {
	alert("The location is "+locationText);	
	
}
