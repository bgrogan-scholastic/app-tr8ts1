
// For a single date selection, we need this function
// It's safe to assume that we're on the journal search page and that
// all these form elements exist.
function addDate() {
	var booleanValue = "";
	var thedate = getValue("thedate");
		if ((thedate == "") && document.eajform) {	//when blank, get data from the form
			thedate = document.eajform.year.options[document.eajform.year.selectedIndex].value
				+ document.eajform.month.options[document.eajform.month.selectedIndex].value
				+ document.eajform.day.options[document.eajform.day.selectedIndex].value;
			booleanValue = document.eajform.boolean1.options[document.eajform.boolean1.selectedIndex].value;
			if (thedate == "-1-1-1") thedate = "";
		}
				
	if (thedate != ""){
		appendUrl(new urlObject("DATEchoice1",thedate));
		appendUrl(new urlObject("DATEchoiceop1","%3A"));    //hex equivalent of = sign
		appendUrl(new urlObject("field1","DATE"));
		appendUrl(new urlObject("numDATE","1"));
		appendUrl(new urlObject("DATEboolean",booleanValue));
		appendUrl(new urlObject("numpassfields","1"));
		return true;	//prevents date range check
	}
	return false	//enables date range check
}   //end single date function

