// This function is for date range selections.
function addDateRange() {
	fromDate = false;
	toDate = false;
	datechoice1 = "";
	datechoiceop1 = "";
	datechoice2 = "";
	datechoiceop2 = "";
	

    //set up "from" date for range
	if ((document.eajform.yearfrom.options[document.eajform.yearfrom.selectedIndex].value > "-1")
		&& (document.eajform.monthfrom.options[document.eajform.monthfrom.selectedIndex].value > "-1")
		&& (document.eajform.dayfrom.options[document.eajform.dayfrom.selectedIndex].value > "-1")){
		fromDate = true;
		datechoice1=document.eajform.yearfrom.options[document.eajform.yearfrom.selectedIndex].value
			+ document.eajform.monthfrom.options[document.eajform.monthfrom.selectedIndex].value
			+ document.eajform.dayfrom.options[document.eajform.dayfrom.selectedIndex].value;
		datechoiceop1="%3C%3D";    //hex equivalent of <= sign
	}
	//set up "to" date for range
	if ((document.eajform.yearto.options[document.eajform.yearto.selectedIndex].value > "-1")
		&& (document.eajform.monthto.options[document.eajform.monthto.selectedIndex].value > "-1")
		&& (document.eajform.dayto.options[document.eajform.dayto.selectedIndex].value > "-1")){
		toDate = true;
		datechoice2=document.eajform.yearto.options[document.eajform.yearto.selectedIndex].value
			+ document.eajform.monthto.options[document.eajform.monthto.selectedIndex].value
			+ document.eajform.dayto.options[document.eajform.dayto.selectedIndex].value;
		datechoiceop2="%3E%3D";    //hex equivalent of : sign
	}
	//only when "from" and "to" dates exist, do we add it to URL.
	if (fromDate && toDate) {
		
		appendUrl(new urlObject("DATEchoice1",datechoice1));
		appendUrl(new urlObject("DATEchoiceop1",datechoiceop1));
		appendUrl(new urlObject("DATEchoice2",datechoice2));
		appendUrl(new urlObject("DATEchoiceop2",datechoiceop2));

		appendUrl(new urlObject("choicebool","AND"));
		//					document.eajform.boolean2.options[document.eajform.boolean2.selectedIndex].value));					
		appendUrl(new urlObject("field1","DATE"));
		appendUrl(new urlObject("numDATE","2"));
		appendUrl(new urlObject("DATEboolean", "and"));

		if (getValue("numpassfields") == "")
			appendUrl(new urlObject("numpassfields","1"));
	}
}   //end date range function

