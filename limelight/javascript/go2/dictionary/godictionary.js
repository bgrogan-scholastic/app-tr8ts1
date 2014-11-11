// This determines the final access list outcome for each dictionary
// All dictionaries are first set to the off position
// If a product's dictionary list has a dictionary as yes
// then that Dictionary is changed to true.  This avoids
// a duplicate list being generated, by products
// that share dictionaries.
		 
// The different dictionaries are: AHD4CAPI, AHCD, AHSD, AHSE, AHES, AHCT, THES

/* if no default product is set, we set the current product to the go environment */
var DictionaryDefault = "";
if ( GetCookie("CurrentProduct") == "gme.grolier.com") {
  DictionaryDefault = "AHSD";
}
		
if ( GetCookie("CurrentProduct") == "ea.grolier.com") {
  DictionaryDefault = "AHD4CAPI";
}

if ( GetCookie("CurrentProduct") == "nbk.grolier.com") {
  DictionaryDefault = "AHCD";
}

if ( GetCookie("CurrentProduct") == "nec.grolier.com") {
  DictionaryDefault = "S2E";
}

if ( GetCookie("CurrentProduct") == "atb.grolier.com") {
  DictionaryDefault = "AHCD";
}

if ( GetCookie("CurrentProduct") == "lp.grolier.com") {
  DictionaryDefault = "AHSD";
}

if ( GetCookie("CurrentProduct") == "nbps.grolier.com") {
  DictionaryDefault = "AHSD";
}

if ( GetCookie("CurrentProduct") == "eas.grolier.com") {
  DictionaryDefault = "AHD4CAPI";
}

if ( DictionaryDefault == "") {
  DictionaryDefault = "AHD4CAPI";
}

