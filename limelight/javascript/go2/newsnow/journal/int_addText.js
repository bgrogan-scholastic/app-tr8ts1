// When there's a text field, we need this function.
function addText(value) {
	text = getValue("editfield1");
	if (text != "") {
		text = "(" + text + " AND " + value + ")";
		replaceValue("editfield1", text);
	}
	else {
		appendUrl(new urlObject("editfield1",value));
	}
	
	if (getValue("numpassfields") != "")
		replaceValue("numpassfields","1");
	else {
		appendUrl(new urlObject("numpassfields","1"));
	}

}   //end text field selection
