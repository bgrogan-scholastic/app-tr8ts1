// Submit a request for looking up the definition of a particular word
function submitLookup() {
  // Make sure the user selected a dictionary
  var checked = false;
  for (var i = 0; i < document.GoDictionary.dname.length; i++) {
    if (document.GoDictionary.dname[i].checked) {
      checked = true;
      break;    
    }
  }

  document.GoDictionary.searchtype.value = "lookup";

  if (checked == false)
   // alert("Please select a dictionary.");
  else 
    document.GoDictionary.submit();  
}

// Submit a request for looking up the definition of a particular word
function submitBrowse() {
  document.GoDictionary.searchtype.value = "browse";
  document.GoDictionary.submit();  
}

// Change the dictionary the user is referring to
function changeDictionary(dictionary) {
    var new_dictionary = "";
    for (var i = 0; i < document.GoDictionary.dname.length; i++) {
        if (document.GoDictionary.dname[i].checked) {
            new_dictionary = document.GoDictionary.dname[i].value;
            break;
        }
    }
  document.GoDictionary.dictionary.value   = new_dictionary;
  document.GoDictionary.searchstring.value = "";
  submitLookup();
}

// Set the dictionary by turning on the approriate radio button
function setDictionary() {
  for (var i = 0; i < document.GoDictionary.dname.length; i++) {
    if (document.GoDictionary.dname[i].value == currentDictionary) {
      document.GoDictionary.dname[i].checked = true;
      break;
    }
  }
 
  var word = GetCookie("wordlookup");
  if (word != null && word != '') {
    document.GoDictionary.searchstring.value = word;    
    DeleteCookie("wordlookup", "/", myDomain);
    submitLookup();	
  }

  if (currentSearchstring != "" && currentSearchstring != "undefined") {
    var text    = "";
    var tmpText = unescape(currentSearchstring);
    var index   = tmpText.indexOf("+");
	
    while (index != -1) {
      text += tmpText.substring(0, index) + " ";
      tmpText = tmpText.substring(index + 1, tmpText.length);
      index = tmpText.indexOf("+");
    }
    text += tmpText;
 
    document.GoDictionary.searchstring.value = text;
  }
}




