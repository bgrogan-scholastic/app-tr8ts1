// Global Variables
var searchURL = "/cgi-bin/journal?";
 
//defaults
//passed onto plweb
appendUrl(new urlObject("sorting","-DATE,TITLE"));	

//used by search object handler
appendUrl(new urlObject("tn","/newsnow/int_date_search.html"));	
appendUrl(new urlObject("numtextfields","1"));

//******debugging
//appendUrl(new urlObject("debug","ON");

//******optional - leaving this out removed :TEXT from query & 
// will search all "searchable" fields for text
//  not recommended to leave this off with a ranked query, like in 
// searching all encyclopedia articles
// appendUrl(new urlObject("fieldname","TEXT");

function submitRequest() {
  setUpVariables();
  var locationStr = document.location.href;
  //  searchURL += getUrlString();
  document.location = searchURL + getUrlString();
}


function submitFormRequest() {
  // validate form variables
  if (validateForm() == true) {
    setUpVariables();
    var locationStr = document.location.href;
    //    searchURL += getUrlString();
    document.location = searchURL + getUrlString();
  }
}

function validateForm() {
  errorMsg = 'Invalid date selection. The "FROM" date cannot be more recent than the "TO" date.';
  errorFlag = false;
 
  // Check the year
  yearfrom = document.eajform.yearfrom.selectedIndex;
  yearto   = document.eajform.yearto.selectedIndex;

  if (yearfrom > 1 && yearto > 1 && yearfrom < yearto) {
    errorFlag = true;
  }

  // Check the month/year combo
  monthfrom = document.eajform.monthfrom.selectedIndex;
  monthto   = document.eajform.monthto.selectedIndex;

  if (monthfrom > 1 && monthto > 1 && monthfrom > monthto && yearto == yearfrom) {
    errorFlag = true;
  }

  // Check the day
  dayfrom = document.eajform.dayfrom.selectedIndex;
  dayto   = document.eajform.dayto.selectedIndex;

  if (yearfrom == yearto && monthfrom == monthto && dayfrom > dayto) {
    errorFlag = true;
  }

  //  alert(yearfrom + " " + yearto + " " + monthfrom + " " + monthto + " " + dayfrom + " " + dayto);

  // Check to make sure no defaults are set
  defaults = (yearfrom <= 1 && yearto <= 1 && monthfrom <= 1 && monthto <= 1 && dayfrom <= 1 && dayto <=1);
  if (defaults) {
    //  if (yearfrom <= 1 && yearto <= 1 && monthfrom <= 1 && monthto <= 1 && dayfrom <= 1 && dayto <=1) {
    errorFlag = false;
  } else if (yearfrom <= 1 || yearto <= 1 || monthfrom <= 1 || monthto <= 1 || dayfrom <= 1 || dayto <=1) {
    alert("Invalid date selection. Please specify a month, day and year");
    return false;
  }

  // If the user selected "All" as the country, make sure they either picked
  // a date range or a search term
  searchterm = document.eajform.editfield1.value.replace(/^\s*$/, '');

  if (document.eajform.country.options[document.eajform.country.selectedIndex].value == -1) {
    // Check for date range or search term
    if (searchterm == "" && defaults) {
      alert("When selecting \"All\" countries, you must add either a search term or a date range.");
      return false;
    }
  }


  if (errorFlag == true) {
    alert(errorMsg);
    return false;
  }

  return true;
}  

function setTemplateName(value) {
	replaceValue("tn",value);
}

function setAssetID(assetid,pid) {
	if (getValue("assetid") == "") {
		appendUrl(new urlObject("assetid", assetid));
		appendUrl(new urlObject("pid", pid));
	}
	
}

function setDate(value) {
	appendUrl(new urlObject("thedate",value));
}


function toAtlas(assetid) {
	OpenBlurbWindow(basehref_goatlas + assetid,750,550,'map','yes');
}
