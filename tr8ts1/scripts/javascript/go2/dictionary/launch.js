var dictionaryWindow = null;
function launchDictionary() 
{	
	var Dictionary_BaseHref = gBase; 	
	var DictionaryDefault = dictionary;
	if(DictionaryDefault == "")
	{
		DictionaryDefault = "AHSD";
	}
	
	var DictionaryURL = Dictionary_BaseHref + "/page?tn=/dictionary/lookup.html&productid=xs&dictionary="+ DictionaryDefault + "&searchtype=lookup&authcode="+AUTH_PCODE;
	var puWidth = 800; var puHeight=450;
	
	dictionaryWindow = thePopup1.newWindow(DictionaryURL, puWidth, puHeight, "dictionary", "no", "no", "no", "yes", "no", "no", (screen.width-puWidth)/2, (screen.height-puHeight)/2);
}

