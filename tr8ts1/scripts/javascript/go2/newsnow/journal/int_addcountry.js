function addCountry(assetid,pid) {
	text = "(" + pid + "):ASSETID";
	value = getValue("editfield1");
	if (value != "") {
		value = "(" + value + " AND " + text + ")";
		replaceValue("editfield1",value);
	}
	else appendUrl(new urlObject("editfield1", text));

	setAssetID(assetid,pid);
	
	if (getValue("numpassfields") == "") appendUrl(new urlObject("numpassfields","1"));	//used by search object handler
	replaceValue("tn","/newsnow/int_country_search.html");


}   //end text field selection
