

function urlObject(name,value) {
	this.name = name;
	this.value = value;
}

var urlArray = new Array();

function initializeArray() {	//for IE 4.5
	urlArray = new Array();
//	alert("**Initialization** Printing urlArray objects\n\nlength" + urlArray.length + "\nValues: " + getUrlString());
}

function appendUrl(aNameValuePair) {

	urlArray[urlArray.length] = aNameValuePair;
//alert("Appending to urlArray objects\n\nlength" + urlArray.length + "\nValues: " + getUrlString());

}

function getUrlString() {
	outText = "";
	ampersand = "";
	for (var i=0; i<urlArray.length; i++) {

		if (urlArray[i].name == "editfield1") {
			outText += ampersand + urlArray[i].name
				+ "=" + urlEncode(urlArray[i].value);
		}
		else {
			outText += ampersand + urlArray[i].name
				+ "=" + urlArray[i].value;
		}
		ampersand = "&";
	}
	return outText;
}

function getValue(name) {
	outText = "";
	for (i=0; i<urlArray.length; i++) {
		if ((urlArray[i].name == name) && (urlArray[i].value != ""))
			return urlArray[i].value;
	}
	return "";	
}

function getNameValue(name) {
	value = getValue(name);
	if (value != "") return (name + "=" + value);
}

function replaceValue(name,value) {
	for (i=0; i<urlArray.length; i++) {
		if (urlArray[i].name == name) urlArray[i].value = value;
	}
}

function removeValue(name) {
	replaceValue(name,"");
}

function testit() {
	
	appendUrl(new urlObject("edtifield1","(0050800):ASSETID"));
	appendUrl(new urlObject("assetid=","0050800-00"));
	appendUrl(new urlObject("pid=","0050800"));
	appendUrl(new urlObject("textfield=","bombing"));
	
	alert("Printing urlArray objects\n\nlength" + urlArray.length + "\nValues: " + getUrlString());
	alert("Value for textfield=" + getValue("textfield="));
	replaceValue("textfield=","dancing");
	alert("Value for textfield=" + getValue("textfield="));	
}
